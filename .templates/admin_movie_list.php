<?php $containerParams['title'] = 'Manage Movies' ?>
<?php $this->loadCss('admin.css') ?>
<?php $this->loadCss('admin_movie_list.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Manage Movies</h1>
		</div>
	</div>
</div>

<div class="container topCtrl">
	<div class="row">
		<div class="col-xs-12">
			<a class="button primary" href="<?php $this->buildLink('admin/movies/add') ?>">+ Add New Movie</a>
		</div>
	</div>
</div>

<div class="container section">
	<div class="row">
		<div class="col-xs-12">
			<?php if ($movies): ?>
				<div class="sectionHeader">
					<h3>Available Movies</h3>
				</div>
				
				<div class="dataList">
					<ol>
						<?php foreach ($movies as $movie): ?>
							<li>
								<a href="<?php $this->buildLink('admin/movies/edit', $movie) ?>">
									<img class="movieThumb" src="<?php __($movie['thumbUrl']) ?>" />
									<h4><?php __($movie['title']) ?></h4>
									<span class="movieSnippet"><?php ___(nl2br($movie['synopsis'])) ?></span>
									<span class="movieReleaseDate">Release Date: <?php __(\App\Locale::date($movie['release_date'], 'absolute')) ?></span>
								</a>
								<a class="deleteButton DeleteConfirm" href="<?php $this->buildLink('admin/movies/delete', $movie) ?>"></a>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
				
				<div class="sectionFooter">
					<p class="footerText">Showing <?php __(\App\Locale::numberFormat(count($movies))) ?> item(s).</p>
				</div>
			<?php else: ?>
				<div class="noResults">No movies have been added yet.</div>
			<?php endif; ?>
		</div>
	</div>
</div>