<?php
require "common.php";
require "services.php";
make_header('Login');
?>

<h1>Login</h1>

<?php
check_csrf();
$accounts = new AccountService();

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

if ($accounts->isValidAccount($login, $password))
{
    echo "<p>Login successful</p>";
    session_regenerate_id(true); // new session ID after login (prevents session fixation)
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
