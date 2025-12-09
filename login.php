<?php
session_start();
include 'koneksi.php';

$message = ""; 

if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];


    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {

        $message = "<script>alert('Username sudah terdaftar! Silakan gunakan nama lain.');</script>";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if (mysqli_query($conn, $query)) {
            $message = "<script>alert('Pendaftaran Berhasil! Silakan Login.');</script>";
        } else {
            $message = "<script>alert('Terjadi kesalahan saat mendaftar.');</script>";
        }
    }
}


if (isset($_POST['signin'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];


    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        

        if (password_verify($password, $data['password'])) {
            
            $_SESSION['username'] = $username;
            $_SESSION['status'] = "login";
            header("Location: index.php"); 
            exit;
        } else {
            
            $message = "<script>alert('Password salah!');</script>";
        }
    } else {
        
        $message = "<script>alert('Username tidak terdaftar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up - LiteForum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: #f6f5f7; display: flex; justify-content: center; align-items: center;
            flex-direction: column; height: 100vh; margin: 0;
        }

        .container {
            background-color: #dcead8; 
            border-radius: 20px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            position: relative; overflow: hidden; width: 850px; max-width: 100%; min-height: 550px;
        }

        .form-container {
            position: absolute; top: 0; height: 100%; transition: all 0.6s ease-in-out;
        }

        
        form {
            background-color: #dcead8; display: flex; align-items: center; justify-content: center;
            flex-direction: column; padding: 0 50px; height: 100%; text-align: center;
        }
        h1 { font-weight: bold; margin: 0; color: #3d5636; margin-bottom: 20px;}
        span { font-size: 12px; margin-bottom: 10px; color: #666; }
        
        .infield {
            position: relative; margin: 8px 0; width: 100%;
        }
        input {
            background-color: #fff; border: none; padding: 12px 15px; margin: 8px 0; width: 100%;
            border-radius: 10px; outline: none;
        }
        label {
            font-size: 12px; font-weight: 600; color: #333; display: block; text-align: left; margin-left: 5px;
        }

        button {
            border-radius: 20px; border: 1px solid #3d5636; background-color: #3d5636;
            color: #FFFFFF; font-size: 12px; font-weight: bold; padding: 12px 45px;
            letter-spacing: 1px; text-transform: uppercase; transition: transform 80ms ease-in; cursor: pointer;
            margin-top: 20px;
        }
        button:active { transform: scale(0.95); }
        button:focus { outline: none; }
        button.ghost { background-color: transparent; border-color: #FFFFFF; }

        
        .sign-in-container { left: 0; width: 50%; z-index: 2; }
        .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }

        .container.right-panel-active .sign-in-container { transform: translateX(100%); }
        .container.right-panel-active .sign-up-container {
            transform: translateX(100%); opacity: 1; z-index: 5; animation: show 0.6s;
        }

        @keyframes show { 0%, 49.99% { opacity: 0; z-index: 1; } 50%, 100% { opacity: 1; z-index: 5; } }

        
        .overlay-container {
            position: absolute; top: 0; left: 50%; width: 50%; height: 100%;
            overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100;
        }
        .container.right-panel-active .overlay-container { transform: translateX(-100%); }

        .overlay {
            background: #3d5636; 
            background: -webkit-linear-gradient(to right, #3d5636, #4a6741);
            background: linear-gradient(to right, #3d5636, #4a6741);
            background-repeat: no-repeat; background-size: cover; background-position: 0 0;
            color: #FFFFFF; position: relative; left: -100%; height: 100%; width: 200%;
            transform: translateX(0); transition: transform 0.6s ease-in-out;
        }
        .container.right-panel-active .overlay { transform: translateX(50%); }

        .overlay-panel {
            position: absolute; display: flex; align-items: center; justify-content: center;
            flex-direction: column; padding: 0 40px; text-align: center; top: 0; height: 100%; width: 50%; transform: translateX(0); transition: transform 0.6s ease-in-out;
        }
        .overlay-left { transform: translateX(-20%); }
        .container.right-panel-active .overlay-left { transform: translateX(0); }
        .overlay-right { right: 0; transform: translateX(0); }
        .container.right-panel-active .overlay-right { transform: translateX(20%); }

        
        .overlay-panel h1 { color: white; }
        .overlay-panel p { margin: 20px 0 30px; font-size: 14px; font-weight: 100; line-height: 20px; }

        .social-container { margin: 20px 0; }
        .social-container a {
            border: 1px solid #DDDDDD; border-radius: 50%; display: inline-flex;
            justify-content: center; align-items: center; margin: 0 5px; height: 40px; width: 40px;
        }
    </style>
</head>
<body>

<?php echo $message; ?>

<div class="container" id="container">
    
    <div class="form-container sign-up-container">
        <form action="" method="POST">
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your email for registration</span>
            
            <input type="text" name="username" placeholder="Username (Min 8 char)" required minlength="8" />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            
            <button type="submit" name="signup">Sign Up</button>
        </form>
    </div>

    <div class="form-container sign-in-container">
        <form action="" method="POST">
            <h1>Sign in</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your account</span>
            
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <a href="#">Forgot your password?</a>
            
            <button type="submit" name="signin">Sign In</button>
        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Selamat Datang Kembali!</h1>
                <p>Masukkan detail pribadi Anda dan mulailah perjalanan bersama kami</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            
            <div class="overlay-panel overlay-right">
                <h1>Hallo, Teman!</h1>
                <p>Masukkan detail pribadi Anda dan mulailah perjalanan bersama kami</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>

</body>
</html>