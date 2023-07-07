<?php
// Classe do modelo (TaskModel)
class TaskModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getAllTasks() {
        $query = "SELECT * FROM tasks";
        $result = $this->conn->query($query);
        
        $tasks = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
        }
        return $tasks;
    }
    
    public function createTask($titulo, $descricao) {
        $titulo = $this->conn->real_escape_string($titulo);
        $descricao = $this->conn->real_escape_string($descricao);
        
        $query = "INSERT INTO tasks (titulo, descricao) VALUES ('$titulo', '$descricao')";
        $result = $this->conn->query($query);
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function updateTask($id, $titulo, $descricao) {
        $titulo = $this->conn->real_escape_string($titulo);
        $descricao = $this->conn->real_escape_string($descricao);
        
        $query = "UPDATE tasks SET titulo='$titulo', descricao='$descricao' WHERE id=$id";
        $result = $this->conn->query($query);
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function deleteTask($id) {
        $query = "DELETE FROM tasks WHERE id=$id";
        $result = $this->conn->query($query);
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>
