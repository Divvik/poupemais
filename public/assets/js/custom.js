// https://github.com/vanilla-masker/vanilla-masker

// Máscara do formulário de cadastro
VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");
VMasker(document.querySelector("#cep")).maskPattern("99999-999");
VMasker(document.querySelector("#telefone")).maskPattern("(99) 9.9999-9999");