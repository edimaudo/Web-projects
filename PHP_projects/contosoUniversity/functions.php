<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'root';
    $DATABASE_NAME = 'contosoUDB';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}

function getDepartmentName($pdo, $departmentId) {
    $sql = "SELECT Name FROM Department WHERE DepartmentID = :departmentId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
    $stmt->execute();
    
    $department = $stmt->fetch(PDO::FETCH_ASSOC);
    return $department ? $department['Name'] : null;
}

function getInstructorName($pdo, $instructorId) {
    $sql = "SELECT CONCAT(LastName,', ',FirstMidName) as Name  FROM Instructor WHERE ID = :instructorId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':instructorId', $instructorId, PDO::PARAM_INT);
    $stmt->execute();
    
    $instructor = $stmt->fetch(PDO::FETCH_ASSOC);
    return $instructor ? $instructor['Name'] : null;
}

?>


