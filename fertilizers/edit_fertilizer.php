<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_fertilizers.php");
    exit();
}

$id = intval($_GET['id']);

/* FETCH EXISTING DATA */
$result = mysqli_query($conn, "SELECT * FROM fertilizers WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Record not found");
}

/* UPDATE DATA */
if (isset($_POST['update'])) {

    $field_id = $_POST['field_id'];
    $fertilizer_name = $_POST['fertilizer_name'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];
    $application_date = $_POST['application_date'];
    $notes = $_POST['notes'];

    $sql = "UPDATE fertilizers SET
            field_id='$field_id',
            fertilizer_name='$fertilizer_name',
            quantity='$quantity',
            cost='$cost',
            application_date='$application_date',
            notes='$notes'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: view_fertilizers.php");
        exit();
    } else {
        $error = "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Fertilizer - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* SIDEBAR SHIFT */
        .main-content{
            margin-left:230px;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card{
            width:450px;
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
        }

        .title{
            text-align:center;
            font-size:20px;
            font-weight:700;
            color:#1f2a40;
            margin-bottom:15px;
        }

        input, textarea{
            width:100%;
            padding:12px;
            margin:8px 0;
            border:1px solid #ddd;
            border-radius:8px;
            font-size:14px;
            box-sizing:border-box;
        }

        input:focus, textarea:focus{
            outline:none;
            border-color:#00d4ff;
        }

        button{
            width:100%;
            padding:12px;
            background:#1f2a40;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-size:15px;
            transition:0.3s;
        }

        button:hover{
            background:#00d4ff;
            color:black;
        }

        .back{
            display:block;
            text-align:center;
            margin-top:12px;
            text-decoration:none;
            color:#1f2a40;
            font-weight:600;
        }

        .back:hover{
            color:#00d4ff;
        }

        .error{
            color:red;
            text-align:center;
            margin-top:10px;
        }
    </style>
</head>

<body>

<div class="main-content">

<div class="card">

    <div class="title">✏ Edit Fertilizer Record</div>

    <form method="POST">

        <input type="number" name="field_id"
               value="<?php echo $row['field_id']; ?>" required>

        <input type="text" name="fertilizer_name"
               value="<?php echo $row['fertilizer_name']; ?>" required>

        <input type="number" name="quantity"
               value="<?php echo $row['quantity']; ?>" required>

        <input type="number" name="cost"
               value="<?php echo $row['cost']; ?>" required>

        <input type="date" name="application_date"
               value="<?php echo $row['application_date']; ?>" required>

        <textarea name="notes"><?php echo $row['notes']; ?></textarea>

        <button type="submit" name="update">Update Fertilizer</button>

    </form>

    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <a class="back" href="view_fertilizers.php">← Back to List</a>

</div>

</div>

</body>
</html>