<?php
require "services.php";

$people = new PeopleService();

//allow access from any client (public API)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: origin, x-csrftoken, content-type, accept, x-requested-with');
		
//reads the person data from the JSON request body; only the expected fields are used
//(the data is validated by the business layer)
function read_person()
{
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data))
        return null;
    return ['name' => (string) ($data['name'] ?? ''), 'surname' => (string) ($data['surname'] ?? '')];
}

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
            $rdata = $people->getPeople();
        } else {
            $rdata = $people->getPerson($id);
            if ($rdata === false) {
                $rdata = ['error' => 'not found'];
                $rcode = 404; //not found 
            }
        }
        break;

    case 'POST':
        $person = read_person();
        if ($person === null) {
            $rdata = ['error' => 'invalid JSON data'];
            $rcode = 400; //bad request
            break;
        }
        $rdata = $people->addPerson($person);
        if ($rdata !== false) {
            $rcode = 201; //created
        } else {
            $rdata = ['error' => $people->getErrorMessage()];
            $rcode = 400; //bad request
        }
        break;
        
    case 'PUT':
        if ($id !== null) {
            $person = read_person();
            if ($person === null) {
                $rdata = ['error' => 'invalid JSON data'];
                $rcode = 400; //bad request
                break;
            }
            $person['id'] = $id;
            if ($people->updatePerson($person)) {
                $rdata = ['result' => 'ok'];
            } else {
                $rdata = ['error' => $people->getErrorMessage()];
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
                $rdata = ['error' => $people->getErrorMessage()];
                $rcode = 400; //bad request
            }
        } else {
            $rdata = ['error' => 'id not specified'];
            $rcode = 400; //bad request
        }
        break;

    case 'OPTIONS': //CORS preflight request, the headers above are sufficient
        break;

    default:
        $rdata = ['error' => 'method not allowed'];
        $rcode = 405; //method not allowed
}

//send the JSON result
http_response_code($rcode);
header('Content-Type: application/json');
echo json_encode($rdata);
