<?php if(!defined('DIRREQ')) exit; ?>

<?php require_once VIEWS . 'includes/header.php' ?>
	<div class="container">
		<form id="form-cad-cliente" action="<?= DIRPAGE . '/cadastro/validado'?>" method="post">
			<ul id="progressbar">
				<li class="active">Dados Pessoais</li>
				<li>Endereço</li>
				<li>Login Senha</li>
				<li>Plano</li>
			</ul>
			<fieldset>
				<h2 class="fs-title">Dados Pessoais</h2>
				<input type="text" name="c_nome" id="cad-cli-nome" placeholder="nome" />
				<input type="text" name="c_cpf" id="cpf" placeholder="CPF" />
				<input type="text" name="c_rg" id="rg" placeholder="RG" />
				<select name="c_estado_civil" id="estado-civil" required>
					<option value="" selected disabled hidden>Estado Civil</option>
					<option value="Solteiro">Solteiro</option>
					<option value="Casado">Casado</option>
					<option value="Viúvo">Viúvo</option>
					<option value="Divorciado">Divorciado</option>
				</select>
				<input type="text" name="c_telefone" id="telefone" placeholder="Telefone" />
				<button type="button" class="action-btn next">proximo</button>
			</fieldset>				
			<fieldset>
				<h2 class="fs-title">Endereço</h2>
				<input type="text" name="c_endereco" id="endereco" placeholder="Rua, Av, Trav." />
				<input type="text" name="c_bairro" id="bairro" placeholder="Bairro" />
				<input type="text" name="c_cep" id="cep" placeholder="CEP" />
				<input type="text" name="c_cidade" id="cidade" placeholder="Cidade" />
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
				<input type="email" name="c_email" id="cad-cliente-email" placeholder="email" />
				<input type="text" name="c_login" id="cad-cliente-login" placeholder="Login" />
				<input type="password" name="c_senha" id="cad-cliente-senha" placeholder="Password" />
				<input type="password" name="c_conf-senha" id="conf-senha" placeholder="Conf-Password" />
				<button type="button" class="action-btn previous-btn previous">anterior</button>
				<button type="button" class="action-btn next">proximo</button>
			</fieldset>
			<fieldset>
				<h2 class="fs-title">Planos</h2>
				<select name="name_plano" id="nome-plano" required>
					<option value="" selected disabled hidden>Escolha Plano</option>
					<?php foreach ($data['planos'] as $nomePlano):?>
						<option value="<?= $nomePlano['id'] ?>"><?= $nomePlano['nome']?></option>
					<?php endforeach ; ?>
				</select>
				<!-- <input type="hidden" name="c_g-recaptcha-response" id="g-recaptcha-response"> -->
				<p class="erro alert"></p>
				<p class="alert email"></p>
				<p class="alert alert-success"></p>
				<button type="button" class="action-btn previous-btn previous">anterior</button>
				<button type="submit" class="action-btn enviar-btn">cadastar</button>
			</fieldset>
		</form>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>

