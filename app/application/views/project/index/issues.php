<div class="blue-box">
	<div class="inside-pad">

		<?php if(!$issues): ?>
		<p><?php echo __('tinyissue.no_issues'); ?></p>
		<?php else: ?>
		<div class="issue-quote">
			<strong><?php echo __('tinyissue.total_quote'); ?>:</strong><span><?php echo Time::time_duration(Project::current()->total_quote($issues)); ?></span>
		</div>
		<ul class="issues">
			<?php foreach($issues as $row):  ?>
			<li>
				<a href="" class="comments"><?php echo $row->comment_count(); ?></a>
				<a href="" class="id">#<?php echo $row->id; ?></a>
				<div class="data">
					<a href="<?php echo $row->to(); ?>"><?php echo $row->title; ?></a>
					<div class="info">
						<?php echo __('tinyissue.created_by'); ?>
						<strong><?php echo $row->user->firstname . ' ' . $row->user->lastname; ?></strong>
						<?php if(is_null($row->updated_by)): ?>
							<?php echo Time::age(strtotime($row->created_at)); ?>
						<?php endif; ?>

						<?php if(!is_null($row->updated_by)): ?>
							- <?php echo __('tinyissue.updated_by'); ?>
							<strong><?php echo $row->updated->firstname . ' ' . $row->updated->lastname; ?></strong>
							<?php echo Time::age(strtotime($row->updated_at)); ?>
						<?php endif; ?>

						<?php if($row->assigned_to != 0): ?>
							- <?php echo __('tinyissue.assigned_to'); ?>
							<strong><?php echo $row->assigned->firstname . ' ' . $row->assigned->lastname; ?></strong>
						<?php endif; ?>

						<?php if ($row->time_quote > 0): ?>
						- <?php echo __('tinyissue.time_quote'); ?> <strong><?php echo Time::time_duration($row->time_quote); ?></strong>
						<?php endif; ?>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

	</div>
</div>
