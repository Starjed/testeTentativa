<?php
include_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>CRUD - PHP FETCH</title>
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4>Listar Usuários</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="openCadastroForm()">Novo
                        Cadastro</button>
                </div>
            </div>
        </div>
        <hr>

        <span id="msgAlerta"></span>

        <div class="row">
            <div class="col-4">
                <form id="cad-usuario-form">
                    <span id="msgAlertaErroCad"></span>
                    <div class="mb-3">
                        <div class="mb-3" style="display: none;">
                            <label for="data" class="col-form-label">Data:</label>
                            <input type="date" name="data" class="form-control" id="data">
                        </div>

                        <label for="descricao" class="col-form-label">Descricao:</label>
                        <input type="text" name="descricao" class="form-control" id="nome"
                            placeholder="Digite o nome completo">
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="col-form-label">Valor:</label>
                        <input type="number" name="valor" class="form-control" id="valor"
                            placeholder="Digite o seu valor" required>
                    </div>
                    <div class="mb-3">
                        <label class="ml-2" for="tipo-entrada">Entrada</label>
                        <input type="radio" id="tipo-entrada" name="tipo" value="entrada" required>

                        <label class="ml-2" for="tipo-saida">Saída</label>
                        <input type="radio" id="tipo-saida" value="saida" name="tipo" required>
                    </div>
                    <input type="submit" class="btn btn-outline-success btn-sm" id="cad-usuario-btn"
                        value="Cadastrar" />
                </form>
            </div>
            <div class="col-8">
                <span class="listar-usuarios"></span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Função para abrir o formulário de cadastro
        function openCadastroForm() {
            $("#cad-usuario-form").show();
            $("#msgAlertaErroCad").html("");
        }

        // Função para enviar o formulário de cadastro
        $("#cad-usuario-form").submit(function (e) {
            e.preventDefault();

           
    var form = $(this);
    var url = form.attr("action");
    var method = form.attr("method");

    // Obtenha a data atual
    var dataAtual = new Date();
    var ano = dataAtual.getFullYear();
    var mes = ("0" + (dataAtual.getMonth() + 1)).slice(-2);
    var dia = ("0" + dataAtual.getDate()).slice(-2);
    var dataFormatada = ano + "-" + mes + "-" + dia;

    // Adicione a data atual aos dados do formulário
    form.find('input[name="data"]').val(dataFormatada);

    // Obtenha os dados do formulário
    var formData = new FormData(form[0]);

    // Adicione a data atual à query string
    formData.append("data", dataFormatada);
    
            $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.erro) {
                        $("#msgAlertaErroCad").html(response.msg);
                    } else {
                        $("#msgAlerta").html(response.msg).addClass("alert alert-success");
                        form.trigger("reset");
                        setTimeout(function () {
                            $("#msgAlerta").html("").removeClass("alert alert-success");
                        }, 3000);
                    }
                },
                error: function () {
                    $("#msgAlertaErroCad").html("<div class='alert alert-danger' role='alert'>Erro ao cadastrar usuário.</div>");
                }
            });
        });

        // Função para listar os usuários
        function listarUsuarios() {
            $.ajax({
                url: "list.php",
                type: "POST",
                success: function (response) {
                    $(".listar-usuarios").html(response);
                },
                error: function () {
                    $(".listar-usuarios").html("<div class='alert alert-danger' role='alert'>Erro ao listar usuários.</div>");
                }
            });
        }

        $(document).ready(function () {
            listarUsuarios();
        });
    </script>
</body>

</html>