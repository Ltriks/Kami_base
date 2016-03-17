<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Validator;
use Log;

class Controller extends BaseController
{
    const SUCCESS         = 0;
    const UNKNOWN_ERROR   = 10000;
    const INVALID_SESSION = 10001;
    const EXPIRED_SESSION = 10002;

    const BAD_REQUEST     = 400;
    const UNAUTHORIZED    = 401;
    const NOT_FOUND       = 404;

    public $validated;
    public $request;

    public function __construct() {
        $this->request = app('request');
    }

    /**
     * 验证输入信息
     * @param  array $rules
     * @return response
     */
    public function validateInput($rules)
    {
        $validator = Validator::make($this->request->all(), $rules);
        if ($validator->fails()) {
            return self::error(self::BAD_REQUEST, $validator->messages()->first());
        } else {
            $this->validated = $this->request->only(array_keys($rules));
            return false;
        }
    }

    /**
     * 返回Json数据
     * @param  array   $data
     * @param  array   $ext
     * @param  array   $paged
     * @return json
     */
    public function json($data = false, $ext = false, $paged = false)
    {
        $body['success'] = true;
        
        if (is_array($data)) {
            $body['data'] = $data;
        }

        if (is_array($ext)) {
            $body['ext'] = $ext;
        }

        if (is_array($paged)) {
            $body['paged'] = $paged;
        }

        // 写入日志
        if (env('APP_DEBUG', false)) {

            $debug_id = uniqid();

            Log::debug($debug_id,[
                'LOG_ID'         => $debug_id,
                'IP_ADDRESS'     => $this->request->ip(),
                'REQUEST_URL'    => $this->request->fullUrl(),
                'AUTHORIZATION'  => $this->request->header('Authorization'),
                'REQUEST_METHOD' => $this->request->method(),
                'PARAMETERS'     => $this->request->input(),
                'RESPONSES'      => $body
            ]);

            $body['debug_id'] = $debug_id;
        }

        return response()->json($body);
    }

    /**
     * 返回错误信息
     * @param  integer $code
     * @param  string  $message
     * @return json
     */
    public static function error($code, $message = null)
    {
        switch ($code) {
            case self::UNKNOWN_ERROR:
                $message = trans('message.error.unknown');
                break;
            
            case self::NOT_FOUND:
                $message = trans('message.error.404');
                break;
        }

        $body['success'] = false;
        $body['code'] = $code;
        $body['message'] = $message;

        return response()->json($body);
    }
    
    public function formatPaged($page, $size, $total)
    {
        return [
            'total' => $total,
            'page' => $page,
            'size' => $size,
            'more' => ($total > $page * $size) ? true : false
        ];
    }



}