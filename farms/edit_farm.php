<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_farms.php");
    exit();
}

$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM farms WHERE id=$id");

if ($result->num_rows == 0) {
    header("Location: view_farms.php");
    exit();
}

$farm = $result->fetch_assoc();

/* UPDATE */
if (isset($_POST['update'])) {

    $farm_name = $_POST['farm_name'];
    $location = $_POST['location'];

    $conn->query("UPDATE farms 
                  SET farm_name='$farm_name',
                      location='$location'
                  WHERE id=$id");

    header("Location: view_farms.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Farm - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* SHIFT CONTENT DUE TO SIDEBAR */
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
            font-size:22px;
            font-weight:700;
            color:#1f2a40;
            margin-bottom:20px;
        }

        label{
            font-size:13px;
            color:#555;
            font-weight:600;
        }

        input{
            width:100%;
            padding:12px;
            margin:8px 0 15px 0;
            border:1px solid #ddd;
            border-radius:8px;
            font-size:14px;
            outline:none;
        }

        input:focus{
            border-color:#00d4ff;
        }

        .btn{
            width:100%;
            padding:12px;
            background:#1f2a40;
            color:white;
            border:none;
            border-radius:8px;
            font-size:15px;
            cursor:pointer;
            font-weight:600;
        }

        .btn:hover{
            background:#00d4ff;
            color:black;
        }

        .back{
            display:block;
            text-align:center;
            margin-top:15px;
            text-decoration:none;
            color:#1f2a40;
            font-weight:600;
            font-size:13px;
        }

        .back:hover{
            color:#00d4ff;
        }
    </style>
</head>

<body>

<div class="main-content">

<div class="card">

    <div class="title">✏ Edit Farm</div>

    <form method="POST">

        <label>Farm Name</label>
        <input type="text" name="farm_name"
               value="<?php echo htmlspecialchars($farm['farm_name']); ?>"
               required>

        <label>Location</label>
        <input type="text" name="location"
               value="<?php echo htmlspecialchars($farm['location']); ?>">

        <button type="submit" name="update" class="btn">
            Update Farm
        </button>

    </form>

    <a class="back" href="view_farms.php">← Back to Farms</a>

</div>

</div>

</body>
</html>