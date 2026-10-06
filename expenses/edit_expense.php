<?php
session_start();
include("../includes/db.php");
include("../includes/sidebar.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: view_expenses.php");
    exit();
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM expenses WHERE id='$id'");
$expense = mysqli_fetch_assoc($result);

if(!$expense){
    die("Expense record not found.");
}

if(isset($_POST['update'])){

    $field_id = $_POST['field_id'];
    $expense_type = $_POST['expense_type'];
    $amount = $_POST['amount'];
    $expense_date = $_POST['expense_date'];

    $sql = "UPDATE expenses SET
            field_id='$field_id',
            expense_type='$expense_type',
            amount='$amount',
            expense_date='$expense_date'
            WHERE id='$id'";

    if(mysqli_query($conn, $sql)){
        header("Location: view_expenses.php");
        exit();
    }

    $error = "Failed to update expense.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Expense - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        /* SHIFT FOR SIDEBAR */
        .main-content{
            margin-left:230px;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card{
            width:430px;
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
        }

        .title{
            text-align:center;
            font-size:22px;
            font-weight:700;
            color:#1f2a40;
            margin-bottom:20px;
        }

        input,select{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ddd;
            border-radius:8px;
            box-sizing:border-box;
            font-size:14px;
        }

        input:focus,
        select:focus{
            outline:none;
            border-color:#00d4ff;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            border-radius:8px;
            background:#1f2a40;
            color:white;
            cursor:pointer;
            font-size:15px;
            transition:.3s;
        }

        button:hover{
            background:#00d4ff;
            color:black;
        }

        .back{
            display:block;
            text-align:center;
            margin-top:15px;
            text-decoration:none;
            font-weight:600;
            color:#1f2a40;
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

<div class="main-content">

<div class="card">

    <div class="title">✏ Edit Expense</div>

    <form method="POST">

        <input type="number" name="field_id"
               value="<?php echo $expense['field_id']; ?>" required>

        <select name="expense_type" required>

            <option value="fertilizer" <?php if($expense['expense_type']=="fertilizer") echo "selected"; ?>>🌱 Fertilizer</option>

            <option value="labor" <?php if($expense['expense_type']=="labor") echo "selected"; ?>>👨‍🌾 Labor</option>

            <option value="seed" <?php if($expense['expense_type']=="seed") echo "selected"; ?>>🌾 Seed</option>

            <option value="water" <?php if($expense['expense_type']=="water") echo "selected"; ?>>💧 Water</option>

            <option value="machinery" <?php if($expense['expense_type']=="machinery") echo "selected"; ?>>🚜 Machinery</option>

        </select>

        <input type="number" name="amount"
               value="<?php echo $expense['amount']; ?>" required>

        <input type="date" name="expense_date"
               value="<?php echo $expense['expense_date']; ?>" required>

        <button type="submit" name="update">Update Expense</button>

    </form>

    <?php
    if(isset($error)){
        echo "<div class='error'>$error</div>";
    }
    ?>

    <a class="back" href="view_expenses.php">← Back to Expenses</a>

</div>

</div>

</body>
</html>