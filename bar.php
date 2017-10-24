<h1>Product Categories</h1>
<ul>
    <?php
    $catsql = "SELECT * FROM categories;";
    $catres = mysqli_query($db, $catsql);
    while($catrow = mysqli_fetch_assoc($catres))
    {
        echo "<li><a href='" . "products.php?id=" . $catrow['id'] . "'>". $catrow['name'] . "</a></li>";
    }
    ?>
</ul>
