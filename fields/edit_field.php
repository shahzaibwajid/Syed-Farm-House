<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_fields.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM fields WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Field not found");
}

if (isset($_POST['update'])) {

    $field_name = $_POST['field_name'];
    $area = $_POST['area'];
    $water_source = $_POST['water_source'];

    $sql = "UPDATE fields SET
            field_name='$field_name',
            area='$area',
            water_source='$water_source'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: view_fields.php");
        exit();
    } else {
        $error = "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Field - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR SPACE FIX */
        .sidebar{
            width:250px;
            background:#1f2a40;
            color:white;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
        }

        /* MAIN CONTENT CENTER FIX */
        .main-content{
            margin-left:250px;
            width:calc(100% - 250px);

            display:flex;
            justify-content:center;
            align-items:center;

            min-height:100vh;
            padding:20px;
        }

        .card{
            width:420px;
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

        input{
            width:100%;
            padding:12px;
            margin:8px 0;
            border:1px solid #ddd;
            border-radius:8px;
            font-size:14px;
            box-sizing:border-box;
        }

        input:focus{
            outline:none;
            border-color:#00d4ff;
            box-shadow:0 0 5px rgba(0,212,255,0.3);
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

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

    <div class="card">

        <div class="title">✏ Edit Field</div>

        <form method="POST">

            <input type="text" name="field_name"
                   value="<?php echo htmlspecialchars($row['field_name']); ?>" required>

            <input type="number" step="0.01" name="area"
                   value="<?php echo htmlspecialchars($row['area']); ?>" required>

            <input type="text" name="water_source"
                   value="<?php echo htmlspecialchars($row['water_source']); ?>" required>

            <button type="submit" name="update">Update Field</button>

        </form>

        <?php
        if(isset($error)){
            echo "<div class='error'>$error</div>";
        }
        ?>

        <a class="back" href="view_fields.php">← Back to Fields</a>

    </div>

</div>

</body>
</html>