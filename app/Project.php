<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * Models fillable array for mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:F jS, Y',
        'updated_at' => 'datetime:F jS, Y',
    ];

    /**
     * Get the manager of the given project
     *
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the testers of the given project.
     *
     */
    public function projectTesters()
    {
        return $this->belongsToMany(User::class)->wherePivot('type', 'tester');
    }

    /**
     * Get the developers of the given project.
     *
     */
    public function projectDevelopers()
    {
        return $this->belongsToMany(User::class)->wherePivot('type', 'developer');
    }

    /**
     * Get all the projects issues.
     *
     */
    public function issues()
    {
        return $this->hasMany(Issue::class)->orderBy('created_at', 'desc');
    }

    /**
     * Assign Testers to the given project.
     *
     * @param array $ids
     * @return void
     */
    public function assignTesters(array $ids)
    {
        $this->projectTesters()->attach($ids, ['type' => 'tester']);
    }

    /**
     * Detach Testers from the given project.
     *
     * @param array $ids
     * @return void
     */
    public function detachTesters(array $ids)
    {
        $this->projectTesters()->detach($ids);
    }

    /**
     * Assign Developers to the given project.
     *
     * @param array $ids
     * @return void
     */
    public function assignDevelopers(array $ids)
    {
        $this->projectDevelopers()->attach($ids, ['type' => 'developer']);
    }

    /**
     * Detach Developers from the given project.
     *
     * @param array $ids
     * @return void
     */
    public function detachDevelopers(array $ids)
    {
        $this->projectDevelopers()->detach($ids);
    }

    /**
     * Update project status to closed.
     *
     */
    public function close()
    {
        $this->update(['status' => 'closed']);
    }

    /** Update project status to opened.
     *
     */
    public function open()
    {
        $this->update(['status' => 'opened']);
    }

    /**
     * Determine if the project is open.
     *
     */
    public function isOpened()
    {
        return $this->status == 'opened';
    }
}
