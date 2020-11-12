<?php
require "services.php";

$people = new PeopleService();

//allow access from any client (public API)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: origin, x-csrftoken, content-type, accept, x-requested-with');
		
//get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$params = [];
if (isset($_SERVER['PATH_INFO'])) {
    $params = explode('/', trim($_SERVER['PATH_INFO'], '/'));
}

$id = null;
if (count($params) > 0 && strlen(trim($params[0])) > 0) {
    $id = intval($params[0]);
}

//response data
$rcode = 200;
$rdata = [];

//process the request
switch ($method) {
    case 'GET':
        if ($id === null) {
            $rdata = $people->getPeople()->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $rdata = $people->getPerson($id);
            if ($rdata === false) {
                $rdata = ['error' => 'not found'];
                $rcode = 404; //not found 
            }
        }
        break;

    case 'POST':
        $person = json_decode(file_get_contents('php://input'), true);
        $rdata = $people->addPerson($person);
        if ($rdata !== false) {
            $rcode = 201; //created
        } else {
            $rdata = ['error' => 'couldn\'t insert'];
            $rcode = 400; //bad request
        }
        break;
        
    case 'PUT':
        if ($id !== null) {
            $person = json_decode(file_get_contents('php://input'), true);
            $person['id'] = $id;
            if ($people->updatePerson($person)) {
                $rdata = ['result' => 'ok'];
            } else {
                $rdata = ['error' => 'update failed'];
                $rcode = 400; //bad request
            }
        } else {
            $rdata = ['error' => 'id not specified'];
            $rcode = 400; //bad request
        }
        break;
        
    case 'DELETE':
        if ($id !== null) {
            if ($people->deletePerson($id)) {
                $rdata = ['result' => 'ok'];
            } else {
                $rdata = ['error' => 'delete failed'];
                $rcode = 400; //bad request
            }
        } else {
            $rdata = ['error' => 'id not specified'];
            $rcode = 400; //bad request
        }
        break;
        
}

//send the JSON result
http_response_code($rcode);
header('Content-Type: application/json');
echo json_encode($rdata);
