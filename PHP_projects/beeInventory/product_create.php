
<?php
// products.php - List products
require_once 'config.php';
require_once 'navigation.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = [];
$error = '';
$success = '';

// Get all product groups for dropdown
try {
    $stmt = $pdo->query("SELECT id, name FROM product_groups ORDER BY name");
    $groups = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// Get product data if editing
if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        
        if (!$product) {
            echo "Product not found.";
            exit;
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $group_id = isset($_POST['group']) ? (int)$_POST['group'] : null;
    
    if (empty($name)) {
        $error = "Product name is required";
    } elseif (empty($price)) {
        $error = "Price is required";
    } else {
        try {
            if ($id > 0) {
                // Update existing product
                $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, group_id = ? WHERE id = ?");
                $stmt->execute([$name, $price, $group_id ?: null, $id]);
            } else {
                // Insert new product
                $stmt = $pdo->prepare("INSERT INTO products (name, price, group_id) VALUES (?, ?, ?)");
                $stmt->execute([$name, $price, $group_id ?: null]);
                
                // Get the new product ID
                $id = $pdo->lastInsertId();
                
                // Create default stock entries based on variants
                if ($group_id) {
                    $stmt = $pdo->prepare("SELECT id FROM variants WHERE group_id = ?");
                    $stmt->execute([$group_id]);
                    $variants = $stmt->fetchAll();
                    
                    foreach ($variants as $variant) {
                        $stmt = $pdo->prepare("INSERT INTO stock (product_id, variant_id, quantity) VALUES (?, ?, 0)");
                        $stmt->execute([$id, $variant['id']]);
                    }
                }
            }
            
            $success = "Product saved successfully";
            
            // Redirect after short delay
            header("Refresh: 1; url=products.php");
            
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}

// Check if the selected group has a price set
$groupHasPrice = false;
if (isset($product['group_id']) && $product['group_id']) {
    $stmt = $pdo->prepare("SELECT price FROM product_groups WHERE id = ? AND price IS NOT NULL");
    $stmt->execute([$product['group_id']]);
    $groupHasPrice = $stmt->fetchColumn() !== false;
}
?>

<h2>Product</h2>

<a href="product.php" class="back-link">&lt; Back to list</a>

<?php if (!empty($error)): ?>
    <div style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . ($id ? "?id=$id" : '')); ?>" method="post">
    <div class="form-group">
        <label for="name">Product name*</label>
        <input type="text" id="name" name="name" value="<?php echo isset($product['name']) ? sanitize($product['name']) : ''; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" id="price" name="price" step="0.1" value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>" required>
        <?php if (isset($product['group_id']) && $groupHasPrice): ?>
            <div style="color: #666; font-size: 0.9em; margin-top: 5px;">
                (This price