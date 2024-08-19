<?php
require "../config/config.php";
require "../libs/App.php";

if (isset($_POST['item_id']) && isset($_POST['quantity'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    $app = new App;
    $query = "UPDATE cart SET quantity = :quantity WHERE id = :item_id AND user_id AND user_id= :user_id";
    $arr = [
        ":quantity" => $quantity,
        ":item_id" => $item_id,
        ":user_id" => $_SESSION['user']
    ];
    $app->update($query,$arr,null);
    echo "Quantity updated successfully";
    exit();
}
?>