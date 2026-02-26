<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - 404</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        background: #fffafc;
        color: #1e1e1e;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1.5;
    }

    /* main container – fully responsive padding */
    .full-404 {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: clamp(1rem, 5vw, 3rem);
    }

    /* --- TOP BAR (flex wrap everywhere) --- */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.2rem 2rem;
        margin-bottom: clamp(2rem, 6vw, 4rem);
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: clamp(1.4rem, 4vw, 1.8rem);
        font-weight: 300;
        letter-spacing: 1px;
    }

    .logo i {
        color: #EC4899;
        font-size: clamp(1.8rem, 5vw, 2.2rem);
        background: #FCE7F3;
        padding: 0.4rem;
        border-radius: 50%;
        transition: transform 0.2s;
    }

    .logo:hover i {
        transform: scale(1.02);
    }

    .logo span {
        font-weight: 600;
        color: #EC4899;
    }

    .mini-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem 1.8rem;
    }

    .mini-nav a {
        text-decoration: none;
        color: #2c2c2c;
        font-weight: 500;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        border-bottom: 2px solid transparent;
        transition: 0.2s;
        padding-bottom: 4px;
    }

    .mini-nav a:hover {
        border-bottom-color: #EC4899;
        color: #EC4899;
    }

    /* --- HERO GRID (responsive flex) --- */
    .hero-grid {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        gap: clamp(1.5rem, 4vw, 3rem);
        margin: clamp(1.5rem, 5vw, 3rem) 0;
    }

    .hero-grid>* {
        flex: 1 1 300px;
    }

    /* left visual zone */
    .visual-zone {
        background: transparent;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        /* changed for mobile later */
    }

    .big-404 {
        font-size: clamp(6rem, 18vw, 12rem);
        font-weight: 700;
        line-height: 0.9;
        color: #EC4899;
        text-shadow: clamp(4px, 1.5vw, 8px) clamp(4px, 1.5vw, 8px) 0 #FCE7F3;
        letter-spacing: -2px;
        margin-bottom: 0.8rem;
        word-break: break-word;
    }

    .big-404 span {
        color: #ddd;
        text-shadow: none;
        font-weight: 300;
        opacity: 0.3;
    }

    .fashion-scribble {
        display: flex;
        gap: clamp(0.8rem, 3vw, 2rem);
        align-items: center;
        flex-wrap: wrap;
        margin: 1rem 0 1.5rem 0;
    }

    .scribble-item {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #FCE7F3;
        padding: 0.5rem 1.2rem;
        border-radius: 60px;
        color: #EC4899;
        font-weight: 500;
        font-size: clamp(0.9rem, 2.5vw, 1.1rem);
        white-space: nowrap;
    }

    .scribble-item i {
        font-size: 1.2rem;
    }

    .dress-doodle {
        font-size: clamp(2.5rem, 8vw, 4rem);
        color: #EC4899;
        opacity: 0.6;
        margin-top: 0.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .dress-doodle i {
        transition: transform 0.2s;
    }

    .dress-doodle i:hover {
        transform: translateY(-4px);
        opacity: 1;
    }

    /* right message zone */
    .message-zone {
        padding: 0.5rem 0 0.5rem clamp(1rem, 4vw, 2.5rem);
        border-left: 3px solid #FCE7F3;
    }

    .pre-tag {
        color: #EC4899;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        font-weight: 600;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .pre-tag i {
        font-size: 1.1rem;
    }

    .message-zone h1 {
        font-size: clamp(2rem, 6vw, 3.2rem);
        font-weight: 500;
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    .message-zone h1 strong {
        color: #EC4899;
        font-weight: 700;
        background: #FCE7F3;
        padding: 0.1rem 0.4rem;
        display: inline-block;
    }

    .description {
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        color: #3e3e3e;
        max-width: 480px;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    /* action row — stack on small */
    .action-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin: 2rem 0 1.5rem;
    }

    .btn {
        text-decoration: none;
        padding: 0.8rem 2rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s;
        border: 2px solid transparent;
        flex: 0 1 auto;
    }

    .btn-primary {
        background: #EC4899;
        color: white;
        box-shadow: 0 8px 18px -6px #EC4899;
    }

    .btn-primary:hover {
        background: #ce3c82;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -8px #EC4899;
    }

    .btn-outline {
        background: transparent;
        border: 2px solid #EC4899;
        color: #EC4899;
    }

    .btn-outline:hover {
        background: #FCE7F3;
        border-color: #EC4899;
        transform: translateY(-2px);
    }

    /* shop strip + pills (always wrap) */
    .shop-strip {
        margin: 2rem 0 1rem;
    }

    .shop-strip p {
        font-weight: 600;
        margin-bottom: 1rem;
        color: #2c2c2c;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        flex-wrap: wrap;
        font-size: clamp(0.95rem, 2.5vw, 1.1rem);
    }

    .pill-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.7rem;
    }

    .pill {
        background: #f6f6f6;
        padding: 0.6rem 1.4rem;
        border-radius: 50px;
        font-weight: 500;
        text-decoration: none;
        color: #1e1e1e;
        transition: 0.15s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #eee;
        font-size: clamp(0.9rem, 2vw, 1rem);
        white-space: nowrap;
    }

    .pill i {
        color: #EC4899;
        font-size: 0.9rem;
    }

    .pill:hover {
        background: #FCE7F3;
        border-color: #EC4899;
        color: #EC4899;
    }

    /* extra hint chip – fully responsive */
    .hint-chip {
        margin-top: 2rem;
        background: #FCE7F3;
        padding: 0.7rem 1.4rem;
        border-radius: 100px;
        display: inline-block;
        color: #1e1e1e;
        font-weight: 400;
        font-size: clamp(0.85rem, 2.2vw, 0.95rem);
        max-width: 100%;
        white-space: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .hint-chip i {
        color: #EC4899;
        margin-right: 6px;
    }

    /* bottom links – wrap & scale */
    .foot-links {
        display: flex;
        flex-wrap: wrap;
        gap: 1.2rem 2.2rem;
        margin-top: clamp(2.5rem, 7vw, 4rem);
        padding-top: 2rem;
        border-top: 2px dashed #FCE7F3;
        font-size: clamp(0.9rem, 2.2vw, 1rem);
    }

    .foot-links a {
        text-decoration: none;
        color: #4b4b4b;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: color 0.2s;
    }

    .foot-links a i {
        color: #EC4899;
        transition: transform 0.2s;
    }

    .foot-links a:hover {
        color: #EC4899;
    }

    .foot-links a:hover i {
        transform: scale(1.1);
    }

    /* fashion quote – adapts */
    .quote {
        text-align: right;
        font-style: italic;
        color: #EC4899;
        opacity: 0.7;
        margin-top: 2.2rem;
        font-size: clamp(0.9rem, 2.2vw, 1rem);
        border-left: 4px solid #FCE7F3;
        padding-left: clamp(1rem, 4vw, 2rem);
        max-width: 80%;
        margin-left: auto;
    }

    /* ===== ADVANCED RESPONSIVE FIXES ===== */
    @media (max-width: 850px) {
        .message-zone {
            border-left: none;
            padding-left: 0;
        }

        .visual-zone {
            align-items: center;
            text-align: center;
        }

        .fashion-scribble {
            justify-content: center;
        }

        .dress-doodle {
            justify-content: center;
        }

        .big-404 {
            text-align: center;
            width: 100%;
        }

        .hero-grid {
            gap: 2rem;
        }
    }

    @media (max-width: 600px) {
        .full-404 {
            padding: 1.2rem;
        }

        .top-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .mini-nav {
            width: 100%;
            justify-content: space-between;
        }

        .action-row .btn {
            flex: 1 1 auto;
            min-width: 160px;
        }

        .hint-chip {
            white-space: normal;
            word-break: break-word;
            text-align: center;
            width: auto;
            display: inline-block;
        }

        .foot-links {
            justify-content: space-between;
            gap: 1rem;
        }
    }

    @media (max-width: 430px) {
        .action-row {
            flex-direction: column;
        }

        .action-row .btn {
            width: 100%;
            justify-content: center;
        }

        .pill {
            white-space: normal;
            word-break: keep-all;
            flex: 1 1 auto;
            justify-content: center;
        }

        .pill-group {
            justify-content: center;
        }

        .mini-nav {
            gap: 0.8rem;
            justify-content: flex-start;
        }

        .quote {
            max-width: 100%;
            text-align: left;
            margin-left: 0;
        }

        .foot-links {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.8rem;
        }
    }

    /* tiny screens (<=360) */
    @media (max-width: 360px) {
        .scribble-item {
            white-space: normal;
            text-align: center;
            padding: 0.5rem 1rem;
        }

        .fashion-scribble {
            flex-direction: column;
            align-items: stretch;
        }

        .dress-doodle {
            font-size: 2.5rem;
            justify-content: center;
        }

        .big-404 {
            font-size: 5rem;
        }
    }

    /* ensure no overflow issues */
    img,
    svg,
    i {
        max-width: 100%;
        vertical-align: middle;
    }

    /* interactive touch-friendly */
    a,
    button,
    .pill,
    .btn {
        cursor: pointer;
        -webkit-tap-highlight-color: rgba(236, 72, 153, 0.1);
    }

    /* subtle hover for all links */
    a:focus-visible {
        outline: 2px solid #EC4899;
        outline-offset: 4px;
        border-radius: 4px;
    }
</style>


<div class="full-404">


    <!-- main flexible grid -->
    <div class="hero-grid">
        <!-- left side: visual (centered on mobile) -->
        <div class="visual-zone">
            <div class="big-404">
                4<span>0</span>4
            </div>
            <div class="fashion-scribble">
                <span class="scribble-item"><i class="fas fa-vest"></i> ready-to-wear</span>
                <span class="scribble-item"><i class="fas fa-gem"></i> limited</span>
            </div>
            <div class="dress-doodle">
                <i class="fas fa-tshirt"></i>
                <i class="fas fa-handbag"></i>
                <i class="fas fa-shoe-prints"></i>
                <i class="fas fa-hat-cowboy"></i>
            </div>
            <div style="margin-top: 1rem; color:#EC4899; opacity:0.4; font-size: clamp(1.8rem, 6vw, 2.2rem);">
                <i class="fas fa-hanger"></i>
            </div>
        </div>

        <!-- right side: message & navigation -->
        <div class="message-zone">
            <div class="pre-tag">
                <i class="fas fa-map-signs"></i> lost your way?
            </div>
            <h1>
                this <strong>look</strong><br>
                isn't on the runway.
            </h1>
            <p class="description">
                The link might be having a fitting moment — or it never existed.
                Either way, let's get you back to something beautiful.
            </p>

            <!-- action row: stacks nicely on small devices -->
            <div class="action-row">
                <a href="{{route('page.index')}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> home</a>
                {{--<a href="#" class="btn btn-outline"><i class="fas fa-tag"></i> sale picks</a>--}}
            </div>

            <!-- category pills: always wrap, mobile optimised -->
            {{--<div class="shop-strip">
                <p><i class="fa-regular fa-heart"></i> keep browsing</p>
                <div class="pill-group">
                    <a href="#" class="pill"><i class="fas fa-dress"></i> dresses</a>
                    <a href="#" class="pill"><i class="fas fa-vest"></i> tops</a>
                    <a href="#" class="pill"><i class="fas fa-shoe-prints"></i> footwear</a>
                    <a href="#" class="pill"><i class="fas fa-gem"></i> jewelry</a>
                    <a href="#" class="pill"><i class="fas fa-bag-shopping"></i> bags</a>
                </div>
            </div>

            <!-- extra hint – fully responsive chip -->
            <div class="hint-chip">
                <i class="fas fa-gift"></i> free shipping on orders over $150
            </div>--}}
        </div>
    </div>


</div>

</body>
</html>