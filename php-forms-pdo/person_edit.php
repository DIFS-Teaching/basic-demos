<?php
require "common.php";
require "services.php";
make_header('Edit Person');
?>

<h1>Edit Person</h1>

<?php
$id = $_GET['id'];
$people = new PeopleService();

if (isset($_GET['name']) && isset($_GET['surname']))
{
   $newperson = array(
        'id' => $id,
        'name' => $_GET['name'],
        'surname' => $_GET['surname']
    );

    if ($people->updatePerson($newperson))
        echo "<p>Person updated</p>";
    else
        echo "<p>Error: " . $people->getErrorMessage() . "</p>";
}

$person = $people->getPerson($id);

if ($person) {
?>

    <form action="person_edit.php" method="get">
        <input type="hidden" name="id"
            value="<?php echo $id;?>">
        <label for="name">Name</label>
        <input type="text" name="name" id="name"
            value="<?php echo $person['name']; ?>"><br>
        <label for="surname">Surname</label>
        <input type="text" name="surname" id="surname"
            value="<?php echo $person['surname']; ?>"><br>

        <input type="submit" value="Save">
    </form>

<?php
}
else
{
    echo '<p class="error">Error: no such person in the database.</p>';
}
?>

<a href="index.php">Back to the list</a>

<?php
make_footer();
?>
