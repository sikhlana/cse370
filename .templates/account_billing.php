<?php $containerParams['title'] = 'Account' ?>
<?php $this->loadCss('account.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Billing Information</h1>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-4 col-sm-3">
			<ul class="accountLink">
				<li class="<?php __($minorSection == 'dashboard' ? 'selected' : '') ?>"><a href="<?php $this->buildLink('account') ?>">Dashboard</a></li>
				<li class="<?php __($minorSection == 'billing' ? 'selected' : '') ?>"><a href="<?php $this->buildLink('account/billing') ?>">Billing Information</a></li>
			</ul>
		</div>
		
		<div class="col-xs-8 col-sm-9">
			<form class="AutoValidator form" method="post" action="<?php $this->buildLink('account/billing/save') ?>" data-redirect="on">
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_first_name">First Name:</label></div>
					<div class="field"><input type="text" id="ctrl_first_name" class="textCtrl" name="first_name" value="<?php __($user['first_name']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_last_name">Last Name:</label></div>
					<div class="field"><input type="text" id="ctrl_last_name" class="textCtrl" name="last_name" value="<?php __($user['last_name']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="billing_street_1">Street Address:</label></div>
					<div class="field"><input type="text" id="billing_street_1" class="textCtrl" name="billing_street_1" value="<?php __($user['billing_street_1']) ?>" /></div>
					<div class="field"><input type="text" id="billing_street_2" class="textCtrl" name="billing_street_2" value="<?php __($user['billing_street_2']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_billing_zip">Postal Code / ZIP:</label></div>
					<div class="field"><input type="text" id="ctrl_billing_zip" class="textCtrl" name="billing_zip" value="<?php __($user['billing_zip']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_billing_city">City:</label></div>
					<div class="field"><input type="text" id="ctrl_billing_city" class="textCtrl" name="billing_city" value="<?php __($user['billing_city']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_billing_country">Country:</label></div>
					<div class="field">
                        <select id="ctrl_billing_country" class="textCtrl" name="billing_country">
							<?php foreach ($countryOptions as $option): ?>
								<option<?php ___($option['selected'] ? ' selected="selected"' : '') ?> value="<?php __($option['value']) ?>"><?php __($option['label']) ?></option>
							<?php endforeach; ?>
						</select>
                    </div>
				</div>
				
				<div class="submitUnit">
					<button class="button primary" type="submit">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>