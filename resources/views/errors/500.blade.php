<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection lost · Please refresh</title>
    <!-- Google Font for a clean, modern look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: linear-gradient(145deg, #f0f5fe 0%, #e6edf7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            line-height: 1.5;
            color: #1e293b;
        }

        .network-card {
            max-width: 680px;
            width: 100%;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 2.5rem;
            padding: 3.5rem 2.5rem;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.7) inset,
                0 1px 3px 0 rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.2s ease;
            animation: cardAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardAppear {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Icon / graphic area — network / wifi style */
        .network-graphic {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: #dbeafe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px -8px rgba(37, 99, 235, 0.15);
        }

        .network-graphic svg {
            width: 60px;
            height: 60px;
            color: #1d4ed8;
            display: block;
        }

        /* Soft status badge — network hint */
        .status-badge {
            display: inline-block;
            background: #eef2ff;
            color: #1e40af;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.4px;
            padding: 0.4rem 1.25rem;
            border-radius: 40px;
            margin-bottom: 1.25rem;
            border: 1px solid #c7d2fe;
            text-transform: uppercase;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #0f172a;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .subhead {
            font-size: 1.125rem;
            color: #475569;
            max-width: 480px;
            margin: 0 auto 2rem;
        }

        /* Refresh panel — friendly network hint */
        .refresh-panel {
            background: #f8fafc;
            border-radius: 2rem;
            padding: 2rem 1.75rem;
            border: 1px solid #e2e8f0;
            margin-bottom: 2.25rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .refresh-message {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .refresh-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }

        .refresh-icon svg {
            width: 24px;
            height: 24px;
            color: #2563eb;
            display: block;
        }

        .refresh-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
            text-align: left;
        }

        .refresh-text span {
            font-weight: 400;
            color: #64748b;
            font-size: 1rem;
            display: block;
            margin-top: 0.15rem;
        }

        /* Primary button (refresh) */
        .btn-refresh {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            background: #1e293b;
            color: white;
            border: none;
            border-radius: 3rem;
            padding: 1rem 2.25rem;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 8px 18px -6px rgba(30, 41, 59, 0.25);
            border: 1px solid #0f172a;
            width: 100%;
            max-width: 280px;
            margin: 0 auto 0.5rem;
            letter-spacing: 0.3px;
        }

        .btn-refresh:hover {
            background: #0f172a;
            transform: translateY(-2px);
            box-shadow: 0 14px 24px -8px rgba(15, 23, 42, 0.35);
        }

        .btn-refresh:active {
            transform: translateY(1px);
            box-shadow: 0 4px 10px -4px rgba(15, 23, 42, 0.3);
        }

        .btn-refresh svg {
            width: 20px;
            height: 20px;
            transition: transform 0.2s ease;
        }

        .btn-refresh:hover svg {
            transform: rotate(45deg);
        }

        .btn-refresh:focus-visible {
            outline: 3px solid #3b82f6;
            outline-offset: 3px;
        }

        /* Alternative action */
        .alt-action {
            font-size: 0.95rem;
            color: #64748b;
            margin-top: 1rem;
        }

        .alt-action a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid transparent;
            transition: border-color 0.15s;
        }

        .alt-action a:hover {
            border-bottom-color: #2563eb;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.75rem 0 0.5rem;
            color: #94a3b8;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* Small footer hint */
        .footer-note {
            margin-top: 1.25rem;
            font-size: 0.85rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .footer-note svg {
            width: 14px;
            height: 14px;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .network-card {
                padding: 2.5rem 1.5rem;
                border-radius: 2rem;
            }

            h1 {
                font-size: 1.9rem;
            }

            .subhead {
                font-size: 1rem;
            }

            .refresh-panel {
                padding: 1.5rem 1rem;
                border-radius: 1.5rem;
            }

            .refresh-message {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }

            .refresh-text {
                text-align: center;
            }

            .btn-refresh {
                padding: 0.9rem 1.5rem;
                font-size: 1rem;
            }
        }

        /* For users who prefer reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .network-card {
                animation: none;
            }
            .btn-refresh {
                transition: none;
            }
            .btn-refresh:hover {
                transform: none;
            }
            .btn-refresh:hover svg {
                transform: none;
            }
        }
    </style>
</head>
<body>
    <div class="network-card" role="status" aria-labelledby="network-title">
        <!-- Network graphic — wifi / globe / signal style -->
        <div class="network-graphic" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
            </svg>
        </div>

        <!-- Status badge — feels like network hint -->
        <div class="status-badge" aria-hidden="true">⚠️ Network hiccup</div>
        <!-- start lakshman -->
        @if(config('app.debug') && isset($exception))
    <div style="margin-top: 2rem; text-align: left; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 1rem; padding: 1.25rem;">
        <div style="font-size: 0.85rem; font-weight: 700; color: #be123c; margin-bottom: 0.75rem;">
            DEBUG INFORMATION
        </div>

        <div style="font-size: 0.9rem; color: #334155; margin-bottom: 0.75rem;">
            <strong>Error:</strong>
            {{ $exception->getMessage() ?: 'No error message available.' }}
        </div>

        @if($exception->getFile())
            <div style="font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; word-break: break-all;">
                <strong>File:</strong>
                {{ $exception->getFile() }}
            </div>
        @endif

        @if($exception->getLine())
            <div style="font-size: 0.85rem; color: #475569; margin-bottom: 0.75rem;">
                <strong>Line:</strong>
                {{ $exception->getLine() }}
            </div>
        @endif

        @if($exception->getTraceAsString())
            <details style="margin-top: 1rem;">
                <summary style="cursor: pointer; font-weight: 600; color: #334155;">
                    Show stack trace
                </summary>

                <pre style="margin-top: 0.75rem; padding: 1rem; background: #0f172a; color: #e2e8f0; border-radius: 0.75rem; overflow-x: auto; white-space: pre-wrap; word-break: break-word; font-size: 0.75rem; line-height: 1.5;">{{ $exception->getTraceAsString() }}</pre>
            </details>
        @endif
    </div>
@endif
<!-- end lakshman -->
        <!-- Main heading — no error mention -->
        <h1 id="network-title">Connection lost</h1>
        <p class="subhead">
            It looks like your network connection is unstable or offline. This is usually temporary.
        </p>

        <!-- Refresh instruction panel -->
         {{--
        <div class="refresh-panel">
            <div class="refresh-message">
                <div class="refresh-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
                <div class="refresh-text">
                    Refresh the page
                    <span>to reconnect and continue</span>
                </div>
            </div>
        </div>
        --}}

        <!-- Primary CTA -->
        <button class="btn-refresh" id="refreshButton" type="button" aria-label="Refresh page">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            Refresh now
        </button>

        <!-- Alternative action -->
        <p class="alt-action">
            or <a href="/" id="homeLink">go back to home</a>
        </p>

        <!-- Divider with auto-retry hint -->
        <div class="divider" aria-hidden="true">
            <span class="divider-line"></span>
            <span>auto‑retry available</span>
            <span class="divider-line"></span>
        </div>

        <!-- Footnote -->
        <div class="footer-note">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span>If the connection issue persists, check your Wi‑Fi or mobile data.</span>
        </div>
    </div>

    <script>
    (function() {
        'use strict';

        // Get the previous page URL from the referrer (works like "back" but safe)
        const previousPage = document.referrer;

        // Primary refresh button: go back to the previous page / reload
        const refreshBtn = document.getElementById('refreshButton');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // If we have a referrer, go back to it
                if (previousPage && previousPage !== '') {
                    window.location.href = previousPage;
                } else {
                    // Fallback: use browser history to go back
                    if (window.history.length > 1) {
                        window.history.back();
                    } else {
                        // Last resort: reload current page
                        window.location.reload();
                    }
                }
            });
        }

        // Bonus: subtle auto-retry suggestion (not automatic, but hints)
        // We don't auto-refresh to avoid loops — just a soft nudge.
        // The divider says "auto-retry available" but we leave it as a manual nudge.
        // If you wanted a real auto-retry, uncomment the lines below (with a delay):
        /*
        setTimeout(function() {
            // Only auto-reload if the user hasn't interacted and page is still visible
            if (!document.hidden) {
                window.location.reload();
            }
        }, 15000); // 15 seconds
        */
    })();
</script>
</body>
</html>