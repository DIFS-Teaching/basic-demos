<?php
require "common.php";
require "services.php";
make_header('New Person');
?>

<h1>New Person</h1>

<?php
$serv = new PeopleService();

$newperson = array(
    'name' => $_GET['name'],
    'surname' => $_GET['surname']
);

$serv->addPerson($newperson);

?>
<p>The new person has been inserted.</p>
<p><a href="index.php">Back to the list</a></p>
<?php
make_footer();
?>
