<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Farm - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* MAIN CONTENT SHIFT (because sidebar is fixed) */
        .main-content{
            margin-left:230px;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card{
            background:white;
            width:420px;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
        }

        .title{
            text-align:center;
            font-size:20px;
            font-weight:700;
            color:#1f2a40;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ddd;
            border-radius:8px;
            outline:none;
            font-size:14px;
            box-sizing:border-box;
        }

        input:focus{
            border-color:#00d4ff;
        }

        button{
            width:100%;
            padding:12px;
            background:#1f2a40;
            color:white;
            border:none;
            border-radius:8px;
            font-size:15px;
            cursor:pointer;
        }

        button:hover{
            background:#00d4ff;
            color:black;
        }

        .msg{
            margin-top:15px;
            text-align:center;
            font-weight:600;
        }

        .success{ color:green; }
        .error{ color:red; }

        .back{
            display:block;
            text-align:center;
            margin-top:15px;
            text-decoration:none;
            color:#1f2a40;
            font-weight:600;
        }

        .back:hover{
            color:#00d4ff;
        }
    </style>
</head>

<body>

<div class="main-content">

<div class="card">

    <div class="title">🌾 Add New Farm</div>

    <form method="POST">

        <input type="text" name="farm_name" placeholder="Farm Name" required>

        <input type="text" name="location" placeholder="Location">

        <button type="submit" name="save">Save Farm</button>

    </form>

<?php
if (isset($_POST['save'])) {

    $farm_name = $_POST['farm_name'];
    $location = $_POST['location'];

    $sql = "INSERT INTO farms (farm_name, location)
            VALUES ('$farm_name', '$location')";

    if ($conn->query($sql)) {
        echo "<div class='msg success'>✔ Farm Added Successfully</div>";
    } else {
        echo "<div class='msg error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<a class="back" href="view_farms.php">← Back to Farms</a>

</div>

</div>

</body>
</html>