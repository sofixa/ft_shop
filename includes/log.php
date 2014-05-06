<?php
if (!isset($_SESSION['uname'])) {
?>
<p>Register an account, or, if you already have, login from below:</p><br />
<form action="index.php?action=register" method="post">
Username: <input type="text" name="uname" /> <br />
Password: <input type="password" name="pass" /> <br />
Ful Name: <input type="text" name="name" /><br />
Email: <input type="text" name="email" /><br />
<input type="submit" name="submit" value="Submit" />
</form>
<form action="index.php?action=log" method="post">
Username: <input type="text" name="uname" /> <br />
Password: <input type="password" name="pass" /> <br />
<input type="submit" name="submit" value="Submit" />
</form>
<?php
}
?>
