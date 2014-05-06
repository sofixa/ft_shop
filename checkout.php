<?php
if (file_exists("includes/conf.php"))
		include_once("includes/conf.php");
else
	header( 'Location: install.php' ) ;
if (!isset($_SESSION['uname']))
	header('Location: index.php');
?>
<html>
<head>
<?php
if (file_exists("includes/includes.php"))
include_once("includes/includes.php");
?>
	<title>Checkout | <?php echo $name; ?></title>
</head>
<body>
<div id="cart"><a id='carta' href='checkout.php'>
<?php
echo count($_SESSION['cart']); 
if (count($_SESSION['cart']) > 1)
	echo " items";
else
	echo " item";
?>
</a></div>
<?php
include_once('includes/header.php');
include_once('includes/sidebar.php');
?>
<div id="content">
<p>You have the following items in your cart:</p>
<table border='1'>
<tr><th>Product name</th><th>Product summary</th><th>Photo</th><th>Remove from cart</th></tr>
<?php
foreach ($_SESSION['cart'] as $cart) {
	$query = "SELECT title, summary, photo FROM products WHERE pid = ?";
	$sql = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($sql, 'd', $cart);
	if (!mysqli_stmt_execute($sql))
			die ("Something went wrong".mysqli_stmt_error($sql));
	mysqli_stmt_bind_result($sql, $ptitle, $psummary, $pphoto);
	while (mysqli_stmt_fetch($sql)) {
		echo "<tr><td><a href='product.php?pid=$cart'>$ptitle</td><td>$psummary</td><td><a href='$pphoto'>Link</a></td><td><a href='#' onclick='removeFromCart($cart)'>Remove from Cart</p></td></tr>";
	}
}
?>

</table>
<p><a href='#'>Click here to check out an proceed to payment</a></p>
</div>
</body>
</html>
