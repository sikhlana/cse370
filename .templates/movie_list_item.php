<?php $this->loadCss('movie_list_item.css') ?>

<li class="movieListItem">
	<div class="poster" style="background-image: url(<?php __($movie['thumbUrl']) ?>);"></div>
	<div class="wrapper">
		<h3 class="title"><?php __($movie['title']) ?> <span class="year"><?php __($movie['imdbData']['Year']) ?></span></h3>
		<div class="meta">
			<span class="releaseDate" title="Movie Release Date"><i class="fa fa-calendar"></i> <?php ___(\App\Locale::date($movie['release_date'], 'absolute')) ?></span>
			<?php if ($movie['imdbData']['Rated']): ?>
				<span class="rating" title="Movie Rating"><i class="fa fa-users"></i> <?php __($movie['imdbData']['Rated']) ?></span>
			<?php endif; ?>
			<?php if ($movie['runtime']['hours'] || $movie['runtime']['minutes']): ?>
				<span class="runtime" title="Movie Runtime"><i class="fa fa-clock-o"></i>
					<?php if ($movie['runtime']['hours']): ?>
						<?php __($movie['runtime']['hours']) ?> hour<?php __($movie['runtime']['hours'] > 1 ? 's' : '') ?><?php if ($movie['runtime']['minutes']) { __(', '); } ?>
					<?php endif; ?>
					<?php if ($movie['runtime']['minutes']): ?>
						<?php __($movie['runtime']['minutes']) ?> minute<?php __($movie['runtime']['minutes'] > 1 ? 's' : '') ?>
					<?php endif; ?>
				</span>
			<?php endif; ?>
			<span class="genre" title="Movie Genre"><i class="fa fa-film"></i> <?php __($movie['imdbData']['Genre']) ?></span>
		</div>
		
		<p class="synopsis"><?php ___(nl2br($movie['synopsis'])) ?></p>
		<div class="footer">
			<a class="button primary" href="<?php $this->buildLink('movies', $movie) ?>">View Details</a>
			<?php if ($movie['has_showtime']): ?>
				<a class="button green" href="<?php $this->buildLink('movies/schedule', $movie) ?>">Buy Tickets</a>
			<?php endif; ?>
		</div>
	</div>
</li>