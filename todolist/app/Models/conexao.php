<?php
function getConnection() {
    
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'todolist';

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erro de conexão com o banco de dados: " . $conn->connect_error);
    }

    return $conn;
}

?>
