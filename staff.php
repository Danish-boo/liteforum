<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'forum_app';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM staff");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Forum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="staff-section">
    <div class="header">
        <h2>Our Team</h2>
        <p>Halaman ini menampilkan para staf yang mengelola, memantau, dan menjaga forum tetap rapi serta nyaman digunakan. Di sini pengguna bisa melihat siapa saja yang berada di balik jalannya komunitas.</p>
    </div>

    <div class="staff-container">
        <?php if ($result && $result->num_rows): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="staff-card">
                    <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" 
                         alt="<?= htmlspecialchars($row['nama']) ?>">

                    <h3><?= htmlspecialchars($row['nama']) ?></h3>
                    <p class="position">(<?= htmlspecialchars($row['jabatan']) ?>)</p>
                    <p class="description"><?= htmlspecialchars($row['deskripsi']) ?></p>

                    <div class="social-links">
                        <a href="<?= $row['whatsapp'] ?>" target="_blank"><img src="icon/whatsapp.png"></a>
                        <a href="<?= $row['linkedin'] ?>" target="_blank"><img src="icon/linkedin.png"></a>
                        <a href="<?= $row['instagram'] ?>" target="_blank"><img src="icon/social.png"></a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada data staff.</p>
        <?php endif; ?>
    </div>
</section>

</body>
</html>

<?php $conn->close(); ?>