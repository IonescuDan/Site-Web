<?php
function pf_validate_number($value, $function, $redirect) {
    $final = 1;
    $error = 0;
    if(isset($value) == TRUE) {
        if(is_numeric($value) == FALSE) {
            $error = 1;
        }
        if($error == 1) {
            header("Location: " . $redirect);
        }
        else {
            $final = $value;
        }
    }
    else {
        if($function == 'redirect') {
            header("Location: " . $redirect);
        }
        if($function == "value") {
            $final = 0;
        }
    }
    return $final;
}


function showcart()
{
    require("config.php");

    if(isset($_SESSION['SESS_ORDERNUM']))
    {
        if(isset($_SESSION['SESS_LOGGEDIN']))
        {
            $custsql = "SELECT id, status from orders WHERE customer_id = ". $_SESSION['SESS_USERID']. " AND status < 2;";
            $custres = mysqli_query($db, $custsql)or die(mysqli_error($db));;
            $custrow = mysqli_fetch_assoc($custres);

            $itemssql = "SELECT products.*, orderitems.*, orderitems.id AS itemid FROM products, orderitems WHERE orderitems.product_id =products.id AND order_id = " . $custrow['id'];
            $itemsres = mysqli_query($db, $itemssql)or die(mysqli_error($db));;
            $itemnumrows = mysqli_num_rows($itemsres);
        }
        else
        {
            $custsql = "SELECT id, status from orders WHERE session = '" . session_id(). "' AND status < 2;";
            $custres = mysqli_query($db, $custsql)or die(mysqli_error($db));;
            $custrow = mysqli_fetch_assoc($custres);
            $itemssql = "SELECT products.*, orderitems.*, orderitems.id AS itemid FROM products, orderitems WHERE orderitems.product_id = products.id AND order_id = " . $custrow['id'];
            $itemsres = mysqli_query($db, $itemssql)or die(mysqli_error($db));;
            $itemnumrows = mysqli_num_rows($itemsres);

        }
    }
    else
    {
       $itemnumrows = 0;
    }
    if($itemnumrows == 0)
    {
        echo "You have not added anything to your shopping cart yet.";
    }

    else
    {
        echo "<table cellpadding='10'>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td><strong>Item</strong></td>";
        echo "<td><strong>Quantity</strong></td>";
        echo "<td><strong>Unit Price</strong></td>";
        echo "<td><strong>Total Price</strong></td>";
        echo "<td></td>";
        echo "</tr>";
        while($itemsrow = mysqli_fetch_assoc($itemsres))
        {
            $quantitytotal = $itemsrow['price'] * $itemsrow['quantity'];
            echo "<tr>";
            if(empty($itemsrow['image'])) {
                echo "<td><img src='productimages/default.jpg' width='150' alt='" . $itemsrow['name'] . "'></td>";
            }
            else {
                echo "<td><img src='productimages/" .$itemsrow['image'] . "' width='50' alt='". $itemsrow['name'] . "'></td>";
            }
            echo "<td>" . $itemsrow['name'] . "</td>";
            echo "<td>" . $itemsrow['quantity'] . "</td>";
            echo "<td><strong>" . sprintf('%.2f', $itemsrow['price']) . " lei" . "</strong></td>";
            echo "<td><strong>". sprintf('%.2f', $quantitytotal) . " lei" . "</strong></td>";
            echo "<td>[<a href='delete.php?id=". $itemsrow['itemid'] . "'>X</a>]</td>";
            echo "</tr>";
            @$total = $total + $quantitytotal;
            $totalsql = "UPDATE orders SET total = ". $total . " WHERE id = ". $_SESSION['SESS_ORDERNUM'];
            $totalres = mysqli_query($db, $totalsql)or die(mysqli_error($db));;
        }
        echo "<tr>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td>TOTAL</td>";
        echo "<td><strong>". sprintf('%.2f', $total) . " lei" . "</strong></td>";
        echo "<td></td>";
        echo "</tr>";
        echo "</table>";
        echo "<p><a href='checkout-address.php'>Go to the checkout</a></p>";
    }
}

function setComments($db){
    if(isset($_POST['commentSubmit'])){
       $uid = $_POST['uid'];
       $date = $_POST['date'];
       $message = $_POST['message'];
       $pid = $_GET['id'];

       $sql = "INSERT INTO comments (uid, date, message, pid) 
                VALUES ('$uid', '$date', '$message', '$pid')";

       $result = mysqli_query($db, $sql);
    }
}

function getComments($db){
    $sql = "SELECT * FROM comments WHERE pid = " . $_GET['id']. ";";
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='comment-box'><p></p>";
            echo $row['uid'] . "<br>";
            echo $row['date'] . "<br>";
            echo nl2br($row['message']);
        echo "</p>";
        if(@$_SESSION['SESS_LOGGEDIN'] == 1) {
            if (@$_SESSION['SESS_USERNAME'] == $row['uid']) {
                echo " <form class='delete-form' method='POST' action='".deleteComments($db)."'>
                <input type='hidden' name='cid' value='".$row['cid']."'>
                <button type = 'submit' name = 'commentDelete'>Delete</button>
            </form>
            <form class='edit-form' method='POST' action='editcomments.php?'>
                <input type='hidden' name='cid' value='".$row['cid']."'>
                <input type='hidden' name='uid' value='".$row['uid']."'>
                <input type='hidden' name='date' value='".$row['date']."'>
                <input type='hidden' name='pid' value='".$row['pid']."'>
                <input type='hidden' name='message' value='".$row['message']."'>
                <button>Edit</button>
            </form>";
            }
        }

        if(@$_SESSION['SESS_ADMINLOGGEDIN'] == 1) {
            if (@$_SESSION['SESS_ADMINUSERNAME'] == $row['uid']) {
                echo " <form class='delete-form' method='POST' action='".deleteComments($db)."'>
                <input type='hidden' name='cid' value='".$row['cid']."'>
                <button type = 'submit' name = 'commentDelete'>Delete</button>
            </form>
            <form class='edit-form' method='POST' action='editcomments.php'>
                <input type='hidden' name='cid' value='".$row['cid']."'>
                <input type='hidden' name='uid' value='".$row['uid']."'>
                <input type='hidden' name='date' value='".$row['date']."'>
                <input type='hidden' name='pid' value='".$row['pid']."'>
                <input type='hidden' name='message' value='".$row['message']."'>
                <button>Edit</button>
            </form>";
            }
        }
        echo "</div>";
    }
}

function editComments($db){
    if(isset($_POST['commentSubmit'])){
        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        $sql = "UPDATE comments SET message = '$message' WHERE cid = '$cid'";
        $result = mysqli_query($db, $sql);

    }

}

function deleteComments($db){
    if(isset($_POST['commentDelete'])){
        $cid = $_POST['cid'];

        $sql = "DELETE FROM comments WHERE cid = '$cid'";
        $result = mysqli_query($db, $sql);
        header("Location: comments.php?id=".$_GET['id']);
    }
}