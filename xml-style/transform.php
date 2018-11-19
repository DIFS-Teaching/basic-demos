<?php
$cwd = dirname(__FILE__);

$xmldoc = new DOMDocument();
$xsldoc = new DOMDocument();
$xsl = new XSLTProcessor();

$xmldoc->load($cwd . '/data.xml');
$xsldoc->load($cwd . '/style.xsl');

$result = $xsl->importStyleSheet($xsldoc);
$outdoc = $xsl->transformToDoc($xmldoc);

echo $outdoc->saveHTML();
