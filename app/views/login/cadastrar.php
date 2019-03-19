<?php if(!defined('DIRREQ')) exit; ?>

<?php require_once VIEWS . 'includes/header.php' ?>
	<div class="container">
			<form id="form-cadastro-cliente" action="<?= DIRPAGE . '/validar'?>" method="post">
				<legend>Cadastrar</legend>
				<label for="cad-cli-nome">Nome</label>
				<input type="text" name="c_nome" id="cad-cli-nome" placeholder="nome" required>
				
				<label for="cpf">CPF</label>
				<input type="text" name="c_cpf" id="cpf" placeholder="XXX.XXX.XXX-XX" required>

				<label for="rg">RG</label>
				<input type="text" name="c_rg" id="rg" placeholder="XX.XXX.XXX-X" required>

				<label for="estado"> Estado Civil </label>
					<select name="c_estado_civil" id="estado_civil" required>
						<option value=""></option>
						<option value="Solteiro">Solteiro</option>
						<option value="Viúvo">Viúvo</option>
						<option value="Divorciado">Divorciado</option>
						<option value="Amasiado ">Amasiado </option>
					</select>
				
				<label for="endereco">Endereço</label>
				<input type="text" name="c_endereco" id="endereco" placeholder="rua,av,quadra..."required>
				
				<label for="bairro">Bairro
					<input type="text" name="c_bairro" id="bairro" placeholder="bairro" required>
				</label>
				
				<label for="cep">CEP
					<input type="text" name="c_cep" id="cep" placeholder="XXXXX-XXX" required>
				</label>
				<label for="cidade">Cidade</label>
				<input type="text" name="c_cidade" id="cidade" placeholder="cidade" required>
				
				<label for="estado"> Estado </label>
					<select name="c_estado" id="estado" required>
						<option value=""></option>
						<option value="sp">SP</option>
						<option value="mg">MG</option>
						<option value="rj">RJ</option>
						<option value="sc">SC</option>
					</select>
				
				<label for="telefone">Telefone</label>
				<input type="text" name="c_telefone" id="telefone" placeholder="(XX)X-XXXX-XXXX"required>
				
				<label for="cad-cliente-email">Email</label>
				<input type="email" name="c_email" id="cad-cliente-email" placeholder="email@email.com.br" required>
				
				<label for="cad-cliente-login">Login</label>
				<input type="text" name="c_login" id="cad-cliente-login" placeholder="users" required>
				
				<label for="cad-cliente-senha">Senha</label>
				<input type="password" name="c_senha" id="cad-cliente-senha" placeholder="password" required>
				
				<label for="conf-senha">Confirme a senha</label>
				<input type="password" name="c_conf-senha" id="conf-senha" placeholder="conf-password" required>

				<input type="hidden" name="c_g-recaptcha-response" id="g-recaptcha-response">
				
				<button class="btn btn-cadastar" type="submit">Cadastar</button>
				<a class="btn-cancelar btn-voltar-link" href="<?= DIRPAGE . '/login/index'?>">Voltar</a>
			</form>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>

