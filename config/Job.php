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
        // Gör om eventuella ' eller " till meningslösa tecken.
        $workplace = $this->db->real_escape_string($workplace);
        $title = $this->db->real_escape_string($title);
        $description = $this->db->real_escape_string($description);
        $start = $this->db->real_escape_string($start);
        $end = $this->db->real_escape_string($end);

        // Gör om eventuell html-kod till tecken
        $workplace = htmlspecialchars($workplace);
        $title = htmlspecialchars($title);
        $description = htmlspecialchars($description);
        $start = htmlspecialchars($start);
        $end = htmlspecialchars($end);

        // Lägg till jobb
        $sql = "INSERT INTO Jobs (workplace, title, description, start_date, end_date) VALUES ('$workplace', '$title', '$description', '$start', '$end');";
        $result = $this->db->query($sql);

        return $result;
    }

    // Ta bort ett jobb
    public function deleteJob($id)
    {
        // Kollar om ett jobb med detta id finns
        $sql = "SELECT * FROM Jobs WHERE id='$id';";
        $result = $this->db->query($sql);

        // Om jobb finns, radera. Returnera false om jobbet inte finns
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
        // Kollar om ett jobb med detta id finns
        $sql = "SELECT * FROM Jobs WHERE id=$id;";
        $result = $this->db->query($sql);

        // Om jobbet finns, redigera. Returnera false om jobbet inte finns
        if (mysqli_num_rows($result)) {
            // Gör om eventuella ' eller " till meningslösa tecken.
            $workplace = $this->db->real_escape_string($workplace);
            $title = $this->db->real_escape_string($title);
            $description = $this->db->real_escape_string($description);
            $start = $this->db->real_escape_string($start);
            $end = $this->db->real_escape_string($end);

            // Gör om eventuell html-kod till tecken
            $workplace = htmlspecialchars($workplace);
            $title = htmlspecialchars($title);
            $description = htmlspecialchars($description);
            $start = htmlspecialchars($start);
            $end = htmlspecialchars($end);

            // Uppdatera jobb
            $sql = "UPDATE Jobs SET workplace='$workplace', title='$title', description='$description', start_date='$start', end_date='$end' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        } else {
            return false;
        }
    }
}
