<?php
session_start();
require 'functions.php';
require 'crudClass.php';
require 'eventsClass.php';
require 'membersClass.php';
require 'userToolsClass.php';
require 'newsClass.php';
require 'photoClass.php';
require 'galleryClass.php';

$db = new db();
$db->connect();



?>
