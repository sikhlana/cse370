<?php $containerParams['title'] = 'Checkout' ?>
<?php $this->loadCss('account_checkout.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Checkout</h1>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-8">
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
		
		<div class="col-xs-4">
			<div class="checkoutDetails">
				<div class="pairsJustified">
					<dl>
						<dt>Number of Tickets</dt><dd><?php __(\App\Locale::numberFormat(count($tickets))) ?></dd>
					</dl>
					<dl>
						<dt>Total Price</dt><dd>BDT <?php __(\App\Locale::numberFormat($totalPrice)) ?></dd>
					</dl>
				</div>
				
				<div class="text-center">
					<a class="button primary" href="<?php $this->buildLink('account/checkout/pay') ?>">Buy Now</a>
					<a class="button red DeleteConfirm" href="<?php $this->buildLink('account/checkout/cancel') ?>">Cancel Order</a>
				</div>
			</div>
		</div>
	</div>
</div>