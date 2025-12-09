<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteForum</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <i class="fa-solid fa-globe"></i> LiteForum
        </div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Kategori</a>
            <a href="#">Thread Baru</a>
            <a href="#">Profil</a>
        </div>
        <div class="auth-buttons">
    <span style="margin-right:10px; font-weight:bold; color:#4a6741;">Hi, <?php echo $_SESSION['username']; ?></span>
    <a href="logout.php" class="btn btn-daftar">Logout</a>
</div>
    </nav>

    <header class="hero">
        <h1>FORUM DISKUSI</h1>
        <p>"Forum yang menghadirkan ruang aman untuk bertanya, berbagi, dan memahami hal-hal baru."</p>
        
        <div class="hero-card">
            <h2>Disini Kita Ada Untuk Membantu</h2>
            <div class="search-container">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Mencari diskusi...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <a href="create_thread.php" class="btn-primary">Tambahkan Diskusi</a>
            </div>
        </div>
    </header>

    <section class="categories">
        <?php
        $query_cat = "SELECT * FROM categories";
        $result_cat = mysqli_query($conn, $query_cat);

        while($row = mysqli_fetch_assoc($result_cat)) {
            echo '
            <div class="cat-card">
                <h3>'.$row['name'].'</h3>
                <span>'.number_format($row['post_count']).' post</span>
            </div>';
        }
        ?>
    </section>

    <section class="latest-threads">
    <h2>Thread Terbaru</h2>
    
    <?php
    $query_thread = "SELECT * FROM threads ORDER BY date_created DESC";
    $result_thread = mysqli_query($conn, $query_thread);

while($thread = mysqli_fetch_assoc($result_thread)) {
    
    $tombol_hapus = "";
    if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin123') {
        $tombol_hapus = '
        <a href="hapus.php?id='.$thread['id'].'" class="btn-hapus" onclick="return confirm(\'Yakin ingin menghapus diskusi ini?\')">
            <i class="fa-solid fa-trash"></i> Hapus
        </a>';
    }

    echo '
    <div class="thread-item">
        <div class="thread-info">
            <div class="user-icon"><i class="fa-regular fa-user"></i></div>
            <div class="thread-content">
                <div class="thread-meta">
                    <span>By '.$thread['author'].'</span>
                </div>
                
                <h4><a href="detail.php?id='.$thread['id'].'">'.$thread['title'].'</a></h4>
                
                <div class="thread-meta">
                    <span>'.$thread['date_created'].'</span>
                    <span><i class="fa-regular fa-thumbs-up"></i> '.$thread['likes'].'</span>
                    <span><i class="fa-regular fa-comment"></i> '.$thread['comments'].'</span>
                    
                    '.$tombol_hapus.'
                </div>
            </div>
        </div>
    </div>';
    }
    ?>
</section>

</section>

    <section class="services-section" id="services">
        <div class="services-header">
            <h1>OUR SERVICES</h1>
            <p>Kami menyediakan berbagai layanan untuk mendukung forum diskusi Anda.</p>
            <a href="#" class="btn-contact">Contact Us</a>
        </div>

        <div class="services-container-box">
            <div class="cards-wrapper">
                
                <div class="service-card">
                    <div class="icon"><i class="fa-solid fa-headset"></i></div>
                    <h3>Consultation</h3>
                    <p>Dapatkan bantuan langsung dari tim admin forum kami.</p>
                </div>

                <div class="service-card">
                    <div class="icon"><i class="fa-solid fa-lightbulb"></i></div>
                    <h3>Best Ideas</h3>
                    <p>Temukan ide-ide hebat dari anggota komunitas.</p>
                </div>

                <div class="service-card">
                    <div class="icon"><i class="fa-solid fa-gear"></i></div>
                    <h3>Simple Setting</h3>
                    <p>Atur forum Anda dengan mudah melalui fitur kami.</p>
                </div>

            </div>
        </div>
    </section>
    
    <script src="script.js"></script>
</body>
</html>

    <script src="script.js"></script>
</body>
</html>