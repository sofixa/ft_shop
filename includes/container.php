<?php
$query = "SELECT cid, title, summary FROM categories";
$sql = mysqli_prepare($con, $query);
if (!mysqli_stmt_execute($sql))
	die ("Something went wrong".mysqli_stmt_error($sql));
mysqli_stmt_bind_result($sql, $cid, $ctitle, $csummary);
while (mysqli_stmt_fetch($sql))
	$list_categories[$cid] = $ctitle;
mysqli_stmt_free_result($sql);
mysqli_stmt_close($sql);
?>
<div id="content">
<h1>Category:</h1> <select name="cid" onchange="showProducts(this.value)">
<?php
foreach ($list_categories as $ckey => $cvalue)
	echo "<option value='$ckey'>$cvalue</option>"
?>
</select>
<br />
<br />
<?php
	$query = "SELECT pid, title, summary, description, photo FROM products";
$sql = mysqli_prepare($con, $query);
if (!mysqli_stmt_execute($sql))
	die ("Something went wrong".mysqli_stmt_error($sql));
mysqli_stmt_bind_result($sql, $pid, $ptitle, $psummary, $pdescription, $pphoto);
mysqli_stmt_store_result($sql);
if (mysqli_stmt_num_rows($sql) < 1)
	echo "No products found\n";
else {
?>
<div id ="result">
<?php
while (mysqli_stmt_fetch($sql)) {
	echo "<div class='pelem'><img src='$pphoto' alt='$psummary' class='pphoto'/><br /><a href='product.php?pid=$pid' class='ptitle'>$ptitle</a><p class='psummary'>$psummary</p><a href='#' onclick='addToCart($pid)'> Add to Cart</p></div>";
}
}
mysqli_stmt_free_result($sql);
mysqli_stmt_close($sql);
?>
</div>
</div>



