<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FacebookAnalyticsController extends Controller
{
    private string $pageId;
    private string $token;
    private string $base = 'https://graph.facebook.com/v25.0';

    public function __construct()
    {
        $this->pageId = env('FB_PAGE_ID', '');
        $this->token  = env('FB_PAGE_ACCESS_TOKEN', '');
    }

    public function getData(): array
    {
        if (!$this->pageId || !$this->token) {
            return ['error' => 'FB_PAGE_ID or FB_PAGE_ACCESS_TOKEN missing in .env', 'pageInfo'=>null,'metrics'=>null,'posts'=>[]];
        }

        try {
            // ── 1. Page basic info ───────────────────────────────────────
            $pageInfo = Cache::remember('fb_page_info', 300, fn() =>
                Http::get("{$this->base}/{$this->pageId}", [
                    'fields'       => 'name,fan_count,followers_count,link',
                    'access_token' => $this->token,
                ])->json()
            );

            if (isset($pageInfo['error'])) {
                Cache::forget('fb_page_info');
                throw new \Exception($pageInfo['error']['message']);
            }

            // ── 2. Posts with reactions/comments/shares ──────────────────
            $postsRes = Cache::remember('fb_posts', 300, fn() =>
                Http::get("{$this->base}/{$this->pageId}/posts", [
                    'fields'       => 'id,message,story,created_time,full_picture,permalink_url,likes.summary(true),comments.summary(true),shares',
                    'limit'        => 8,
                    'access_token' => $this->token,
                ])->json()
            );

            if (isset($postsRes['error'])) {
                Cache::forget('fb_posts');
            }

            $posts = $postsRes['data'] ?? [];

            // ── 3. Build metrics from post data (no insights API needed) ─
            $totalLikes    = 0;
            $totalComments = 0;
            $totalShares   = 0;
            foreach ($posts as $p) {
                $totalLikes    += $p['likes']['summary']['total_count']    ?? 0;
                $totalComments += $p['comments']['summary']['total_count'] ?? 0;
                $totalShares   += $p['shares']['count']                    ?? 0;
            }

            $metrics = [
                'page_fans'     => ['total' => $pageInfo['fan_count']       ?? 0, 'daily' => []],
                'followers'     => ['total' => $pageInfo['followers_count'] ?? 0, 'daily' => []],
                'total_likes'   => ['total' => $totalLikes,    'daily' => []],
                'total_comments'=> ['total' => $totalComments, 'daily' => []],
                'total_shares'  => ['total' => $totalShares,   'daily' => []],
                'total_posts'   => ['total' => count($posts),  'daily' => []],
            ];

            return [
                'error'    => null,
                'pageInfo' => $pageInfo,
                'metrics'  => $metrics,
                'posts'    => $posts,
            ];

        } catch (\Exception $e) {
            return [
                'error'    => $e->getMessage(),
                'pageInfo' => null,
                'metrics'  => null,
                'posts'    => [],
            ];
        }
    }

    public function refresh()
    {
        Cache::forget('fb_page_info');
        Cache::forget('fb_insights');
        Cache::forget('fb_posts');
        return redirect()->route('admin.analytics')->with('success', '✅ Facebook analytics refreshed!');
    }
}