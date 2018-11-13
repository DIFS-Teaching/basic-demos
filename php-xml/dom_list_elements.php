<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>DOM elements</title>
</head>
<body>

<?php

function print_node_info($node)
{
    if ($node->nodeType == XML_ELEMENT_NODE)
    {
        echo "Element: &lt;{$node->tagName}&gt;";
    }
    elseif ($node->nodeType == XML_TEXT_NODE)
    {
        echo "Text: '{$node->nodeValue}'";
    }
    else
    {
        echo "(other node)";
    }
}

function recursive_print_nodes($root)
{
    echo '<li>';
    print_node_info($root);
    echo '<ul>';
    if (isset($root->childNodes))
    {
        foreach ($root->childNodes as $child) {
            recursive_print_nodes($child);
        }
    }
    echo '</ul>';
    echo '</li>';
}


$xmlDoc = new DOMDocument();
$xmlDoc->preserveWhiteSpace = false;
$xmlDoc->load("data.xml");

echo '<ul>';
recursive_print_nodes($xmlDoc->documentElement);
echo '</ul>';

?>

</body>
</html>
