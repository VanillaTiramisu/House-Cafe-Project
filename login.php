<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ganti 'admin_cafe' dan 'admin123' dengan username dan password yang Anda inginkan
    if ($username === 'admin_cafe' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.html');
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>House Cafe</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/tailwind.css" />
    <link rel="stylesheet" href="css/house-cafe.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('img/loginbackground.png') no-repeat center center/cover; 
        }
        .tm-item-container {
            background: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        .error { color: white; /* Menetapkan warna teks menjadi putih */ margin-top: 10px;}
    </style>
</head>
<body>
    <div class="tm-item-container">
        <h2 class="mb-6 text-white text-4xl font-medium">
            Login Admin
        </h2>
        <form id="Login" class="text-lg" action="" method="POST">
            <input 
                type="text" 
                name="username" 
                class="input w-full bg-black border-b bg-opacity-0 text-white px-0 py-4 mb-4 tm-border-gold" 
                placeholder="Username" 
                required 
            />
            <input 
                type="password" 
                name="password" 
                class="input w-full bg-black border-b bg-opacity-0 text-white px-0 py-4 mb-4 tm-border-gold" 
                placeholder="Password" 
                required 
            />
            <div class="flex justify-between items-center">
            <a href="intro.html" class="text-white hover:text-yellow-500 transition">
                <span>Back</span>
            </a>
            <button type="submit" class="text-white hover:text-yellow-500 transition">Login</button>
        </div>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
