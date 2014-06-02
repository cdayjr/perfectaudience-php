<?php
require_once('SplClassLoader.php');

// Load the Prad namespace
$loader = new \Prad\SplClassLoader('Prad', dirname(__DIR__));
$loader->register();
