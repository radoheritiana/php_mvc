<?php


// On définit le dossier racine

define("ROOT", dirname(__DIR__));
require_once ROOT."\\vendor\\autoload.php";

use App\Core\Main;

$app = new Main();

$app->start();

?>