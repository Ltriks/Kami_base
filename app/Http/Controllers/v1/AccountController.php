<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Models\v1\Account;
use App\Helper\Token;

class AccountController extends Controller
{
    /** 
     * POST /accounts
     */
    public function create()
    {   
        $rules = [
            'email' => 'required|unique:account|email',
            'password' => 'required|string|min:6|max:20',
            'username' => 'required|unique:account|string|min:4|max:20'
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        if ($model = Account::toCreate($this->validated))
        {
            $token = Token::encode(['uid' => $model->id]);
            return $this->json($model->formatBody(), ['token' => $token]);
        }

        return $this->error(self::UNKNOWN_ERROR, trans('message.unknown_error'));
    }

    /**
     * GET accounts/me
     */
    public function me()
    {   
        extract($request->all());

        $id = Token::authorization();//uid
        
        if ($model = Account::findOne($id)) {
            return $this->json($model->formatBody());
        }

        return $this->error(self::NOT_FOUND);
    }


    /**
     * GET /accounts
     */
    public function index()
    {   
        $model = Account::findAll();
        return $this->json($model->toArray());
    }

    /**
     * GET /accounts/id:
     */
    public function view($id)
    {   
        if ($model = Account::findOne($id)) {
            return $this->json($model->formatBody());
        }

        return $this->error(self::NOT_FOUND);
    }

    /**
     * PUT /accounts/:id
     */
    public function update($id)
    {
        $rules = [
            'old_password' => 'string|min:6|max:20',
            'password'     => 'string|min:6|max:20',
            'email'        => 'email|min:4',
            'role_id'      => 'integer|min:1',
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        extract($this->request->all());

        if (isset($email)) {
            $data['email'] = $email;
        }
        if (isset($role_id)) {
            $data['role_id'] = $role_id;
        }
        
        // if (isset($old_password)) {
        //     if (password_verify($old_password, Account::findOne($id)->pluck('password'))) {
        //         $data['password'] = bcrypt($password);
        //     } else {
        //         return $this->error(self::BAD_REQUEST, trans('message.account.old_password'));
        //     }
        // }
        if (isset($password)) {
            $data['password'] = bcrypt($password);
        }
        
        if (!empty($data)) {
            if ($model = Account::toUpdate($id, $data)) {
                if (isset($data['password'])) {
                    return $this->json($model->formatBody());
                }
                return $this->json($model->formatBody());
            }
        }

        return $this->error(self::UNKNOWN_ERROR);
    }

    /**
     * PUT /accounts/me
     */
    public function updateme()
    {
        $id = Token::authorization();//uid
        return self::update($id,$this->request->all());
    }
}
