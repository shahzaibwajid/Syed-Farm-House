<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

/* ================= BASIC COUNTS ================= */
$farmCount = $conn->query("SELECT COUNT(*) as total FROM farms")->fetch_assoc()['total'];
$fieldCount = $conn->query("SELECT COUNT(*) as total FROM fields")->fetch_assoc()['total'];
$cropCount = $conn->query("SELECT COUNT(*) as total FROM crops")->fetch_assoc()['total'];

$totalTasks = $conn->query("SELECT COUNT(*) as t FROM tasks")->fetch_assoc()['t'];
$doneTasks = $conn->query("SELECT COUNT(*) as t FROM tasks WHERE status='Done'")->fetch_assoc()['t'];
$pendingTasks = $conn->query("SELECT COUNT(*) as t FROM tasks WHERE status='Pending'")->fetch_assoc()['t'];

/* ================= EXPENSE ================= */
$totalExpense = $conn->query("SELECT SUM(amount) as total FROM expenses")->fetch_assoc()['total'] ?? 0;

$laborExpense = $conn->query("SELECT SUM(amount) as total FROM expenses WHERE expense_type='labor'")->fetch_assoc()['total'] ?? 0;

$fertilizerExpense = $conn->query("SELECT SUM(amount) as total FROM expenses WHERE expense_type='fertilizer'")->fetch_assoc()['total'] ?? 0;

$seedExpense = $conn->query("SELECT SUM(amount) as total FROM expenses WHERE expense_type='seed'")->fetch_assoc()['total'] ?? 0;

/* ================= FERTILIZER ================= */
$totalFertilizerCost = $conn->query("SELECT SUM(cost) as total FROM fertilizers")->fetch_assoc()['total'] ?? 0;

$totalFertilizerRecords = $conn->query("SELECT COUNT(*) as total FROM fertilizers")->fetch_assoc()['total'] ?? 0;

/* ================= FIELD ANALYTICS ================= */
$fieldStats = $conn->query("
    SELECT fields.field_name, COUNT(tasks.id) as total
    FROM fields
    LEFT JOIN tasks ON fields.id = tasks.field_id
    GROUP BY fields.id
");

$fieldNames = [];
$fieldCounts = [];

while ($row = $fieldStats->fetch_assoc()) {
    $fieldNames[] = $row['field_name'];
    $fieldCounts[] = $row['total'];
}

/* ================= CROP ================= */
$cropResult = $conn->query("
    SELECT crop_name, COUNT(*) as total
    FROM crops
    GROUP BY crop_name
");

$cropNames = [];
$cropCounts = [];

while ($row = $cropResult->fetch_assoc()) {
    $cropNames[] = $row['crop_name'];
    $cropCounts[] = $row['total'];
}

/* ================= STATUS ================= */
$statusResult = $conn->query("
    SELECT status, COUNT(*) as total
    FROM crops
    GROUP BY status
");

$statusNames = [];
$statusCounts = [];

while ($row = $statusResult->fetch_assoc()) {
    $statusNames[] = $row['status'];
    $statusCounts[] = $row['total'];
}

/* ================= REMINDERS ================= */
$overdue = $conn->query("SELECT * FROM tasks WHERE due_date < CURDATE() AND status='Pending'");
$today = $conn->query("SELECT * FROM tasks WHERE due_date = CURDATE() AND status='Pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>🌾 Syed Farm ERP Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Inter', sans-serif;
            background:#f4f6f9;
        }

        .header{
            background: linear-gradient(135deg, #1f2a40, #2c3e50);
            color:white;
            padding:20px;
            text-align:center;
        }

        .container{
            padding:20px;
        }

        .grid{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap:15px;
            margin-top:20px;
        }

        .card{
            background:white;
            padding:18px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
            text-align:center;
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card h3{
            margin:0;
            font-size:14px;
            color:#666;
        }

        .card h2{
            margin:10px 0 0;
            font-size:26px;
            color:#1f2a40;
        }

        .section{
            background:white;
            padding:20px;
            margin-top:20px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.06);
        }

        .section h2{
            margin-top:0;
            color:#1f2a40;
        }

        .chart-box{
            max-width:500px;
            margin:auto;
        }

        .links a{
            display:inline-block;
            margin:5px;
            padding:10px 14px;
            background:#1f2a40;
            color:white;
            text-decoration:none;
            border-radius:8px;
            font-size:13px;
        }

        .links a:hover{
            background:#00d4ff;
            color:black;
        }

        .logout{
            background:red !important;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>🌾 Syed Farm House ERP Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['user']; ?> 👋</p>
</div>

<div class="container">

<!-- ================= CARDS ================= -->
<div class="grid">

    <div class="card"><h3>🌾 Farms</h3><h2><?php echo $farmCount; ?></h2></div>
    <div class="card"><h3>📍 Fields</h3><h2><?php echo $fieldCount; ?></h2></div>
    <div class="card"><h3>🌱 Crops</h3><h2><?php echo $cropCount; ?></h2></div>
    <div class="card"><h3>📋 Tasks</h3><h2><?php echo $totalTasks; ?></h2></div>

</div>

<!-- ================= EXPENSE ================= -->
<div class="section">
    <h2>💰 Expense Summary</h2>

    <div class="grid">
        <div class="card"><h3>Total</h3><h2><?php echo $totalExpense; ?></h2></div>
        <div class="card"><h3>Labor</h3><h2><?php echo $laborExpense; ?></h2></div>
        <div class="card"><h3>Fertilizer</h3><h2><?php echo $fertilizerExpense; ?></h2></div>
        <div class="card"><h3>Seed</h3><h2><?php echo $seedExpense; ?></h2></div>
    </div>
</div>

<!-- ================= TASK ================= -->
<div class="section">
    <h2>📊 Task Analytics</h2>

    <div class="grid">
        <div class="card" style="background:#28a745;color:white;">
            <h3>Completed</h3>
            <h2><?php echo $doneTasks; ?></h2>
        </div>

        <div class="card" style="background:#ffc107;">
            <h3>Pending</h3>
            <h2><?php echo $pendingTasks; ?></h2>
        </div>

        <div class="card" style="background:#17a2b8;color:white;">
            <h3>Crops</h3>
            <h2><?php echo $cropCount; ?></h2>
        </div>
    </div>
</div>

<!-- ================= CHARTS ================= -->
<div class="section">
    <h2>📊 Task Chart</h2>
    <div class="chart-box">
        <canvas id="taskChart"></canvas>
    </div>
</div>

<div class="section">
    <h2>🌾 Field Chart</h2>
    <div class="chart-box">
        <canvas id="fieldChart"></canvas>
    </div>
</div>

<div class="section">
    <h2>🌱 Crop Chart</h2>
    <div class="chart-box">
        <canvas id="cropChart"></canvas>
    </div>
</div>

<!-- ================= REMINDERS ================= -->
<div class="section">
    <h2>🔔 Reminders</h2>

    <h3>⚠️ Overdue</h3>
    <?php
    if ($overdue->num_rows > 0) {
        while ($row = $overdue->fetch_assoc()) {
            echo "<p style='color:red;'>❌ {$row['task_name']} ({$row['due_date']})</p>";
        }
    } else {
        echo "<p style='color:green;'>No overdue tasks 🎉</p>";
    }
    ?>

    <h3>📅 Today</h3>
    <?php
    if ($today->num_rows > 0) {
        while ($row = $today->fetch_assoc()) {
            echo "<p style='color:blue;'>🔵 {$row['task_name']}</p>";
        }
    } else {
        echo "<p style='color:green;'>No tasks today 👍</p>";
    }
    ?>
</div>

<!-- ================= LINKS ================= -->
<div class="section links">
    <h2>📌 Quick Links</h2>

    <a href="farms/view_farms.php">Farms</a>
    <a href="fields/view_fields.php">Fields</a>
    <a href="crops/view_crops.php">Crops</a>
    <a href="tasks/view_tasks.php">Tasks</a>
    <a href="expenses/view_expenses.php">Expenses</a>
    <a href="fertilizers/view_fertilizers.php">Fertilizers</a>

    <br><br>
    <a class="logout" href="logout.php">🚪 Logout</a>
</div>

</div>

<!-- ================= CHART JS ================= -->
<script>
new Chart(document.getElementById('taskChart'), {
    type: 'pie',
    data: {
        labels: ['Completed', 'Pending'],
        datasets: [{
            data: [<?php echo $doneTasks; ?>, <?php echo $pendingTasks; ?>],
            backgroundColor: ['#28a745', '#ffc107']
        }]
    }
});

new Chart(document.getElementById('fieldChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($fieldNames); ?>,
        datasets: [{
            data: <?php echo json_encode($fieldCounts); ?>,
            backgroundColor: '#007bff'
        }]
    }
});

new Chart(document.getElementById('cropChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($cropNames); ?>,
        datasets: [{
            data: <?php echo json_encode($cropCounts); ?>,
            backgroundColor: '#28a745'
        }]
    }
});
</script>

</body>
</html>