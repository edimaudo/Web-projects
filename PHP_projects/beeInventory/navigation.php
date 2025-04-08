
<?php

require_once 'config.php';


// Get current page name
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeeInventory - Inventory Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #e0e0e0;
            color: #333;
            padding: 10px 20px;
            border-bottom: 1px solid #ccc;
        }
        .content-wrapper {
            display: flex;
            min-height: calc(100vh - 40px);
        }
        .sidebar {
            width: 175px;
            background-color: #333;
            padding: 20px 0;
        }
        .sidebar-item {
            padding: 15px 20px;
            margin: 10px;
            background-color: #f0f0f0;
            border-radius: 3px;
            cursor: pointer;
            text-align: center;
        }
        .sidebar-item a {
            color: <?php echo $current_page == strtolower($link) ? 'red' : 'black'; ?>;
            text-decoration: none;
            display: block;
            width: 100%;
        }
        .sidebar-item.active {
            background-color: #ccc;
            border: 1px solid #aaa;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .btn {
            background: #f0f0f0;
            border: 1px solid #ddd;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
            display: inline-block;
            margin-right: 5px;
        }
        .btn:hover {
            background: #e0e0e0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
        }
        .back-link {
            color: blue;
            margin-bottom: 20px;
            display: inline-block;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: inline-block;
            width: 150px;
            text-align: right;
            margin-right: 10px;
            color: <?php echo strpos($current_page, 'product') !== false ? 'red' : 'inherit'; ?>;
        }
        .form-group input, .form-group select, .form-group textarea {
            padding: 8px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        
    </div>
    <div class="content-wrapper">
        <div class="sidebar">
            <div class="sidebar-item <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>">
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="sidebar-item <?php echo $current_page == 'products' ? 'active' : ''; ?>">
                <a href="product.php">Products</a>
            </div>
            <div class="sidebar-item <?php echo $current_page == 'product_groups' ? 'active' : ''; ?>">
                <a href="product_group.php">Product Groups</a>
            </div>
            <div class="sidebar-item <?php echo $current_page == 'orders' ? 'active' : ''; ?>">
                <a href="order.php">Orders</a>
            </div>
            <div class="sidebar-item <?php echo $current_page == 'stock' ? 'active' : ''; ?>">
                <a href="stock.php">Stock</a>
            </div>
        </div>
        <div class="main-content">