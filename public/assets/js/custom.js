var pageAtual = window.location;
var pageCad = 'http://localhost/poupemais/cadastro';

if(pageAtual == pageCad) {
    // https://github.com/vanilla-masker/vanilla-masker
    // Máscara do formulário de cadastro
    VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");
    VMasker(document.querySelector("#rg")).maskPattern("99.999.999-9");
    VMasker(document.querySelector("#cep")).maskPattern("99999-999");
    VMasker(document.querySelector("#telefone")).maskPattern("(99) 9.9999-9999");
}

// Recaptcha
function getCaptcha() {
    grecaptcha.ready(function() {
        grecaptcha.execute('6LcTy5cUAAAAACxOvmDYhhqbi9xdBxnN1yC3m9EH', {action: 'homepage'}).then(function(token) {
            const gRecaptchaResponse = document.querySelector("#g-recaptcha-response").value = token;
        });
    });
}
// getCaptcha();
// requisição servidor

// Ajax do formulário de cadastro
var formCad = document.querySelector("#form-cad-cliente");
$("#form-cad-cliente").on("submit", function(event){
    event.preventDefault();
    var dados = $(this).serialize();

    $.ajax({
        url:formCad.action,
        type: 'POST',
        data: dados,
        dataType: 'json',
        beforeSend : function(){
            $(".erro").html("<i class='fas fa-spinner fa-spin loading'> </i>");
        },success: function(response){
            $('.erro').empty().removeClass('warning');
            // Tratametno Erro Cadastro
            if(response.retornoCad == 'erro') {
                $.each(response.erros, function(key, value){
                    $(".erro").append(value+'<br>').addClass("warning");
                });
            } else {
                $('.alert-success').empty();
                $('.alert-success').append('Cadastro efetuado com sucesso!').addClass('success'); 
                // Caso não tenha erro Cadastro
                // Trata erro Envio email
                if(response.email.retorno == 'erro') {
                    // getCaptcha();
                    $('.email').empty();
                    $.each(response.email.erros, function(key, value){
                        $(".erro").append(value+'<br><br>').addClass("warning");
                    });
                // Caso não tenha nenhum                
                } else {  
                    $('.email').empty();
                    $('.email').append(response.email.msg).addClass('success');
                    setTimeout(function(){
                        window.location = 'http://localhost/poupemais/login';
                    }, 5000);
                }    
            }
        }
    });
});

var formLogin = document.querySelector("#form-login");

$("#form-login").on("submit", function(event){
    event.preventDefault();
    var dados = $(this).serialize();

    $.ajax({
        url: formLogin.action,
        type: 'POST',
        dataType: 'json',
        data: dados,
        beforeSend : function(){
            $(".erro").html("<i class='fas fa-spinner fa-spin'> </i>");
        },success: function(response){
            if(response.retorno == 'erro'){
                // getCaptcha();
                if(response.tentativas == true) {
                    $('#form-login').hide();
                }
                $(".erro").empty();
                $.each(response.erros, function(key, value){
                    $(".erro").append(value+'<br>').addClass("warning-login");
                });                
            } else {
                $(".retorno").empty();
                $(".retorno").append(response.success).addClass("success");
                setTimeout(function(){
                    window.location = 'http://localhost/poupemais/dashboard';
                }, 2000);
            }
        }
    });
});

// CapsLock
$("#password").keypress(function(e) {
    // teclas selecionadas
    kc = e.keyCode ? e.keyCode : e.which;
    // shift pressionado
    sk = e.shiftKey ? e.shiftKey : ((kc == 16) ? true:false );
    if((kc >= 65 && kc <= 90 && !sk) || (kc >= 97 && kc <= 122) && sk){
        $('.caps-lock').html('Caps Lock Ligado').addClass("warning");
    } else {
        $('.caps-lock').empty().removeClass("warning");
    }   
});