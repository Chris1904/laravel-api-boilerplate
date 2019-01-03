<?php

namespace App\Api\V1\Traits;

use App\Models\User;

trait QueriesUsers
{
    protected $userQuery;

    public function users()
    {
        $this->userQuery = User::query();

        return $this;
    }

    public function add()
    {

    }

    public function fetch()
    {
        return $this->userQuery->get();
    }
}
