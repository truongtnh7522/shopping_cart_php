<!DOCTYPE html>
<html>

<head>
    <title>Web Project</title>
    <style>
    .product {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }

    .product img {
        width: 100px;
        height: 100px;
        margin-right: 10px;
        float: left;
    }

    .product .name {
        font-weight: bold;
    }

    .product .price {
        color: green;
    }

    .product .description {
        margin-bottom: 10px;
    }

    .cart {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }

    .cart .item {
        margin-bottom: 10px;
    }

    .cart .item img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        float: left;
    }

    .cart .item .name {
        font-weight: bold;
    }

    .cart .item .price {
        color: green;
    }

    .cart .item .quantity {
        margin-right: 10px;
    }

    .empty-cart {
        font-weight: bold;
        color: red;
    }
    </style>
</head>

<body>
    <?php
    // Kiểm tra xem giỏ hàng có tồn tại không
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Lấy dữ liệu sản phẩm từ tệp shoes.json
    $jsonData = file_get_contents('shoes.json');
    $products = json_decode($jsonData, true)['shoes'];

    // Xử lý khi người dùng thêm sản phẩm vào giỏ hàng
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        // Kiểm tra xem sản phẩm đã được thêm vào giỏ hàng chưa
        if (!in_array($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $productId;
        }
    }

    // Xử lý khi người dùng xóa sản phẩm khỏi giỏ hàng
    if (isset($_POST['remove_product_id'])) {
        $productId = $_POST['remove_product_id'];

        // Xóa sản phẩm khỏi giỏ hàng
        $_SESSION['cart'] = array_diff($_SESSION['cart'], [$productId]);
    }
    ?>

    <h2>Our Products</h2>
    <?php foreach ($products as $product): ?>
    <div class="product">
        <img src="<?php echo $product['image']; ?>">
        <div class="name"><?php echo $product['name']; ?></div>
        <div class="description"><?php echo $product['description']; ?></div>
        <div class="price">$<?php echo $product['price']; ?></div>
        <?php if (in_array($product['id'], $_SESSION['cart'])): ?>
        <button disabled>✓</button>
        <?php else: ?>
        <form method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit">Add To Cart</button>
        </form>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <h2>Your Cart</h2>
    <?php if (empty($_SESSION['cart'])): ?>
    <div class="empty-cart">Your cart is empty.</div>
    <?php else: ?>
    <div class="cart">
        <?php
            $totalPrice = 0;
            foreach ($products as $product) {
                if (in_array($product['id'], $_SESSION['cart'])) {
                    $totalPrice += $product['price'];
                    ?>
        <div class="item">
            <img src="<?php echo $product['image']; ?>">
            <div class="name"><?php echo $product['name']; ?></div>
            <div class="price">$<?php echo $product['price']; ?></div>
            <form method="post">
                <input type="hidden" name="remove_product_id" value="<?php echo $product['id']; ?>">
                <button type="submit">Remove</button>
            </form>
        </div>
        <?php
                }
            }
            ?>
        <div class="total-price">Total Price: $<?php echo $totalPrice; ?></div>
    </div>
    <?php endif; ?>
</body>

</html>
