<?php
/**
 * @authors XiaoGai (xiaogai@geek-zoo.com)
 * Copyright (c) 2015-2016, Geek Zoo Studio
 * http://www.geek-zoo.com
 */

namespace App\Models\v1;
  
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use GenTux\Jwt\JwtPayloadInterface;

class User extends BaseModel implements JwtPayloadInterface
{
    //use EntrustUserTrait; // add this trait to your user model

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];


    public function getPayload()
    {
        return [
            'sub' => $this->id,
            'exp' => time() + 7200,
            'context' => [
                'email' => $this->email,
                'user_id' => $this->id
            ]
        ];
    }
}