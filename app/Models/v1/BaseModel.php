<?php 
/**
 * @authors XiaoGai (xiaogai@geek-zoo.com)
 * Copyright (c) 2015-2016, Geek Zoo Studio
 * http://www.geek-zoo.com
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model 
{
    const INACTIVE = 0;
    const ACTIVE   = 1;
    const DELETED  = 2;
    
    /**
     * 格式化Body
     * @return array
     */
    public function formatBody()
    {
        return $this->toArray();
    }


    /**
     * 万能搜索
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
     public static function search($params,$order)
    {   
        if ($params) {
            foreach ($params as $key => $value) {
                if (endWith($value,':=')) {
                    if (!isset($model)) {
                        $model = self::where($key, $value);
                    } else {
                        $model->where($key, $value);
                    }
                    
                } else {
                    if (!isset($model)) {
                        $model = self::where($key, 'like', '%'.$value.'%');
                    } else {
                        $model->where($key, 'like', '%'.$value.'%');
                    }
                }
            }
        }else{
            $model = self::where('id','>',0);
        }
        if (!$order) {
            $order = ['id' => 'DESC'];
        }

        return $model->orderBy(key($order),$order[key($order)]);
    }
}