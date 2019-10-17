<?php
require "common.php";
require "services.php";
make_header('Home Page');
?>

<h1>Home Page</h1>

<?php
if (isset($_SESSION['user']))
{
    echo "Current user: <strong>" . $_SESSION['user'] . '</strong>';
    echo '<p><a href="admin.php">Go to admin page</a>';
    echo '<p><a href="logout.php">Logout</a>';
}
else
{
?>
    <div>
        <form action="login.php" method="post">
            <label for="login">Login</label>
            <input type="text" name="login" id="login"><br>
            
            <label for="password">Password</label>
            <input type="password" name="password" id="password"><br>
            
            <input type="submit" value="Log in">
        </form>
    </div>
    <p><a href="register.php">Register</a></p>
<?php
}

make_footer();
?>
