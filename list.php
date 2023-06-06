<?php
include_once "conexao.php";

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

// Consulta para obter os totais de entrada e saída
$query_totais = "SELECT SUM(CASE WHEN tipo = 'entrada' THEN valor ELSE 0 END) AS total_entrada,
                SUM(CASE WHEN tipo = 'saida' THEN valor ELSE 0 END) AS total_saida
                FROM registros";
$result_totais = $conn->prepare($query_totais);
$result_totais->execute();
$row_totais = $result_totais->fetch(PDO::FETCH_ASSOC);
$totais = [
    'entrada' => $row_totais['total_entrada'],
    'saida' => $row_totais['total_saida']
];

// Consulta para obter os registros
$query_registros = "SELECT data, descricao, valor, tipo FROM registros";
$result_registros = $conn->prepare($query_registros);
$result_registros->execute();

// Montar a tabela de registros
$dados = "<table class='table table-striped'>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>";
while ($row_usuario = $result_registros->fetch(PDO::FETCH_ASSOC)) {
    extract($row_usuario);
    $cor = ($tipo == 'entrada') ? 'green' : 'red';
    $dados .= "<tr>
                    <td>$data</td>
                    <td>$descricao</td>
                    <td style='color: $cor;'>$valor</td>
                    <td>$tipo</td>
                </tr>";
}
$dados .= "</tbody>
            </table>";

// Montar o JSON com os totais para o gráfico
$dados_json = json_encode($totais);

// Saída do HTML e JSON
echo $dados;
echo "<div id='grafico-container'><canvas id='grafico'></canvas></div>";
echo "<script>var totais = $dados_json;</script>";
?>