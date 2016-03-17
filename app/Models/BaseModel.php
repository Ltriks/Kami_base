<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const INACTIVE = 0;
    const ACTIVE   = 1;
    
    public static function findOne($id)
    {
        return self::find($id);
    }

    public static function findAll()
    {
        return self::get();
    }

    public static function toCreate(array $data)
    {
        if ($model = self::create($data)) {
            return self::find($model->id);
        };

        return false;
    }

    public static function toUpdate($id, array $data)
    {   
        if ($model = self::find($id)) {
            if ($model->update($data))
            {
                return self::find($id);
            }
        }
        return false;
    }

    public static function toDelete($id)
    {
        if ($model = self::find($id)) {
            $model->delete();
        }
        return false;
    }

    /**
     * 格式化Body
     * @return array
     */
    public function formatBody()
    {
        return $this->toArray();
    }


}