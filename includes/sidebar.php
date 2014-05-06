<div id="sidebar">
<ul id="menu">
<?php
if (isset($_SESSION['uname'])) {

	if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1)
		echo "<li><a href='admin.php'>Admin panel</a></li>";
?>
<li><a href="edit.php">Change account settings</a></li>
<li><a href="includes/login.php?action=logout">Log out</a></li>
<?php
}
else {
	include_once("includes/log.php");
}
?>
</ul>
</div>
