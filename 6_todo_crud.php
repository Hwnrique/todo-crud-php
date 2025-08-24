<?php

    $host = "localhost";
    $usuario = "root";
    $senha = "aacce";
    $banco = "todo_list";

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if($conn->connect_error) {
        die("Falha na conexão com o banco." . $conn->connect_error);
    };


    //criacao da tarefa
    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["descricao"])) {


        $descricao = $conn->real_escape_string($_POST["descricao"]);

        $sqlInsert = "INSERT INTO tarefas (descricao) VALUES ('$descricao')";

        if($conn->query($sqlInsert) === TRUE){
            header("Location: 6_todo_crud.php");
            exit;
        }

    }

    //exclusao

    if(isset($_GET['delete'])) {
        $id = intval($_GET['delete']);

        $sqlDelete = "DELETE FROM tarefas WHERE id = $id";

        if($conn->query($sqlDelete) === TRUE){
            header("Location: 6_todo_crud.php");
            exit;
    }
}

     $tarefas = [];

    //resgate de tarefas
    $sqlSelect = "SELECT * FROM tarefas ORDER BY data_criacao DESC";
    $result = $conn->query($sqlSelect);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tarefas[] = $row;
        };
    };

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
</head>
<body>
    <form action="6_todo_crud.php" method="POST">
        <h1>Todo List</h1>
        <input type="text" placeholder="Descrição da tarefa" name="descricao" required>
        <button type="submit">Adicionar</button>
    </form>

    <h2>Suas terfas</h2>
    <?php if(!empty($tarefas)): ?>
        <ul>
            <?php foreach($tarefas as $tarefa):  ?>

                <li>
                    <?php echo $tarefa['descricao']?>
                    <a href="6_todo_crud.php?delete=<?php echo $tarefa['id'] ?>">Excluir</a>
                </li>

            <?php endforeach;?>
        </ul>
    <?php else: ?>
        <p>Não há tarefas</p>
    <?php endif;?>
</body>
</html>