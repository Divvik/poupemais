<?php if(!defined('DIRREQ')) exit; ?>

<?php require_once VIEWS . 'includes/header.php' ?>
	<div class="container">
			<form id="form-cadastro-cliente" action="<?= DIRPAGE . '/validar'?>" method="post">
				<legend>Cadastrar</legend>
				<label for="cad-cli-nome">Nome</label>
				<input type="text" name="c_nome" id="cad-cli-nome" placeholder="nome" >
				
				<label for="cpf">CPF</label>
				<input type="text" name="c_cpf" id="cpf" placeholder="XXX.XXX.XXX-XX" >
				
				<label for="endereco">Endereço</label>
				<input type="text" name="c_endereco" id="endereco" placeholder="rua,av,quadra...">
				
				<label for="bairro">Bairro
					<input type="text" name="c_bairro" id="bairro" placeholder="bairro" >
				</label>
				
				<label for="cep">CEP
					<input type="text" name="c_cep" id="cep" placeholder="XXXXX-XXX" >
				</label>
				<label for="cidade">Cidade</label>
				<input type="text" name="c_cidade" id="cidade" placeholder="cidade" >
				
				<label for="estado"> Estado </label>
					<select name="c_estado" id="estado">
						<option value=""></option>
						<option value="sp">SP</option>
						<option value="mg">MG</option>
						<option value="rj">RJ</option>
						<option value="sc">SC</option>
					</select>
				
				<label for="telefone">Telefone</label>
				<input type="text" name="c_telefone" id="telefone" placeholder="(XX)X-XXXX-XXXX">
				
				<label for="cad-cliente-email">Email</label>
				<input type="email" name="c_email" id="cad-cliente-email" placeholder="email@email.com.br" >
				
				<label for="cad-cliente-login">Login</label>
				<input type="text" name="c_login" id="cad-cliente-login" placeholder="users" >
				
				<label for="cad-cliente-senha">Senha</label>
				<input type="password" name="c_senha" id="cad-cliente-senha" placeholder="password" >
				
				<label for="conf-senha">Confirme a senha</label>
				<input type="password" name="c_conf-senha" id="conf-senha" placeholder="conf-password" >
				
				<button class="btn btn-cadastar" type="submit">Cadastar</button>
				<a class="btn-cancelar btn-voltar-link" href="<?= DIRPAGE . '/login/index'?>">Voltar</a>
			</form>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>

