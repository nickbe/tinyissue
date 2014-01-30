<div class="blue-box">
	<div class="inside-pad">
		<?php	if	(!$notes):	?>
			<p><?php	echo	__('tinyissue.no_notes');	?></p>
		<?php	else:	?>
			<ul class="issues notes">
				<?php	foreach	($notes	as	$row):	?>
					<li id="note<?php	echo	$row->id;	?>" class="note">
						<div class="insides">
							<?php	if	(Auth::user()->permission('project-modify')):	?>
								<a href="javascript:void(0);" class="edit">Edit</a>
								<a href="javascript:void(0);" class="delete">Delete</a>
							<?php	endif;	?>
							<div class="data">
								<div class="content">
									<div class="note-content">
										<?php	echo	Project\Issue\Comment::format($row->body);	?>
									</div>
									<?php	if	(Auth::user()->permission('project-modify')):	?>
										<div class="note-edit">
											<textarea name="body"><?php	echo	stripslashes($row->body);	?></textarea>
											<div class="right">
												<a href="javascript:void(0);" class="action save"><?php	echo	__('tinyissue.save');	?></a>
												<a href="javascript:void(0);" class="action cancel"><?php	echo	__('tinyissue.cancel');	?></a>
											</div>
										</div>
									<?php	endif;	?>
								</div>

								<div class="info">
									<?php	echo	__('tinyissue.created_by');	?>
									<strong><?php	echo	$row->user->firstname	.	' '	.	$row->user->lastname;	?></strong>
									<?php	echo	Time::age(strtotime($row->created_at));	?>

									<?php	if	(!is_null($row->updated_by)):	?>
										- <?php	__('tinyissue.updated_by');	?> <strong><?php	echo	$row->updated->firstname	.	' '	.	$row->updated->lastname;	?></strong>
										<?php	echo	Time::age(strtotime($row->updated_at));	?>
									<?php	endif;	?>
								</div>
							</div>
						</div>
						<div class="clr"></div>
					</li>
				<?php	endforeach;	?>
			</ul>
		<?php	endif;	?>
	</div>
</div>

<div class="new-note" id="new-note">
	<h4>
		<?php	echo	__('tinyissue.add_note');	?>
	</h4>

	<form method="post" action="">
		<p>
			<textarea name="note"></textarea>
			<a href="http://daringfireball.net/projects/markdown/basics/" target="_blank" style="margin-left: 86%;">Format with Markdown</a>
		</p>

		<p style="margin-top: 10px;">
			<input type="submit" class="button primary" value="<?php	echo	__('tinyissue.save');	?>" />
		</p>

		<?php	echo	Form::hidden('session',	Crypter::encrypt(Auth::user()->id));	?>
		<?php	echo	Form::hidden('project_id',	$project->id);	?>
		<?php	echo	Form::hidden('token',	md5($project->id	.	time()	.	\Auth::user()->id	.	rand(1,	100)));	?>
		<?php	echo	Form::token();	?>
	</form>

</div>