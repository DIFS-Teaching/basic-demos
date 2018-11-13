<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>DOM elements</title>
  <style>
    td {
        border: 1px solid black; 
        padding: 0.3em 0.5em;
    }
  </style>
</head>
<body>

<table>
<tr><th>Name</th><th>Surname</th><th>Address</th></th>
<?php

$xmlDoc = new DOMDocument();
$xmlDoc->preserveWhiteSpace = false;
$xmlDoc->load("data.xml");

$people = $xmlDoc->getElementsByTagName('person');

foreach ($people as $person)
{
    $fname = $person->getElementsByTagName('firstName')->item(0)->textContent;
    $lname = $person->getElementsByTagName('lastName')->item(0)->textContent;
    $addr = '';
    foreach ($person->getElementsByTagName('address')->item(0)->childNodes as $field)
    {
        $addr .= $field->textContent . ' ';
    }
    
    echo "<tr><td>$fname</td><td>$lname</td><td>$addr</td></tr>";
}

?>
</table>

</body>
</html>
