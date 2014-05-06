<?php
if (file_exists("includes/conf.php"))
	include_once("includes/conf.php");
else
	header('Location: install.php');
?>
<html>
<head>
<?php
if (file_exists("includes/includes.php"))
	include_once("includes/includes.php");
?>
<?php
if (!isset($_SESSION['uname']))
	header("index.php");
?>
	<title>Edit Account | <?php echo $name; ?></title>
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
$query = "SELECT * FROM users WHERE uid = ? LIMIT 1";
$sql = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($sql, 'd', $_SESSION['id']);
if (!mysqli_stmt_execute($sql))
	die("Something went wrong3".mysqli_stmt_error($sql));
mysqli_stmt_bind_result($sql, $id, $name, $email, $uname, $password, $admin);
if (!mysqli_stmt_fetch($sql))
	die ("Something went wrong4".mysqli_stmt_error($sql));
mysqli_stmt_free_result($sql);
mysqli_stmt_close($sql);
?>



<?php
if (!empty($_GET) && $_GET['action'] == "edit" && isset($_POST['submit'])) {
	$query1 = "UPDATE users SET name = ?, email = ?, uname = ?, pass = ? WHERE uid = ?";
	if(!$sql1 = mysqli_prepare($con, $query1))
		echo "Something went wrong1".mysqli_error($sql1);
	if (!isset($_POST['newpassword']))
		$pass = $password;
	else
		$pass = hash('sha512', $_POST['newpassword']);
	mysqli_stmt_bind_param($sql1, 'ssssd', $_POST['name'], $_POST['email'], $_POST['uname'], $pass, $id);
	if (!mysqli_stmt_execute($sql1))
		echo "Something went wrong2".mysqli_stmt_error($sql1);
	mysqli_stmt_free_result($sql1);
	mysqli_stmt_close($sql1);

	$query = "SELECT * FROM users WHERE uid = ? LIMIT 1";
	$sql = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($sql, 'd', $_SESSION['id']);
	if (!mysqli_stmt_execute($sql))
		die("Something went wrong3".mysqli_stmt_error($sql));
	mysqli_stmt_bind_result($sql, $id, $name, $email, $uname, $password, $admin);
	if (!mysqli_stmt_fetch($sql))
		die ("Something went wrong4".mysqli_stmt_error($sql));
	mysqli_stmt_free_result($sql);
	mysqli_stmt_close($sql);

}

?>
<form action="edit.php?action=edit" method="post">
Username: <input type="text" name="uname" value="<?php echo $uname; ?>" /><br />
Full Name: <input type="text" name="name" value="<?php echo $name; ?>" /><br />
Email: <input type="text" name="email" value="<?php echo $email; ?>" /><br />
New password:(if left blank, no changes will be made) <input type="password" name="newpassword" /><br />
Password (needed for changes): <input type="password" name="password" /><br />
<input type="submit" name="submit" value="submit" />
</form>
</body>
</html>
