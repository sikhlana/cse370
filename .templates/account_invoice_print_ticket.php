<?php $this->loadCss('account_invoice_print_ticket.css') ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<ul class="ticketList">
				<?php foreach ($tickets as $ticket): ?>
					<li>
						<div class="price"><span>BDT</span> <?php __(\App\Locale::numberFormat($ticket['ticket_price'])) ?></div>
						<h4>Ticket #<?php __($ticket['ticket_id']) ?></h4>
						<p class="ticketDetails"><span>Movie:</span> <?php __($ticket['title']) ?></p>
						<p class="ticketDetails"><span>Hall Name:</span> <?php __($ticket['hall_name']) ?></p>
						<p class="ticketDetails"><span>Showtime:</span> <?php __($ticket['preparedDate']) ?> @ <?php __($ticket['preparedTime']) ?></p>
						<p class="ticketDetails"><span>Seat Number:</span> <?php __($ticket['seat_number']) ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>