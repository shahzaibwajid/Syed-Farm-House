<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$fields = $conn->query("SELECT * FROM fields");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Task - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR FIX */
        .sidebar{
            width:250px;
            background:#1f2a40;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            color:white;
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
            background:white;
            width:450px;
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

        input, select, textarea{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ddd;
            border-radius:8px;
            outline:none;
            font-size:14px;
            box-sizing:border-box;
            font-family:'Inter', sans-serif;
        }

        input:focus, select:focus, textarea:focus{
            border-color:#00d4ff;
            box-shadow:0 0 5px rgba(0,212,255,0.3);
        }

        textarea{
            resize:none;
            height:90px;
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

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<div class="card">

    <div class="title">➕ Add New Task</div>

    <form method="POST">

        <select name="field_id" required>
            <option value="">Select Field</option>
            <?php
            while ($f = $fields->fetch_assoc()) {
                echo "<option value='{$f['id']}'>{$f['field_name']}</option>";
            }
            ?>
        </select>

        <input type="text" name="task_name" placeholder="Task Name" required>

        <textarea name="description" placeholder="Task Description"></textarea>

        <input type="date" name="due_date" required>

        <select name="priority">
            <option value="Low">🟢 Low Priority</option>
            <option value="Medium">🟡 Medium Priority</option>
            <option value="High">🔴 High Priority</option>
        </select>

        <button type="submit" name="save">Save Task</button>
    </form>

<?php
if (isset($_POST['save'])) {

    $field_id = $_POST['field_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];

    $sql = "INSERT INTO tasks (field_id, task_name, description, due_date, priority)
            VALUES ('$field_id', '$task_name', '$description', '$due_date', '$priority')";

    if ($conn->query($sql)) {
        echo "<div class='msg success'>✔ Task Added Successfully</div>";
    } else {
        echo "<div class='msg error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<a class="back" href="view_tasks.php">← Back to Tasks</a>

</div>

</div>

</body>
</html>