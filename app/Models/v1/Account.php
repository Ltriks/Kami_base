<?php

namespace App\Models\v1;

use Cache;
use App\Helper\Helper;
class Account extends BaseModel
{
    protected $table = 'account';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string'
    ];
    
    protected $hidden = ['password', 'role_id'];

    public static function findOne($id)
    {
        return self::with('role')->where(['id' => $id])->first();
    }

    public static function findAll()
    {
        return self::with('role')->get();
    }

    public static function findByEmail($email)
    {
        return self::with('role')->where(['email' => $email])->first();
    }

    public static function findByUsername($username)
    {
        return self::with('role')->where(['username' => $username])->first();
    }

    public static function findByRoleId($role_id)
    {
        return self::with('role')->where(['role_id' => $role_id])->first();
    }

    public static function findBySession($session)
    {
        if ($user_id = Cache::get('backend_session:' . $session)) {
            return self::findOne($user_id);
        }

        return false;
    }

    public static function toCreate(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = 1; 

        if ($model = self::create($data)) {
            return self::findOne($model->id);
        };

        return false;
    }

    public static function toUpdate($id, array $data)
    {   
        if ($model = self::findOne($id)) {
            if ($model->update($data))
            {
                return self::findOne($id);
            }
        }
        return false;
    }


    public static function toDelete($id)
    {
        if (self::findOne($id)->delete())
        {
            return true;
        }
        return false;
    }

    public static function validatePassword($username, $password)
    {
        if ($model = self::findByUsername($username)) {
            if (password_verify($password, $model->password)) {
                return $model;
            }
        }
        return false;
    }

    public static function search($params,$order)
    {   
        if ($params) {
            foreach ($params as $key => $value) {
                if (Helper::endWith($value,':=')) {
                    if (!isset($model)) {
                        $model = self::where($key, $value)->with('role');
                    } else {
                        $model->where($key, $value)->with('role');
                    }
                    
                } else {
                    if (!isset($model)) {
                        $model = self::where($key, 'like', '%'.$value.'%')->with('role');
                    } else {
                        $model->where($key, 'like', '%'.$value.'%')->with('role');
                    }
                }
            }
        }else{
            $model = self::where('id','>',0)->with('role');
        }
        if (!$order) {
            $order = ['id' => 'DESC'];
        }

        return $model->orderBy(key($order),$order[key($order)]);
    }
    /*
    |--------------------------------------------------------------------------
    | ACL Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Checks a Permission
     *
     * @param  String permission Slug of a permission (i.e: manage_user)
     * @return Boolean true if has permission, otherwise false
     */

    public function can($permission = null)
    {
        return !is_null($permission) && $this->checkPermission($permission);
    }

 
    /**
     * Check if the permission matches with any permission user has
     *
     * @param  String permission slug of a permission
     * @return Boolean true if permission exists, otherwise false
     */
    protected function checkPermission($perm)
    {
        $permissions = $this->getAllPernissionsFormAllRoles();
        $permissionArray = is_array($perm) ? $perm : [$perm];
        return count(array_intersect($permissions, $permissionArray));
    }

    /**
     * Get all permission slugs from all permissions of all roles
     *
     * @return Array of permission slugs
     */
    protected function getAllPernissionsFormAllRoles()
    {
        $permissionsArray = [];
        $permissions = $this->role->toArray();
        foreach ($permissions['permissions'] as $value) {
            $permissionsArray[] = $value['slug'];
        }
        return $permissionsArray;
    }

    public function role()
    {
        return $this->belongsTo('App\Models\v1\Role')->with('permissions');
    }
}
