<?php
session_start();
include("includes/db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        html, body{
            height:100%;
            margin:0;
        }

        body{
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1f2a40, #2c3e50);

            display:flex;
            justify-content:center;
            align-items:center;

            min-height:100vh;
        }

        .login-box{
            background:white;
            width:350px;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
            text-align:center;
        }

        .login-box h2{
            margin-bottom:20px;
            color:#1f2a40;
        }

        .login-box input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ddd;
            border-radius:8px;
            outline:none;
            font-size:14px;
            box-sizing:border-box;
        }

        .login-box input:focus{
            border-color:#1f2a40;
        }

        .login-box button{
            width:100%;
            padding:12px;
            background:#1f2a40;
            color:white;
            border:none;
            border-radius:8px;
            font-size:15px;
            cursor:pointer;
            transition:0.3s;
        }

        .login-box button:hover{
            background:#00d4ff;
            color:black;
        }

        .error{
            color:red;
            margin-top:10px;
            font-size:14px;
        }

        .title{
            font-size:18px;
            font-weight:700;
            margin-bottom:10px;
            color:#00d4ff;
        }
    </style>
</head>

<body>

<div class="login-box">

    <div class="title">🌾 Syed Farm House 🌾</div>
    <h2>Login</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit" name="login">Login</button>
    </form>

<?php
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit();

    } else {
        echo "<div class='error'>❌ Wrong Username or Password</div>";
    }
}
?>

</div>

</body>
</html>