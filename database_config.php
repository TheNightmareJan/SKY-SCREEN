<?php
$servername = 'localhost:3306';
$username = 'c3sa';
$password = 'Uw97%kiad46';
$database = 'c3sadweqesdasd-admins';

// Erstelle eine Verbindung zur Datenbank
$conn = new mysqli($servername, $username, $password, $database);

// Überprüfe die Verbindung
if ($conn->connect_error) {
    die('Verbindung zur Datenbank fehlgeschlagen: ' . $conn->connect_error);
}
?>
