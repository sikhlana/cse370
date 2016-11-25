<?php $containerParams['title'] = 'Schedule for ' . $movie['title'] ?>
<?php $this->loadCss('movie_view.css') ?>

<div class="container movieContainer">
	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<img class="moviePoster img-responsive" src="<?php __($movie['posterUrl']) ?>" />
		</div>
		
		<div class="col-xs-12 col-sm-8">
			<h1 class="toLeft">Schedule for <em><?php __($movie['title']) ?></em></h1>
			
			<div class="movieShowtime">
				<ol class="movieShowtimes">
					<?php foreach ($showtimesGrouped as $date => $halls): ?>
						<li>
							<h3 class="date"><?php __($date) ?></h3>
							<ul class="hallList">
								<?php foreach ($halls as $hall): ?>
									<?php $this->loadTemplate('showtime_list_item', array('hall' => $hall)) ?>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</div>
</div>