<?php

    session_start();


    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }


    $jsonData = file_get_contents('./shoes.json');
    $products = json_decode($jsonData, true)['shoes'];


    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];


        if (!in_array($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][$productId] = 1;
        } else {

            $_SESSION['cart'][$productId]++;
        }
    }


    if (isset($_POST['remove_product_id'])) {
        $productId = $_POST['remove_product_id'];


        unset($_SESSION['cart'][$productId]);
    }


    if (isset($_POST['increase_product_id'])) {
        $productId = $_POST['increase_product_id'];


        $_SESSION['cart'][$productId]++;
    }


    if (isset($_POST['decrease_product_id'])) {
        $productId = $_POST['decrease_product_id'];


        $_SESSION['cart'][$productId]--;
        if ($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
    }
    include './cart.html';
?>
