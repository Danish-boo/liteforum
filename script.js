// script.js

function tambahDiskusi() {
    // Di sini Anda bisa mengarahkan ke halaman form atau membuka modal
    alert("Fitur 'Tambahkan Diskusi' akan membuka form pembuatan thread baru.");
}

// Fitur Search Sederhana (Client Side filtering demo)
const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        alert('Mencari topik: ' + searchInput.value);
        // buat dihubungin ke PHP $_GET['search']
    }

function likeThread(threadId) {
    const formData = new FormData();
    formData.append('id', threadId);

    fetch('like.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) 
    .then(jumlahLikeBaru => {
        if (jumlahLikeBaru) {
            document.getElementById('like-count').innerText = jumlahLikeBaru;
            const btn = document.querySelector('.btn-like');
            btn.style.backgroundColor = '#4a6741';
            btn.style.color = 'white';
            btn.innerHTML = '<i class="fa-solid fa-thumbs-up"></i> <span id="like-count">' + jumlahLikeBaru + '</span> Liked';
        }
    })
    .catch(error => console.error('Error:', error));

}
});