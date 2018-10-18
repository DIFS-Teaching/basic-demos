<?php
require "common.php";
make_header('New Person');
?>

<h1>New Person</h1>

<form action="person_insert.php" method="get">
    <label for="name">Name</label>
    <input type="text" name="name" id="name"><br>
    
    <label for="surname">Surname</label>
    <input type="text" name="surname" id="surname"><br>
    
    <input type="submit" value="Save">
</form>

<?php
make_footer();
?>
