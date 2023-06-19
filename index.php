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
    include './cart.html';
?>
