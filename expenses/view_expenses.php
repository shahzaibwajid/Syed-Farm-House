<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* DELETE EXPENSE */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM expenses WHERE id=$id");
    header("Location: view_expenses.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Expenses - Syed Farm House</title>

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

        .btn-add{
            background:#1f2a40;
            color:white;
            padding:10px 15px;
            border-radius:8px;
            text-decoration:none;
            font-size:14px;
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

        .btn-delete{
            background:red;
            color:white;
            padding:6px 10px;
            border-radius:6px;
            text-decoration:none;
            font-size:13px;
        }

        .btn-edit{
            background:#28a745;
            color:white;
            padding:6px 10px;
            border-radius:6px;
            text-decoration:none;
            font-size:13px;
        }

        .btn-edit:hover{ background:#1e7e34; }
        .btn-delete:hover{ background:#c40000; }

        .action{
            display:flex;
            gap:6px;
        }

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
        }

        .labor{ background:#e3f2fd; color:#1565c0; }
        .fertilizer{ background:#e8f5e9; color:#2e7d32; }
        .seed{ background:#fff3e0; color:#ef6c00; }
        .water{ background:#ede7f6; color:#6a1b9a; }
        .machinery{ background:#fce4ec; color:#ad1457; }
    </style>
</head>

<body>

<div class="main-content">

<div class="header">
    <h1>💰 All Expenses</h1>
</div>

<div class="top-bar">
    <h2>Expense Records</h2>
    <a href="add_expense.php" class="btn-add">+ Add Expense</a>
</div>

<table>

<tr>
    <th>ID</th>
    <th>Field ID</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM expenses ORDER BY id DESC");

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){
        $type = strtolower($row['expense_type']);

        echo "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['field_id']}</td>
            <td><span class='badge $type'>{$row['expense_type']}</span></td>
            <td>{$row['amount']}</td>
            <td>{$row['expense_date']}</td>
            <td>
                <div class='action'>
                    <a class='btn-edit' href='edit_expense.php?id={$row['id']}'>Edit</a>

                    <a class='btn-delete'
                       href='?delete={$row['id']}'
                       onclick=\"return confirm('Are you sure you want to delete this expense?')\">
                       Delete
                    </a>
                </div>
            </td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='6' class='empty'>No expenses found</td></tr>";
}
?>

</table>

</div>

</body>
</html>