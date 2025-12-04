<?php
ini_set('display_errors',1); error_reporting(E_ALL);
$c = new PDO('sqlite:/var/www/html/cracks/database/cracks.db');
echo "OK PDO\n";
var_dump($c->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN));
