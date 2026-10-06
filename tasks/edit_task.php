<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_tasks.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM tasks WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Task not found");
}

if (isset($_POST['update'])) {

    $field_id = $_POST['field_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];

    $sql = "UPDATE tasks SET
            field_id='$field_id',
            task_name='$task_name',
            description='$description',
            due_date='$due_date',
            priority='$priority'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: view_tasks.php");
        exit();
    } else {
        $error = "Update failed!";
    }
}

$fields = $conn->query("SELECT * FROM fields");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task - Syed Farm House</title>

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

        input, select, textarea{
            width:100%;
            padding:12px;
            margin:8px 0;
            border:1px solid #ddd;
            border-radius:8px;
            font-size:14px;
            box-sizing:border-box;
            font-family:'Inter', sans-serif;
        }

        textarea{
            resize:none;
            height:80px;
        }

        input:focus, select:focus, textarea:focus{
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

    <div class="title">✏ Edit Task</div>

    <form method="POST">

        <select name="field_id" required>
            <?php
            while ($f = $fields->fetch_assoc()) {
                $selected = ($f['id'] == $row['field_id']) ? "selected" : "";
                echo "<option value='{$f['id']}' $selected>{$f['field_name']}</option>";
            }
            ?>
        </select>

        <input type="text" name="task_name"
               value="<?php echo htmlspecialchars($row['task_name']); ?>" required>

        <textarea name="description"><?php echo htmlspecialchars($row['description']); ?></textarea>

        <input type="date" name="due_date"
               value="<?php echo htmlspecialchars($row['due_date']); ?>" required>

        <select name="priority">
            <option value="Low" <?php if($row['priority']=="Low") echo "selected"; ?>>🟢 Low</option>
            <option value="Medium" <?php if($row['priority']=="Medium") echo "selected"; ?>>🟡 Medium</option>
            <option value="High" <?php if($row['priority']=="High") echo "selected"; ?>>🔴 High</option>
        </select>

        <button type="submit" name="update">Update Task</button>

    </form>

    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <a class="back" href="view_tasks.php">← Back to Tasks</a>

</div>

</div>

</body>
</html>