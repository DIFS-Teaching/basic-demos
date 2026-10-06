<?php
require "common.php";
require "services.php";
make_header('Delete a Person');
?>

<h1>Delete a Person</h1>

<?php

$people = new PeopleService();
$id = intval($_GET['id'] ?? 0); // convert to int to avoid SQL injection, use 0 (invalid id) if not set

$person = $people->getPerson($id);
if ($person)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        check_csrf();
        if ($people->deletePerson($id))
            echo "<p>The person has been deleted.</p>";
        else
            echo "<p>Error: " . $people->getErrorMessage() . "</p>";
        ?>
        <p><a href="index.php">Back to the list</a></p>
        <?php
    }
    else
    {
        ?>
        <p>Do you really want to delete
            <strong><?php echo h($person['name'] . ' ' . $person['surname']);?></strong>?
        </p>
        <form action="person_delete.php?id=<?php echo $id?>" method="post" class="action">
            <?php csrf_field(); ?>
            <input type="submit" value="yes">
            <a href="index.php">no</a>
        </form>
        <?php
    }
}

make_footer();
?>
