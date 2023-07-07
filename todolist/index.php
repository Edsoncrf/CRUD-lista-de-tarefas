<!DOCTYPE html>
<html>
<head>
    <title>Lista de Tarefas</title>
    <style>
        
    </style>
</head>
<body>
    <h1>Lista de Tarefas</h1>
    
    <form id="create-task-form">
        <input type="text" id="titulo" placeholder="Título" required>
        <textarea id="descricao" placeholder="Descrição"></textarea>
        <button type="submit">Adicionar Tarefa</button>
    </form>
    
    <ul id="task-list">
        
    </ul>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            
            function loadTasks() {
                $.ajax({
                    url: 'app/Controllers/TaskController.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response && response.length > 0) {
                            var tasks = response;
                            var taskList = $('#task-list');
                            taskList.empty();

                            for (var i = 0; i < tasks.length; i++) {
                                (function(task) { 
                                    var listItem = $('<li>');
                                    listItem.html('<h3>' + task.titulo + '</h3><p>' + task.descricao + '</p>');
                                    
                                    var editButton = $('<button>');
                                    editButton.text('Editar');
                                    editButton.click(function() {
                                        var taskId = task.id;
                                        var editForm = $('<form>');
                                        var edittituloInput = $('<input>');
                                        edittituloInput.attr('type', 'text');
                                        edittituloInput.attr('value', task.titulo);
                                        var editdescricaoInput = $('<textarea>');
                                        editdescricaoInput.text(task.descricao);
                                        var updateButton = $('<button>');
                                        updateButton.text('Atualizar');
                                        
                                        editForm.append(edittituloInput);
                                        editForm.append(editdescricaoInput);
                                        editForm.append(updateButton);
                                        listItem.append(editForm);
                                        
                                        updateButton.click(function(e) {
                                            e.preventDefault();
                                            
                                            var updatedtitulo = edittituloInput.val();
                                            var updateddescricao = editdescricaoInput.val();
                                            
                                            $.ajax({
                                                url: 'app/Controllers/TaskController.php',
                                                type: 'POST',
                                                data: {
                                                    action: 'update',
                                                    id: taskId,
                                                    titulo: updatedtitulo,
                                                    descricao: updateddescricao
                                                },
                                                success: function(response) {
                                                    if (response.success) {
                                                        
                                                        task.titulo = updatedtitulo;
                                                        task.descricao = updateddescricao;
                                                        listItem.children('h3').text(updatedtitulo);
                                                        listItem.children('p').text(updateddescricao);
                                                        
                                                        editForm.remove();
                                                    } else {
                                                        alert(response.message);
                                                    }
                                                },
                                                error: function() {
                                                    alert('Ocorreu um erro ao atualizar a tarefa.');
                                                }
                                            });
                                        });
                                    });
                                    
                                    var deleteButton = $('<button>');
                                    deleteButton.text('Excluir');
                                    deleteButton.click(function() {
                                        var taskId = task.id;
                                        
                                        $.ajax({
                                            url: 'app/Controllers/TaskController.php',
                                            type: 'POST',
                                            data: {
                                                action: 'delete',
                                                id: taskId
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    listItem.remove();
                                                } else {
                                                    alert(response.message);
                                                }
                                            },
                                            error: function() {
                                                alert('Ocorreu um erro ao excluir a tarefa.');
                                            }
                                        });
                                    });
                                    
                                    listItem.append(editButton);
                                    listItem.append(deleteButton);
                                    taskList.append(listItem);
                                })(tasks[i]); 
                            }
                        } else {
                            alert('Nenhuma tarefa encontrada.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        console.log(status);
                        console.log(error);
                        alert('Ocorreu um erro ao carregar as tarefas.');
                    }
                });
            }
            
            // Carregar as tarefas ao carregar a página
            loadTasks();
            
            
            $('#create-task-form').submit(function(e) {
                e.preventDefault();
                
                var titulo = $('#titulo').val();
                var descricao = $('#descricao').val();
                
                $.ajax({
                    url: 'app/Controllers/TaskController.php',
                    type: 'POST',
                    data: {
                        action: 'create',
                        titulo: titulo,
                        descricao: descricao
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#titulo').val('');
                            $('#descricao').val('');
                            
                            loadTasks();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Ocorreu um erro ao criar a tarefa.');
                    }
                });
            });
        });
    </script>
</body>
</html>
