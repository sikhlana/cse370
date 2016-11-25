<?php $containerParams['title'] = 'Login' ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Login</h1>
		</div>
	</div>
</div>

<div class="container login">
	<div class="row">
		<div class="col-xs-12">
			<form class="loginForm AutoValidator form" method="post" action="<?php $this->buildLink('login/login') ?>" data-redirect="on">
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_username">Email:</label></div>
					<div class="field"><input type="text" id="ctrl_username" class="textCtrl" name="username" placeholder="john@doe.com" /></div>
				</div> 
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_password">Password:</label></div>
					<div class="field"><input type="password" id="ctrl_password" class="textCtrl" name="password" /></div>
				</div>
				
				<div class="submitUnit">
					<button class="button primary" type="submit">Login</button>
					<a class="button secondary" href="<?php $this->buildLink('register') ?>">Don't have an account? Register!</a>
				</div>
			</form>
		</div>
	</div>
</div>