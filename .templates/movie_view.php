<?php $containerParams['title'] = $movie['title'] ?>
<?php $this->loadCss('movie_view.css') ?>
<?php $this->loadJs('js/jquery.fitvids.js') ?>
<?php $this->loadJs('js/movie_view.js') ?>

<div class="container movieContainer">
	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<img class="moviePoster img-responsive" src="<?php __($movie['posterUrl']) ?>" />
			
			<div class="movieDetails">
				<h4>Details</h4>
				<div class="pairsJustified">
					<dl>
						<dt>Actors</dt><dd><?php __($movie['imdbData']['Actors']) ?></dd>
					</dl>
					<dl>
						<dt>Director</dt><dd><?php __($movie['imdbData']['Director']) ?></dd>
					</dl>
					<dl>
						<dt>Release Date</dt><dd><?php __(\App\Locale::date($movie['release_date'], 'absolute')) ?></dd>
					</dl>
					<dl>
						<dt>Rating</dt><dd><?php __($movie['imdbData']['Rated']) ?></dd>
					</dl>
					<dl>
						<dt>Genre</dt><dd><?php __($movie['imdbData']['Genre']) ?></dd>
					</dl>
					<dl>
						<dt>Runtime</dt>
						<dd>
							<?php if ($movie['runtime']['hours'] || $movie['runtime']['minutes']): ?>
								<?php if ($movie['runtime']['hours']): ?>
									<?php __($movie['runtime']['hours']) ?> hour<?php __($movie['runtime']['hours'] > 1 ? 's' : '') ?><?php if ($movie['runtime']['minutes']) { __(', '); } ?>
								<?php endif; ?>
								<?php if ($movie['runtime']['minutes']): ?>
									<?php __($movie['runtime']['minutes']) ?> minute<?php __($movie['runtime']['minutes'] > 1 ? 's' : '') ?>
								<?php endif; ?>
							<?php else: ?>
								N/A
							<?php endif; ?>
						</dd>
					</dl>
					<dl>
						<dt>Language</dt><dd><?php __($movie['imdbData']['Language']) ?></dd>
					</dl>
					<dl>
						<dt>Country</dt><dd><?php __($movie['imdbData']['Country']) ?></dd>
					</dl>
				</div>
			</div>
		</div>
		
		<div class="col-xs-12 col-sm-8">
			<?php if ($visitor['user_id'] && !$hasInWishlist): ?>
				<a class="wishlist button small green OverlayTrigger" href="<?php $this->buildLink('movies/wishlist', $movie) ?>">Add to Wishlist</a>
			<?php endif; ?>
			<h1 class="toLeft movieTitle"><?php __($movie['title']) ?></h1>
			<div class="movieMeta">
				<span class="genre" title="Movie Genre"><i class="fa fa-film"></i> <?php __($movie['imdbData']['Genre']) ?></span>
				<?php if ($movie['runtime']['hours'] || $movie['runtime']['minutes']): ?>
					<span class="runtime" title="Movie Runtime"><i class="fa fa-clock-o"></i>
						<?php if ($movie['runtime']['hours']): ?>
							<?php __($movie['runtime']['hours']) ?> hour<?php __($movie['runtime']['hours'] > 1 ? 's' : '') ?>
							<?php if ($movie['runtime']['minutes']) { __(', '); } ?>
						<?php endif; ?>
						<?php if ($movie['runtime']['minutes']): ?>
							<?php __($movie['runtime']['minutes']) ?> minute<?php __($movie['runtime']['minutes'] > 1 ? 's' : '') ?>
						<?php endif; ?>
					</span>
				<?php endif; ?>
			</div>

			<h3>Synopsis</h3>
			<article class="movieSynopsis"><?php ___(nl2br($movie['synopsis'])) ?></article>
			
			<div class="movieTrailer">
				<h3>Trailer</h3>
				<iframe src="https://www.youtube.com/embed/<?php __($movie['youtubeId']) ?>" frameborder="0"></iframe>
			</div>
			
			<?php if ($showtimesGrouped): ?>
				<div class="movieShowtime">
					<h3>Movie Showtime</h3>
					<p class="hint">* Click/Tap on one of the timings to book your seats.</p>
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
			<?php endif; ?>
			
			<div class="userFeebacks">
				<h3>User Reviews <?php if ($feedbackAvg) { __('(' . \App\Locale::numberFormat($feedbackAvg, 2) . ')'); } ?></h3>
				
				<?php if ($feedbacks): ?>
					<ol class="feedbackLink">
						<?php foreach ($feedbacks as $feedback): ?>
							<li>
								<h4><?php __($feedback['obfuscatedUsername']) ?></h4>
								<div class="rating">
									<span class="star">
										<?php if ($feedback['rating'] >= 1):?>
											<i class="fa fa-star selected"></i>
										<?php else: ?>
											<i class="fa fa-star-o"></i>
										<?php endif; ?>
									</span>
									
									<span class="star">
										<?php if ($feedback['rating'] >= 2):?>
											<i class="fa fa-star selected"></i>
										<?php else: ?>
											<i class="fa fa-star-o"></i>
										<?php endif; ?>
									</span>
									
									<span class="star">
										<?php if ($feedback['rating'] >= 3):?>
											<i class="fa fa-star selected"></i>
										<?php else: ?>
											<i class="fa fa-star-o"></i>
										<?php endif; ?>
									</span>
									
									<span class="star">
										<?php if ($feedback['rating'] >= 4):?>
											<i class="fa fa-star selected"></i>
										<?php else: ?>
											<i class="fa fa-star-o"></i>
										<?php endif; ?>
									</span>
									
									<span class="star">
										<?php if ($feedback['rating'] >= 5):?>
											<i class="fa fa-star selected"></i>
										<?php else: ?>
											<i class="fa fa-star-o"></i>
										<?php endif; ?>
									</span>
								</div>
								
								<p class="comment"><?php ___(nl2br($feedback['comment'])) ?></p>
							</li>
						<?php endforeach; ?>
					</ol>
				<?php else: ?>
					<div class="noResults">There are no user reviews yet.</div>
				<?php endif; ?>
				
				<?php if ($canPostFeedback): ?>
					<form class="form FeedbackForm AutoValidator" method="post" action="<?php $this->buildLink('movies/review', $movie) ?>" data-reldirect="on">
						<h4>Post Review</h4>

						<div class="ctrlUnit">
							<div class="label"><label>Your Rating</label></div>
							<div class="field">
								<div class="RatingField">
									<span class="star Star"></span>
									<span class="star Star"></span>
									<span class="star Star"></span>
									<span class="star Star"></span>
									<span class="star Star"></span>
									<input type="hidden" name="rating" value="0" class="RatingFieldInput" />
								</div>
							</div>
						</div>

						<div class="ctrlUnit">
							<div class="label"><label for="ctrl_comment">Your Comment</label></div>
							<div class="field"><textarea class="textCtrl" id="ctrl_comment" name="comment" ></textarea></div>
						</div>
						
						<div class="submitUnit">
							<input type="submit" class="button primary" value="Post Review" />
						</div>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>