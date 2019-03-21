<?php if(!defined('DIRREQ')) exit; ?>

<?php require_once VIEWS . 'includes/header.php' ?>
	<div class="container">
			<form id="form-cadastro-cliente" action="<?= DIRPAGE . '/validar'?>" method="post">
				<legend>Cadastrar</legend>
				
				<div class="container-input">
					<input type="text" name="c_nome" id="cad-cli-nome" pattern=".+" required>
					<label for="cad-cli-nome">Nome</label>
				</div>

				<div class="container-input">
					<input type="text" name="c_cpf" id="cpf" pattern=".+" required>
					<label for="cpf">CPF</label>
					<p class="error-cad cpf"></p>
				</div>

				<div class="container-input">
					<input type="text" name="c_rg" id="rg" pattern=".+" required>
					<label for="rg">RG</label>
				</div>
				
				<label for="estado"> Estado Civil </label>
					<select name="c_estado_civil" class="w50" id="estado_civil" pattern=".+" required>
						<option value="">Selecione</option>
						<option value="Solteiro">Solteiro</option>
						<option value="Viúvo">Viúvo</option>
						<option value="Divorciado">Divorciado</option>
						<option value="Amasiado ">Amasiado </option>
					</select>
				
				<div class="container-input">
					<input type="text" name="c_endereco" id="endereco" pattern=".+" required>
					<label for="endereco">Endereço</label>
				</div>

				<div class="container-input input-floats float-left m-right">
					<input type="text" name="c_bairro" id="bairro" pattern=".+" required>
					<label for="bairro">Bairro</label>
				</div>

				<div class="container-input input-floats float-left">
					<input type="text" name="c_cep" id="cep" pattern=".+" required>
					<label for="cep">CEP</label>
				</div>

				<div class="container-input clear">
					<input type="text" name="c_cidade" id="cidade" pattern=".+" required>
					<label for="cidade">Cidade</label>
				</div>

				<label for="estado"> Estado </label>
					<select name="c_estado" id="estado" required>
						<option value="">Selecione</option>
						<option value="sp">SP</option>
						<option value="mg">MG</option>
						<option value="rj">RJ</option>
						<option value="sc">SC</option>
					</select>
				<div class="container-input clear" >
					<input type="text" name="c_telefone" id="telefone" pattern=".+" required>
					<label for="telefone">Telefone</label>
				</div>
				
				<div class="container-input">
					<input type="email" name="c_email" id="cad-cliente-email" pattern=".+" required>
					<label for="cad-cliente-email">Email</label>
					<p class="error-cad email"></p>
				</div>

				<div class="container-input">
					<input type="text" name="c_login" id="cad-cliente-login" pattern=".+" required>
					<label for="cad-cliente-login">Login</label>
				</div>

				<div class="container-input">
					<input type="password" name="c_senha" id="cad-cliente-senha" pattern=".+" required>
					<label for="cad-cliente-senha">Senha</label>
					<p class="error-cad senha-strong"></p>
				</div>

				<div class="container-input">
					<input type="password" name="c_conf-senha" id="conf-senha" pattern=".+" required>
					<label for="conf-senha">Confirme a senha</label>
					<p class="error-cad conf-senha"></p>
				</div>
				
				<input type="hidden" name="c_g-recaptcha-response" id="g-recaptcha-response">
				
				<button class="btn btn-cadastar" type="submit">Cadastar</button>
				<a class="btn-cancelar btn-voltar-link" href="<?= DIRPAGE . '/login/index'?>">Voltar</a>
			</form>
			<p class="error-cad dados-em-brancos success"></p>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>

