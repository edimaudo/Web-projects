// add/edit product group

<?php
// product_group_edit.php - Edit product group
require_once 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$group = [];
$variants = [];
$error = '';
$success = '';

// Get group data if editing
if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM product_groups WHERE id = ?");
        $stmt->execute([$id]);
        $group = $stmt->fetch();
        
        if (!$group) {
            echo "Group not found.";
            exit;
        }
        
        // Get variants
        $stmt = $pdo->prepare("SELECT * FROM variants WHERE group_id = ? ORDER BY name");
        $stmt->execute([$id]);
        $variants = $stmt->fetchAll();
        
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    
    if (empty($name)) {
        $error = "Group name is required";
    } else {
        try {
            $pdo->beginTransaction();
            
            if ($id > 0) {
                // Update existing group
                $stmt = $pdo->prepare("UPDATE product_groups SET name = ?, price = ? WHERE id = ?");
                $stmt->execute([$name, $price ?: null, $id]);
            } else {
                // Insert new group
                $stmt = $pdo->prepare("INSERT INTO product_groups (name, price) VALUES (?, ?)");
                $stmt->execute([$name, $price ?: null]);
                $id = $pdo->lastInsertId();
            }
            
            $pdo->commit();
            $success = "Group saved successfully";
            
            // Redirect after success if not adding variants
            if (empty($_POST['new_variant'])) {
                header("Location: product_groups.php");
                exit;
            }
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Error: " . $e->getMessage();
        }
    }
    
    // Add new variant if provided
    if (!empty($_POST['new_variant']) && $id > 0) {
        $variantName = trim($_POST['new_variant']);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO variants (name, group_id) VALUES (?, ?)");
            $stmt->execute([$variantName, $id]);
            
            // Refresh page to show new variant
            header("Location: product_group_edit.php?id=$id");
            exit;
            
        } catch (PDOException $e) {
            $error = "Error adding variant: " . $e->getMessage();
        }
    }
}
?>

<h2>Group</h2>

<a href="product_groups.php" class="back-link">&lt; Back to list</a>

<?php if (!empty($error)): ?>
    <div style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . ($id ? "?id=$id" : '')); ?>" method="post">
    <div class="form-group">
        <label for="name">Group name*</label>
        <input type="text" id="name" name="name" value="<?php echo isset($group['name']) ? sanitize($group['name']) : ''; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo isset($group['price']) ? $group['price'] : ''; ?>">
        <span>Will be applied to all products from group.</span>
    </div>
    
    <?php if ($id > 0): ?>
        <div class="form-group">
            <label for="variants">Variants</label>
            <div style="display: inline-block; width: 250px;">
                <table>
                    <thead>
                        <tr>
                            <th>Variant Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($variants as $variant): ?>
                            <tr>
                                <td><?php echo sanitize($variant['name']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="form-group">
            <label for="new_variant">New Variant:</label>
            <input type="text" id="new_variant" name="new_variant">
            <button type="submit" class="btn">Add</button>
        </div>
    <?php endif; ?>
    
    <div style="margin-top: 20px; text-align: right;">
        <button type="submit" class="btn">Save</button>
    </div>
</form>

<?php require_once 'footer.php'; ?>