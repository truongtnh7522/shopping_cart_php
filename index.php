<!DOCTYPE html>
<html>

<head>
    <title>Web Project</title>
    <style>
        .product {}

        body {
            background-image: url("https://images.saymedia-content.com/.image/t_share/MTkzODU1MjgzMjUxMTkzMzI4/svg-wave-generator.gif");
            background-size: cover;
            background-repeat: no-repeat;
        }

        .card-container {
            display: flex;
            flex-direction: row;
            gap: 20px;
            width: 800px;
            height: 590px;
            margin: 60px auto;
            overflow: hidden;
        }


        .product-card {
            border-radius: 20px;
            background-color: #ffff;
            flex: 1;
            border: 1px solid #ccc;
            padding-left: 20px;
            padding-right: 20px;
            padding-bottom: 20px;
            margin-bottom: 10px;
            overflow: auto;
            max-height: 550px;
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        .cart-card {
            font-size: 23px;
            border-radius: 20px;
            background-color: #ffff;
            flex: 1;
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 10px;
            overflow: auto;
            max-height: 550px;
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        .product-card::-webkit-scrollbar,
        .cart-card::-webkit-scrollbar {
            width: 8px;
        }

        .product-card::-webkit-scrollbar-thumb,
        .cart-card::-webkit-scrollbar-thumb {
            background-color: transparent;
            border-radius: 4px;
        }

        .product-card::-webkit-scrollbar-track,
        .cart-card::-webkit-scrollbar-track {
            background-color: transparent;
        }

        .product-card img {
            border-radius: 50px;
            width: 350px;
            height: 350px;
            align-items: center;
        }

        .cart-card img {
            width: 100px;
            height: 100px;
            margin-right: 10px;
            float: left;
        }

        .product-card .name,
        .cart-card .name {
            font-weight: bold;
        }

        .product-card .price,
        .cart-card .price {
            color: green;
        }

        .product-card .description,
        .cart-card .item {
            margin-bottom: 30px;
        }

        .cart-card .item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            float: left;
        }

        .cart-card .item .name {
            font-weight: bold;
        }

        .cart-card .item .price {
            color: green;
        }

        .cart-card .item .quantity {
            margin-right: 10px;
        }

        .empty-cart {
            font-weight: bold;
            color: red;
        }

        .cart-card .header {
            position: sticky;
            top: 0;
            background-color: #ffffff;
            padding: 10px;
            padding-top: 0px;

            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card .header-product {
            display: block;
            width: 10000px;
            position: sticky;
            top: 0;
            background-color: #ffffff;
            padding-top: 20px;
            padding-bottom: 10px;
            z-index: 1;
            backdrop-filter: blur(5px);
            transform: translateZ(0);
        }
    </style>
</head>

<body>
    <?php
    // Start the session
    session_start();

    // Kiểm tra xem giỏ hàng có tồn tại không
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Lấy dữ liệu sản phẩm từ tệp shoes.json
    $jsonData = file_get_contents('./shoes.json');
    $products = json_decode($jsonData, true)['shoes'];

    // Xử lý khi người dùng thêm sản phẩm vào giỏ hàng
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        // Kiểm tra xem sản phẩm đã được thêm vào giỏ hàng chưa
        if (!in_array($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][$productId] = 1; // Set initial quantity as 1
        } else {
            // Increase the quantity if the product is already in the cart
            $_SESSION['cart'][$productId]++;
        }
    }

    // Xử lý khi người dùng xóa sản phẩm khỏi giỏ hàng
    if (isset($_POST['remove_product_id'])) {
        $productId = $_POST['remove_product_id'];

        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$productId]);
    }

    // Xử lý khi người dùng tăng số lượng sản phẩm trong giỏ hàng
    if (isset($_POST['increase_product_id'])) {
        $productId = $_POST['increase_product_id'];

        // Tăng số lượng sản phẩm
        $_SESSION['cart'][$productId]++;
    }

    // Xử lý khi người dùng giảm số lượng sản phẩm trong giỏ hàng
    if (isset($_POST['decrease_product_id'])) {
        $productId = $_POST['decrease_product_id'];

        // Giảm số lượng sản phẩm và xóa nếu giảm xuống 0
        $_SESSION['cart'][$productId]--;
        if ($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
    }
    // include './cart.html';
?>

    <div class="card-container">
        <div class="product-card">

            <div class="header-product">
                <img style="width: 70px;height: 50px;" src="./assets/nike.png" alt="">
                <h2 style="font-size: 30px;margin-top: 5px;">Our Products</h2>
            </div>

            <?php foreach ($products as $product): ?>
            <div class="product" style="padding-bottom: 30px;">
                <img src="<?php echo $product['image']; ?>" style="background-color: <?php echo $product['color']; ?>;">
                <div style="font-size: 30px;" class="name">
                    <?php echo $product['name']; ?>
                </div>
                <div class="description">
                    <?php echo $product['description']; ?>
                </div>
                <div style="display: flex;font-size: 30px;">
                    <div class="price">$<?php echo $product['price']; ?>
                    </div>
                    <div style="margin-left: 120px;">
                        <?php if (isset($_SESSION['cart'][$product['id']])): ?>
                    <button disabled style=" border-radius: 50%;background-color: #30e792;margin-left: 60px;">
                        <img style="height: 30px;width: 30px;" src="./assets/check.png" alt="Check">
                    </button>

                    <?php else: ?>
                    <form method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" style="background-color: #30e792; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; display: inline-block; width: 130px;">Add To Cart</button>

                    </form>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-card">
            <?php
            $totalPrice = 0;
            foreach ($products as $product) {
                if (isset($_SESSION['cart'][$product['id']])) {
                    $quantity = $_SESSION['cart'][$product['id']];
                    $subtotal = $product['price'] * $quantity;
                    $totalPrice += $subtotal;
                }
            }
        ?>
            <div class="header">

                <img style="width: 70px;height: 50px;" src="./assets/nike.png" alt="">
               <div style="display: flex;">
                <h2 style="font-size: 30px;margin-top: 5px;">Your Cart</h2>

                <div style="margin-top: 10px;margin-left: 100px;" class="total-price">$
                    <?php echo $totalPrice; ?>
                </div>
               </div>
            </div>
            <?php if (empty($_SESSION['cart'])): ?>
            <div class="empty-cart">Your cart is empty.</div>
            <?php else: ?>
            <div class="cart">
                <?php
                    $totalPrice = 0;
                    foreach ($products as $product) {
                        if (isset($_SESSION['cart'][$product['id']])) {
                            $quantity = $_SESSION['cart'][$product['id']];
                            $subtotal = $product['price'] * $quantity;
                            $totalPrice += $subtotal;
                            ?>
                <div class="item"style="padding-bottom:30px">
                    <img src="<?php echo $product['image']; ?>"
                        style="border-radius:50%;width:  100px;height: 100px;background-color: <?php echo $product['color']; ?>;">
                    <div style="font-size: 20px;" class="name">
                        <?php echo $product['name']; ?>
                    </div>
                    <div class="price">$
                        <?php echo $product['price']; ?>
                    </div>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="increase_product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit"style=" border-radius: 10px;">
                            <img style="height: 20px;width: 20px;
                            margin-left: 10px;" src="assets/plus.png" alt="Check">
                        </button>
                    </form>
                    <span class="quantity">
                        <?php echo $quantity; ?>
                    </span>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="decrease_product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit"style=" border-radius: 10px;">
                            <img style="height: 20px;width: 20px;margin-left: 10px;" src="assets/minus.png" alt="Check">
                        </button>
                    </form>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="remove_product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" style=" border-radius: 5px;background-color: #66b0e9">
                            <img style="height: 20px;width: 20px;margin-left: 10px;" src="assets/trash.png" alt="Check">

                        </button>
                    </form>
                </div>
                <?php
                        }
                    }
                    ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
