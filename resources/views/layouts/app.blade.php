<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#082c2d">
    <title>@yield('title', 'Solusi Net Nusantara | Koneksi untuk berkembang')</title>
    <meta name="description" content="PT Solusi Net Nusantara menyediakan layanan internet fiber, instalasi jaringan, dan dukungan teknis untuk rumah serta bisnis.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <header class="site-header">
        <div class="container nav-inner">
            <a class="brand" href="{{ route('home') }}" aria-label="Solusi Net Nusantara, beranda"><span class="brand-mark"><i class="fa-solid fa-wifi"></i></span><span class="brand-name">solusi<span>net</span><small>NUSANTARA</small></span></a>
            <button class="menu-toggle" type="button" aria-label="Buka navigasi" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
            <nav class="main-nav" id="main-nav" aria-label="Navigasi utama">
                <a href="{{ route('home') }}#tentang">Tentang</a><a href="{{ route('home') }}#layanan">Layanan</a><a href="{{ route('home') }}#galeri">Galeri</a><a href="{{ route('home') }}#kontak">Kontak</a>
                @auth
                    @if (auth()->user()->isAdmin())<a class="nav-account" href="{{ route('admin.index') }}">Admin <i class="fa-solid fa-arrow-up-right-from-square"></i></a>@else<span class="nav-user">Hai, {{ Str::before(auth()->user()->name, ' ') }}</span>@endif
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="nav-login" type="submit">Keluar <i class="fa-solid fa-arrow-right-from-bracket"></i></button></form>
                @else<a class="nav-login" href="{{ route('login') }}">Masuk <i class="fa-solid fa-arrow-right"></i></a>@endauth
            </nav>
        </div>
    </header>
    @if (session('status'))<div class="toast" role="status"><i class="fa-regular fa-circle-check"></i><span>{{ session('status') }}</span><button type="button" aria-label="Tutup pemberitahuan"><i class="fa-solid fa-xmark"></i></button></div>@endif
    @if ($errors->any())<div class="toast toast-error" role="alert"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $errors->first() }}</span><button type="button" aria-label="Tutup pemberitahuan"><i class="fa-solid fa-xmark"></i></button></div>@endif
    @yield('content')
    <footer class="site-footer">
        <div class="container footer-main"><a class="brand brand-footer" href="{{ route('home') }}"><span class="brand-mark"><i class="fa-solid fa-wifi"></i></span><span class="brand-name">solusi<span>net</span><small>NUSANTARA</small></span></a><p>Menghubungkan hari ini,<br>membuka kemungkinan esok.</p><div class="footer-social"><a href="https://instagram.com" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a><a href="https://linkedin.com" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a><a href="https://facebook.com" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a></div></div>
        <div class="container footer-bottom"><span>© {{ date('Y') }} PT Solusi Net Nusantara</span><span>Internet & jaringan, dengan tujuan.</span><a href="#beranda">Kembali ke atas ↑</a></div>
    </footer>
</body>
</html>