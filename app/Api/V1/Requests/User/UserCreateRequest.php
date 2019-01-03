<?php

namespace App\Api\V1\Requests\User;

use App\Api\V1\Traits\QueriesUser;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    use QueriesUser;

    public function rules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }
}
