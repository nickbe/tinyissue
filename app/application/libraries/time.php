<?php

class Time {

	/**
	 * Displays the timestamp's age in human readable format
	 *
	 * @param  int $timestamp
	 * @return string
	 */
	public static function age($timestamp)
	{
		$timestamp = (int) $timestamp;
		$difference = time() - $timestamp;
		$periods = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
		$lengths = array('60','60','24','7','4.35','12','10');

		for($j = 0; $difference >= $lengths[$j]; $j++)
		{
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1)
		{
			$periods[$j] .= 's';
		}

		return $difference . ' ' . $periods[$j] . ' ago';
	}

	 /**
			* Convert seconds into time duration format
			*
			* @param int $value
			* @return string
			*/
		public	static	function	time_duration($value)	{
			$hours	=	floor($value	/	3600);
			$minutes	=	($value	/	60)	%	60;
			$seconds	=	$value	%	60;

			$output	=	'';
			$seperatorChar	=	', ';
			$seperator	=	'';
			if	($hours	>	0)	{
				$output	.=	$hours	.	' '	.	__('tinyissue.short_hours');
				$seperator	=	$seperatorChar;
			}
			if	($minutes	>	0)	{
				$output	.=	$seperator	.	$minutes	.	' '	.	__('tinyissue.short_minutes');
				$seperator	=	$seperatorChar;
			}
			if	($seconds	>	0)	{
				$output	.=	$seperator	.	$seconds	.	' '	.	__('tinyissue.short_seconds');
			}
			return	$output;
		}

}