<?php 
include 'koneksi.php'; 

$id_thread = $_GET['id'];

if(isset($_POST['submit_comment'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $isi = htmlspecialchars($_POST['isi']);
    
    $sql_insert = "INSERT INTO comments (thread_id, user_name, comment_text) VALUES ('$id_thread', '$nama', '$isi')";
    mysqli_query($conn, $sql_insert);

    mysqli_query($conn, "UPDATE threads SET comments = comments + 1 WHERE id = '$id_thread'");
}

$query = "SELECT * FROM threads WHERE id = '$id_thread'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?> - LiteForum</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo"><a href="index.php"><i class="fa-solid fa-arrow-left"></i> Kembali</a></div>
    </nav>

    <div class="container-detail">
        <div class="thread-full">
            <h1><?php echo $data['title']; ?></h1>
            <div class="meta-info">
                <span><i class="fa-solid fa-user"></i> <?php echo $data['author']; ?></span>
                <span><i class="fa-solid fa-calendar"></i> <?php echo $data['date_created']; ?></span>
            </div>
            <div class="thread-body">
                <p> <?php echo $data['content']; ?></p>
            </div>
            
            <div class="interaction-bar">
                <button class="btn-like" onclick="likeThread(<?php echo $data['id']; ?>)">
                    <i class="fa-regular fa-thumbs-up"></i> <span id="like-count"><?php echo $data['likes']; ?></span> Likes
                </button>
            </div>
        </div>

        <div class="comments-section">
            <h3>Komentar Diskusi</h3>
            
            <form method="POST" class="comment-form">
                <input type="text" name="nama" placeholder="Nama Anda" required>
                <textarea name="isi" placeholder="Tulis pendapatmu..." required></textarea>
                <button type="submit" name="submit_comment" class="btn-kirim">Kirim Komentar</button>
            </form>

            <div class="comment-list">
                <?php
                $q_komen = "SELECT * FROM comments WHERE thread_id = '$id_thread' ORDER BY created_at DESC";
                $r_komen = mysqli_query($conn, $q_komen);
                
                while($k = mysqli_fetch_assoc($r_komen)) {
                    echo '
                    <div class="comment-item">
                        <strong>'.$k['user_name'].'</strong>
                        <p>'.$k['comment_text'].'</p>
                        <small>'.$k['created_at'].'</small>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>