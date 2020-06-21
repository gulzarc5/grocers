<?php


require('barcode.php');

$barcode = new Barcode($_GET['text'], 2);
$barcode->display();

?>