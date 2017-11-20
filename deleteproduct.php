<?php
require("config.php");
require('header.php');
$id = $_GET['id'];
$category = "SELECT cat_id FROM products WHERE id = " . $id . ";";
$cat = mysqli_query($db, $category);
$value = mysqli_fetch_assoc($cat);

$deleteProd = "DELETE FROM products WHERE id = ". $id . ";";
$deleteReviews = "DELETE FROM comments WHERE pid = ". $id . ";";

if(mysqli_query($db, $deleteProd) && mysqli_query($db, $deleteReviews)) {
    header("Location:". $config_basedir ."products.php?id=" . $value['cat_id']);
}else{
    echo "Error on deleting product!";
}
require('footer.php');
?>