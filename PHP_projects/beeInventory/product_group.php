
<?php
// product_groups.php - List product groups
require_once 'config.php';
require_once 'navigation.php';

// Get all product groups
try {
    $stmt = $pdo->query("SELECT * FROM product_groups ORDER BY name");
    $groups = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<h2>Product Groups</h2>

<a href="product_group_create.php" class="btn">Add</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($groups as $group): ?>
            <tr>
                <td><?php echo $group['id']; ?></td>
                <td><?php echo sanitize($group['name']); ?></td>
                <td><?php echo $group['price'] ? number_format($group['price'], 2) : ''; ?></td>
                <td>
                    <a href="product_group_update.php?id=<?php echo $group['id']; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
