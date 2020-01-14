<?php

namespace App\Traits;

trait UserQueryScopes
{
       /**
     * Scope query to only include users with role tester and developer.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyTestersAndDevelopers($query)
    {
        return $query->whereIn('role',['tester','developer']);
    }

    /**
     * Scope query to only include users with role tester.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTesters($query)
    {
        return $query->whereRole('tester');
    }

     /**
     * Scope query to only include users with role developer.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeDevelopers($query)
    {
        return $query->whereRole('developer');
    }

    /**
     * Scope query to exclude an array of given ids.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPartOfTheProject($query, array $partOfTheProject)
    {
        return $query->whereNotIn('id', $partOfTheProject);
    }
}