<?php $containerParams['title'] = 'Manage Halls' ?>
<?php $this->loadCss('admin.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Manage Halls</h1>
		</div>
	</div>
</div>

<div class="container topCtrl">
	<div class="row">
		<div class="col-xs-12">
			<a class="button primary" href="<?php $this->buildLink('admin/halls/add') ?>">+ Add New Hall</a>
		</div>
	</div>
</div>

<div class="container section">
	<div class="row">
		<div class="col-xs-12">
			<?php if ($halls): ?>
				<div class="sectionHeader">
					<h3>Available Halls</h3>
				</div>
				
				<div class="dataList">
					<ol>
						<?php foreach ($halls as $hall): ?>
							<li>
								<a href="<?php $this->buildLink('admin/halls/edit', $hall) ?>">
									<h4><?php __($hall['hall_name']) ?></h4>
								</a>
								<a class="deleteButton DeleteConfirm" href="<?php $this->buildLink('admin/halls/delete', $hall) ?>"></a>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
				
				<div class="sectionFooter">
					<p class="footerText">Showing <?php __(\App\Locale::numberFormat(count($halls))) ?> item(s).</p>
				</div>
			<?php else: ?>
				<div class="noResults">No halls have been added yet.</div>
			<?php endif; ?>
		</div>
	</div>
</div>