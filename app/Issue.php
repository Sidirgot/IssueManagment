<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = ['title', 'description', 'priority', 'status' , 'closed_on', 'closed_by'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:F jS, Y',
        'closed_on' => 'datetime:F jS, Y',
    ];

    /**
     * Get the tester that created the issue.
     *
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'tester_id');
    }

    /**
     * Get all the followups for the given issue.
     *
     */
    public function followups()
    {
        return $this->hasMany(Followup::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the user that clode the issue.
     *
     */
    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    /**
     * Update the status of an issue to closed
     * and set the closed_on date to the current date.
     *
     */
    public function close()
    {
        return $this->update([
            'status' => 'closed',
            'closed_on' => Carbon::now(),
            'closed_by' => auth()->user()->id
        ]);
    }

    /**
     * Scope a query to only return issues marked as opened.
     *
     */
    public function scopeOpened($query)
    {
        return $query->whereStatus('opened');
    }

    /**
     * Scope a query to only return issues marked as closed.
     *
     */
    public function scopeClosed($query)
    {
        return $query->whereStatus('closed');
    }
}
