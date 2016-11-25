<?php $containerParams['title'] = 'Account' ?>
<?php $this->loadCss('account.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1>Dashboard</h1>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-4 col-sm-3">
			<ul class="accountLink">
				<li class="<?php __($minorSection == 'dashboard' ? 'selected' : '') ?>"><a href="<?php $this->buildLink('account') ?>">Dashboard</a></li>
				<li class="<?php __($minorSection == 'billing' ? 'selected' : '') ?>"><a href="<?php $this->buildLink('account/billing') ?>">Billing Information</a></li>
			</ul>
		</div>
		
		<div class="col-xs-8 col-sm-9">
			<div class="movieWishlist">
				<h3>Your Wishlist</h3>
				<?php if ($wishlist): ?>
					<ul class="wishlist">
						<?php foreach ($wishlist as $movie): ?>
							<li>
								<img class="moviePoster" src="<?php __($movie['thumbUrl']) ?>" />
								<div class="movieWrapper">
									<h4><a href="{xen:link movies, $movie}"><?php __($movie['title']) ?></a></h4>
									<p><?php ___(nl2br($movie['synopsis'])) ?></p>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<div class="noResults">Your wishlist is empty.</div>
				<?php endif; ?>
			</div>
			
			<div class="pastOrders">
				<h3>Past Orders</h3>
				<?php if ($orders): ?>
					<ol class="orderList">
						<?php foreach ($orders as $order): ?>
							<li>
								<div class="orderStatus <?php __($order['invoice_status']) ?>"><?php __($order['invoice_status']) ?></div>
								<h4>Order #<?php __($order['order_id']) ?></h4>
								<p class="orderDetails"><span>Order Date:</span> <?php __(\App\Locale::dateTime($order['order_date'], 'absolute')) ?></p>
								<p class="orderDetails"><a href="<?php $this->buildLink('account/invoices/print/tickets', $order) ?>">Print Tickets</a></p>
							</li>
						<?php endforeach; ?>
					</ol>
				<?php else: ?>
					<div class="noResults">There are no orders yet.</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>