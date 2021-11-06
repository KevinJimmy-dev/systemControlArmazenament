function verificar(){
    var pronto = 0;
    var usuario = document.getElementsByName('usuario')[0].value;
    var senha = document.getElementsByName('senha')[0].value;

    if (usuario == "abc" && senha == "dfg"){
        window.location = "../../program/php/program.html";
        pronto = 1;
    }
    if (pronto < 1){
        alert('Dados incorretos, tente novamente!');
    } 
}