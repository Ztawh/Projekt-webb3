<?php


/* Anslut till databasen */
if ($_SERVER["SERVER_NAME"] == "localhost") {
    $db = new mysqli("localhost", "root", "", "ProjectWebb3DB");
    if ($db->connect_errno > 0) {
        die('Fel vid anslutning [' . $db->connect_error . ']');
    }
} else {
    $db = new mysqli('studentmysql.miun.se', 'amhv2000', 'lösen', 'amhv2000');
    if ($db->connect_errno > 0) {
        die('Fel vid anslutning [' . $db->connect_error . ']');
    }
}

// // Skapar databas
// $sql = "CREATE DATABASE ProjectWebb3DB";
// if ($db->query($sql) === TRUE) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . $db->error;
// }


$sql = "DROP TABLE IF EXISTS Courses;
CREATE TABLE Courses(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    school VARCHAR(100),
    course_id VARCHAR(8),
    name VARCHAR(100),
    start_date VARCHAR(10),
    end_date VARCHAR(10)
);

DROP TABLE IF EXISTS Jobs;
CREATE TABLE Jobs(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    workplace VARCHAR(100),
    title VARCHAR(100),
    description VARCHAR(1000),
    start_date VARCHAR(10),
    end_date VARCHAR(10)
);

DROP TABLE IF EXISTS Websites;
CREATE TABLE Websites(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100),
    url VARCHAR(300),
    description VARCHAR(1000)
);";

// Skickar queryn till databasen
if ($db->multi_query($sql)) {
    echo "Table created successfully";
    
} else {
    echo "Error creating table: " . $db->error;
}

echo $db->error;
