<?php
require "common.php";
require "services.php";
make_header('List of People');
?>

<h1>List of People</h1>

<table>
<tr><th>Name</th><th>Surname</th></tr>
<?php

$serv = new PeopleService();

$rows = $serv->getPeople();

while ($row = $rows->fetch())
{
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['surname'] . "</td>";
    echo '<td class="action">';
    $id = $row['id'];
    echo "<a href=\"person_edit.php?id=$id\">edit</a> ";
    echo "<a href=\"person_delete.php?id=$id\">delete</a>";
    echo "</td>\n";
    echo "</tr>\n";
}

?>
</table>

<p><a href="person_new.php">Insert a new person</a></p>

<?php
make_footer();
?>
