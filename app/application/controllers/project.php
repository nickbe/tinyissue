<?php

class Project_Controller extends Base_Controller {

	public $layout = 'layouts.project';

	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'project');
		$this->filter('before', 'permission:project-modify')->only(array('edit', 'edit_note', 'delete_note'));
	}

	/**
	 * Display activity for a project
	 * /project/(:num)
	 *
	 * @return View
	 */
	public function get_index()
	{
		return $this->layout->nest('content', 'project.index', array(
			'page' => View::make('project/index/activity', array(
				'project' => Project::current(),
				'activity' => Project::current()->activity(10)
			)),
			'active' => 'activity',
			'notes_count' => Project::current()->notes()
				 ->count(),
			'open_count' => Project::current()->issues()
				 ->where('status', '=', 1)
				 ->count(),
			'closed_count' => Project::current()->issues()
				 ->where('status', '=', 0)
				 ->count(),
			'assigned_count' => Project::current()->count_assigned_issues()
		));
	}

	/**
	 * Display issues for a project
	 * /project/(:num)
	 *
	 * @return View
	 */
	public function get_issues()
	{
		$status = Input::get('status', 1);

		return $this->layout->nest('content', 'project.index', array(
			'page' => View::make('project/index/issues', array(
				'issues' => Project::current()->issues()
				->where('status', '=', $status)
				->order_by('updated_at', 'DESC')
				->get(),
			)),
			'active' => $status == 1 ? 'open' : 'closed',
			'notes_count' => Project::current()->notes()
				->count(),
			'open_count' => Project::current()->issues()
				->where('status', '=', 1)
				->count(),
			'closed_count' => Project::current()->issues()
				->where('status', '=', 0)
				->count(),
			'assigned_count' => Project::current()->count_assigned_issues()
		));
	}

	/**
	 * Display issues assigned to current user for a project
	 * /project/(:num)
	 *
	 * @return View
	 */
	public function get_assigned()
	{
		$status = Input::get('status', 1);

		return $this->layout->nest('content', 'project.index', array(
			'page' => View::make('project/index/issues', array(
				'issues' => Project::current()->issues()
					->where('status', '=', $status)
					->where('assigned_to', '=', Auth::user()->id)
					->order_by('updated_at', 'DESC')
					->get(),
			)),
			'active' => 'assigned',
			'notes_count' => Project::current()->notes()
				->count(),
			'open_count' => Project::current()->issues()
				->where('status', '=', 1)
				->count(),
			'closed_count' => Project::current()->issues()
				->where('status', '=', 0)
				->count(),
			'assigned_count' => Project::current()->count_assigned_issues()
		));
	}

	/**
	 * Edit the project
	 * /project/(:num)/edit
	 *
	 * @return View
	 */
	public function get_edit()
	{
		return $this->layout->nest('content', 'project.edit', array(
			'project' => Project::current()
		));
	}

	public function post_edit()
	{
		/* Delete the project */
		if(Input::get('delete'))
		{
			Project::delete_project(Project::current());

			return Redirect::to('projects')
				->with('notice', __('tinyissue.project_has_been_deleted'));
		}

		/* Update the project */
		$update = Project::update_project(Input::all(), Project::current());

		if($update['success'])
		{
			return Redirect::to(Project::current()->to('edit'))
				->with('notice', __('tinyissue.project_has_been_updated'));
		}

		return Redirect::to(Project::current()->to('edit'))
			->with_errors($update['errors'])
			->with('notice-error', __('tinyissue.we_have_some_errors'));
	}

	/**
	 * Post a note to a project
	 *
	 * @return Redirect
	 */
	public function post_notes()
	{
		if(!Input::get('note'))
		{
			return Redirect::to(Project\Note::current()->to() . '#new-note')
				->with('notice-error', __('tinyissue.you_put_no_note'));
		}

		$note = \Project\Note::create_note(Input::all(), Project::current());

		return Redirect::to(Project::current()->to('notes') . '#note' . $note->id)
			->with('notice', __('tinyissue.your_note_added'));
	}

	/**
	 * Display notes for a project
	 * /project/(:num)
	 *
	 * @return View
	 */
	public function get_notes()
	{
		return $this->layout->nest('content', 'project.index', array(
			'page' => View::make('project/index/notes', array(
				'notes' => Project::current()->notes()
				->order_by('updated_at', 'DESC')
				->get(),
				'project' => Project::current(),
			)),
			'notes_count' => Project::current()->notes()
				->count(),
			'open_count' => Project::current()->issues()
				->where('status', '=', 1)
				->count(),
			'closed_count' => Project::current()->issues()
				->where('status', '=', 0)
				->count(),
			'assigned_count' => Project::current()->count_assigned_issues(),
				'active' => 'notes',
		));
	}

	/**
	 * Update / Edit a note
	 * /project/(:num)/edit_note
	 *
	 * @request ajax
	 * @return string
	 */
	public function post_edit_note()
	{
		if(Input::get('body'))
		{
			Project\Note::find(str_replace('note', '', Input::get('id')))
					->fill(array('body' => Input::get('body')))
					->save();

			return Project\Issue\Comment::format(Input::get('body'));
		}
	}

	/**
	 * Delete a note
	 * /project/(:num)/delete_note
	 *
	 * @return Redirect
	 */
	public function get_delete_note()
	{
		Project\Note::delete_note(str_replace('note', '', Input::get('delete')));

		return true;
	}

}