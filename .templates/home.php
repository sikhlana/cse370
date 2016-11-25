<?php /** @var $this \App\Template */ ?>
<?php $this->loadCss('home.css') ?>

<div class="container-fluid ongoingMovies">
	<div class="row">
		<div class="col-xs-12 MovieSlider">
			<?php foreach ($ongoingMovies as $movie): ?>
				<div class="movieSliderItem">
					<a class="linkContainer" href="<?php $this->buildLink('movies', $movie) ?>"></a>
					
					<div class="movieMeta">
						<div class="movieRating"><i class="fa fa-star"></i> <?php __($movie['imdbData']['imdbRating']) ?>/10</div>
						<h3 class="movieTitle"><?php __($movie['title']) ?></h3>
						<div class="movieGenre"><?php __($movie['imdbData']['Genre']) ?></div>
					</div>
					
					<div class="moviePoster" style="background-image: url(<?php __($movie['posterUrl']) ?>)"></div>
					<div class="wrapper"></div>
					<div class="gradientWrapper"></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php if ($upcomingMovies): ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1 class="toLeft">Upcoming Movies</h1>
			</div>
			
			<div class="col-xs-12">
				<ol class="movieList">
					<?php foreach ($upcomingMovies as $movie): ?>
						<?php $this->loadTemplate('movie_list_item', array('movie' => $movie)) ?>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</div>
<?php endif; ?>