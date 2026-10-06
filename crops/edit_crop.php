<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_crops.php");
    exit();
}

$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM crops WHERE id=$id");

if ($result->num_rows == 0) {
    header("Location: view_crops.php");
    exit();
}

$crop = $result->fetch_assoc();

/* UPDATE CROP */
if (isset($_POST['update'])) {

    $crop_name = $_POST['crop_name'];
    $sowing_date = $_POST['sowing_date'];
    $harvest_date = $_POST['harvest_date'];
    $status = $_POST['status'];

    $conn->query("UPDATE crops SET 
                    crop_name='$crop_name',
                    sowing_date='$sowing_date',
                    harvest_date='$harvest_date',
                    status='$status'
                  WHERE id=$id");

    header("Location: view_crops.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Crop - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* SHIFT MAIN CONTENT DUE TO SIDEBAR */
        .main-content{
            margin-left:230px;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card{
            width:420px;
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
        }

        .title{
            text-align:center;
            font-size:22px;
            font-weight:700;
            margin-bottom:20px;
            color:#1f2a40;
        }

        label{
            font-size:13px;
            font-weight:600;
            color:#555;
        }

        input, select{
            width:100%;
            padding:10px;
            margin:6px 0 15px 0;
            border:1px solid #ddd;
            border-radius:8px;
            font-size:14px;
            outline:none;
        }

        input:focus, select:focus{
            border-color:#00d4ff;
        }

        .btn{
            width:100%;
            padding:12px;
            background:#1f2a40;
            color:white;
            border:none;
            border-radius:8px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
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

    <div class="title">✏ Edit Crop</div>

    <form method="POST">

        <label>Crop Name</label>
        <input type="text" name="crop_name"
               value="<?php echo htmlspecialchars($crop['crop_name']); ?>" required>

        <label>Sowing Date</label>
        <input type="date" name="sowing_date"
               value="<?php echo $crop['sowing_date']; ?>" required>

        <label>Harvest Date</label>
        <input type="date" name="harvest_date"
               value="<?php echo $crop['harvest_date']; ?>" required>

        <label>Status</label>
        <select name="status" required>
            <option value="Growing" <?php if($crop['status']=="Growing") echo "selected"; ?>>Growing</option>
            <option value="Ready" <?php if($crop['status']=="Ready") echo "selected"; ?>>Ready</option>
            <option value="Harvested" <?php if($crop['status']=="Harvested") echo "selected"; ?>>Harvested</option>
        </select>

        <button type="submit" name="update" class="btn">
            Update Crop
        </button>

    </form>

    <a class="back" href="view_crops.php">← Back to Crops</a>

</div>

</div>

</body>
</html>