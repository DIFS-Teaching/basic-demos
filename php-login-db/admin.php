<?php
require "common.php";
require "services.php";

make_header('Admin page');
$accounts = new AccountService();

$login = require_user();
$user = $accounts->getAccount($login);
?>

<h1>Admin page</h1>

<p>Welcome, <b>{$user->name}</b> ($user->login)!</p>
<p>You are now authorized to access this section.</p>

<p><a href="index.php">Back to home page</a></p>
<p><a href="logout.php">Logout</a></p>

<?php
make_footer();
?>
