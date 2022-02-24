<?php
//Arquivo pra busca sem refresh da página requisição funcionar, mas inclui outros codigos da página também...
//Incluindo a conexão do banco de dados
include_once 'conexao.php';

//Inicia sessão
session_start();

//Recupera o valor da palavra
$produtos = $_POST['palavra'];

//Pesquisa no banco de dados o nome do produto referente a palavra digitada
$produtos = "SELECT * FROM produto WHERE nome_produto LIKE '%$produtos%'";
$resultado_produtos = mysqli_query($conexaoMysqli, $produtos);

//Se não possuir nenhum resultado
if (mysqli_num_rows($resultado_produtos) <= 0) {
    //Imprimi uma mensagem
    echo "Nenhum produto encontrado...";

//Se possuir
} else {
    //Enquanto tiver resultados no array, será imprimido
    while ($rows = mysqli_fetch_assoc($resultado_produtos)) {
        //Váriavel recebendo o id_produto
        $name = $rows['id_produto'];
        //Imprimi o resultado dentro de um <li>, e do lado um botão com eventos
        echo "<li class='left-align list' id='" . $name . "' value='" . $rows['nome_produto'] . "' name='" . $name . "'>" . $rows['nome_produto'] .
            " <button name='$rows[quantidade_produto]' class='botao_add' id='" . $rows['nome_produto'] . "' onclick='adicionou(id, name), desabilitar(id), noFocus()' value=''> <abbr class='cursor-pointer' title='Clique para adicionar a lista'><i class='fas fa-plus black-color'></i></abbr>  </button> </li>";
    }

    //Código de Javascript dentro de um echo
    //Básicamente algumas funções de javascript
    $script = "
        <script>
            //Essa função irá adicionar na tabela, o nome do produto, um input com a quantidade do produto e outro input para fazer a requisição
            function adicionou(nome, qntd){
                //Pegando objetos do html
                var tbl = document.getElementById('trueTbl');
                var div = document.getElementById('div');

                //Criando objetos do html com javascript
                var tbody         = document.createElement('tbody');
                var novoTr        = document.createElement('tr');
                var inputHidden   = document.createElement('input');
                var novoTd        = document.createElement('td');
                var novaInputQntd = document.createElement('td');
                var inputReq      = document.createElement('td');
                var excluir       = document.createElement('button');
                var abbrExcluir   = document.createElement('abbr');
                var iconExcluir   = document.createElement('i');
        
                //Adicionando valores aos objetos criados
                novoTd.innerHTML        = nome;
                novaInputQntd.innerHTML = '<input name=qnt[] type=number class=input-table value=' + qntd + ' readonly>';
                inputReq.innerHTML      = '<input name=req[] type=number class=input-table step=.01 required>';
                excluir.innerHTML       = '';

                //Input escondido recebendo algumas caracteristicas
                inputHidden.type  = 'hidden';
                inputHidden.name  = 'escondido[]';
                inputHidden.value = nome;

                //Abreviação mudando
                abbrExcluir.title = 'Clique para deletar da lista';

                //Dando novas classes para os objetos
                novoTr.classList.add('no-border-top');
                novoTd.classList.add('left-align');
                excluir.classList.add('no-border');
                abbrExcluir.classList.add('cursor-pointer');
                iconExcluir.classList.add('fas');
                iconExcluir.classList.add('fa-minus-circle');
                iconExcluir.classList.add('black-color');

                //Dando um evento onclick para o botão de excluir
                excluir.setAttribute('onclick', 'excluir(event.target)');

                //Dando novos filhos para os objetos
                div.appendChild(inputHidden);

                tbl.appendChild(tbody);
                tbody.appendChild(novoTr);

                novoTr.appendChild(novoTd);
                novoTr.appendChild(novaInputQntd);
                novoTr.appendChild(inputReq);
                novoTr.appendChild(excluir);
                
                excluir.appendChild(abbrExcluir);
                abbrExcluir.appendChild(iconExcluir);
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
        </script>";

    //Imprime tudo da variável
    echo $script;
}
