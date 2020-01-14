<?php

namespace App\Traits;

trait RoleCheck
{
    /**
     * Determine if the current user is a manager.
     *
     */
    public function isManager()
    {
        return $this->role === 'manager' ? true : false;
    }

    /**
     * Determine if the current user is a tester.
     *
     */
    public function isTester()
    {
        return $this->role === 'tester' ? true : false;
    }

    /**
     * Determine if the current user is a developer.
     *
     */
    public function isDeveloper()
    {
        return $this->role === 'developer' ? true : false;
    }
}