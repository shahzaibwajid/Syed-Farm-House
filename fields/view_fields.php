<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* DELETE FIELD */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM fields WHERE id=$id");
    header("Location: view_fields.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Fields - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            display:flex;
            background:#f4f6f9;
        }

        /* MAIN AREA */
        .main-content{
            flex:1;
            padding:20px;
        }

        /* HEADER */
        .header{
            background: linear-gradient(135deg, #1f2a40, #2c3e50);
            color:white;
            padding:20px;
            text-align:center;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin:20px 0;
        }

        .btn{
            background:#1f2a40;
            color:white;
            padding:10px 15px;
            text-decoration:none;
            border-radius:8px;
            font-size:14px;
            transition:0.3s;
        }

        .btn:hover{
            background:#00d4ff;
            color:black;
        }

        /* TABLE */
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

        .empty{
            text-align:center;
            padding:20px;
            color:#777;
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
    </style>
</head>

<body>

<!-- SIDEBAR -->
<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<div class="header">
    <h1>🌾 All Fields</h1>
</div>

<div class="top-bar">
    <h2>Field Records</h2>
    <a class="btn" href="add_field.php">+ Add New Field</a>
</div>

<table>

<tr>
    <th>ID</th>
    <th>Field Name</th>
    <th>Area (Acres)</th>
    <th>Water Source</th>
    <th>Action</th>
</tr>

<?php
$sql = "SELECT * FROM fields";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        echo "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['field_name']}</td>
            <td>{$row['area']}</td>
            <td>{$row['water_source']}</td>
            <td>
                <div class='action'>
                    <a class='btn-edit' href='edit_field.php?id={$row['id']}'>Edit</a>

                    <a class='btn-delete'
                       href='?delete={$row['id']}'
                       onclick=\"return confirm('Are you sure you want to delete this field?')\">
                       Delete
                    </a>
                </div>
            </td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='5' class='empty'>No fields found</td></tr>";
}
?>

</table>

</div>

</body>
</html>