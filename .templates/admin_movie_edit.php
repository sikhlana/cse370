<?php $containerParams['title'] = $movie['movie_id'] ? 'Edit Movie: ' . $movie['title'] : 'Add New Movie' ?>
<?php $this->loadCss('admin.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1><?php ___($movie['movie_id'] ? 'Edit Movie: <em>' . $movie['title'] . '</em>' : 'Add New Movie') ?></h1>
		</div>
	</div>
</div>

<div class="container section">
	<div class="row">
		<div class="col-xs-12">
			<form class="form" method="post" enctype="multipart/form-data" action="<?php $this->buildLink('admin/movies/save', $movie) ?>">
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_title">Title:</label></div>
					<div class="field"><input type="text" id="ctrl_title" class="textCtrl" name="title" value="<?php __($movie['title']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_release_date">Release Date:</label></div>
					<div class="field"><input type="date" id="ctrl_release_date" class="textCtrl" name="release_date" value="<?php __(\App\Locale::date($movie['release_date'], 'Y-m-d')) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_synopsis">Synopsis:</label></div>
					<div class="field"><textarea id="ctrl_synopsis" class="textCtrl" name="synopsis"><?php __($movie['synopsis']) ?></textarea></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_imdb_id">IMDB ID:</label></div>
					<div class="field"><input type="text" id="ctrl_imdb_id" class="textCtrl" name="imdb_id" value="<?php __($movie['imdb_id']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_trailer_link">Trailer Link:</label></div>
					<div class="field"><input type="url" id="ctrl_trailer_link" class="textCtrl" name="trailer_link" value="<?php __($movie['trailer_link']) ?>" /></div>
				</div>
				
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_poster">Movie Poster:</label></div>
					<div class="field"><input type="file" id="ctrl_poster" class="textCtrl" name="poster" accept="image/*" /></div>
					<p class="explain">Select a new image to overwrite the existing one.</p>
				</div>
				
				<div class="submitUnit">
					<button class="button primary" type="submit">Save Movie</button>
				</div>
			</form>
		</div>
	</div>
</div>