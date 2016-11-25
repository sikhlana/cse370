<?php $containerParams['title'] = 'Error' ?>
<?php $this->loadCss('error.css') ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12 errorCode">
			<?php __($errorCode) ?>
		</div>
		
		<?php foreach ($errorMessage as $m): ?>
			<div class="col-xs-12 errorMessage">
				<?php __($m) ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>