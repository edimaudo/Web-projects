
<?php
// dashboard.php - Dashboard page
require_once 'config.php';
require_once 'navigation.php';

// Get counts
// try {
//     $productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
//     $groupCount = $pdo->query("SELECT COUNT(*) FROM product_groups")->fetchColumn();
//     $orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    
//     // Get order stats by month for chart
//     $stmt = $pdo->prepare("
//         SELECT 
//             DATE_FORMAT(created_at, '%b') AS month, 
//             COUNT(*) AS order_count 
//         FROM orders 
//         WHERE created_at > DATE_SUB(NOW(), INTERVAL 4 MONTH) 
//         GROUP BY DATE_FORMAT(created_at, '%Y-%m')
//         ORDER BY created_at
//     ");
//     $stmt->execute();
//     $orderStats = $stmt->fetchAll();
    
// } catch (PDOException $e) {
//     echo "Error: " . $e->getMessage();
//     exit;
// }

// // Prepare data for chart
// $chartData = array(
//     'Jan' => 0,
//     'Feb' => 0,
//     'Mar' => 0,
//     'Apr' => 0,
// );

// foreach ($orderStats as $stat) {
//     $chartData[$stat['month']] = (int)$stat['order_count'];
// }
?>

<h2>DASHBOARD</h2>

<div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
    <div style="border: 1px solid #ccc; padding: 15px; width: 30%; text-align: center;">
        <h3>Products: <?php echo $productCount; ?></h3>
    </div>
    <div style="border: 1px solid #ccc; padding: 15px; width: 30%; text-align: center;">
        <h3>Groups: <?php echo $groupCount; ?></h3>
    </div>
    <div style="border: 1px solid #ccc; padding: 15px; width: 30%; text-align: center;">
        <h3>Orders: <?php echo $orderCount; ?></h3>
    </div>
</div>

<h2>ORDER STATS</h2>

<div id="chart-container" style="height: 300px; width: 100%; position: relative;">
    <div style="position: absolute; left: 0; bottom: 20px; width: 40px; height: 250px; display: flex; flex-direction: column; justify-content: space-between;">
        <div>4</div>
        <div>3</div>
        <div>2</div>
        <div>1</div>
        <div>0</div>
    </div>
    
    <div style="display: flex; position: absolute; left: 40px; bottom: 0; height: 270px; width: calc(100% - 40px);">
        <?php foreach ($chartData as $month => $count): ?>
            <div style="flex: 1; display: flex; flex-direction: column; justify-content: flex-end; align-items: center; padding: 0 10px;">
                <div style="width: 30px; background-color: #FF6347; height: <?php echo $count * 60; ?>px;"></div>
                <div style="margin-top: 5px;"><?php echo $month; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div style="position: absolute; bottom: 20px; left: 40px; right: 0; border-top: 1px dashed #ccc;"></div>
    <div style="position: absolute; bottom: 80px; left: 40px; right: 0; border-top: 1px dashed #ccc;"></div>
    <div style="position: absolute; bottom: 140px; left: 40px; right: 0; border-top: 1px dashed #ccc;"></div>
    <div style="position: absolute; bottom: 200px; left: 40px; right: 0; border-top: 1px dashed #ccc;"></div>
    <div style="position: absolute; bottom: 260px; left: 40px; right: 0; border-top: 1px dashed #ccc;"></div>
</div>

