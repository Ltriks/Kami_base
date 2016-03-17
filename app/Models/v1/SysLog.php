<?php

namespace App\Models\v1;

class SysLog extends BaseModel
{
    protected $table = 'syslog';

    protected $hidden = [];
    public  $timestamps   = true;
    protected $guarded = [];
    // protected $appends = ['des'];


    public static function findAll()
    {
        return self::orderBy('id','DESC')->get();
    }

    public static function toCreate($user_id,$action_id,$action)
    {
        if (self::create([
                        'user_id' => $user_id,
                        'action_id' => $action_id,
                        'action' => $action,
                    ])) {

            return true;
        }
        return false;

    }

    // public function getDesAttribute()
    // {
    //     if ($this->slug && $red = explode(':', $this->slug)) {
    //         return $red[1];
    //     }

    //     return null;
    // }
}
