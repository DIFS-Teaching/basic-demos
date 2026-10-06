<?php
require "common.php";
require "services.php";
make_header('New Account');
?>

<h1>Create New Account</h1>

<?php
check_csrf();
$accounts = new AccountService();

$newperson = array(
    'login' => $_POST['login'] ?? '',
    'password' => $_POST['password'] ?? '',
    'name' => $_POST['name'] ?? ''
);

if ($accounts->addAccount($newperson))
    echo "<p>The new account has been created.</p>";
else
    echo "<p>Error: " . $accounts->getErrorMessage() . "</p>";

?>
<p><a href="index.php">Back</a></p>
<?php
make_footer();
?>
