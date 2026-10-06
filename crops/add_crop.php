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
    <title>Add Crop - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* MAIN CONTENT SHIFT DUE TO SIDEBAR */
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

        input, select{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ddd;
            border-radius:8px;
            outline:none;
            font-size:14px;
            box-sizing:border-box;
            background:white;
        }

        input:focus, select:focus{
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
            transition:0.3s;
            margin-top:10px;
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

    <div class="title">🌱 Add New Crop</div>

    <form method="POST">

        <input type="text" name="crop_name" placeholder="Crop Name" required>

        <input type="date" name="sowing_date" required>

        <input type="date" name="harvest_date" required>

        <select name="status">
            <option value="Growing">🌱 Growing</option>
            <option value="Ready">🟢 Ready</option>
            <option value="Harvested">🌾 Harvested</option>
        </select>

        <button type="submit" name="save">Save Crop</button>

    </form>

<?php
if (isset($_POST['save'])) {

    $crop_name = $_POST['crop_name'];
    $sowing_date = $_POST['sowing_date'];
    $harvest_date = $_POST['harvest_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO crops (crop_name, sowing_date, harvest_date, status)
            VALUES ('$crop_name', '$sowing_date', '$harvest_date', '$status')";

    if ($conn->query($sql)) {
        echo "<div class='msg success'>✔ Crop Added Successfully</div>";
    } else {
        echo "<div class='msg error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<a class="back" href="view_crops.php">← Back to Crops</a>

</div>

</div>

</body>
</html>