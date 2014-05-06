<div id="header">
<div>
<ul id="nav">
<li><a href="index.php">Home</a></li>
<li><a href="product.php">Products</a></li>
<li><a href="checkout.php">Checkout</a></li>
<?php
if (isset($_SESSION['uname'])){
echo '<li><a href="edit.php">Edit account</a></li>';
}
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1)
	echo '<li><a href="admin.php">Admin panel</a></li>'
?>
</ul>
</div>
</div>
