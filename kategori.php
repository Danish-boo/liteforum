<?php


$kategori = [
    ["nama" => "Teknologi", "jumlah" => "10.000"],
    ["nama" => "Pendidikan", "jumlah" => "5.367"],
    ["nama" => "Seni", "jumlah" => "2.892"],
    ["nama" => "Olahraga", "jumlah" => "1.346"],
    ["nama" => "Game", "jumlah" => "1.303"],
    ["nama" => "Kesehatan", "jumlah" => "1.288"],
    ["nama" => "Kuliner", "jumlah" => "1.187"],
    ["nama" => "Film", "jumlah" => "1.006"],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kategori Diskusi</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #e2f4d7;
    }

    .header {
        width: 100%;
        height: 350px;
        background-image: url("berdiskusi.jpeg");
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        align-items: center;
        padding: 40px;
    }

    .home {
        position: absolute;
        top: 20px;
        left: 30px;
        font-size: 22px;
        font-weight: bold;
        color: #060606;
        z-index: 3;
        cursor: pointer;
        text-decoration: none;
    }

    .home:hover { opacity: 0.7; }

    .header-overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.6);
        top: 0;
        left: 0;
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .judul { font-size: 32px; font-weight: bold; color: #171616; }
    .subjudul { color: #444; margin: 10px 0 20px; }

    .search-box {
        display: flex;
        align-items: center;
        background: white;
        width: 350px;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
    }

    .search-box input {
        border: none;
        outline: none;
        width: 100%;
    }

    .populer-text {
        margin-top: 20px;
        font-size: 20px;
        font-weight: bold;
        color: black;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    .populer-text:hover { opacity: 0.7; }

    .kategori-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        padding: 20px;
    }

    .card {
        background: #d6eac9;
        padding: 20px;
        border-radius: 20px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        color: #2b402e;
        box-shadow: 0px 3px 6px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: 0.2s;
        text-decoration: none;
        display: block;
    }

    .card:hover { transform: scale(1.05); }

    .jumlah { margin-top: 8px; font-size: 14px; color: #444; }
</style>
</head>
<body>

<div class="header">
    <div class="header-overlay"></div>

    <a href="home.php" class="home">🏠 HOME</a>

    <div class="header-content">
        <div class="judul">Kategori Diskusi</div>
        <div class="subjudul">“Temukan topik yang kamu minati dan bergabung!”</div>

        <div class="search-box">
            🔍 <input type="text" placeholder="Search Here......">
        </div>

        <a href="populer.php" class="populer-text">Populer sekarang →</a>
    </div>
</div>

<div class="kategori-container">

    <?php foreach ($kategori as $k): ?>
        <a href="kategori.php?nama=<?= urlencode($k['nama']) ?>" class="card">
            <?= $k['nama'] ?>
            <div class="jumlah"><?= $k['jumlah'] ?> post</div>
        </a>
    <?php endforeach; ?>

</div>

</body>
</html>
