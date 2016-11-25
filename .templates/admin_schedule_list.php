<?php $containerParams['title'] = 'Manage Schedule' ?>
<?php $this->loadCss('admin.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Manage Schedule</h1>
		</div>
	</div>
</div>

<div class="container topCtrl">
	<div class="row">
		<div class="col-xs-12">
			<a class="button primary" href="<?php $this->buildLink('admin/schedule/add') ?>">+ Add New Showtime</a>
		</div>
	</div>
</div>

<div class="container section">
	<div class="row">
		<div class="col-xs-12">
			<?php if ($showtimes): ?>
				<div class="sectionHeader">
					<h3>Schedule</h3>
				</div>
				
				<div class="dataList">
					<ol>
						<?php foreach ($showtimes as $showtime): ?>
							<li>
								<a href="<?php $this->buildLink('admin/schedule/edit', $showtime) ?>">
									<h4><?php __($showtime['movie_title']) ?> on <?php __($showtime['preparedDate']) ?> at <?php __($showtime['preparedTime']) ?></h4>
								</a>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
				
				<div class="sectionFooter">
					<p class="footerText">Showing <?php __(\App\Locale::numberFormat(count($showtimes))) ?> item(s).</p>
				</div>
			<?php else: ?>
				<div class="noResults">No showtime have been added yet.</div>
			<?php endif; ?>
		</div>
	</div>
</div>