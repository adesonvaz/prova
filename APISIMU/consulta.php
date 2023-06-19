<?php
header('Access-Control-Allow-Origin: *'); //Permite acesso de todas as origens
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//Permite acesso dos métodos GET, POST, PUT, DELETE
//PUT é utilizado para fazer um UPDATE no banco
//DELETE é utilizado para deletar algo do banco
header('Access-Control-Allow-Headers: Content-Type'); //Permite com que qualquer header consiga acessar o sistema
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit;
}
include 'conexao.php';
//inclui os dados de conexão com o bd no sistema abaixo

//Rota para obter todos os livros
//Utilizando o GET
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $stmt = $conn->prepare("SELECT * FROM carros");
    $stmt -> execute();
    $carros = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($carros);
    //converter dados em json
}
//-------------------------------------------------
//Rota para inserir livros
//Utilizando o POST
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anofabricacao = $_POST['anofabricacao'];
    $preco = $_POST['preco'];
    //inserir outros campos caso necessario ....

    $stmt = $conn->prepare("INSERT INTO carros ( idcarro, marca, modelo, anofabricacao, preco) VALUES (:idcarro, :marca, :modelo, :anofabricacao, :preco)");
    $stmt -> bindParam(':marca', $marca);
    $stmt -> bindParam(':modelo', $modelo);
    $stmt -> bindParam(':anofabricacao', $anofabricacao);
    $stmt -> bindParam(':preco', $preco);
    $stmt -> bindParam(':idcarro', $idcarro);
    //Outros bindParams ....

    if($stmt->execute()){
        echo "carros agendada com sucesso!!";
    }else{
        echo "Erro ao agendadar carros";
    }
}

//Rota para atualizar uma rota existente
if($_SERVER['REQUEST_METHOD']==='PUT' && isset($_GET['id'])){
    //convertendo dados recebidos em string
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_GET['id'];
    $novo_marca = $_PUT['marca'];
    $novo_modelo = $_PUT['modelo'];
    $novo_anofabricacao = $_PUT['anofabricacao'];
    $novo_preco = $_PUT['preco'];

    $stmt = $conn->prepare("UPDATE carros SET marca = :marca, modelo = :modelo, anofabricacao, = :anofabricacao, preco = :preco WHERE id = :id");
    $stmt->bindParam(':marca', $novo_marca);
    $stmt->bindParam(':modelo', $novo_modelo);
    $stmt->bindParam(':anofabricacao', $novo_anofabricacao);
    $stmt->bindParam(':preco', $novo_preco);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "carros atualizada com sucesso!!";
    } else {
        echo "Erro ao atualizar a carros :( ";
    }
}

//rota para deletar uma carros exister
if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM carros WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "carros excluida com sucesso!!";
    } else {
        echo "erro ao excluir carros";
    }
}