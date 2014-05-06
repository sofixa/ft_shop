<?php
if (file_exists("includes/conf.php"))
		include_once("includes/conf.php");
else
		 header( 'Location: install.php' ) ;
?>
<html>
<head>
<?php
if (file_exists("includes/includes.php"))
		include_once("includes/includes.php");
?>
	<title>Product page | <?php echo $name; ?></title>
</head>
<body>
<?php
if (isset($_SESSION['cart'])) {
		echo "<div id='cart'><a id='carta' href='checkout.php'>".count($_SESSION['cart']);
			if (count($_SESSION['cart']) > 1)
						echo " items";
				else
							echo " item";
			echo "</a></div>";
}
else {
		$_SESSION['cart'] = array();
			echo "<div id='cart'><a id='carta' href='checkout.php'>0</a></div>";
}

include_once("includes/login.php");
include_once("includes/header.php");
include_once("includes/sidebar.php");
?>
<div id="content">
<?php
if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {
	$query = "SELECT title, summary, description, photo FROM products WHERE pid = ?";
	$sql = mysqli_prepare($con, $query);
	if (!mysqli_stmt_bind_param($sql, 'd', $_GET['pid']))
					echo "Something went wrong".mysqli_stmt_error($sql);
	if (!mysqli_stmt_execute($sql))
			die ("Something went wrong".mysqli_stmt_error($sql));
	mysqli_stmt_bind_result($sql, $ptitle, $psummary, $pdescription, $pphoto);
	mysqli_stmt_store_result($sql);
		if (mysqli_stmt_num_rows($sql) < 1)
		echo "No result found for product with such id. Try again, link broken?\n";
		else {
			$pid = $_GET['pid'];
?>
<table border='1'>
<?php
	while (mysqli_stmt_fetch($sql)) {
		echo "<tr><td>Photo</td><td><img src='$pphoto' height='300px' width='300px' /></td></tr>";
		echo "<tr><td>Product name</td><td>$ptitle</td></tr>";
		echo "<tr><td>Product summary</td><td>$psummary</td></tr>";
		echo "<tr><td>Product description</td><td>$pdescription</td></tr>";
		echo "<tr><td><a href='#' onclick='addToCart($pid)'>Add to cart</a></td></tr>";
		if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1)
			echo "<tr><td><a href='admin.php'>Edit</a></td></tr>";
	}
	echo "</table>";
	}
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);
}
else {
include_once('includes/container.php');

}
?>

</div>
</body>
<?php
mysqli_close($con);
?>
</html>
