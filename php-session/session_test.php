<!DOCTYPE html>
<html>
<head>
    <title>Simple session test</title>
    <meta charset="utf-8">
</head>
<body>

<h1>Sessions</h1>

<?php

session_start();
$cnt = isset($_SESSION['cnt']) ? $_SESSION['cnt'] : 0;
echo "<p>Počet přístupů: <strong>$cnt</strong></p>";
$_SESSION['cnt'] = $cnt + 1;

?>


</body>
</html>
