<?php

namespace App\Models\v1;

class Role extends BaseModel
{
    protected $table = 'roles';
    protected $hidden = [ 'pivot', 'slug'];
    protected $guarded = [];
    public  $timestamps   = false;

    public function users()
    {
        return $this->belongsToMany('App\Models\v1\User');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\v1\Permission');
    }

    public static function findOne($id)
    {
        return self::with('permissions')->where(['id' => $id])->first();
    }

    public static function findAll()
    {
        return self::orderBy('id','DESC')->get();
    }

    public static function toCreate(array $data)
    {
        if ($model = self::create($data)) {
            return self::findOne($model->id);
        };

        return false;
    }

    public static function toUpdate($id, array $data)
    {
        if ($model = self::findOne($id))
        {
            if ($model->update($data)) {
                return self::findOne($model->id);
            }
        }
        return false;
    }


    public static function toDelete($id)
    {
        if ($model = self::findOne($id))
        {
            return $model->delete();
        }
        return false;
    }
    
}
