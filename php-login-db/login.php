<?php
require "common.php";
require "services.php";
make_header('Login');
?>

<h1>Login</h1>

<?php
$serv = new AccountService();

$login = $_POST['login'];
$password = $_POST['password'];

if ($serv->isValidAccount($login, $password))
{
    echo "<p>Login successful</p>";
    $_SESSION['user'] = $login;
}
else
{
    echo "<p>Incorrect login</p>";
}

?>

<a href="admin.php">Go to admin page</a>
<br><a href="index.php">Back to home page</a>

<?php
make_footer();
?>
