
<?php
//{"workplace": "Kappahl", "title": "nu redigerar", "description": "Jobbat på Kappahl Norrtälje City i en miljon år", "start_date": "2012-11-00", "end_date": "2222-12-22"}
// Inkluderar klass
require "config/Job.php";

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

// Skapa instans av Job-klassen
$jobObj = new Job();


switch ($method) {
    case 'GET':
        //Lagra ett meddelande som sedan skickas tillbaka till anroparen

        if (isset($_GET['id'])) { // Om id medskickat, hämta ett jobb
            if ($jobObj->getOneJob($_GET['id'])) {
                //Skickar en "HTTP response status code"
                http_response_code(200); //Ok - The request has succeeded
                $response = $jobObj->getOneJob($_GET['id']);
            } else { // Om jobbet med det id inte hittas
                $response = array("message" => "Couldn't find job");
            }
        } else { // Om id inte medskickat, hämta alla
            if ($jobObj->getJobs()) {
                http_response_code(200); // Ok
                $response = $jobObj->getJobs();
            } else { // Om databasen är tom
                $response = array("message" => "There is nothing to get yet");
            }
        }

        break;
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));

        // Om jobbet kunde läggas till, true. 
        if ($jobObj->addJob($data->workplace, $data->title, $data->description, $data->start_date, $data->end_date)) {
            http_response_code(201); //Created
            $response = array("message" => "Created");
        } else { // Om jobbet redan finns
            http_response_code(503); //Server error
            $response = array("message" => "No job added");
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
            if ($jobObj->editJob($id, $data->workplace, $data->title, $data->description, $data->start_date, $data->end_date)) {
                http_response_code(200);
                $response = array("message" => "Job with id=$id is updated");
            } else {
                http_response_code(503); //Server error
                $response = array("message" => "Job didn't update");
            }
        }
        break;
    case 'DELETE':
        // Kollar om id finns.
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");
        } elseif ($jobObj->deleteJob($id)) { // Om jobbet kunde raderas
            http_response_code(200);
            $response = array("message" => "Job with id=$id is deleted");
        } else { // Om jobbet inte kunde raderas
            $response = array("message" => "Job with id=$id doesn't exist");
        }
        break;
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);
