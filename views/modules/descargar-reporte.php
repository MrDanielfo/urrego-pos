<?php

// Modelos
require_once '../../models/ClientsModel.php';
require_once '../../models/ProductsModel.php';
require_once '../../models/SellsModel.php';

// Controladores 

require_once '../../controllers/ClientsController.php';
require_once '../../controllers/ProductsController.php';
require_once '../../controllers/SellsController.php';


$descargarReporte = new SellsController();
$descargarReporte->descargarReporte();