<?php
if (file_exists("includes/conf.php"))
	include_once("includes/conf.php");
if ($_SESSION['admin'] != 1)
	header('Location: index.php');
?>
<html>
<head>
<?php
if (file_exists("includes/includes.php"))
	include_once("includes/includes.php");
?>
	<title> Admin Panel | <?php echo $name; ?> </title>
</head>
<body>
<?php
include_once("includes/header.php");
include_once("includes/sidebar.php");
echo "<div id ='content'>";
if (!empty($_POST) && isset($_GET['action']) && (isset($_POST['udel']) && $_POST['udel'] == 1) || (isset($_POST['cdel']) && $_POST['cdel'] == 1) || (isset($_POST['pdel']) && $_POST['pdel'] == 1)) {
	if (isset($_POST['cdel']) && $_POST['cdel'] == 1) { 
		$query1= "DELETE FROM cat_ref WHERE cid = ?";
		$sql1 = mysqli_prepare($con, $query1);
		mysqli_stmt_bind_param($sql1, 'd', $_POST['cid']);
	if (!mysqli_stmt_execute($sql1))
		echo "Something went wrong".mysqli_stmt_error($sql1);
	mysqli_stmt_free_result($sql1);
	mysqli_stmt_close($sql1);
		$query = "DELETE FROM categories WHERE cid = ?";
		$sql = mysqli_prepare($con, $query);
		mysqli_stmt_bind_param($sql, 'd', $_POST['cid']);
	}
	else if (isset($_POST['pdel']) && $_POST['pdel'] == 1) {
	$query = "DELETE FROM products WHERE pid = ?";
		$sql = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($sql, 'd', $_POST['pid']);
}
else if (isset($_POST['udel']) && $_POST['udel'] == 1) {
	$query = "DELETE FROM users WHERE uid = ?";
		$sql = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($sql, 'd', $_POST['uid']);
}
	if (!mysqli_stmt_execute($sql))
		echo "Something went wrong".mysqli_stmt_error($sql);
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);
}
else if (!empty($_POST) && isset($_GET['action']) && $_GET['action'] == "addp") {
	$query = "INSERT INTO products (title, summary, description, photo)
		VALUES (?, ?, ?, ?)";
	$sql = mysqli_prepare($con, $query);
	if (!mysqli_stmt_bind_param($sql, 'ssss', $_POST['pname'], $_POST['psummary'], $_POST['pdescription'], $_POST['pphoto']))
		echo "Something went wrong".mysqli_stmt_error($sql);
	if (!mysqli_stmt_execute($sql))
		echo "Something went wrong".mysqli_stmt_error($sql);
	$insert_id = mysqli_stmt_insert_id($sql);
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);

	foreach ($_POST['categories'] as $cats) {
		$query = "INSERT INTO cat_ref (cid, pid) VALUES (?, ?)";
		$sql = mysqli_prepare($con, $query);
		if (!mysqli_stmt_bind_param($sql, 'dd', $cats, $insert_id))
			echo "Something went wrong".mysqli_stmt_error($sql);
		if (!mysqli_stmt_execute($sql))
			echo "Something went wrong".mysqli_stmt_error($sql);
		mysqli_stmt_free_result($sql);
		mysqli_stmt_close($sql);
	}
}
else if (!empty($_POST) && isset($_GET['action']) && $_GET['action'] == "addc") {
	$query = "INSERT INTO categories (title, summary, description)
		VALUES (?, ?, ?)";
	$sql = mysqli_prepare($con, $query);
	if (!mysqli_stmt_bind_param($sql, 'sss', $_POST['cname'], $_POST['csummary'], $_POST['cdescription']))
		echo "Something went wrong".mysqli_stmt_error($sql);
	if (!mysqli_stmt_execute($sql))
		echo "Something went wrong".mysqli_stmt_error($sql);
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);
}
else if (!empty($_POST) && isset($_GET['action']) && $_GET['action'] == "editc") {
	$query = "UPDATE categories SET title = ?, summary = ?, description = ? WHERE cid = ?";
	$sql = mysqli_prepare($con, $query);
	if (!mysqli_stmt_bind_param($sql, 'ssss', $_POST['cname'], $_POST['csummary'], $_POST['cdescription'], $_POST['cid']))
		echo "Something went wrong".mysqli_stmt_error($sql);
	if (!mysqli_stmt_execute($sql))
		echo "Something went wrong".mysqli_stmt_error($sql);
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);
}
else if (!empty($_POST) && isset($_GET['action']) && $_GET['action'] == "editp") {
	$query = "UPDATE products SET title = ?, summary = ?, description = ?, photo = ? WHERE pid = ?";
	$sql = mysqli_prepare($con, $query);
	if (!mysqli_stmt_bind_param($sql, 'sssss', $_POST['pname'], $_POST['psummary'], $_POST['pdescription'], $_POST['pphoto'], $_POST['pid']))
		echo "Something went wrong".mysqli_stmt_error($sql);
	if (!mysqli_stmt_execute($sql))
		echo "Something went wrong".mysqli_stmt_error($sql);
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);
}
else if (!empty($_POST) && isset($_GET['action']) && $_GET['action'] == "editu" && $_POST['uid'] != "new") {
	$query1 = "UPDATE users SET name = ?, email = ?, uname = ?, admin = ? WHERE uid = ?";
	if(!$sql1 = mysqli_prepare($con, $query1))
		echo "Something went wrong1".mysqli_error($sql1);
	mysqli_stmt_bind_param($sql1, 'sssdd', $_POST['name'], $_POST['email'], $_POST['uname'], $_POST['admin'], $_POST['uid']);
	if (!mysqli_stmt_execute($sql1))
		echo "Something went wrong2".mysqli_stmt_error($sql1);
	mysqli_stmt_free_result($sql1);
	mysqli_stmt_close($sql1);
}
else if (!empty($_POST) && isset($_GET['action']) && $_GET['action'] == "editu" && $_POST['uid'] == "new") {
	$query = "INSERT INTO users (name, email, uname, pass)
		VALUES (?, ?, ?, ?)";
	$sql = mysqli_prepare($con, $query);
	if (!mysqli_stmt_bind_param($sql, 'ssss', $_POST['name'], $_POST['email'], $_POST['uname'], hash('sha512', $_POST['pass'])))
		echo "Something went wrong".mysqli_stmt_error($sql);
	if (!mysqli_stmt_execute($sql))
		echo "Something went wrong".mysqli_stmt_error($sql);
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);
}


$query = "SELECT uid, name FROM users";
$sql = mysqli_prepare($con, $query);
if (!mysqli_stmt_execute($sql))
	die ("Something went wrong".mysqli_stmt_error($sql));
mysqli_stmt_bind_result($sql, $uid, $uname);
while (mysqli_stmt_fetch($sql))
	$list_users[$uid] = $uname;
mysqli_stmt_free_result($sql);
mysqli_stmt_close($sql);


$query = "SELECT cid, title, summary FROM categories";
$sql = mysqli_prepare($con, $query);
if (!mysqli_stmt_execute($sql))
	die ("Something went wrong".mysqli_stmt_error($sql));
mysqli_stmt_bind_result($sql, $cid, $ctitle, $csummary);
while (mysqli_stmt_fetch($sql))
	$list_categories[$cid] = $ctitle;
mysqli_stmt_free_result($sql);
mysqli_stmt_close($sql);

$query = "SELECT pid, title, summary FROM products";
$sql = mysqli_prepare($con, $query);
if (!mysqli_stmt_execute($sql))
	die ("Something went wrong".mysqli_stmt_error($sql));
mysqli_stmt_bind_result($sql, $pid, $ptitle, $psummary);
while (mysqli_stmt_fetch($sql))
	$list_products[$pid] = $ptitle;
mysqli_stmt_free_result($sql);
mysqli_stmt_close($sql);
?>

<form method="post" action="admin.php?action=addp">
Add a new product:<br />
Product title: <input type="text" name="pname" /><br /> 
Product summary: <input type="text" name="psummary" /><br />
Product description: <input type="text" name="pdescription" /><br />
Product photo(link): <input type="text" name="pphoto" /><br />
<?php
foreach ($list_categories as $ckey => $cvalue)
	echo "Product categories: <input type='checkbox' name='categories[]' value='$ckey'>$cvalue<br />";
?>
<input type="submit" name="submit" value="submit" />
</form>
<form method="post" action="admin.php?action=addc"> 
Add a new category:<br />
Category title: <input type="text" name="cname" /><br /> 
Category summary: <input type="text" name="csummary" /><br />
Category description: <input type="text" name="cdescription" /><br />
<input type="submit" name="submit" value="submit" />
</form>

<form method="post" action="admin.php?action=editp"> 
Edit a product:<br />
<select name="pid">
<?php
foreach ($list_products as $pkey => $pvalue)
	echo "<option value='$pkey'>$pvalue</option>"
?>
</select><br />
Product title: <input type="text" name="pname" /><br /> 
Product summary: <input type="text" name="psummary" /><br />
Product description: <input type="text" name="pdescription" /><br />
Product photo: <input type="text" name="pphoto" /><br />
Delete product: (beware, this will delete it!) <input type="checkbox" name="pdel" value="1" /> 
<input type="submit" name="submit" value="submit" />
</form>

<form method="post" action="admin.php?action=editc"> 
Edit a category:<br />
<select name="cid">
<?php
	foreach ($list_categories as $ckey => $cvalue)
		echo "<option value='$ckey'>$cvalue</option>"
?>
</select><br />
Category title: <input type="text" name="cname" /><br /> 
Category summary: <input type="text" name="csummary" /><br />
Category description: <input type="text" name="cdescription" /><br />
Delete category: (beware, this will delete it!) <input type="checkbox" name="cdel" value="1" /> 
<input type="submit" name="submit" value="submit" />
</form>

<form action="admin.php?action=editu" method="post">
Edit/Create a user: <br />
<select name="uid">
<option value="new">New User</option>
<?php
		foreach ($list_users as $ukey => $uvalue)
			echo "<option value='$ukey'>$uvalue</option>"
?>
</select>
<br />
Username: <input type="text" name="uname"/><br />
Full Name: <input type="text" name="name" /><br />
Email: <input type="text" name="email" /><br />
Password:(only for new users): <input type="password" name="pass" /><br />
Admin rights: <input type='checkbox' name='admin' value='1'><br />
Delete user: (beware, this will delete it!) <input type="checkbox" name="udel" value="1" /> 
<input type="submit" name="submit" value="submit" />
</form>

<?php
?>

<?php
			mysqli_close($con);
?>
</div>
</body>
