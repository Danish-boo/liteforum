<?php
session_start();

include 'koneksi.php';

// Pastikan hanya user yang sudah login yang bisa membuat thread
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

$message = '';

$username_author = $_SESSION['username']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    
    $category_id = 1; 

    if (empty($title) || empty($content)) {
        $message = '<p style="color: red;">Judul dan konten diskusi wajib diisi!</p>';
    } else {
        $sql = "INSERT INTO threads (title, author, content, date_created, category_id, likes, comments) 
                VALUES (?, ?, ?, NOW(), ?, 0, 0)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $title, $username_author, $content, $category_id);
            
            if ($stmt->execute()) {
                header("Location: index.php?status=success_thread");
                exit();
            } else {
                $message = '<p style="color: red;">Error saat menyimpan: ' . $stmt->error . '</p>';
            }
            $stmt->close();
        } else {
            $message = '<p style="color: red;">Error preparing statement: ' . $conn->error . '</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambahkan Diskusi Baru - LiteForum</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #f7f9f7;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            text-align: center;
            color: #4a6741;
            margin-bottom: 25px;
            border-bottom: 2px solid #4a6741;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-group textarea {
            min-height: 200px;
            resize: vertical;
        }
        .submit-btn {
            background-color: #4a6741;
            color: white;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #3d5636;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4a6741;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Buat Thread Diskusi Baru</h2>
    <?php echo $message;?>
    
    <form action="" method="post">
        <div class="form-group">
            <label for="title">Judul Diskusi:</label>
            <input type="text" id="title" name="title" required placeholder="Tulis judul yang menarik...">
        </div>
        
        <div class="form-group">
            <label for="content">Isi Diskusi:</label>
            <textarea id="content" name="content" required placeholder="Jelaskan detail diskusi Anda di sini..."></textarea>
        </div>
        
        <button type="submit" class="submit-btn">Kirim Diskusi</button>
    </form>
    
    <a href="index.php" class="back-link">← Kembali ke Beranda</a>
</div>

</body>
</html>