<?php $containerParams['title'] = 'Register' ?>
<?php $this->loadCss('register.css') ?>
<?php $this->loadJs('js/zxcvbn.js') ?>
<?php $this->loadJs('js/register.js') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Register</h1>
		</div>
	</div>
</div>

<div class="container register">
	<div class="row">
		<div class="col-xs-12">
			<form class="registerForm AutoValidator form" method="post" action="<?php $this->buildLink('register/register') ?>" data-redirect="on">
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_first_name">First Name:</label></div>
					<div class="field"><input type="text" id="ctrl_first_name" class="textCtrl" name="first_name" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_last_name">Last Name:</label></div>
					<div class="field"><input type="text" id="ctrl_last_name" class="textCtrl" name="last_name" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_username">Email:</label></div>
					<div class="field"><input type="text" id="ctrl_username" class="textCtrl" name="username" placeholder="john@doe.com" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_password">Password:</label></div>
					<div class="field"><input type="password" id="ctrl_password" class="textCtrl Password" name="password" /></div>
					<div class="PasswordMeter"><div class="Strength"></div></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_password_confirm">Confirm Password:</label></div>
					<div class="field"><input type="password" id="ctrl_password_confirm" class="textCtrl" name="password_confirm" /></div>
				</div>
				
				<div class="submitUnit">
					<button class="button primary" type="submit">Register</button>
					<p class="formFooter">By registering you are agreeing to our Terms of Service.</p>
					<a class="button secondary" href="{xen:link login}">Already have an account? Login!</a>
				</div>
			</form>
		</div>
	</div>
</div>