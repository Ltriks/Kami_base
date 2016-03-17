<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use App\Models\v1\SysLog;
use Input;

class SyslogController extends Controller
{

    /**
     * GET /syslog
     */
    public function index()
    {
        $data = SysLog::findAll();
 		return $this->json($data->toArray());
    }

    /**
     * GET /syslog/{id}
     */
    public function view($role_id)
    {
        $data = PermissionRole::findAllByRoleId($role_id);
 		return $this->json($data->toArray());
    }

    /**
     * GET /:model/search
     */
    public function search(Request $request)
    {
        $rules = [
            'q'        => 'array',
            'order'    => 'array',
            'page'     => 'integer|min:1',
            'per_page' => 'integer|min:1',
        ];
        if ($error = $this->validateInput($rules,$request)) {
            return $error;
        }
        $order = false;
        $q = false;
        extract($request->all());
        $model = 'syslog';
        $modelName = studly_case(str_singular($model));
        $className = "App\Models\\v1\\{$modelName}";

        if (isset($page) && isset($per_page) && $page && $per_page) {
            $data = $className::search($q,$order)->paginate($per_page)->toArray();
            return $this->json($data['data'], false, $this->formatPaged($page, $per_page, $data['total']));
        }   

        return $this->json($className::search($q,$order)->get()->toArray());
    }

}