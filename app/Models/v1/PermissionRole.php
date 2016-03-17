<?php

namespace App\Models\v1;

class PermissionRole extends BaseModel
{
    protected $table = 'permission_role';

    protected $hidden = ['pivot'];
    protected $guarded = [];
    public  $timestamps   = false;

    public static function findAllByRoleId($role_id)
    {
        return self::where('role_id',$role_id)->orderBy('id','DESC')->get();
    }


    public static function toUpdate($role_id, array $permissions)
    {
        self::where('role_id',$role_id)->delete();
        foreach ($permissions as $key => $permission) {
    		self::insert(['role_id' => $role_id,'permission_id' => $permission]);
    	}
        return true;
    }

}
