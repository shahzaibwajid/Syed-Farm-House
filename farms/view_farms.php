<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* DELETE FARM */
if(isset($_GET['delete'])){

    $id = intval($_GET['delete']);

    $conn->query("DELETE FROM farms WHERE id=$id");

    header("Location: view_farms.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Farms - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* MAIN CONTENT SHIFT */
        .main-content{
            margin-left:230px;
            padding:20px;
        }

        .header{
            background: linear-gradient(135deg, #1f2a40, #2c3e50);
            color:white;
            padding:20px;
            text-align:center;
            border-radius:10px;
        }

        .container{
            padding-top:20px;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:15px;
        }

        .btn{
            background:#1f2a40;
            color:white;
            padding:10px 15px;
            border-radius:8px;
            text-decoration:none;
            font-size:14px;
            transition:0.3s;
        }

        .btn:hover{
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
        }

        td{
            padding:12px;
            border-bottom:1px solid #eee;
        }

        tr:hover{
            background:#f1f5ff;
        }

        .btn-edit{
            background:#007bff;
            color:white;
            padding:7px 12px;
            border-radius:6px;
            text-decoration:none;
            margin-right:5px;
            font-size:13px;
        }

        .btn-edit:hover{
            background:#0056b3;
        }

        .btn-delete{
            background:#dc3545;
            color:white;
            padding:7px 12px;
            border-radius:6px;
            text-decoration:none;
            font-size:13px;
        }

        .btn-delete:hover{
            background:#b02a37;
        }

        .empty{
            text-align:center;
            padding:20px;
            color:#777;
        }

    </style>
</head>

<body>

<div class="main-content">

    <div class="header">
        <h1>🌾 All Farms</h1>
    </div>

    <div class="container">

        <div class="top-bar">
            <h2>Farm Records</h2>
            <a class="btn" href="add_farm.php">+ Add New Farm</a>
        </div>

        <table>

            <tr>
                <th>ID</th>
                <th>Farm Name</th>
                <th>Location</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT * FROM farms";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['farm_name']}</td>
                        <td>{$row['location']}</td>
                        <td>
                            <a class='btn-edit' href='edit_farm.php?id={$row['id']}'>
                                ✏ Edit
                            </a>

                            <a class='btn-delete'
                               href='?delete={$row['id']}'
                               onclick=\"return confirm('Are you sure you want to delete this farm?')\">
                                🗑 Delete
                            </a>
                        </td>
                    </tr>";
                }

            } else {

                echo "
                <tr>
                    <td colspan='4' class='empty'>
                        No farms found
                    </td>
                </tr>";
            }
            ?>

        </table>

    </div>

</div>

</body>
</html>