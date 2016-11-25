<?php $containerParams['title'] = 'Movies' ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Movies</h1>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<ol class="movieList">
				<?php foreach ($movies as $movie): ?>
					<?php $this->loadTemplate('movie_list_item', array('movie' => $movie)) ?>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</div>