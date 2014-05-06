<?php
if (file_exists("conf.php")){
	include_once("conf.php");
}
if (isset($_GET['action']) && $_GET['action'] == "showproducts" && isset($_GET['cid']) && is_numeric($_GET['cid'])) {
	$cid = intval($_GET['cid']);
	$query = "SELECT c.pid, c.title, c.summary, c.description, c.photo FROM products AS c JOIN cat_ref AS o ON c.pid = o.pid WHERE o.cid = ?";
	if(!$sql = mysqli_prepare($con, $query))
		echo "Something went wrong".mysqli_error($sql);
	if(!mysqli_stmt_bind_param($sql, 'd', $_GET['cid']))
		echo "Something went wrong".mysqli_error($sql);
	if (!mysqli_stmt_execute($sql))
		die ("Something went wrong".mysqli_stmt_error($sql));
	if(!mysqli_stmt_bind_result($sql, $pid, $ptitle, $psummary, $pdescription, $pphoto))
		echo "Something went wrong".mysqli_stmt_error($sql);
	mysqli_stmt_store_result($sql);
	if (mysqli_stmt_num_rows($sql) < 1)
		echo "No results found\n";
	else {
	while (mysqli_stmt_fetch($sql)){
		echo "<div class='pelem'><img src='$pphoto' alt='$psummary' class='pphoto'/><br /><a href='product.php?pid=$pid' class='ptitle'>$ptitle</a><p class='psummary'>$psummary</p></div> <a href='#' onclick='addToCart($pid)'> Add to Cart</p>";
	}
	}
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);
}

else if (isset($_GET['action']) && $_GET['action'] == "addtocart" && is_numeric($_GET['pid'])) {
	$logic = true;
	foreach($_SESSION['cart'] as $cart) {
		if ($cart === $_GET['pid']) {
			$logic = false;
			$break;
		}
	}
	if ($logic === true) {
		$_SESSION['cart'][] = $_GET['pid'];
		echo "Successfully added item to cart!";
	}
	else 
		echo "Item is already in cart!";
}
else if (isset($_GET['action']) && $_GET['action'] == "countcart") {
	echo count($_SESSION['cart']);
	if (count($_SESSION['cart']) > 1 || count($_SESSION['cart']) === 0)
		echo " items";
	else
		echo " item";
}
else if (isset($_GET['action']) && $_GET['action'] == "removefromcart" && is_numeric($_GET['pid'])) {
	foreach ($_SESSION['cart'] as $key => $cart) {
		if ($cart === $_GET['pid']) {
			unset($_SESSION['cart'][$key]);
			echo "Successfully removed item from cart!";
		}
	}
}
?>
