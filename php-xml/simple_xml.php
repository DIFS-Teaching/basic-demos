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

<pre>
<?php
$xml = simplexml_load_file('data.xml');
print_r($xml);
?>
</pre>

<table>
<tr><th>Name</th><th>Surname</th><th>Address</th></th>
<?php

$xml = simplexml_load_file('data.xml');

foreach ($xml->children() as $person)
{
    $fname = $person->firstName;
    $lname = $person->lastName;
    $addr = '';
    foreach ($person->address->children() as $field)
    {
        $addr .= $field . ' ';
    }
    
    echo "<tr><td>$fname</td><td>$lname</td><td>$addr</td></tr>";
}

?>

</table>

</body>
</html>
