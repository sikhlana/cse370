<?php $containerParams['title'] = $showtime['showtime_id'] ? 'Edit Showtime' : 'Add New Showtime' ?>
<?php $this->loadCss('admin.css') ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1><?php ___($showtime['showtime_id'] ? 'Edit Showtime' : 'Add New Showtime') ?></h1>
		</div>
	</div>
</div>

<div class="container section">
	<div class="row">
		<div class="col-xs-12">
			<form class="AutoValidator form" method="post" action="<?php $this->buildLink('admin/schedule/save', $showtime) ?>" data-redirect="on">
                <div class="ctrlUnit">
                    <div class="label"><label for="ctrl_movie_id">Movie:</label></div>
                    <div class="field">
                        <select id="ctrl_movie_id" name="movie_id" class="textCtrl">
                            <?php foreach ($movies as $item): ?>
                                <option<?php ___($item['selected'] ? ' selected="selected"' : '') ?> value="<?php __($item['value']) ?>"><?php __($item['label']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="ctrlUnit">
                    <div class="label"><label for="ctrl_hall_id">Hall:</label></div>
                    <div class="field">
                        <select id="ctrl_hall_id" name="hall_id" class="textCtrl">
                            <?php foreach ($halls as $item): ?>
                                <option<?php ___($item['selected'] ? ' selected="selected"' : '') ?> value="<?php __($item['value']) ?>"><?php __($item['label']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
				<div class="ctrlUnit">
					<div class="label"><label for="ctrl_showtime_date">Date:</label></div>
					<div class="field">
                        <div class="fieldPart" style="width: 60%;">
                            <input type="date" id="ctrl_showtime_date" class="textCtrl" name="showtime_date" value="<?php __(\App\Locale::date($showtime['showtime_date'], 'Y-m-d')) ?>" />
                        </div><div class="fieldPart" style="width: 40%;">
                            <select id="ctrl_showtime_time" class="textCtrl" name="showtime_time">
                                <?php foreach ($timing as $item): ?>
                                    <option<?php ___($item['selected'] ? ' selected="selected"' : '') ?> value="<?php __($item['value']) ?>"><?php __($item['label']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
				</div>
				
				<div class="submitUnit">
					<button class="button primary" type="submit">Save Showtime</button>
				</div>
			</form>
		</div>
	</div>
</div>