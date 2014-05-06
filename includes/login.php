<?php
if (file_exists("conf.php"))
	include_once("conf.php");
if (!empty($_POST)) {
	if ($_GET['action'] === "register") {
		$query = "INSERT INTO users (name, email, uname, pass)
			VALUES (?, ?, ?, ?)";
		$sql = mysqli_prepare($con, $query);
		if (!mysqli_stmt_bind_param($sql, 'ssss', $_POST['name'], $_POST['email'], $_POST['uname'], hash('sha512', $_POST['pass'])))
			echo "Something went wrong".mysqli_stmt_error($sql);
		if (!mysqli_stmt_execute($sql))
			echo "Something went wrong".mysqli_stmt_error($sql);
	}
	else if ($_GET['action'] === "log") {
		$query = "SELECT uname, admin, uid FROM users WHERE uname = ? AND pass = ? LIMIT 1";
		$sql = mysqli_prepare($con, $query);
		mysqli_stmt_bind_param($sql, 'ss', $_POST['uname'], hash('sha512', $_POST['pass']));
		if (!mysqli_stmt_execute($sql))
			die ("Something went wrong".mysqli_stmt_error($sql));
		mysqli_stmt_bind_result($sql, $result, $admin, $id);
		if(mysqli_stmt_fetch($sql)) {
			$_SESSION['uname'] = $result;
			$_SESSION['admin'] = $admin;
			$_SESSION['id'] = $id;
		}
		else
			echo "Login failed";
	}
	mysqli_stmt_close($sql);
}
else if (!empty($_GET) && isset($_GET['action']) && $_GET['action'] == "logout")
{
	session_destroy();
	header('Location: index.php');
}
?>
