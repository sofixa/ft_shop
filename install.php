<html>
<head>
<?php
include_once("includes/includes.php");
?>
	<title>Install <?php echo $name; ?> </title>
</head>
<body>
<?php
if (!empty($_POST)) {
	if (!$_POST['mysqlhost'] || !$_POST['mysqluser'] || !$_POST['mysqlpass'] || !$_POST['mysqldb'] || !$_POST['apass'])
		echo "Missing argument, go back and fill the form properly!\n";
	else {
		$con=mysqli_connect($_POST['mysqlhost'],$_POST['mysqluser'],$_POST['mysqlpass']);
		if (mysqli_connect_errno()) {
			echo "Failed to connect to the MySQL server, are you sure it's running and the details are correct?\n";
			die ("Error Report:".mysqli_connect_error());
		}
		else {
			$db = mysqli_select_db($con, $_POST['mysqldb']);
			if (!$db) {
				if (!mysqli_query($con, "CREATE DATABASE ".$_POST['mysqldb']))
					die ("Error creating database ".mysqli_error($con)."\n");
				else {
					echo "Successfully created database ".$_POST['mysqldb']."\n";
					$db = mysqli_select_db($con, $_POST['mysqldb']);
				}
			}
			$sql = "CREATE TABLE IF NOT EXISTS `users` ( 
				`uid` int(11) NOT NULL auto_increment, 
				`name` varchar(255) default NULL, 
				`email` varchar(255) default NULL, 
				`uname` varchar(255) default NULL, 
				`pass` text, 
				`admin` tinyint(1),
				PRIMARY KEY (`uid`),
				UNIQUE KEY (`uname`)
			);";
			if(mysqli_query($con, $sql)) {
				$sql2 = "CREATE TABLE IF NOT EXISTS `categories` ( 
				`cid` int(11) NOT NULL auto_increment, 
				`time_added` datetime default NULL, 
				`title` varchar(255) default NULL, 
				`summary` text, 
				`description` text, 
				PRIMARY KEY (`cid`),
				UNIQUE KEY(`title`));";
				if (mysqli_query($con, $sql2)) {

			$sql1 = "CREATE TABLE IF NOT EXISTS `products` ( 
				`pid` int(11) NOT NULL auto_increment, 
				`time_added` datetime default NULL, 
				`title` varchar(255) default NULL, 
				`summary` text, 
				`description` text, 
				`photo` text,
				PRIMARY KEY (`pid`));";
			if (mysqli_query($con, $sql1))
			{
				$sql3 = "CREATE TABLE IF NOT EXISTS `cat_ref` (
					  cid INT NOT NULL,
					    pid INT NOT NULL,
						FOREIGN KEY (cid) REFERENCES categories(cid));";
				if (mysqli_query($con, $sql3)) {
				$hash = hash('sha512', $_POST['apass']);
				if(!mysqli_query($con, "INSERT INTO users (name, uname, pass, admin) VALUES ('admin', 'admin', '$hash', '1')"))
					die("Something went wrong while creating admin account".mysqli_error($con));
				echo "Successfully created tables!\n";
				file_put_contents("includes/conf.php", '<?php '."\n".'session_start();'."\n".'$con=mysqli_connect("'.$_POST["mysqlhost"].'", "'.$_POST["mysqluser"].'", "'.$_POST["mysqlpass"].'", "'.$_POST["mysqldb"].'");'."\n".'if(mysqli_connect_errno())'."\n".'die("Failed to connect to the db."); ?> '."\n".'');
			}
			else 
				die("Unsuccess! Try again?\n".mysqli_error($con));
			}
			else
				die("Unsuccess! Try again\n".mysqli_error($con));
			}
			else
				die ("Unsuccess! Try again\n".mysqli_error($con));
			}
		}
		mysqli_close($con);
	}
}
else {
?>
<form action="install.php" method="post">
<p>Before we can use <?php echo $name; ?>, we need to install it!. <br />
First, we'll make our MySQL configs. If you don't know what you're doing, don't change them, just type the password you entered while installing MAPM</p>
MySQL host: 
<input type="text" name="mysqlhost" id="mysqlhost" value="localhost" /><br />
MySQL user: 
<input type="text" name="mysqluser" id="mysqluser" value="root" /> <br />
MySQL password: 
<input type="password" name="mysqlpass" id="mysqlopass" /><br />
MySQL database: (if it doesn't exist, it will be created) 
<input type="text" name="mysqldb" id="mysqldb" value="rush00" /><br />
Site admin password<input type="password" name="apass" /><br />
<input type="submit" name="submit" value="Submit" />
</form>
<?php
}
?>
</body>
</html>
