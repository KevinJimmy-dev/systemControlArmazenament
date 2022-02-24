//Um dos arquivos responsaveis pela pesquisa sem refresh na página
$(function () {
    //Function quando está digitando no campo, ativa o evento
    $("#pesquisa").keyup(function () {
        //Variavel recebendo o valor do input
        var pesquisa = $(this).val();

        //Verificar se a algo digitado
        if (pesquisa != "") {
            //Variavel recebendo um objeto, e a variavel pesquisa dentro do objeto
            var dados = {
                palavra: pesquisa
            }

            //Manda para o arquivo busca passando a variavel dados
            $.post("../../../Model/Entity/busca.php", dados, function (retorna) {
                //Mostra dentro da ul os resultados obtidos
                $(".resultado").html(retorna);
            });

        //Senão recebe nada
        } else {
            $(".resultado").html('');
        }
    });
});

//Variaveis recebendo objetos do html
var lista    = document.getElementById('lista'); 
var pesquisa = document.getElementById('pesquisa'); 

//Evento que dispara quando sai do campo, mudando o style apenas
function noFocus(){
    lista.style.display = "none";
    pesquisa.style.borderBottom = "1px solid #19c0d3 !important";
}

//Evento que dispara quando entra no campo, mudando o style apenas
function onFocus(){
    lista.style.display = "inline";
}
