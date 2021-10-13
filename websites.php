
<?php
//{"title": "Webbplatsis", "url": "en url till", "description": "Massor med text", "thumbnail": "bild"}
// Inkluderar klass
require "config/Website.php";

/*Headers med inställningar för din REST webbtjänst*/

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av id finns i urlen lagras det i en variabel
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Skapa instans av Website-klassen
$webObj = new Website();


switch ($method) {
    case 'GET':
        //Lagra ett meddelande som sedan skickas tillbaka till anroparen

        if (isset($_GET['id'])) { // Om id medskickat, hämta en webbsida
            if ($webObj->getOneWebsite($_GET['id'])) {
                //Skickar en "HTTP response status code"
                http_response_code(200); //Ok - The request has succeeded
                $response = $webObj->getOneWebsite($_GET['id']);
            } else { // Om webbsidan med det id inte hittas
                $response = array("message" => "Couldn't find website");
            }
        } else { // Om id inte medskickat, hämta alla
            if ($webObj->getWebsites()) {
                http_response_code(200); // Ok
                $response = $webObj->getWebsites();
            } else { // Om databasen är tom
                $response = array("message" => "There is nothing to get yet");
            }
        }

        break;
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));

        // Om webbsidan kunde läggas till, true. 
        if ($webObj->addWebsite($data->title, $data->url, $data->description, $data->thumbnail)) {
            http_response_code(201); //Created
            $response = array("message" => "Created");
        } else { // Om webbsidan redan finns
            http_response_code(503); //Server error
            $response = array("message" => "Website already exists");
        }

        break;
    case 'PUT':
        //Om inget id är medskickat, skicka felmeddelande
        if (!isset($id)) {
            http_response_code(400); //Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "No id is sent");
        } else { //Om id är skickat
            $data = json_decode(file_get_contents("php://input"));

            // Om jobbet kunde redigeras
            if ($webObj->editWebsite($id, $data->title, $data->url, $data->description, $data->thumbnail)) {
                http_response_code(200);
                $response = array("message" => "Website with id=$id is updated");
            } else {
                http_response_code(503); //Server error
                $response = array("message" => "Website didn't update");
            }
        }
        break;
    case 'DELETE':
        // Kollar om id finns.
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");
        } elseif ($webObj->deleteWebsite($id)) { // Om webbsidan kunde raderas
            http_response_code(200);
            $response = array("message" => "Website with id=$id is deleted");
        } else { // Om webbsidan inte kunde raderas
            $response = array("message" => "Website with id=$id doesn't exist");
        }
        break;
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);
