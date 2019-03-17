// https://github.com/vanilla-masker/vanilla-masker

// Máscara do formulário de cadastro
VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");
VMasker(document.querySelector("#rg")).maskPattern("99.999.999-9");
VMasker(document.querySelector("#cep")).maskPattern("99999-999");
VMasker(document.querySelector("#telefone")).maskPattern("(99) 9.9999-9999");


// Recaptcha
(function getCaptcha() {
    grecaptcha.ready(function() {
        grecaptcha.execute('6LcTy5cUAAAAACxOvmDYhhqbi9xdBxnN1yC3m9EH', {action: 'homepage'}).then(function(token) {
            console.log(token);
        });
    });
}());