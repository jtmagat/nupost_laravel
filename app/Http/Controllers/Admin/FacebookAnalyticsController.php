<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FacebookAnalyticsController extends Controller
{
    private string $token;
    private string $base = 'https://graph.facebook.com/v21.0';

    /**
     * Allowed period presets and their config.
     */
    private const PERIODS = [
        '7d'  => ['days' => 7,  'label' => '7 Days',   'short' => '7d'],
        '30d' => ['days' => 30, 'label' => '30 Days',  'short' => '30d'],
        '60d' => ['days' => 60, 'label' => '2 Months', 'short' => '60d'],
    ];

    public function __construct()
    {
        $this->token = env('FB_PAGE_ACCESS_TOKEN', '');
    }

    public function index(Request $request)
    {
        $period = $request->query('period', '7d');
        if (!array_key_exists($period, self::PERIODS)) {
            $period = '7d';
        }

        $fb = $this->getData($period);
        $fb['period']       = $period;
        $fb['period_label'] = self::PERIODS[$period]['label'];
        $fb['period_short'] = self::PERIODS[$period]['short'];
        $fb['periods']      = self::PERIODS;

        return view('admin.analytics', compact('fb'));
    }

    /**
     * Reusable Facebook HTTP client with SSL bypass for local/XAMPP environments.
     */
    private function fbHttp()
    {
        return Http::withoutVerifying()->timeout(15);
    }

    public function getData(string $period = '7d'): array
    {
        $config = self::PERIODS[$period] ?? self::PERIODS['7d'];
        $days   = $config['days'];

        if (!$this->token) {
            return [
                'error'    => 'FB_PAGE_ACCESS_TOKEN missing in .env',
                'pageInfo' => null,
                'metrics'  => null,
                'posts'    => [],
            ];
        }

        try {
            // ── 1. Page basic info (use /me — page token auto-resolves) ──
            $pageInfo = Cache::remember('fb_page_info', 300, function () {
                $response = $this->fbHttp()->get("{$this->base}/me", [
                    'fields'       => 'name,id,fan_count,followers_count,link,picture.type(large)',
                    'access_token' => $this->token,
                ]);

                Log::debug('FB Page Info Response', ['status' => $response->status(), 'body' => $response->json()]);

                return $response->json();
            });

            if (isset($pageInfo['error'])) {
                Cache::forget('fb_page_info');
                throw new \Exception($pageInfo['error']['message'] ?? 'Unknown Facebook API error');
            }

            // ── 2. Posts from the selected period ────────────────────────
            $sinceTs = now()->subDays($days)->timestamp;
            $cacheKey = "fb_posts_{$period}";

            $postsRes = Cache::remember($cacheKey, 300, function () use ($sinceTs) {
                $response = $this->fbHttp()->get("{$this->base}/me/posts", [
                    'fields'       => 'id,message,story,created_time,full_picture,permalink_url,likes.summary(true),comments.summary(true),shares',
                    'since'        => $sinceTs,
                    'limit'        => 100,
                    'access_token' => $this->token,
                ]);

                Log::debug('FB Posts Response', ['status' => $response->status()]);

                return $response->json();
            });

            if (isset($postsRes['error'])) {
                Cache::forget($cacheKey);
                Log::warning('FB Posts API Error', $postsRes['error']);
            }

            // Keep only posts within the period (double-check client-side)
            $cutoff = now()->subDays($days);
            $posts  = collect($postsRes['data'] ?? [])->filter(function ($p) use ($cutoff) {
                return !empty($p['created_time']) && Carbon::parse($p['created_time'])->gte($cutoff);
            })->values()->all();

            // ── 3. Page Insights (reach, engagements) ────────────────────
            //    Facebook insights API returns at most ~93 days of daily data.
            //    We request based on `since` / `until` for the chosen period.
            $insightsCacheKey = "fb_insights_{$period}";
            $insightsSince    = now()->subDays($days)->format('Y-m-d');
            $insightsUntil    = now()->format('Y-m-d');

            $insightsData = Cache::remember($insightsCacheKey, 300, function () use ($insightsSince, $insightsUntil) {
                $response = $this->fbHttp()->get("{$this->base}/me/insights", [
                    'metric'       => 'page_impressions_unique,page_post_engagements',
                    'period'       => 'day',
                    'since'        => $insightsSince,
                    'until'        => $insightsUntil,
                    'access_token' => $this->token,
                ]);

                Log::debug('FB Insights Response', ['status' => $response->status()]);

                return $response->json();
            });

            // Parse insights
            $totalReach      = 0;
            $totalEngagement = 0;
            $dailyReach      = [];
            $dailyEngagement = [];

            if (!empty($insightsData['data'])) {
                foreach ($insightsData['data'] as $metric) {
                    $metricName = $metric['name'] ?? '';
                    $values     = $metric['values'] ?? [];

                    if ($metricName === 'page_impressions_unique') {
                        foreach ($values as $v) {
                            $totalReach += $v['value'] ?? 0;
                            $dailyReach[] = [
                                'date'  => $v['end_time'] ?? '',
                                'value' => $v['value'] ?? 0,
                            ];
                        }
                    }

                    if ($metricName === 'page_post_engagements') {
                        foreach ($values as $v) {
                            $totalEngagement += $v['value'] ?? 0;
                            $dailyEngagement[] = [
                                'date'  => $v['end_time'] ?? '',
                                'value' => $v['value'] ?? 0,
                            ];
                        }
                    }
                }
            }

            // ── 4. Build metrics from period posts ───────────────────────
            $totalLikes    = 0;
            $totalComments = 0;
            $totalShares   = 0;
            foreach ($posts as $p) {
                $totalLikes    += $p['likes']['summary']['total_count']    ?? 0;
                $totalComments += $p['comments']['summary']['total_count'] ?? 0;
                $totalShares   += $p['shares']['count']                    ?? 0;
            }

            $metrics = [
                'page_fans'        => ['total' => $pageInfo['fan_count']       ?? 0, 'daily' => []],
                'followers'        => ['total' => $pageInfo['followers_count'] ?? 0, 'daily' => []],
                'total_reach'      => ['total' => $totalReach,      'daily' => $dailyReach],
                'total_engagement' => ['total' => $totalEngagement, 'daily' => $dailyEngagement],
                'total_likes'      => ['total' => $totalLikes,      'daily' => []],
                'total_comments'   => ['total' => $totalComments,   'daily' => []],
                'total_shares'     => ['total' => $totalShares,     'daily' => []],
                'total_posts'      => ['total' => count($posts),    'daily' => []],
            ];

            return [
                'error'    => null,
                'pageInfo' => $pageInfo,
                'metrics'  => $metrics,
                'posts'    => $posts,
            ];

        } catch (\Exception $e) {
            Log::error('Facebook API Error: ' . $e->getMessage());
            return [
                'error'    => $e->getMessage(),
                'pageInfo' => null,
                'metrics'  => null,
                'posts'    => [],
            ];
        }
    }

    public function refresh(Request $request)
    {
        // Clear all period-specific caches
        Cache::forget('fb_page_info');
        foreach (array_keys(self::PERIODS) as $p) {
            Cache::forget("fb_posts_{$p}");
            Cache::forget("fb_insights_{$p}");
        }

        $period = $request->query('period', '7d');
        return redirect()->route('admin.analytics', ['period' => $period])
                         ->with('success', '✅ Facebook analytics refreshed!');
    }
}