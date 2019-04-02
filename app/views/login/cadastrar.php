<?php if(!defined('DIRREQ')) exit; ?>

<?php require_once VIEWS . 'includes/header.php' ?>
	<div class="container">
		<form id="form-cad-cliente" action="<?= DIRPAGE . '/validar'?>" method="post">
			<ul id="progressbar">
				<li class="active">Dados Pessoais</li>
				<li>Endereço</li>
				<li>Login Senha</li>
				<li>Plano</li>
			</ul>
			<fieldset>
				<h2 class="fs-title">Dados Pessoais</h2>
				<input type="text" name="c_nome" id="cad-cli-nome" placeholder="nome" required/>
				<input type="text" name="c_cpf" id="cpf" placeholder="CPF" required/>
				<p class="cpf alert"></p>
				<input type="text" name="c_rg" id="rg" placeholder="RG" required/>
				<select name="c_estado_civil" class="w50" id="estado_civil" required>
					<option value="" selected disabled hidden>Estado Civil</option>
					<option value="Solteiro">Solteiro</option>
					<option value="Casado">Casado</option>
					<option value="Viúvo">Viúvo</option>
					<option value="Divorciado">Divorciado</option>
				</select>
				<input type="text" name="c_telefone" id="telefone" placeholder="Telefone" required/>
				<button type="button" class="action-btn next">proximo</button>
			</fieldset>				
			<fieldset>
				<h2 class="fs-title">Endereço</h2>
				<input type="text" name="c_endereco" id="endereco" placeholder="Rua, Av, Trav." required/>
				<input type="text" name="c_bairro" id="bairro" placeholder="Bairro" required/>
				<input type="text" name="c_cep" id="cep" placeholder="CEP" required/>
				<input type="text" name="c_cidade" id="cidade" placeholder="Cidade" required/>

				<select name="c_estado" id="estado" required>
					<option value="" selected disabled hidden>Estado</option>
					<option value="SP">SP</option>
					<option value="MG">MG</option>
					<option value="RJ">RJ</option>
					<option value="SC">SC</option>
				</select>
				<button type="button" class="action-btn previous-btn previous">anterior</button>
				<button type="button" class="action-btn next">proximo</button>
			</fieldset>
			<fieldset>
				<h2 class="fs-title">Login e Senha</h2>
				<input type="email" name="c_email" id="cad-cliente-email" placeholder="email" required/>
				<p class="email alert"></p>
				<input type="text" name="c_login" id="cad-cliente-login" placeholder="Login" required/>
				<input type="password" name="c_senha" id="cad-cliente-senha" placeholder="Password" required/>
				<p class="senha-strong alert"></p>
				<input type="password" name="c_conf-senha" id="conf-senha" placeholder="Conf-Password" required/>
				<p class="conf-senha alert"></p>
				<button type="button" class="action-btn previous-btn previous">anterior</button>
				<button type="button" class="action-btn next">proximo</button>
			</fieldset>
			<fieldset>
				<h2 class="fs-title">Planos</h2>
				<select name="name-plano" id="nome-plano" required>
					<option value="" selected disabled hidden>Escolha Plano</option>
					<option value="seis meses">6 Meses</option>
					<option value="doze meses">12 Meses</option>
				</select>
				<select name="plano" id="nome-plano" required>
					<option value="">Escolha Valor</option>
					<option value="50.00">R$ 50,00</option>
					<option value="100.00">R$ 100,00</option>
					<option value="150.00">R$ 150,00</option>
					<option value="200.00">R$ 200,00</option>
				</select>
				<p class="dados-em-brancos alert"></p>
				<p class="alert alert-success"></p>
				<input type="hidden" name="c_g-recaptcha-response" id="g-recaptcha-response">
				<button type="button" class="action-btn previous-btn previous">anterior</button>
				<button type="submit" class="action-btn enviar-btn">cadastar</button>
			</fieldset>
		</form>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>

