<?php

include_once "conexao.php";

$totais = [];
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['descricao'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>"];
} elseif (empty($dados['valor'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>"];
} elseif (empty($dados['tipo'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>"];
} else {
    $query_usuario = "INSERT INTO registros (data, descricao, valor, tipo) VALUES (:data, :descricao, :valor, :tipo)";
    $cad_usuario = $conn->prepare($query_usuario);
    $cad_usuario->bindValue(':data', date("Y-m-d"));
    $cad_usuario->bindParam(':descricao', $dados['descricao']);
    $cad_usuario->bindParam(':valor', $dados['valor']);
    $cad_usuario->bindParam(':tipo', $dados['tipo']);

    $cad_usuario->execute();

    if ($cad_usuario->rowCount()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso!</div>"];
    }
}

echo json_encode($retorna);
