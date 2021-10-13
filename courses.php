
<?php
//{"course_id": "DT152G", "name": "Webbdesign för CMS", "progression": "B", "course_syllabus": "länk"}
// Inkluderar klass
require "config/Course.php";

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

// Skapa instans av Course-klassen
$courseObj = new Course();


switch ($method) {
    case 'GET':
        //Lagra ett meddelande som sedan skickas tillbaka till anroparen

        if (isset($_GET['id'])) { // Om id medskickat, hämta en kurs
            if ($courseObj->getOneCourse($_GET['id'])) {
                //Skickar en "HTTP response status code"
                http_response_code(200); //Ok - The request has succeeded
                $response = $courseObj->getOneCourse($_GET['id']);
            } else { // Om kursen med det id inte hittas
                $response = array("message" => "Couldn't find course");
            }
        } else { // Om id inte medskickat, hämta alla
            if ($courseObj->getCourses()) {
                http_response_code(200); // Ok
                $response = $courseObj->getCourses();
            } else { // Om databasen är tom
                $response = array("message" => "There is nothing to get yet");
            }
        }

        break;
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));

        // Om kursen kunde läggas till, true. 
        if ($courseObj->addCourse($data->school, $data->course_id, $data->name, $data->start_date, $data->end_date)) {
            http_response_code(201); //Created
            $response = array("message" => "Created");
        } else { // Om kursen redan finns
            http_response_code(503); //Server error
            $response = array("message" => "Course already exists");
        }

        break;
    case 'PUT':
        //Om inget id är medskickat, skicka felmeddelande
        if (!isset($id)) {
            http_response_code(400); //Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "No id is sent");
        } else { //Om id är skickat
            $data = json_decode(file_get_contents("php://input"));

            // Om kursen kunde redigeras
            if ($courseObj->editCourse($id, $data->school, $data->course_id, $data->name, $data->start_date, $data->end_date)) {
                http_response_code(200);
                $response = array("message" => "Post with id=$id is updated");
            } else {
                http_response_code(503); //Server error
                $response = array("message" => "Course didn't update");
            }
        }
        break;
    case 'DELETE':
        // Kollar om id finns.
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");
        } elseif ($courseObj->deleteCourse($id)) { // Om kursen kunde raderas
            http_response_code(200);
            $response = array("message" => "Course with id=$id is deleted");
        } else { // Om kursen inte kunde raderas
            $response = array("message" => "Course with id=$id doesn't exist");
        }
        break;
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);
