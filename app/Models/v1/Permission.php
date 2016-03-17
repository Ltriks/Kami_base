<?php

namespace App\Models\v1;

class Permission extends BaseModel
{
    protected $table = 'permissions';

    protected $hidden = ['pivot'];
    public  $timestamps   = false;
    protected $guarded = [];
    protected $appends = ['des'];

    public function roles()
    {
        return $this->belongsToMany('App\Models\v1\Role');
    }
    public static function findAll()
    {
        return self::orderBy('id','DESC')->get();
    }

    public function getDesAttribute()
    {
        if ($this->slug && $red = explode(':', $this->slug)) {
            return $red[1];
        }

        return null;
    }
}
