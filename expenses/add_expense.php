<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Expense - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* SHIFT DUE TO SIDEBAR */
        .main-content{
            margin-left:230px;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card{
            background:white;
            width:420px;
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

        input, select{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ddd;
            border-radius:8px;
            outline:none;
            font-size:14px;
            box-sizing:border-box;
            background:white;
        }

        input:focus, select:focus{
            border-color:#00d4ff;
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

<div class="main-content">

<div class="card">

    <div class="title">💰 Add New Expense</div>

    <form method="POST">

        <input type="number" name="field_id" placeholder="Field ID" required>

        <select name="expense_type" required>
            <option value="">Select Expense Type</option>
            <option value="fertilizer">🌱 Fertilizer</option>
            <option value="labor">👨‍🌾 Labor</option>
            <option value="seed">🌾 Seed</option>
            <option value="water">💧 Water</option>
            <option value="machinery">🚜 Machinery</option>
        </select>

        <input type="number" name="amount" placeholder="Amount" required>

        <input type="date" name="expense_date" required>

        <button type="submit" name="submit">Add Expense</button>
    </form>

<?php
if(isset($_POST['submit'])){

    $field_id = $_POST['field_id'];
    $expense_type = $_POST['expense_type'];
    $amount = $_POST['amount'];
    $expense_date = $_POST['expense_date'];

    $sql = "INSERT INTO expenses (field_id, expense_type, amount, expense_date)
            VALUES ('$field_id', '$expense_type', '$amount', '$expense_date')";

    if(mysqli_query($conn, $sql)){
        echo "<div class='msg success'>✔ Expense Added Successfully</div>";
    } else {
        echo "<div class='msg error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<a class="back" href="view_expenses.php">← Back to Expenses</a>

</div>

</div>

</body>
</html>