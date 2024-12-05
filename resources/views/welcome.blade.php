
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelola Kontak id</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
<nav>
    <div class="logo">Pengelola Kontak Co.</div>
    <div class="menu-toggle">☰</div>
    <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">Features</a></li>
        <li><a href="#">Plans</a></li>
        <li><a href="#">Demo</a></li>
    </ul>
</nav>
<header>
    <h1 class="png">Pengelola</h1>
    <div class="lower">
        <div class="left-side">
            <h1 class="png knt">Kontak</h1>
        </div>
        <div class="right-side">
            <p>Kelola kontak Anda secara efisien dengan solusi komprehensif kami. Kami menyediakan layanan
                unggulan untuk semua kebutuhan manajemen kontak Anda. Platform kami menawarkan alat intuitif
                untuk membantu Anda tetap terorganisir dan terhubung. Rasakan integrasi yang mulus,
                produktivitas yang meningkat.
            </p>
            <a href="{{ route('contacts.index') }}">
                <button>Coba Sekarang</button></a>
            <p class="footer">© 2024 <a href="https://github.com/TitidTerbang" target="_blank"
                                        class="git">Titid Terbang</a></p>
        </div>
    </div>
</header>
</body>

</html>
