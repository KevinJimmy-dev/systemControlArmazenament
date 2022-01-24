<?php
//Arquivo pra busca sem refresh da página requisição funcionar, mas inclui outros codigos da página também...
include_once("conexao.php");
session_start();

//Recuperar o valor da palavra
$produtos = $_POST['palavra'];

//Pesquisar no banco de dadoso nome do curso referente a palavra digitada
$produtos = "SELECT * FROM produto WHERE nome_produto LIKE '%$produtos%'";
$resultado_produtos = mysqli_query($conexaoMysqli, $produtos);

//Se nenhuma linha for buscada
if (mysqli_num_rows($resultado_produtos) <= 0) {
    echo "Nenhum produto encontrado...";
} else {
    //Se buscar alguma, vai imprimir um <li> com o resultado buscado por meio de um array, e do lado um botão pra mandar pra tabela
    while ($rows = mysqli_fetch_assoc($resultado_produtos)) {
        $name = $rows['id_produto'];
        echo "<li id='" . $name . "' value='" . $rows['nome_produto'] . "' name='" . $name . "'>" . $rows['nome_produto'] .
            " <input type='button' name='$rows[quantidade_produto]' id='" . $rows['nome_produto'] . "' onclick='adicionou(id, name), desabilitar(id)' value='+'> </li>";    
            
    }

    //Código de Javascript dentro de um echo
    //Básicamente algumas funções de javascript
    $script = "
        <script>
            //Essa função irá adicionar na tabela, o nome do produto, um input com a quantidade do produto e outro input para fazer a requisição
            function adicionou(nome, qntd){
                var tbl = document.getElementById('tbl');
                var div = document.getElementById('div');

                var inputHidden   = document.createElement('input');
                var novoTr        = document.createElement('tr');
                var novoTd        = document.createElement('td');
                var novoTd1       = document.createElement('td');
                var novaInputQntd = document.createElement('td');
                var inputReq      = document.createElement('td');
                var excluir       = document.createElement('button');
        
                novoTd.innerHTML        = nome;
                novaInputQntd.innerHTML = '<input name=qnt[] type=number value=' + qntd + ' readonly>';
                inputReq.innerHTML      = '<input name=req[] type=number step=.01>';
                excluir.innerHTML       = 'X';

                inputHidden.type  = 'hidden';
                inputHidden.name  = 'escondido[]';
                inputHidden.value = nome;

                excluir.setAttribute('onclick', 'excluir(event.target)');

                div.appendChild(inputHidden);

                tbl.appendChild(novoTr);

                novoTr.appendChild(novoTd);
                novoTr.appendChild(novaInputQntd);
                novoTr.appendChild(inputReq);
                novoTr.appendChild(excluir);
            }

            //Essa função desabilita o botão pra adicionar na tabela, é ativada quando clicar no botão pra add
            function desabilitar(id){
                var botao = document.getElementById(id);
                botao.setAttribute('disabled', 'disabled');
            }

            //Essa função irá deletar a linha da tabela selecionada
            function excluir(elementoClicado){
                elementoClicado.closest('tr').remove();
            }
        </script>"
    ;

    //Esse echo imprime tudo da variável
    echo $script;

    
}
