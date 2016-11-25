<?php $this->loadCss('showtime_list_item.css') ?>

<li class="hallItem">
	<h4 class="hallName"><?php __($hall['hall_name']) ?></h4>
	<ol class="timings">
		<?php foreach ($hall['showtimes'] as $showtime): ?>
			<li><a class="button small orange" href="<?php $this->buildLink('movies/schedule', $showtime) ?>"><?php __($showtime['preparedTime']) ?></a></li>
		<?php endforeach; ?>
	</ol>
</li>