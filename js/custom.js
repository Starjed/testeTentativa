const tbody = document.querySelector(".listar-usuarios");
const cadForm = document.getElementById("cad-usuario-form");
const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
const msgAlerta = document.getElementById("msgAlerta");

const listarUsuarios = async (pagina) => {
    const dados = await fetch("./list.php?pagina=" + pagina);
    const resposta = await dados.text();
    tbody.innerHTML = resposta;
}

listarUsuarios(1);

cadForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    
    const dadosForm = new FormData(cadForm);
    dadosForm.append("add", 1);

    document.getElementById("cad-usuario-btn").value = "Salvando...";
    
    const dados = await fetch("cadastrar.php", {
        method: "POST",
        body: dadosForm,
    });

    const resposta = await dados.json();
    
    if(resposta['erro']){
        msgAlertaErroCad.innerHTML = resposta['msg'];
    }else{
        msgAlerta.innerHTML = resposta['msg'];
        cadForm.reset();
        listarUsuarios(1);
    }
    document.getElementById("cad-usuario-btn").value = "Cadastrar";
});


// Variável para armazenar a referência do gráfico
var myChart;

    // Verificar se o gráfico já foi criado e destruí-lo
    if (myChart) {
        myChart.destroy();
    }

    // Gerar o gráfico de barras
    var ctx = document.getElementById("grafico").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Entrada", "Saída"],
            datasets: [
                {
                    label: "Valores",
                    data: [totais.entrada, totais.saida],
                    backgroundColor: ["rgba(75, 192, 192, 0.6)", "rgba(255, 99, 132, 0.6)"]
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


function formatarData(data) {
    var dia = ("0" + data.getDate()).slice(-2);
    var mes = ("0" + (data.getMonth() + 1)).slice(-2);
    var ano = data.getFullYear();
    return dia + "/" + mes + "/" + ano;
}


function formatarValor(valor) {
    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
  }

function validarCampos() {
    // Verifica se os campos de descrição, valor e pelo menos um dos botões de rádio estão preenchidos
    if (selectDescricao.value && campoValor.value && (radioEntrada.checked || radioSaida.checked)) {
        // Habilita o botão de enviar
        botaoEnviar.disabled = false;
    } else {
        // Desabilita o botão de enviar
        botaoEnviar.disabled = true;
    }
}

