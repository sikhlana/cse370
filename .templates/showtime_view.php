<?php $containerParams['title'] = 'Seat Selection: ' . $movie['title'] . ' - ' . $hall['hall_name'] ?>
<?php $this->loadCss('movie_view.css') ?>
<?php $this->loadCss('showtime_view.css') ?>
<?php $this->loadJs('js/showtime_view.js') ?>

<div class="container movieContainer">
	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<img class="moviePoster img-responsive" src="<?php __($movie['posterUrl']) ?>" />
		</div>
		
		<div class="col-xs-12 col-sm-8">
			<h1 class="toLeft"><?php __($movie['title']) ?></h1>
			<div class="hallInfo">
				<div class="pairsJustified">
					<dl>
						<dt>Showtime</dt><dd><?php __($showtime['preparedDate']) ?> @ <?php __($showtime['preparedTime']) ?></dd>
					</dl>
					<dl>
						<dt>Hall Name</dt><dd><?php __($hall['hall_name']) ?></dd>
					</dl>
					<dl>
						<dt>Hall Type</dt><dd><?php __($hall['hall_type']) ?></dd>
					</dl>
					<dl>
						<dt>Number of Seats</dt><dd><?php __(\App\Locale::numberFormat($hall['row_count'] * $hall['column_count'])) ?> (<?php __($hall['row_count']) ?> x <?php __($hall['column_count']) ?>)</dd>
					</dl>
					<dl>
						<dt>Ticket Price</dt><dd>BDT 400 (Regular)<br />BDT 600 (Premium)</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container" style="padding-top: 20px;">
	<div class="row">
		<div class="col-xs-12">
			<h1>Seat Selection</h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="screen">Screen</div>
		</div>
		
		<div class="col-xs-12">
			<div class="SeatSelection" data-link="<?php $this->buildLink('movies/schedule/select-seat', $showtime) ?>">
				<?php $i = 0; foreach ($seatMatrix as $row): ?>
					<div class="seatRow">
						<?php $j = 0; foreach ($row as $seat): ?>
							<button class="seat <?php __($seat['disabled'] ? 'disabled' : '') ?> <?php __($seat['selected'] ? 'selected' : '') ?> <?php __($seat['seat_type']) ?>" data-ticket-grade="<?php __($seat['seat_type']) ?>" data-ticket-price="<?php __($seat['seat_type'] == 'premium' ? 600 : 400) ?>" data-seat-number="<?php __($seat['number']) ?>" style="width: <?php __(96 / $hall['column_count']) ?>%;"><?php __($seat['number']) ?></button>
						
							<?php if (in_array($j, $splits['column'])): ?>
								<div class="verticalWalkway"></div>
							<?php endif; ?>
						<?php $j++; endforeach; ?>
					</div>
					
					<?php if (in_array($i, $splits['row'])): ?>
						<div class="horizontalWalkway"></div>
					<?php endif; ?>
				<?php $i++; endforeach; ?>
			</div>
			
			<div class="SeatInformation">
				<a class="button green" href="<?php $this->buildLink('account/checkout') ?>">Purchase Tickets</a>
			</div>
		</div>
	</div>
</div>