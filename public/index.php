<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

define("__ROOT__", __DIR__ . "/../");
include "../assets/functions.php";
include "../assets/Autoload.php";

try {
    $autoload = new Autoload([
        ".",
        "core",
        "controller",
        "model",
        "view",
    ]);
    $autoload->registrar();
    
    FrontController::procesarSolicitud();
} catch (Exception $e) {
//     ErrorView::show($e);
    echo "Error: " . $e->getMessage();
   
}
