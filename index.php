<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once "./api/config/database.php";
include_once "./api/models/Event.php";
include_once "./api/controllers/EventController.php";

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialize controller
$eventController = new EventController($db);

// Get the HTTP method and endpoint
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

// Route the request
switch($method) {
    case 'GET':
        if($request[0] == 'events') {
            $eventController->getEvents();
        }
        break;
    
    case 'POST':
        if($request[0] == 'events') {
            $eventController->createEvent();
        }
        break;
    
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed"));
        break;
}
?>
