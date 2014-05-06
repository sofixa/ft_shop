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
	<title>Welcome to <?php echo $name; ?></title>
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
	echo "<div id='cart'>0</div>";
}

include_once("includes/login.php");
include_once("includes/header.php");
include_once("includes/sidebar.php");
include_once("includes/container.php");
?>
</body>
<?php
mysqli_close($con);
?>
</html>
