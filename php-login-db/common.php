<?php

session_start();

function make_header($title)
{
?>
<!DOCTYPE html> 
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title><?php echo h($title);?></title>
</head>
<body>
<?php
}

function make_footer()
{
?>
<footer>&copy; FIT 2026</footer>
</body>
</html>
<?php
}

function redirect($dest)
{
    $script = $_SERVER["PHP_SELF"];
    if (strpos($dest,'/') === 0) {
        $path = $dest;
    } else {
        $path = substr($script, 0, strrpos($script, '/')) . "/$dest";
    }
    header("Location: $path", true, 303); // 303 See Other
    exit();
}

function require_user()
{
    if (!isset($_SESSION['user']))
    {
        echo "<h1>Access forbidden</h1>";
        make_footer();
        exit();
    }
    else
    {
        return $_SESSION['user'];
    }
}

/**
 * Escapes a string for safe use in HTML output (prevents XSS).
 */
function h($s)
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

/**
 * Returns the CSRF token of the current session (generates a new one when necessary).
 */
function csrf_token()
{
    if (!isset($_SESSION['csrf_token']))
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

/**
 * Prints a hidden form field containing the CSRF token.
 */
function csrf_field()
{
    echo '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

/**
 * Checks that the request is a POST request with a valid CSRF token.
 * Stops the script otherwise.
 */
function check_csrf()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST'
        || !isset($_POST['csrf_token'])
        || !hash_equals(csrf_token(), $_POST['csrf_token']))
    {
        http_response_code(403);
        echo "<h1>Invalid request</h1>";
        make_footer();
        exit();
    }
}
