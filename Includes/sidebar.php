<?php
// sidebar.php
?>

<style>
body{
    margin:0;
    font-family:Inter, sans-serif;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    left:0;
    top:0;
    height:100%;
    width:230px;
    background:#1f2a40;
    padding-top:20px;
    box-shadow:2px 0 10px rgba(0,0,0,0.2);
}

/* LOGO */
.sidebar h2{
    color:white;
    text-align:center;
    margin-bottom:30px;
    font-size:18px;
}

/* LINKS */
.sidebar a{
    display:block;
    color:white;
    padding:12px 20px;
    text-decoration:none;
    font-size:14px;
    transition:0.3s;
    border-left:3px solid transparent;
}

.sidebar a:hover{
    background:#00d4ff;
    color:black;
    border-left:3px solid white;
}

/* ACTIVE STYLE (optional use) */
.sidebar a.active{
    background:#00d4ff;
    color:black;
}

/* MAIN CONTENT SHIFT */
.main-content{
    margin-left:230px;
    padding:20px;
}
</style>

<div class="sidebar">

    <h2>🌾 Syed Farm House</h2>

    <a href="../dashboard.php">🏠 Dashboard</a>
    <a href="../fields/view_fields.php">🌾 Fields</a>
    <a href="../crops/view_crops.php">🌱 Crops</a>
    <a href="../tasks/view_tasks.php">📋 Tasks</a>
    <a href="../expenses/view_expenses.php">💰 Expenses</a>
    <a href="../fertilizers/view_fertilizers.php">🌿 Fertilizers</a>
    <a href="../logout.php">🚪 Logout</a>

</div>