$(function () {
    //Pesquisar os produtos sem refresh
    $("#pesquisa").keyup(function () {

        var pesquisa = $(this).val();

        //Verificar se a algo digitado
        if (pesquisa != "") {
            var dados = {
                palavra: pesquisa
            }
            $.post("busca.php", dados, function (retorna) {
                //Mostra dentro da ul os resultados obtidos
                $(".resultado").html(retorna);
            });
        } else {
            $(".resultado").html('');
        }
    });
});
