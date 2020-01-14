<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    protected $fillable = ['body'];

    /**
     * Get the issue that the folloups belong to.
     *
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * Get the user that the followup belongs to.
     *
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
