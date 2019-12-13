<?php

require_once("config.php");

$root = new Usuario();

$root->loadByid(5);

echo $root;

?>