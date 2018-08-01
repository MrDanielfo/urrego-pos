<?php



// Modelos
require_once 'models/CategoriesModel.php';
require_once 'models/ClientsModel.php';
require_once 'models/ProductsModel.php';
require_once 'models/SellsModel.php';
require_once 'models/UsersModel.php';

// Controladores 
require_once 'controllers/TemplateController.php';
require_once 'controllers/CategoriesController.php';
require_once 'controllers/ClientsController.php';
require_once 'controllers/ProductsController.php';
require_once 'controllers/SellsController.php';
require_once 'controllers/UsersController.php';

$template = new TemplateController();
$template->template();