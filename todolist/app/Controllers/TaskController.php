<?php
require_once('../Models/conexao.php');
require_once('../Models/TaskModel.php');

header('Content-Type: application/json');

class TaskController {
    private $model;
    
    public function __construct() {
        $conn = getConnection();
        $this->model = new TaskModel($conn);
    }
    
    public function index() {
        $tasks = $this->model->getAllTasks();
        return $tasks;
    }   
    
    public function create($titulo, $descricao) {
        $result = $this->model->createTask($titulo, $descricao);
        
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Tarefa criada com sucesso.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Ocorreu um erro ao criar a tarefa.'
            ];
        }
        
        echo json_encode($response);
    }
    
    public function update($id, $titulo, $descricao) {
        $result = $this->model->updateTask($id, $titulo, $descricao);
        
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Tarefa atualizada com sucesso.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Ocorreu um erro ao atualizar a tarefa.'
            ];
        }
        
        echo json_encode($response);
    }
    
    public function delete($id) {
        $result = $this->model->deleteTask($id);
        
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Tarefa excluída com sucesso.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Ocorreu um erro ao excluir a tarefa.'
            ];
        }
        
        echo json_encode($response);
    }
}

$controller = new TaskController();

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['titulo']) && isset($_POST['descricao'])) {
                    $titulo = $_POST['titulo'];
                    $descricao = $_POST['descricao'];
                    $controller->create($titulo, $descricao);
                }
            }
            break;
        
        case 'update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['id']) && isset($_POST['titulo']) && isset($_POST['descricao'])) {
                    $id = $_POST['id'];
                    $titulo = $_POST['titulo'];
                    $descricao = $_POST['descricao'];
                    $controller->update($id, $titulo, $descricao);
                }
            }
            break;
        
        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $controller->delete($id);
                }
            }
            break;
        
        default:
            $tasks = $controller->index();
            echo json_encode($tasks);
            break;
    }
} else {
    $tasks = $controller->index();
    echo json_encode($tasks);
}
?>
