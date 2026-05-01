<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUPost | Social Media Request System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #002366;
            --navy-light: #1e4fd8;
            --navy-dark: #001540;
            --amber: #f59e0b;
            --cream: #f9fafb;
            --white: #ffffff;
            --text-main: #111827;
            --text-muted: #4b5563;
            --font-sans: 'DM Sans', sans-serif;
            --font-serif: 'DM Serif Display', serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--cream);
            color: var(--text-main);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--navy);
            font-weight: 700;
            font-size: 24px;
            font-family: var(--font-serif);
        }
        .nav-logo {
            width: 40px; height: 40px;
            background: var(--navy);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }
        .btn-login {
            background: var(--navy);
            color: var(--white);
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(0, 35, 102, 0.2);
        }
        .btn-login:hover {
            background: var(--navy-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 79, 216, 0.3);
        }

        /* ── HERO SECTION ── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 5% 60px;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #f9fafb 0%, #e8eef8 100%);
        }
        .blob {
            position: absolute;
            filter: blur(80px);
            opacity: 0.5;
            z-index: -1;
            border-radius: 50%;
        }
        .blob-1 { top: -10%; right: -5%; width: 500px; height: 500px; background: var(--navy-light); }
        .blob-2 { bottom: -20%; left: -10%; width: 600px; height: 600px; background: var(--amber); }

        .hero-content {
            max-width: 800px;
            position: relative;
            z-index: 2;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(245, 158, 11, 0.15);
            color: #b45309;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 24px;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        .hero-title {
            font-family: var(--font-serif);
            font-size: 5rem;
            line-height: 1.05;
            color: var(--navy-dark);
            margin-bottom: 24px;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 600px;
        }
        .hero-cta {
            display: flex;
            gap: 16px;
        }
        .btn-primary {
            background: var(--amber);
            color: var(--navy-dark);
            text-decoration: none;
            padding: 16px 36px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
        }
        .btn-primary:hover {
            background: #fbbf24;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
        }
        .btn-outline {
            background: transparent;
            color: var(--navy);
            text-decoration: none;
            padding: 16px 36px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid var(--navy);
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            background: var(--navy);
            color: var(--white);
        }

        /* ── FEATURES SECTION ── */
        .features {
            padding: 120px 5%;
            background: var(--white);
            position: relative;
        }
        .section-header {
            text-align: center;
            margin-bottom: 80px;
        }
        .section-title {
            font-family: var(--font-serif);
            font-size: 3.5rem;
            color: var(--navy-dark);
            margin-bottom: 16px;
        }
        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-muted);
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-card {
            background: var(--cream);
            padding: 40px 32px;
            border-radius: 24px;
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 35, 102, 0.08);
            background: var(--white);
        }
        .feature-icon {
            width: 64px; height: 64px;
            background: var(--navy-pale);
            color: var(--navy-light);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }
        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text-main);
        }
        .feature-desc {
            font-size: 1rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ── FOOTER ── */
        .footer {
            background: var(--navy-dark);
            padding: 60px 5% 40px;
            color: rgba(255,255,255,0.7);
            text-align: center;
        }
        .footer-logo {
            font-family: var(--font-serif);
            font-size: 2rem;
            color: var(--white);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .footer-logo svg { color: var(--amber); }
        .footer-text { margin-bottom: 30px; }
        .footer-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin-bottom: 30px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .hero-title { font-size: 3.5rem; }
            .hero-subtitle { font-size: 1.1rem; }
            .hero-cta { flex-direction: column; }
            .section-title { font-size: 2.5rem; }
            .btn-primary, .btn-outline { text-align: center; }
        }
    </style>
</head>
<body>

    <nav class="navbar" id="navbar">
        <a href="/" class="nav-brand">
            <div class="nav-logo">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            NUPost
        </a>
        <a href="{{ route('login') }}" class="btn-login gs-fade">Sign In</a>
    </nav>

    <section class="hero">
        <div class="hero-bg"></div>
        <div class="blob blob-1" id="blob-1"></div>
        <div class="blob blob-2" id="blob-2"></div>
        
        <div class="hero-content">
            <div class="hero-badge gs-hero">Official NU Lipa Platform</div>
            <h1 class="hero-title gs-hero">Streamline Your<br>Social Media Workflow</h1>
            <p class="hero-subtitle gs-hero">The central hub for requesting, tracking, and approving social media content for National University Lipa. Powered by AI and seamless collaboration.</p>
            <div class="hero-cta gs-hero">
                <a href="{{ route('login') }}" class="btn-primary">Get Started Now</a>
                <a href="#features" class="btn-outline">Explore Features</a>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-header">
            <h2 class="section-title gs-up">Everything You Need</h2>
            <p class="section-subtitle gs-up">Designed specifically for the Marketing Office and student organizations.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card gs-card">
                <div class="feature-icon">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h3 class="feature-title">Centralized Requests</h3>
                <p class="feature-desc">Say goodbye to scattered emails. Submit and track all your social media posting requests in one organized dashboard.</p>
            </div>

            <div class="feature-card gs-card">
                <div class="feature-icon">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2.5"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <h3 class="feature-title">Visual Calendar</h3>
                <p class="feature-desc">Schedule and manage content effortlessly with an interactive calendar. Avoid overlapping posts and maximize reach.</p>
            </div>

            <div class="feature-card gs-card">
                <div class="feature-icon">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3 class="feature-title">Direct Collaboration</h3>
                <p class="feature-desc">Chat directly with administrators on specific requests. Resolve issues, discuss edits, and approve content instantly.</p>
            </div>

            <div class="feature-card gs-card">
                <div class="feature-icon">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3 class="feature-title">Bulldawg AI</h3>
                <p class="feature-desc">Stuck on what to write? Generate engaging, platform-specific captions instantly using our built-in AI assistant.</p>
            </div>

            <div class="feature-card gs-card">
                <div class="feature-icon">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                </div>
                <h3 class="feature-title">Real-time Analytics</h3>
                <p class="feature-desc">Connect securely with the Meta Graph API to track reach, engagement, and overall performance directly from your dashboard.</p>
            </div>

            <div class="feature-card gs-card">
                <div class="feature-icon">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3 class="feature-title">Secure Access</h3>
                <p class="feature-desc">Role-based authentication ensures your data is safe. Administrators have full control while requestors see only their data.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-logo">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
            NUPost
        </div>
        <p class="footer-text">The official social media request platform for National University Lipa.</p>
        <div class="footer-divider"></div>
        <p style="font-size: 12px; opacity: 0.6;">&copy; {{ date('Y') }} NU Lipa Marketing Office. All rights reserved.</p>
    </footer>

    <!-- GSAP Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        // Register ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        // Hero Entrance Animations
        const tl = gsap.timeline();
        
        tl.from(".gs-fade", { opacity: 0, y: -20, duration: 0.8, ease: "power3.out" })
          .from(".gs-hero", { 
              opacity: 0, 
              y: 40, 
              duration: 1, 
              stagger: 0.2, 
              ease: "power4.out" 
          }, "-=0.4");

        // Floating Blobs Animation
        gsap.to("#blob-1", {
            y: 50, x: 30, rotation: 10,
            duration: 6, repeat: -1, yoyo: true, ease: "sine.inOut"
        });
        gsap.to("#blob-2", {
            y: -60, x: -40, rotation: -15,
            duration: 7, repeat: -1, yoyo: true, ease: "sine.inOut", delay: 1
        });

        // Scroll Reveal Animations for Features
        gsap.utils.toArray(".gs-up").forEach(elem => {
            gsap.from(elem, {
                scrollTrigger: {
                    trigger: elem,
                    start: "top 85%",
                    toggleActions: "play none none reverse"
                },
                y: 50,
                opacity: 0,
                duration: 0.8,
                ease: "power3.out"
            });
        });

        // Staggered Cards Reveal
        gsap.from(".gs-card", {
            scrollTrigger: {
                trigger: ".features-grid",
                start: "top 80%"
            },
            y: 60,
            opacity: 0,
            duration: 0.8,
            stagger: 0.15,
            ease: "back.out(1.7)"
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(255, 255, 255, 0.95)';
                nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.05)';
            } else {
                nav.style.background = 'rgba(255, 255, 255, 0.8)';
                nav.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>
