<?php
class Job
{
    private $db;

    function __construct()
    {
        // Kopplar upp till databasen
        if ($_SERVER["SERVER_NAME"] == "localhost") {
            $this->db = new mysqli("localhost", "root", "", "ProjectWebb3DB");
            if ($this->db->connect_errno > 0) {
                die('Fel vid anslutning [' . $this->db->connect_error . ']');
            }
        } else {
            $this->db = new mysqli('studentmysql.miun.se', 'amhv2000', 'lösen', 'amhv2000');
            if ($this->db->connect_errno > 0) {
                die('Fel vid anslutning [' . $this->db->connect_error . ']');
            }
        }
    }

    // Hämta alla jobb från databasen
    public function getJobs()
    {
        $sql = "SELECT * FROM Jobs ORDER BY id;";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    // Hämta ett jobb från databasen
    public function getOneJob($id)
    {
        $sql = "SELECT * FROM Jobs WHERE id=$id";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    // Lägg till ett jobb
    public function addJob($workplace, $title, $description, $start, $end)
    {


        // // Gör om eventuella ' eller " till meningslösa tecken.
        // $courseId = $this->db->real_escape_string($courseId);
        // $name = $this->db->real_escape_string($name);
        // $prog = $this->db->real_escape_string($prog);
        // $syllabus = $this->db->real_escape_string($syllabus);

        // // Gör om eventuell html-kod till tecken
        // $courseId = htmlspecialchars($courseId);
        // $name = htmlspecialchars($name);
        // $prog = htmlspecialchars($prog);
        // $syllabus = htmlspecialchars($syllabus);


        // Lägg till jobb
        $sql = "INSERT INTO Jobs (workplace, title, description, start_date, end_date) VALUES ('$workplace', '$title', '$description', '$start', '$end');";
        $result = $this->db->query($sql);


        return $result;
    }

    // Ta bort ett jobb
    public function deleteJob($id) // FORTSÄTT HÄÄÄÄÄÄÄÄRRRR
    {
        // Kollar om ett jobb med detta id finns
        $sql = "SELECT * FROM Jobs WHERE id='$id';";
        $result = $this->db->query($sql);

        // Om kursen finns, radera. Returnera false om kursen inte finns
        if (mysqli_num_rows($result)) {
            $sql = "DELETE FROM Jobs WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        } else {
            return false;
        }
    }

    // Redigera ett jobb
    public function editJob($id, $workplace, $title, $description, $start, $end)
    {
        // Kollar om en kurs med detta id finns
        $sql = "SELECT * FROM Jobs WHERE id=$id;";
        $result = $this->db->query($sql);

        // Om kursen finns, redigera. Returnera false om kursen inte finns
        if (mysqli_num_rows($result)) {
            // Gör om eventuella ' eller " till meningslösa tecken.
            // $courseId = $this->db->real_escape_string($courseId);
            // $name = $this->db->real_escape_string($name);
            // $prog = $this->db->real_escape_string($prog);
            // $syllabus = $this->db->real_escape_string($syllabus);

            // // Gör om eventuell html-kod till tecken
            // $courseId = htmlspecialchars($courseId);
            // $name = htmlspecialchars($name);
            // $prog = htmlspecialchars($prog);
            // $syllabus = htmlspecialchars($syllabus);

            // Uppdatera kurs
            $sql = "UPDATE Jobs SET workplace='$workplace', title='$title', description='$description', start_date='$start', end_date='$end' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        } else {
            return false;
        }
    }
}
