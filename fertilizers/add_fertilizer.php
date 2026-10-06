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
    <title>Add Fertilizer - Syed Farm House</title>

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
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
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
            height:80px;
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

    <div class="title">🌿 Add Fertilizer Record</div>

    <form method="POST">

        <input type="number" name="field_id" placeholder="Field ID" required>

        <input type="text" name="fertilizer_name" placeholder="Fertilizer Name" required>

        <input type="text" name="quantity" placeholder="Quantity (e.g. 50kg)" required>

        <input type="number" name="cost" placeholder="Cost" required>

        <input type="date" name="application_date" required>

        <textarea name="notes" placeholder="Notes (optional)"></textarea>

        <button type="submit" name="submit">Add Fertilizer</button>
    </form>

<?php
if(isset($_POST['submit'])){

    $field_id = $_POST['field_id'];
    $fertilizer_name = $_POST['fertilizer_name'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];
    $application_date = $_POST['application_date'];
    $notes = $_POST['notes'];

    $sql = "INSERT INTO fertilizers 
    (field_id, fertilizer_name, quantity, cost, application_date, notes)
    VALUES 
    ('$field_id', '$fertilizer_name', '$quantity', '$cost', '$application_date', '$notes')";

    if(mysqli_query($conn, $sql)){
        echo "<div class='msg success'>✔ Fertilizer Added Successfully</div>";
    } else {
        echo "<div class='msg error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<a class="back" href="view_fertilizers.php">← Back to Fertilizers</a>

</div>

</div>

</body>
</html>