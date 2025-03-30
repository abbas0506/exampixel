<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Automated question paper generation system')</title>
    {{-- <title>exampixel</title> --}}
    <link rel="icon" href="{{ asset('/images/logo/fav-ico.png') }}">
    <!-- Fonts -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <!-- <script src="{{ asset('js/html5-qrcode.min.js') }}"></script> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/swiper.css') }}">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4509942648157267"
        crossorigin="anonymous"></script>
    {{-- Meta Tags for SEO --}}
    <meta name="description"
        content="Exampixel is built for educators and students to create exams, quizzes, and generate papers for SSC, HSS/Intermediate levels. An easy-to-use platform for seamless paper creation and online test management.">
    <meta name="keywords"
        content="Exampixel, take exam, paper generation, paper making, quiz, SSC paper generation, HSS paper generation, intermediate paper creation, online exam, online quiz platform, online test system, exam management, test mak">

    {{-- og tags for social media --}}
    <meta property="og:title" content="Exampixel - Streamline Exam Creation for Educators">
    <meta property="og:description"
        content="Create exams, quizzes, and generate papers with Exampixel - your go-to platform for SSC, HSS/Intermediate paper making and online test management.">
    <meta property="og:image" content="@yield('ogimage', asset('/images/logo/exampixel-0.png'))">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:site_name" content="Exampixel">
    <meta property="og:type" content="website">

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TD8RFZQV');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TD8RFZQV" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BN651Z3VC4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-BN651Z3VC4');
    </script>

    @yield('header')
    @yield('sidebar')

    @yield('body')
    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
            CommonHTML: {
            linebreaks: {automatic: false}
            }
        });
    </script>

    <script src="{{ asset('js/sweetalert2@10.js') }}"></script>
    <script type="module" src="{{ asset('js/collapsible.js') }}"></script>
    <script type="module" src="{{ asset('js/swiper.js') }}"></script>
    <script type="module" src="{{ asset('js/testimonial.js') }}"></script>
    <script type="module" src="{{ asset('js/flowbite.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <!-- <script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
    </script> -->
    @yield('script')
    @yield('footer')

    <div class="responsive-body">
        @yield('page-content')
    </div>

    <script type="module">
        $('#menu').click(function() {
            $("aside").toggleClass('shown');
        });

        $('.responsive-container').click(function(event) {
            var box = $('#sidebar');
            if (!box.is(event.target) && box.has(event.target).length === 0) {
                box.removeClass('shown');
            }
        })
    </script>
</body>

</html>