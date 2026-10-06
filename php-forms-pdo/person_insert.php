<?php
require "common.php";
require "services.php";
make_header('New Person');
?>

<h1>New Person</h1>

<?php
check_csrf();
$people = new PeopleService();

$newperson = array(
    'name' => $_POST['name'] ?? '',
    'surname' => $_POST['surname'] ?? ''
);

if ($people->addPerson($newperson))
    echo "<p>The new person has been inserted.</p>";
else
    echo "<p>Error: " . $people->getErrorMessage() . "</p>";

?>
<p><a href="index.php">Back to the list</a></p>
<?php
make_footer();
?>
