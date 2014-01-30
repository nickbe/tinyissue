<li onclick="window.location='<?php echo $note->to(); ?>';">

	<div class="tag">
		<label class="label note"><?php echo __('tinyissue.label_note'); ?></label>
	</div>

	<div class="data">
		<span class="note">
			<?php echo str_replace(array("<p>","</p>"), "", \Sparkdown\Markdown('"' . Str::limit($note->body, 60) . '"')); ?>
		</span>

		<?php echo __('tinyissue.was_created_by'); ?>
		<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>

		<span class="time">
			<?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
		</span>
	</div>

	<div class="clr"></div>
</li>
