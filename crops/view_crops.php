<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* DELETE CROP */
if(isset($_GET['delete'])){

    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM crops WHERE id=$id");

    header("Location: view_crops.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Crops - Syed Farm House</title>

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
            background:linear-gradient(135deg,#1f2a40,#2c3e50);
            color:white;
            text-align:center;
            padding:20px;
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
            transition:0.3s;
        }

        .btn:hover{
            background:#00d4ff;
            color:black;
        }

        table{
            width:100%;
            background:white;
            border-collapse:collapse;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
            border-radius:10px;
            overflow:hidden;
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
            padding:6px 10px;
            border-radius:6px;
            text-decoration:none;
            margin-right:5px;
        }

        .btn-delete{
            background:#dc3545;
            color:white;
            padding:6px 10px;
            border-radius:6px;
            text-decoration:none;
        }

        .status{
            padding:5px 8px;
            border-radius:6px;
            font-size:12px;
            font-weight:bold;
            display:inline-block;
        }

        .Growing{background:#ffc107;}
        .Ready{background:#28a745;color:white;}
        .Harvested{background:#6c757d;color:white;}

    </style>
</head>

<body>

<div class="main-content">

    <div class="header">
        <h1>🌱 All Crops</h1>
    </div>

    <div class="container">

        <div class="top-bar">
            <h2>Crop Records</h2>
            <a class="btn" href="add_crop.php">+ Add New Crop</a>
        </div>

        <table>

            <tr>
                <th>ID</th>
                <th>Crop Name</th>
                <th>Sowing Date</th>
                <th>Harvest Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT * FROM crops ORDER BY id DESC";
            $result = $conn->query($sql);

            if($result->num_rows > 0){

                while($row = $result->fetch_assoc()){

                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['crop_name']}</td>
                        <td>{$row['sowing_date']}</td>
                        <td>{$row['harvest_date']}</td>

                        <td>
                            <span class='status {$row['status']}'>
                                {$row['status']}
                            </span>
                        </td>

                        <td>
                            <a class='btn-edit' href='edit_crop.php?id={$row['id']}'>Edit</a>

                            <a class='btn-delete'
                               href='?delete={$row['id']}'
                               onclick=\"return confirm('Delete this crop?')\">
                               Delete
                            </a>
                        </td>
                    </tr>
                    ";
                }

            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>No Crops Found</td></tr>";
            }
            ?>

        </table>

    </div>

</div>

</body>
</html>