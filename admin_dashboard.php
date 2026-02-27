<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | ButtonOn</title>
    <link rel="stylesheet" href="style.css">
    
    <style>
        body { background-color: var(--light-gray); }
        .admin-wrapper { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        
        .dash-card {
            background: white;
            padding: 30px;
            border: 1px solid var(--border-color);
            transition: 0.2s;
        }
        .dash-card:hover { border-color: black; transform: translateY(-2px); }
        
        .big-number { font-size: 3rem; font-weight: 800; color: var(--accent-red); line-height: 1; }
        .card-label { font-size: 0.9rem; text-transform: uppercase; font-weight: 700; color: #666; margin-bottom: 15px; }
        
        .btn-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: underline;
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <nav style="background: white; border-bottom: 1px solid var(--border-color);">
        <div class="logo">BUTTONON <span style="font-size: 0.8rem; color: var(--accent-red);">ADMIN</span></div>
        <div class="nav-links">
            <a href="index.php" target="_blank">View Shop</a>
            <a href="logout.php" style="color: var(--accent-red);">Logout</a>
        </div>
    </nav>

    <div class="admin-wrapper">
        <h2 style="margin-bottom: 20px; text-transform: uppercase; font-weight: 800;">Dashboard Overview</h2>

        <div class="dashboard-grid">
            
            <div class="dash-card">
                <div class="card-label">Total Products</div>
                <?php
                $q1 = mysqli_query($conn, "SELECT COUNT(*) as count FROM products");
                $r1 = mysqli_fetch_assoc($q1);
                ?>
                <div class="big-number"><?php echo $r1['count']; ?></div>
                <a href="inventory.php" class="btn-link">Manage Inventory &rarr;</a>
            </div>

            <div class="dash-card">
                <div class="card-label">Registered Members</div>
                <?php
                $q2 = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role='member'");
                $r2 = mysqli_fetch_assoc($q2);
                ?>
                <div class="big-number"><?php echo $r2['count']; ?></div>
                <a href="members_list.php" class="btn-link">View User List &rarr;</a>
            </div>

        </div>
    </div>

</body>
</html>