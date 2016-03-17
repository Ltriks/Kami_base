<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Exception\HttpResponseException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\Helper\Token;

use App\Models\v1\User;
use App\Models\v1\Account;
use App\Models\v1\Role;

class AuthController extends Controller {

    /**
     * POST /login
     */
    public function login()
    {
        $rules = [
            'username' => 'required|string|min:4|max:20',
            'password' => 'required|min:6|max:20'
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        extract($this->request->all());
        if ($model = Account::validatePassword($username, $password)) {
            $token = Token::encode(['uid' => $model->id]);
            return $this->json(['token' => $token],$model->formatBody());
        }
        
        return $this->error(self::BAD_REQUEST, trans('message.account.failed'));
    }


    /**
     * POST /logout
     */
    public function logout()
    {   
        return $this->json([]);
    }
}
