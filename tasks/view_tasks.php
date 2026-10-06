<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* DELETE TASK */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM tasks WHERE id=$id");
    header("Location: view_tasks.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Tasks - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* MAIN LAYOUT FIX */
        .wrapper{
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR AREA */
        .sidebar{
            width:240px;
            background:#1f2a40;
            color:white;
            position:fixed;
            top:0;
            left:0;
            height:100vh;
            padding-top:20px;
        }

        /* MAIN CONTENT SHIFT */
        .main-content{
            margin-left:240px;
            width:calc(100% - 240px);
            padding:20px;
        }

        .header{
            background:linear-gradient(135deg,#1f2a40,#2c3e50);
            color:white;
            padding:20px;
            text-align:center;
            border-radius:10px;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin:15px 0;
        }

        .btn-add{
            background:#1f2a40;
            color:white;
            padding:10px 15px;
            border-radius:8px;
            text-decoration:none;
            font-size:14px;
        }

        .btn-add:hover{
            background:#00d4ff;
            color:black;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
        }

        th{
            background:#1f2a40;
            color:white;
            padding:12px;
            text-align:left;
            font-size:14px;
        }

        td{
            padding:12px;
            border-bottom:1px solid #eee;
            font-size:14px;
            vertical-align:top;
        }

        tr:hover{
            background:#f1f5ff;
        }

        .action{
            display:flex;
            gap:6px;
        }

        .btn-edit{
            background:#28a745;
            color:white;
            padding:6px 10px;
            border-radius:6px;
            text-decoration:none;
            font-size:13px;
        }

        .btn-delete{
            background:#ff4d4d;
            color:white;
            padding:6px 10px;
            border-radius:6px;
            text-decoration:none;
            font-size:13px;
        }

        .btn-edit:hover{ background:#1e7e34; }
        .btn-delete:hover{ background:#c40000; }

        .empty{
            text-align:center;
            padding:20px;
            color:#777;
        }

        .badge{
            padding:4px 10px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
            display:inline-block;
        }

        .low{ background:#e8f5e9; color:#2e7d32; }
        .medium{ background:#fff3e0; color:#ef6c00; }
        .high{ background:#ffebee; color:#c62828; }

        .desc{
            max-width:250px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
    </style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <?php include("../includes/sidebar.php"); ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="header">
            <h1>📋 All Tasks</h1>
        </div>

        <div class="top-bar">
            <h2>Task Records</h2>
            <a href="add_task.php" class="btn-add">➕ Add Task</a>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Field</th>
                <th>Task</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Priority</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT tasks.*, fields.field_name 
                    FROM tasks 
                    LEFT JOIN fields ON tasks.field_id = fields.id
                    ORDER BY tasks.id DESC";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

                    $priority = strtolower($row['priority']);

                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['field_name']}</td>
                        <td>{$row['task_name']}</td>
                        <td class='desc'>{$row['description']}</td>
                        <td>{$row['due_date']}</td>
                        <td>
                            <span class='badge $priority'>{$row['priority']}</span>
                        </td>
                        <td>
                            <div class='action'>
                                <a class='btn-edit' href='edit_task.php?id={$row['id']}'>Edit</a>
                                <a class='btn-delete' href='?delete={$row['id']}' onclick=\"return confirm('Delete this task?')\">Delete</a>
                            </div>
                        </td>
                    </tr>";
                }

            } else {
                echo "<tr><td colspan='7' class='empty'>No tasks found</td></tr>";
            }
            ?>
        </table>

    </div>
</div>

</body>
</html>