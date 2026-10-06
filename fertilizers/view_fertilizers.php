<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* DELETE */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM fertilizers WHERE id=$id");
    header("Location: view_fertilizers.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Fertilizers - Syed Farm House</title>

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
            padding:20px;
        }

        .header{
            background: linear-gradient(135deg, #1f2a40, #2c3e50);
            color:white;
            padding:20px;
            text-align:center;
            border-radius:10px;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin:20px 0;
        }

        .top-bar h2{
            margin:0;
            color:#1f2a40;
        }

        .btn-add{
            background:#1f2a40;
            color:white;
            padding:10px 16px;
            border-radius:8px;
            text-decoration:none;
            font-size:14px;
            font-weight:600;
            transition:0.3s;
        }

        .btn-add:hover{
            background:#00d4ff;
            color:black;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:12px;
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

        .btn-edit:hover{
            background:#1e7e34;
        }

        .btn-delete{
            background:#ff4d4d;
            color:white;
            padding:6px 10px;
            border-radius:6px;
            text-decoration:none;
            font-size:13px;
        }

        .btn-delete:hover{
            background:#c40000;
        }

        .empty{
            text-align:center;
            padding:20px;
            color:#777;
        }

        .cost{
            font-weight:700;
            color:#1f2a40;
        }
    </style>
</head>

<body>

<div class="main-content">

<div class="header">
    <h1>🌿 Fertilizer Management System</h1>
</div>

<div class="top-bar">
    <h2>Fertilizer Records</h2>
    <a href="add_fertilizer.php" class="btn-add">➕ Add Fertilizer</a>
</div>

<table>

<tr>
    <th>ID</th>
    <th>Field ID</th>
    <th>Fertilizer Name</th>
    <th>Quantity</th>
    <th>Cost</th>
    <th>Date</th>
    <th>Notes</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM fertilizers ORDER BY id DESC");

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

        echo "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['field_id']}</td>
            <td>{$row['fertilizer_name']}</td>
            <td>{$row['quantity']}</td>
            <td class='cost'>{$row['cost']}</td>
            <td>{$row['application_date']}</td>
            <td>{$row['notes']}</td>
            <td>
                <div class='action'>
                    <a class='btn-edit' href='edit_fertilizer.php?id={$row['id']}'>Edit</a>

                    <a class='btn-delete'
                       href='?delete={$row['id']}'
                       onclick=\"return confirm('Are you sure you want to delete this record?')\">
                       Delete
                    </a>
                </div>
            </td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='8' class='empty'>No fertilizers found</td></tr>";
}
?>

</table>

</div>

</body>
</html>