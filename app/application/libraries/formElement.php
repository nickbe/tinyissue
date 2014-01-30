<?php

class	FormElement	{

	/**
		* Render form element to add time (hours:minutes:seconds)
		*
		* @param int $seconds
		* @return string
		*/
	public	static	function	time_input($seconds	=	0)	{
		$periods	=	array(
			'h'	=>	array(
				'label'	=>	__('tinyissue.hours'),
				'value'	=>	floor($seconds	/	3600),
			),
			'm'	=>	array(
				'label'	=>	__('tinyissue.minutes'),
				'value'	=>	(($seconds	/	60)	%	60),
			),
			's'	=>	array(
				'label'	=>	__('tinyissue.seconds'),
				'value'	=>	($seconds	%	60),
			),
		);

		$output	=	'<ul class="time-element">';
		foreach	($periods	as	$key	=>	$period)	{
			$value	=	$period['value']	>	0	?	$period['value']	:	'';
			$output	.=	'<li class="time-'	.	$key	.	'">';
			$output	.=	'<input type="text" name="time_quote['	.	$key	.	']" value="'	.	$value	.	'" />';
			$output	.=	'<span>'	.	$period['label']	.	'</span>';
		}
		$output	.=	'</ul>';

		return	$output;
	}

}
