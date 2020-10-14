<?php
require "common.php";
require "services.php";
make_header('New Account');
?>

<h1>Create New Account</h1>

<?php
$serv = new AccountService();

$newperson = array(
    'login' => $_POST['login'],
    'password' => $_POST['password']
);

$serv->addAccount($newperson);

?>
<p>The new account has been created.</p>
<p><a href="index.php">Back</a></p>
<?php
make_footer();
?>
