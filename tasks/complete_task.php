<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$message = "";

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    $sql = "UPDATE tasks SET status='Done' WHERE id=$id";

    if ($conn->query($sql)) {
        $message = "✔ Task marked as DONE successfully!";
    } else {
        $message = "❌ Error updating task: " . $conn->error;
    }
} else {
    $message = "❌ Invalid Task ID!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Task - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR */
        .sidebar{
            width:250px;
            background:#1f2a40;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            color:white;
        }

        /* MAIN CONTENT CENTER */
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
            background:white;
            width:400px;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
            text-align:center;
        }

        .title{
            font-size:20px;
            font-weight:700;
            color:#1f2a40;
            margin-bottom:15px;
        }

        .msg{
            font-size:15px;
            font-weight:600;
            margin-bottom:20px;
        }

        .success{ color:green; }
        .error{ color:red; }

        a{
            display:inline-block;
            padding:10px 15px;
            background:#1f2a40;
            color:white;
            border-radius:8px;
            text-decoration:none;
            transition:0.3s;
        }

        a:hover{
            background:#00d4ff;
            color:black;
        }
    </style>
</head>

<body>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<div class="card">

    <div class="title">📋 Task Update</div>

    <div class="msg <?php echo (strpos($message,'✔') !== false) ? 'success' : 'error'; ?>">
        <?php echo $message; ?>
    </div>

    <a href="view_tasks.php">← Back to Tasks</a>

</div>

</div>

</body>
</html>