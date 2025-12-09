<?php
include 'koneksi.php';

if(isset($_POST['id'])) {
    $id_thread = intval($_POST['id']);

    $query_update = "UPDATE threads SET likes = likes + 1 WHERE id = $id_thread";
    mysqli_query($conn, $query_update);

    $query_get = "SELECT likes FROM threads WHERE id = $id_thread";
    $result = mysqli_query($conn, $query_get);
    $data = mysqli_fetch_assoc($result);

    echo $data['likes'];
}
?>