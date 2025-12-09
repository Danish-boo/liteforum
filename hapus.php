<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin123') {
    echo "<script>
            alert('Anda tidak memiliki akses untuk menghapus thread ini!');
            window.location.href='index.php';
        </script>";
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM comments WHERE thread_id = '$id'");
    
    // apus thread nya
    $query = "DELETE FROM threads WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Diskusi berhasil dihapus oleh Admin.');
                window.location.href='index.php';
            </script>";
    } else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
}
?>