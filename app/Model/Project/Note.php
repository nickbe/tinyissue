<?php

/*
 * This file is part of the Tinyissue package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tinyissue\Model\Project;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Tinyissue\Model;
use Tinyissue\Model\Traits\Project\Note\CrudTrait;
use Tinyissue\Model\Traits\Project\Note\RelationTrait;

/**
 * Note is model class for project notes.
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 * @property int           $id
 * @property int           $project_id
 * @property int           $created_by
 * @property string        $body
 * @property Model\Project $project
 * @property Model\User    $createdBy
 */
class Note extends BaseModel
{
    use CrudTrait,
        RelationTrait;

    /**
     * Timestamp enabled.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Name of database table.
     *
     * @var string
     */
    protected $table = 'projects_notes';

    /**
     * List of allowed columns to be used in $this->fill().
     *
     * @var array
     */
    protected $fillable = ['project_id', 'created_by', 'body'];

    /**
     * Generate a URL for the project note.
     *
     * @return string
     */
    public function to()
    {
        return \URL::to('project/' . $this->project->id . '/notes#note' . $this->id);
    }
}
