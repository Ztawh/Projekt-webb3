<?php
class Course
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

    // Hämta alla kurser från databasen
    public function getCourses()
    {
        $sql = "SELECT * FROM Courses ORDER BY id;";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    // Hämta en kurs från databasen
    public function getOneCourse($id)
    {
        $sql = "SELECT * FROM Courses WHERE id=$id";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    // Lägg till en kurs
    public function addCourse($school, $courseId, $name, $start, $end)
    {
        // Kollar om kursen redan finns
        $sql = "SELECT * FROM Courses WHERE course_id='$courseId';";
        $result = $this->db->query($sql);

        // Om kursen redan finns, returnera false. Annars lägg till kurs.
        if (mysqli_num_rows($result)) {
            return false;
        } else {

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

            // Lägg till kurs
            $sql = "INSERT INTO Courses (school, course_id, name, start_date, end_date) VALUES ('$school', '$courseId', '$name', '$start', '$end');";
            $result = $this->db->query($sql);
        }

        return $result;
    }

    // Ta bort en kurs
    public function deleteCourse($id)
    {
        // Kollar om en kurs med detta id finns
        $sql = "SELECT * FROM Courses WHERE id='$id';";
        $result = $this->db->query($sql);

        // Om kursen finns, radera. Returnera false om kursen inte finns
        if (mysqli_num_rows($result)) {
            $sql = "DELETE FROM Courses WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        } else {
            return false;
        }
    }

    // Redigera en kurs
    public function editCourse($id, $school, $courseId, $name, $start, $end)
    {
        // Kollar om en kurs med detta id finns
        $sql = "SELECT * FROM Courses WHERE id=$id;";
        $result = $this->db->query($sql);

        // Om kursen finns, redigera. Returnera false om kursen inte finns
        if (mysqli_num_rows($result)) {
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

            // Uppdatera kurs
            $sql = "UPDATE Courses SET school='$school', course_id='$courseId', name='$name', start_date='$start', end_date='$end' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        } else {
            return false;
        }
    }
}
