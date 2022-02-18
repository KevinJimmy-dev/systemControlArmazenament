function mostrar(){
    var senha      = document.getElementById('senha');
    var btn        = document.getElementById('btn-eye');
    var abbr       = document.getElementById('abrev');

    if(senha.type == 'password'){
        senha.type    = 'text';
        btn.classList = 'fas fa-eye';
        abbr.title    = 'Ocultar senha';
        
    } else{
        senha.type = 'password';
        btn.classList = 'fas fa-eye-slash';
        abbr.title    = 'Mostrar senha';
    }
}

function mostrar1(){
    var cad_senha0 = document.getElementById('senha_usuario');
    var btn        = document.getElementById('btn-eye');
    var abbr       = document.getElementById('abrev');

    if(cad_senha0.type == 'password'){
        cad_senha0.type = 'text';
        btn.classList = 'fas fa-eye';
        abbr.title    = 'Ocultar senha';
    } else{
        cad_senha0.type = 'password';
        btn.classList = 'fas fa-eye-slash';
        abbr.title    = 'Mostrar senha';
    }
}

function mostrar2(){
    var cad_senha1 = document.getElementById('confSenha_usuario');
    var btn        = document.getElementById('btn-eyee');
    var abbr       = document.getElementById('abrevi');

    if(cad_senha1.type == 'password'){
        cad_senha1.type = 'text';
        btn.classList = 'fas fa-eye';
        abbr.title    = 'Ocultar senha';
    } else{
        cad_senha1.type = 'password';
        btn.classList = 'fas fa-eye-slash';
        abbr.title    = 'Mostrar senha';
    }
}