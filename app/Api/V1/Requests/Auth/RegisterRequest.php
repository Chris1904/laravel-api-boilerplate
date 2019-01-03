<?php

namespace App\Api\V1\Requests\Auth;

use Config;
use Dingo\Api\Http\FormRequest;
use App\Api\V1\Traits\QueriesUsers;

class RegisterRequest extends FormRequest
{
    use QueriesUsers;

    public function rules()
    {
        return Config::get('boilerplate.sign_up.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
