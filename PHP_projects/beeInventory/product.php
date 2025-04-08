
<?php
// products.php - List products
require_once 'config.php';
require_once 'navigation.php';

// Get all products with their group information
try {
    $stmt = $pdo->query("
        SELECT p.*, g.name AS group_name 
        FROM products p
        LEFT JOIN product_groups g ON p.group_id = g.id
        ORDER BY p.id
    ");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<h2>Products</h2>

<a href="product_add.php" class="btn">Add</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Group</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo sanitize($product['name']); ?></td>
                <td><?php echo sanitize($product['group_name'] ?? ''); ?></td>
                <td><?php echo number_format($product['price'], 1); ?></td>
                <td>
                    <a href="product_edit.php?id=<?php echo $product['id']; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
