<?php $containerParams['title'] = $hall['hall_id'] ? 'Edit Hall: ' . $hall['hall_name'] : 'Add New Hall' ?>
<?php $this->loadCss('admin.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1><?php ___($hall['hall_id'] ? 'Edit Hall: <em>' . $hall['hall_name'] . '</em>' : 'Add New Hall') ?></h1>
		</div>
	</div>
</div>

<div class="container section">
	<div class="row">
		<div class="col-xs-12">
			<form class="AutoValidator form" method="post" action="<?php $this->buildLink('admin/halls/save', $hall) ?>" data-redirect="on">
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_hall_name">Hall Name:</label></div>
					<div class="field"><input type="text" id="ctrl_hall_name" class="textCtrl" name="hall_name" value="<?php __($hall['hall_name']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_hall_type">Hall Type:</label></div>
					<div class="field">
						<select id="ctrl_hall_type" class="textCtrl" name="hall_type">
							<option<?php ___($hall['hall_type'] == '3D' ? ' selected="selected"' : '') ?> value="3D">3D</option>
							<option<?php ___($hall['hall_type'] == '2D' ? ' selected="selected"' : '') ?> value="2D">2D</option>
						</select>
					</div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_row_count">Row Count:</label></div>
					<div class="field"><input type="number" id="ctrl_row_count" class="textCtrl" name="row_count" value="<?php __($hall['row_count']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_column_count">Column Count:</label></div>
					<div class="field"><input type="number" id="ctrl_column_count" class="textCtrl" name="column_count" value="<?php __($hall['column_count']) ?>" /></div>
				</div>
				
				<div class="submitUnit">
					<button class="button primary" type="submit">Save Hall</button>
				</div>
			</form>
		</div>
	</div>
</div>