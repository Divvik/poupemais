var pageAtual = window.location;
var pageCad = 'http://localhost/poupemais/login/cadastrar';

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
getCaptcha();
// requisição servidor

// Ajax do formulário de cadastro
var formCad = document.querySelector("#form-cadastro-cliente");
$("#form-cadastro-cliente").on("submit", function(event){
    event.preventDefault();
    var dados = $(this).serialize();

    $.ajax({
        url:formCad.action,
        type: 'POST',
        data: dados,
        dataType: 'json',
        success: function(response){
            $('.cpf').empty();
            $('.email').empty();
            $('.senha-strong').empty();
            $('.conf-senha').empty();
            $('.dados-em-brancos').empty();
            $('.retornoCad').empty();
            if(response.retorno == 'erro') {
                getCaptcha();
                $('.cpf').append(response.cpf).addClass('warning');
                $('.email').append(response.email).addClass('warning');
                $('.senha-strong').append(response.senhaStrong).addClass('warning');
                $('.conf-senha').append(response.senhaConf).addClass('warning');
                $('.dados-em-brancos').append(response.erros).addClass('warning');
            } else {
                $('.alert-success').append('Cadastro efetuado com sucesso!').addClass('success');
                window.location = 'http://localhost/poupemais/login';
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
        dataType: 'text',
        data: dados,
        beforeSend : function(){
            $(".erro").html("<i class='fas fa-spinner fa-spin'></i>");
        },success: function(msg){
            console.log(msg)
            if(msg != ''){
                $(".erro").append(msg).addClass("warning");
            } else {
                window.location = 'http://localhost/poupemais/dashboard';
            }
        }
    });

});