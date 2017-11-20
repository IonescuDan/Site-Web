<?php
require("config.php");
require("header.php");

if (isset($_POST['add'])) {

    $fields = array('productName', 'description', 'price');
    $error = false;
    foreach($fields AS $fieldname) {
        if(empty($_POST[$fieldname])) {
            echo 'Field '.$fieldname.' misses!<br />'; //Display error with field
            $error = true; //there are errors
        }
    }

    if(!$error) {
        $target = "productimages/" . basename($_FILES['image']['name']);
        $image = $_FILES['image']['name'];
        $name = mysqli_real_escape_string($db, $_POST['productName']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $price = mysqli_real_escape_string($db, $_POST['price']);
        $category = $_GET["id"];
        $sql = "INSERT INTO products (cat_id, name, description, image,price) VALUES ('$category', '$name', '$description', '$image', '$price')";
        mysqli_query($db, $sql);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Failed to upload image";
        }
        echo "<br> Product added successfully ! <br>";
    }
}

?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Image Upload</title>
    </head>
    <body>
    <div id="content">

        <form method="POST" action="<?php echo 'addproducts.php?id=' . $_GET['id'] ?>" enctype="multipart/form-data">
        <table>
                <tr><td>Product name: </td>
                    <td><input type="text" name="productName">
                </tr>
                <tr><td>Price: </td>
                    <td><input type="text" name="price">
                </tr>
                <tr><td>Description: </td>
                    <td><textarea name="description"></textarea>
                </tr>
                <tr><td>Image: </td>
                    <td><input type="file" name="image">
                </tr>
                <tr><td></td>
                    <td><input type="hidden" name="size" value="1000000">
                </tr>
                <tr>
                    <td><button type="submit" name="add">Add</button>
                </tr>
        </table>
        </form>
    </div>
    </body>
    </html>



















<?php require("footer.php"); ?>