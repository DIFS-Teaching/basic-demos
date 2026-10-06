<?php
require "common.php";
require "services.php";
make_header('Edit Person');
?>

<h1>Edit Person</h1>

<?php
$id = intval($_GET['id'] ?? 0);
$people = new PeopleService();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    check_csrf();
    $newperson = array(
        'id' => $id,
        'name' => $_POST['name'] ?? '',
        'surname' => $_POST['surname'] ?? ''
    );

    if ($people->updatePerson($newperson))
        echo "<p>Person updated</p>";
    else
        echo "<p>Error: " . $people->getErrorMessage() . "</p>";
}

$person = $people->getPerson($id);

if ($person) {
?>

    <form action="person_edit.php?id=<?php echo $id;?>" method="post">
        <?php csrf_field(); ?>
        <label for="name">Name</label>
        <input type="text" name="name" id="name"
            value="<?php echo h($person['name']); ?>"><br>
        <label for="surname">Surname</label>
        <input type="text" name="surname" id="surname"
            value="<?php echo h($person['surname']); ?>"><br>

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
