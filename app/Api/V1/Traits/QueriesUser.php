<?php

namespace App\Api\V1\Traits;

use App\Models\User;

trait QueriesUser
{
    protected $userQuery;

    public function users()
    {
        $this->userQuery = User::query();

        return $this;
    }
}
