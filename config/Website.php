<?php
class Website
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

    // Hämta alla webbsidor från databasen
    public function getWebsites()
    {
        $sql = "SELECT * FROM Websites ORDER BY id;";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    // Hämta en webbsida från databasen
    public function getOneWebsite($id)
    {
        $sql = "SELECT * FROM Websites WHERE id=$id";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    // Lägg till en webbsida
    public function addWebsite($title, $url, $description)
    {
        // Kollar om webbsidan redan finns
        $sql = "SELECT * FROM Websites WHERE url='$url';";
        $result = $this->db->query($sql);

        // Om webbsidan redan finns, returnera false. Annars lägg till webbsida.
        if (mysqli_num_rows($result)) {
            return false;
        } else {

            // Gör om eventuella ' eller " till meningslösa tecken.
            $title = $this->db->real_escape_string($title);
            $url = $this->db->real_escape_string($url);
            $description = $this->db->real_escape_string($description);

            // Gör om eventuell html-kod till tecken
            $title = htmlspecialchars($title);
            $url = htmlspecialchars($url);
            $description = htmlspecialchars($description);

            // Lägg till webbsida
            $sql = "INSERT INTO Websites (title, url, description) VALUES ('$title', '$url', '$description');";
            $result = $this->db->query($sql);
        }
        return $result;
    }

    // Ta bort en webbsida
    public function deleteWebsite($id)
    {
        // Kollar om en webbsida med detta id finns
        $sql = "SELECT * FROM Websites WHERE id='$id';";
        $result = $this->db->query($sql);

        // Om webbsidan finns, radera. Returnera false om webbsidan inte finns
        if (mysqli_num_rows($result)) {
            $sql = "DELETE FROM Websites WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        } else {
            return false;
        }
    }

    // Redigera en webbsida
    public function editWebsite($id, $title, $url, $description)
    {
        // Kollar om en webbsida med detta id finns
        $sql = "SELECT * FROM Websites WHERE id=$id;";
        $result = $this->db->query($sql);

        // Om webbsida finns, redigera. Returnera false om webbsidan inte finns
        if (mysqli_num_rows($result)) {
            // Gör om eventuella ' eller " till meningslösa tecken.
            $title = $this->db->real_escape_string($title);
            $url = $this->db->real_escape_string($url);
            $description = $this->db->real_escape_string($description);

            // Gör om eventuell html-kod till tecken
            $title = htmlspecialchars($title);
            $url = htmlspecialchars($url);
            $description = htmlspecialchars($description);

            // Uppdatera webbsida
            $sql = "UPDATE Websites SET title='$title', url='$url', description='$description' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        } else {
            return false;
        }
    }
}
