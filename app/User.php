<?php

namespace App;

use App\Traits\RoleCheck;
use App\Traits\UserQueryScopes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use RoleCheck;
    use UserQueryScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Bcrypt the users password uppon creation.
     *
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Get the projects of the given user.
     *
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'manager_id')->orderBy('created_at', 'desc');
    }

    /**
     * Get all the projects of the given tester.
     *
     */
    public function testerProjects()
    {
        return $this->belongsToMany(Project::class)->whereStatus('opened')->wherePivot('type', 'tester');
    }

    /**
     * Get all the projects of the given developer.
     *
     */
    public function developerProjects()
    {
        return $this->belongsToMany(Project::class)->whereStatus('opened')->wherePivot('type', 'developer');
    }

    /**
     * Get the issues of the given tester.
     *
     */
    public function issues()
    {
        return $this->hasMany(Issue::class, 'tester_id');
    }

    /**
     * Get all the users followups.
     *
     */
    public function followups()
    {
        return $this->hasMany(Followup::class);
    }

    /**
     * Determine if the current user is the authenticated user.
     *
     * @return boolean
     */
    public function isTheCurrentAuthenticatedUser()
    {
        return $this->id == auth()->user()->id;
    }

    /**
     * Determine if the user can access the given project.
     *
     * @param  \App\Project $project
     * @return boolean
     */
    public function canAccessProject(Project $project)
    {
        return $this->projects->contains($project);
    }

    /**
     * Determine if the user can access the given issue.
     *
     * @param  \App\Issue $issue
     * @return boolean
     */
    public function canAccessIssue(Issue $issue)
    {
        return $this->issues->contains($issue);
    }

    /**
     * Determine if the user has access to the project.
     *
     * @param \App\Project $project
     * @return boolean
     */
    public function accessibleProjects(Project $project)
    {
        return $this->testerProjects->contains($project)
                    || $this->developerProjects->contains($project);
    }

    /**
     * Determine if the user can access the given followup.
     *
     * @param  \App\Followup $followup
     * @return boolean
     */
    public function canAccessFollowup(Followup $followup)
    {
        return $this->followups->contains($followup);
    }

}
