<?php

namespace	Project;

class	Note	extends	\Eloquent	{

	public	static	$table	=	'projects_notes';
	public	static	$timestamps	=	true;

	/**
		* @return \User
		*/
	public	function	user()	{
		return	$this->belongs_to('\User',	'created_by');
	}

	/**
		* Create a new note
		*
		* @param  array           $input
		* @param  \Project        $project
		* @return Note|array
		*/
	public	static	function	create_note($input,	$project)	{
		$rules	=	array(
			'note'	=>	'required'
		);

		$validator	=	\Validator::make($input,	$rules);

		if	($validator->fails())	{
			return	array(
				'success'	=>	false,
				'errors'	=>	$validator->errors
			);
		}

		$fill	=	array(
			'created_by'	=>	\Auth::user()->id,
			'project_id'	=>	$project->id,
			'body'	=>	$input['note']
		);

		$note	=	new	static;
		$note->fill($fill);
		$note->save();

		/* Add to user's activity log */
		\User\Activity::add(1,	$project->id,	$note->id);

		return	$note;
	}

	/**
		* Delete a note
		*
		* @param int    $note
		* @return bool
		*/
	public	static	function	delete_note($note)	{
		\User\Activity::where('action_id',	'=',	$note)->delete();

		$note	=	static::find($note);

		if	(!$note)	{
			return	false;
		}

		$note->delete();

		return	true;
	}

}
