<?php
require "common.php";
make_header('New Account');
?>

<h1>Create a new account</h1>

<form action="account_insert.php" method="post">
    <label for="name">Real name</label>
    <input type="text" name="name" id="name"><br>

    <label for="login">Login</label>
    <input type="text" name="login" id="login"><br>
    
    <label for="password">Password</label>
    <input type="password" name="password" id="password"><br>
    
    <input type="submit" value="Register">
</form>

<?php
make_footer();
?>
