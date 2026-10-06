<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Field - Syed Farm House</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            display:flex;
            background:#f4f6f9;
        }

        /* SIDEBAR SPACE */
        .main-content{
            flex:1;
            padding:20px;
        }

        /* CARD */
        .card{
            background:white;
            width:420px;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
            margin:auto;
            margin-top:50px;
        }

        .title{
            text-align:center;
            font-size:20px;
            font-weight:700;
            color:#1f2a40;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ddd;
            border-radius:8px;
            outline:none;
            font-size:14px;
            box-sizing:border-box;
        }

        input:focus{
            border-color:#00d4ff;
            box-shadow:0 0 5px rgba(0,212,255,0.3);
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

<!-- SIDEBAR (future use) -->
<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

<div class="card">

    <div class="title">🌾 Add New Field</div>

    <form method="POST">

        <input type="text" name="field_name" placeholder="Field Name" required>

        <input type="number" step="0.01" name="area" placeholder="Area (Acres)" required>

        <input type="text" name="water_source" placeholder="Water Source">

        <button type="submit" name="save">Save Field</button>
    </form>

<?php
if (isset($_POST['save'])) {

    $field_name = $_POST['field_name'];
    $area = $_POST['area'];
    $water_source = $_POST['water_source'];

    $sql = "INSERT INTO fields (field_name, area, water_source)
            VALUES ('$field_name', '$area', '$water_source')";

    if ($conn->query($sql)) {
        echo "<div class='msg success'>✔ Field Added Successfully</div>";
    } else {
        echo "<div class='msg error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<a class="back" href="view_fields.php">← Back to Fields</a>

</div>

</div>

</body>
</html>