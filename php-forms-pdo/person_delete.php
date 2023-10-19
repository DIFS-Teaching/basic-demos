<?php
require "common.php";
require "services.php";
make_header('Delete a Person');
?>

<h1>Delete a Person</h1>

<?php

$people = new PeopleService();
$id = $_GET['id'];

$person = $people->getPerson($id);
if ($person)
{
    if (isset($_GET['confirmed']) && $_GET['confirmed'] == 'yes')
    {
        $people->deletePerson($id);
        ?>
        <p>The person has been deleted.</p>
        <p><a href="index.php">Back to the list</a></p>
        <?php
    }
    else
    {
        ?>
        <p>Do you really want to delete
            <strong><?php echo $person['name'] . ' ' . $person['surname'];?></strong>?
        </p>
        <p class="action">
        <a href="person_delete.php?confirmed=yes&amp;id=<?php echo $id?>">yes</a>
        <a href="index.php">no</a>
        </p>
        <?php
    }
}

make_footer();
?>
