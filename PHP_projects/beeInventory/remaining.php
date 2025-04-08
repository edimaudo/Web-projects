<?php
// config.php is assumed to already exist with database connection details
require_once 'config.php';

// Database connection function using PDO
function connect_db() {
    global $db_host, $db_name, $db_user, $db_pass;
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// Sanitize input data
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Dashboard page
function show_dashboard() {
    include 'templates/header.php';
    
    $pdo = connect_db();
    
    // Get counts for dashboard statistics
    $products_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $product_groups_count = $pdo->query("SELECT COUNT(*) FROM product_groups")->fetchColumn();
    $orders_count = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    $stock_count = $pdo->query("SELECT SUM(qty) FROM stock")->fetchColumn();
    
    echo <<<HTML
    <div class="main-content">
        <h2>Dashboard</h2>
        <div class="stats">
            <div class="stat-box">
                <h3>Products</h3>
                <p class="stat-value">$products_count</p>
            </div>
            <div class="stat-box">
                <h3>Product Groups</h3>
                <p class="stat-value">$product_groups_count</p>
            </div>
            <div class="stat-box">
                <h3>Orders</h3>
                <p class="stat-value">$orders_count</p>
            </div>
            <div class="stat-box">
                <h3>Total Stock</h3>
                <p class="stat-value">$stock_count</p>
            </div>
        </div>
    </div>
    HTML;
    
    include 'templates/footer.php';
}

// Product Groups functions
function list_product_groups() {
    include 'templates/header.php';
    
    $pdo = connect_db();
    $stmt = $pdo->query("SELECT * FROM product_groups ORDER BY name");
    $groups = $stmt->fetchAll();
    
    echo <<<HTML
    <div class="main-content">
        <div class="header-row">
            <h2>Product Groups</h2>
            <a href="index.php?page=add_product_group" class="btn">Add New Group</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    HTML;
    
    foreach ($groups as $group) {
        $id = $group['id'];
        $name = sanitize($group['name']);
        $price = number_format($group['price'], 2);
        
        echo <<<HTML
            <tr>
                <td>$id</td>
                <td>$name</td>
                <td>$price</td>
                <td>
                    <a href="index.php?page=edit_product_group&id=$id" class="action-link">Edit</a>
                    <a href="index.php?page=delete_product_group&id=$id" class="action-link delete" onclick="return confirm('Are you sure you want to delete this group?')">Delete</a>
                </td>
            </tr>
        HTML;
    }
    
    echo <<<HTML
            </tbody>
        </table>
    </div>
    HTML;
    
    include 'templates/footer.php';
}

function show_product_group_form($id = null) {
    include 'templates/header.php';
    
    $pdo = connect_db();
    $group = ['name' => '', 'price' => '1'];
    $variants = [];
    $page_title = "Add Group";
    $form_action = "index.php?action=save_product_group";
    
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM product_groups WHERE id = ?");
        $stmt->execute([$id]);
        $group = $stmt->fetch();
        
        if (!$group) {
            echo "<div class='error'>Group not found</div>";
            include 'templates/footer.php';
            return;
        }
        
        $stmt = $pdo->prepare("SELECT * FROM variants WHERE group_id = ?");
        $stmt->execute([$id]);
        $variants = $stmt->fetchAll();
        
        $page_title = "Edit Group";
        $form_action = "index.php?action=update_product_group&id=$id";
    }
    
    echo <<<HTML
    <div class="main-content">
        <h2>$page_title</h2>
        <a href="index.php?page=product_groups" class="back-link">&lt; Back to list</a>
        
        <form action="$form_action" method="post">
            <div class="form-group">
                <label for="group_name">Group name*</label>
                <input type="text" id="group_name" name="group_name" value="{$group['name']}" required>
            </div>
            
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" value="{$group['price']}" required>
                <span class="help-text">Will be applied to all products from group.</span>
            </div>
            
            <div class="form-group">
                <label>Variants</label>
                <table class="variant-table">
                    <thead>
                        <tr>
                            <th>Variant Name</th>
                        </tr>
                    </thead>
                    <tbody id="variants-container">
    HTML;
    
    foreach ($variants as $variant) {
        $variant_name = sanitize($variant['name']);
        echo <<<HTML
                        <tr>
                            <td>
                                <input type="text" name="variants[]" value="$variant_name" required>
                            </td>
                        </tr>
        HTML;
    }
    
    // Empty row for new variants
    echo <<<HTML
                        <tr>
                            <td>
                                <input type="text" name="variants[]" value="">
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="add-variant-row">
                    <label for="new_variant">New Variant:</label>
                    <input type="text" id="new_variant">
                    <button type="button" onclick="addVariant()">Add</button>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn">Save</button>
            </div>
        </form>
    </div>
    
    <script>
    function addVariant() {
        const container = document.getElementById('variants-container');
        const input = document.getElementById('new_variant');
        const value = input.value.trim();
        
        if (value) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <input type="text" name="variants[]" value="${value}" required>
                </td>
            `;
            container.appendChild(row);
            input.value = '';
        }
    }
    </script>
    HTML;
    
    include 'templates/footer.php';
}

function save_product_group() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: index.php?page=product_groups');
        exit;
    }
    
    $pdo = connect_db();
    
    $name = $_POST['group_name'] ?? '';
    $price = floatval($_POST['price'] ?? 1);
    $variants = array_filter($_POST['variants'] ?? [], function($v) { return trim($v) !== ''; });
    
    if (empty($name)) {
        echo "<div class='error'>Group name is required</div>";
        return show_product_group_form();
    }
    
    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("INSERT INTO product_groups (name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
        $group_id = $pdo->lastInsertId();
        
        foreach ($variants as $variant) {
            $stmt = $pdo->prepare("INSERT INTO variants (group_id, name) VALUES (?, ?)");
            $stmt->execute([$group_id, $variant]);
        }
        
        $pdo->commit();
        header('Location: index.php?page=product_groups&message=saved');
        exit;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<div class='error'>Error saving group: " . sanitize($e->getMessage()) . "</div>";
        return show_product_group_form();
    }
}

function update_product_group($id) {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: index.php?page=product_groups');
        exit;
    }
    
    $pdo = connect_db();
    
    $name = $_POST['group_name'] ?? '';
    $price = floatval($_POST['price'] ?? 1);
    $variants = array_filter($_POST['variants'] ?? [], function($v) { return trim($v) !== ''; });
    
    if (empty($name)) {
        echo "<div class='error'>Group name is required</div>";
        return show_product_group_form($id);
    }
    
    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("UPDATE product_groups SET name = ?, price = ? WHERE id = ?");
        $stmt->execute([$name, $price, $id]);
        
        // Delete existing variants
        $stmt = $pdo->prepare("DELETE FROM variants WHERE group_id = ?");
        $stmt->execute([$id]);
        
        // Insert new variants
        foreach ($variants as $variant) {
            $stmt = $pdo->prepare("INSERT INTO variants (group_id, name) VALUES (?, ?)");
            $stmt->execute([$id, $variant]);
        }
        
        $pdo->commit();
        header('Location: index.php?page=product_groups&message=updated');
        exit;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<div class='error'>Error updating group: " . sanitize($e->getMessage()) . "</div>";
        return show_product_group_form($id);
    }
}

// Orders functions
function list_orders() {
    include 'templates/header.php';
    
    $pdo = connect_db();
    
    $filter = $_GET['filter'] ?? 'all';
    $where_clause = "";
    
    if ($filter !== 'all') {
        $where_clause = "WHERE type = :filter";
    }
    
    $stmt = $pdo->prepare("SELECT * FROM orders $where_clause ORDER BY created DESC");
    
    if ($filter !== 'all') {
        $stmt->bindParam(':filter', $filter, PDO::PARAM_STR);
    }
    
    $stmt->execute();
    $orders = $stmt->fetchAll();
    
    echo <<<HTML
    <div class="main-content">
        <div class="header-row">
            <h2>Orders</h2>
            <a href="index.php?page=add_order" class="btn">Add</a>
        </div>
        
        <div class="filter-row">
            <label>Filter by:</label>
            <select id="filter-select" onchange="window.location='index.php?page=orders&filter='+this.value">
                <option value="all" {$filter === 'all' ? 'selected' : ''}>All types</option>
                <option value="buy" {$filter === 'buy' ? 'selected' : ''}>Buy</option>
                <option value="sell" {$filter === 'sell' ? 'selected' : ''}>Sell</option>
            </select>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Created</th>
                    <th>Status</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
    HTML;
    
    foreach ($orders as $order) {
        $id = $order['id'];
        $name = sanitize($order['name']);
        $type = sanitize($order['type']);
        $created = sanitize($order['created']);
        $status = sanitize($order['status']);
        $comment = sanitize(substr($order['comment'], 0, 20) . (strlen($order['comment']) > 20 ? '...' : ''));
        
        $type_class = $type === 'buy' ? 'buy-type' : 'sell-type';
        $status_class = $status === 'completed' ? 'status-completed' : 'status-progress';
        
        echo <<<HTML
            <tr>
                <td>$id</td>
                <td><a href="index.php?page=edit_order&id=$id">$name</a></td>
                <td class="$type_class">$type</td>
                <td>$created</td>
                <td class="$status_class">$status</td>
                <td>$comment</td>
            </tr>
        HTML;
    }
    
    echo <<<HTML
            </tbody>
        </table>
    </div>
    HTML;
    
    include 'templates/footer.php';
}

function show_order_form($id = null) {
    include 'templates/header.php';
    
    $pdo = connect_db();
    
    $order = [
        'name' => '',
        'city' => '',
        'address' => '',
        'zip' => '',
        'type' => 'buy',
        'status' => 'in-progress',
        'comment' => ''
    ];
    
    $order_items = [];
    $page_title = "New Order";
    $form_action = "index.php?action=save_order";
    
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch();
        
        if (!$order) {
            echo "<div class='error'>Order not found</div>";
            include 'templates/footer.php';
            return;
        }
        
        $stmt = $pdo->prepare("SELECT oi.*, p.name as product_name, v.name as variant_name FROM order_items oi 
                              JOIN products p ON oi.product_id = p.id 
                              LEFT JOIN variants v ON oi.variant_id = v.id 
                              WHERE oi.order_id = ?");
        $stmt->execute([$id]);
        $order_items = $stmt->fetchAll();
        
        $page_title = "Order";
        $form_action = "index.php?action=update_order&id=$id";
    }
    
    // Get all products for dropdown
    $stmt = $pdo->query("SELECT id, name FROM products ORDER BY name");
    $products = $stmt->fetchAll();
    
    echo <<<HTML
    <div class="main-content">
        <h2>$page_title</h2>
        <a href="index.php?page=orders" class="back-link">&lt; Back to list</a>
        
        <form action="$form_action" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{$order['name']}" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="{$order['city']}">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="{$order['address']}">
                </div>
                <div class="form-group">
                    <label for="zip">ZIP</label>
                    <input type="text" id="zip" name="zip" value="{$order['zip']}">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type">
                        <option value="buy" {$order['type'] === 'buy' ? 'selected' : ''}>Buy</option>
                        <option value="sell" {$order['type'] === 'sell' ? 'selected' : ''}>Sell</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="in-progress" {$order['status'] === 'in-progress' ? 'selected' : ''}>in-progress</option>
                        <option value="completed" {$order['status'] === 'completed' ? 'selected' : ''}>completed</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea id="comment" name="comment" rows="3">{$order['comment']}</textarea>
            </div>
            
            <hr>
            
            <div class="form-group">
                <div class="product-selection">
                    <select id="product-select">
                        <option value="">Select product...</option>
    HTML;
    
    foreach ($products as $product) {
        $product_id = $product['id'];
        $product_name = sanitize($product['name']);
        echo "<option value=\"$product_id\">$product_name</option>";
    }
    
    echo <<<HTML
                    </select>
                    <select id="variant-select">
                        <option value="">Select variant...</option>
                    </select>
                    <button type="button" onclick="addProduct()">Add</button>
                </div>
                
                <div class="help-text">(double-click on price to edit.)</div>
                
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="items-container">
    HTML;
    
    foreach ($order_items as $item) {
        $product_name = sanitize($item['product_name']);
        $variant_name = sanitize($item['variant_name'] ?? '');
        $price = number_format($item['price'], 1);
        $product_id = $item['product_id'];
        $variant_id = $item['variant_id'] ?? '';
        
        echo <<<HTML
                        <tr>
                            <td>$product_name</td>
                            <td>$variant_name</td>
                            <td ondblclick="editPrice(this)">
                                $price
                                <input type="hidden" name="items[product_id][]" value="$product_id">
                                <input type="hidden" name="items[variant_id][]" value="$variant_id">
                                <input type="hidden" name="items[price][]" value="{$item['price']}">
                            </td>
                        </tr>
        HTML;
    }
    
    echo <<<HTML
                    </tbody>
                </table>
                
                <button type="button" class="btn-remove" onclick="removeSelectedItems()">Remove selected</button>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn">Save!</button>
            </div>
        </form>
    </div>
    
    <script>
    let variants = {};
    
    // This would be populated from your database in a real implementation
    async function loadVariantsForProduct(productId) {
        if (productId === '') {
            return [];
        }
        
        // Use AJAX to get variants
        try {
            const response = await fetch(`get_variants.php?product_id=${productId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();
            
            variants[productId] = data;
            return data;
        } catch (error) {
            console.error('Error fetching variants:', error);
            return [];
        }
    }
    
    document.getElementById('product-select').addEventListener('change', async function() {
        const productId = this.value;
        const variantSelect = document.getElementById('variant-select');
        
        // Clear variant select
        variantSelect.innerHTML = '<option value="">Select variant...</option>';
        
        if (productId) {
            if (!variants[productId]) {
                variants[productId] = await loadVariantsForProduct(productId);
            }
            
            // Populate variant dropdown
            variants[productId].forEach(variant => {
                const option = document.createElement('option');
                option.value = variant.id;
                option.textContent = variant.name;
                variantSelect.appendChild(option);
            });
        }
    });
    
    function addProduct() {
        const productSelect = document.getElementById('product-select');
        const variantSelect = document.getElementById('variant-select');
        const container = document.getElementById('items-container');
        
        const productId = productSelect.value;
        const variantId = variantSelect.value;
        
        if (!productId) {
            alert('Please select a product');
            return;
        }
        
        const productName = productSelect.options[productSelect.selectedIndex].text;
        const variantName = variantId ? variantSelect.options[variantSelect.selectedIndex].text : '';
        
        // Create a new row
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${productName}</td>
            <td>${variantName}</td>
            <td ondblclick="editPrice(this)">
                0.0
                <input type="hidden" name="items[product_id][]" value="${productId}">
                <input type="hidden" name="items[variant_id][]" value="${variantId}">
                <input type="hidden" name="items[price][]" value="0">
            </td>
        `;
        
        container.appendChild(row);
    }
    
    function editPrice(cell) {
        const currentPrice = cell.querySelector('input[name="items[price][]"]').value;
        const newPrice = prompt('Enter new price:', currentPrice);
        
        if (newPrice !== null && !isNaN(newPrice)) {
            // Update hidden input
            cell.querySelector('input[name="items[price][]"]').value = newPrice;
            
            // Update displayed text
            cell.childNodes[0].nodeValue = parseFloat(newPrice).toFixed(1);
        }
    }
    
    function removeSelectedItems() {
        const selectedRows = document.querySelectorAll('#items-container tr.selected');
        selectedRows.forEach(row => row.remove());
    }
    
    // Add click event to select rows
    document.addEventListener('click', function(e) {
        if (e.target && e.target.closest('#items-container tr')) {
            const row = e.target.closest('#items-container tr');
            row.classList.toggle('selected');
        }
    });
    </script>
    HTML;
    
    include 'templates/footer.php';
}

function save_order() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: index.php?page=orders');
        exit;
    }
    
    $pdo = connect_db();
    
    $name = $_POST['name'] ?? '';
    $city = $_POST['city'] ?? '';
    $address = $_POST['address'] ?? '';
    $zip = $_POST['zip'] ?? '';
    $type = $_POST['type'] ?? 'buy';
    $status = $_POST['status'] ?? 'in-progress';
    $comment = $_POST['comment'] ?? '';
    $items = $_POST['items'] ?? [];
    
    if (empty($name)) {
        echo "<div class='error'>Name is required</div>";
        return show_order_form();
    }
    
    try {
        $pdo->beginTransaction();
        
        // Create order
        $created = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("INSERT INTO orders (name, city, address, zip, type, status, comment, created) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $city, $address, $zip, $type, $status, $comment, $created]);
        $order_id = $pdo->lastInsertId();
        
        // Add order items
        if (!empty($items['product_id'])) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, variant_id, price) VALUES (?, ?, ?, ?)");
            
            foreach ($items['product_id'] as $i => $product_id) {
                $variant_id = !empty($items['variant_id'][$i]) ? $items['variant_id'][$i] : null;
                $price = !empty($items['price'][$i]) ? floatval($items['price'][$i]) : 0;
                
                $stmt->execute([$order_id, $product_id, $variant_id, $price]);
                
                // Update stock based on order type
                updateStock($product_id, $variant_id, $type, 1);
            }
        }
        
        $pdo->commit();
        header('Location: index.php?page=orders&message=saved');
        exit;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<div class='error'>Error saving order: " . sanitize($e->getMessage()) . "</div>";
        return show_order_form();
    }
}

function update_order($id) {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: index.php?page=orders');
        exit;
    }
    
    $pdo = connect_db();
    
    $name = $_POST['name'] ?? '';
    $city = $_POST['city'] ?? '';
    $address = $_POST['address'] ?? '';
    $zip = $_POST['zip'] ?? '';
    $type = $_POST['type'] ?? 'buy';
    $status = $_POST['status'] ?? 'in-progress';
    $comment = $_POST['comment'] ?? '';
    $items = $_POST['items'] ?? [];
    
    if (empty($name)) {
        echo "<div class='error'>Name is required</div>";
        return show_order_form($id);
    }
    
    try {
        $pdo->beginTransaction();
        
        // Get original order for stock adjustment
        $stmt = $pdo->prepare("SELECT type FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $original_order = $stmt->fetch();
        
        if (!$original_order) {
            throw new PDOException("Order not found");
        }
        
        // Get original items for stock adjustment
        $stmt = $pdo->prepare("SELECT product_id, variant_id FROM order_items WHERE order_id = ?");
        $stmt->execute([$id]);
        $original_items = $stmt->fetchAll();
        
        // Reverse the original stock changes
        foreach ($original_items as $item) {
            // If it was a buy, we subtract; if it was a sell, we add
            $reverse_type = $original_order['type'] === 'buy' ? 'sell' : 'buy';
            updateStock($item['product_id'], $item['variant_id'], $reverse_type, 1);
        }
        
        // Update order
        $stmt = $pdo->prepare("UPDATE orders SET name = ?, city = ?, address = ?, zip = ?, 
                              type = ?, status = ?, comment = ? WHERE id = ?");
        $stmt->execute([$name, $city, $address, $zip, $type, $status, $comment, $id]);
        
        // Delete existing items
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->execute([$id]);
        
        // Add new order items
        if (!empty($items['product_id'])) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, variant_id, price) VALUES (?, ?, ?, ?)");
            
            foreach ($items['product_id'] as $i => $product_id) {
                $variant_id = !empty($items['variant_id'][$i]) ? $items['variant_id'][$i] : null;
                $price = !empty($items['price'][$i]) ? floatval($items['price'][$i]) : 0;
                
                $stmt->execute([$id, $product_id, $variant_id, $price]);
                
                // Update stock based on new order type
                updateStock($product_id, $variant_id, $type, 1);
            }
        }
        
        $pdo->commit();
        header('Location: index.php?page=orders&message=updated');
        exit;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<div class='error'>Error updating order: " . sanitize($e->getMessage()) . "</div>";
        return show_order_form($id);
    }
}

// Stock functions
function show_stock() {
    include 'templates/header.php';
    
    $pdo = connect_db();
    
    $stmt = $pdo->query("SELECT s.*, p.name as product_name, v.name as variant_name 
                        FROM stock s
                        JOIN products p ON s.product_id = p.id
                        LEFT JOIN variants v ON s.variant_id = v.id
                        ORDER BY p.name, v.name");
    $stock_items = $stmt->fetchAll();
    
    echo <<<HTML
    <div class="main-content">
        <h