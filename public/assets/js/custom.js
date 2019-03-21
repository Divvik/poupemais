// https://github.com/vanilla-masker/vanilla-masker

// Máscara do formulário de cadastro
VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");
VMasker(document.querySelector("#rg")).maskPattern("99.999.999-9");
VMasker(document.querySelector("#cep")).maskPattern("99999-999");
VMasker(document.querySelector("#telefone")).maskPattern("(99) 9.9999-9999");


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
var form = document.querySelector("#form-cadastro-cliente");

$("#form-cadastro-cliente").on("submit", function(event){
    event.preventDefault();
    var dados = $(this).serialize();

    $.ajax({
        url:form.action,
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

            console.log(response);
            if(response.retorno == 'erro') {
                getCaptcha();
                $('.cpf').append(response.cpf).addClass('alert-warning');
                $('.email').append(response.email);
                $('.senha-strong').append(response.senhaStrong);
                $('.conf-senha').append(response.senhaConf);
                $('.dados-em-brancos').append(response.erros);
            } else {
                $('.success').append('Cadastro efetuado com sucesso!');
            }
        }
    });
});