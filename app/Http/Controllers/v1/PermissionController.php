<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use App\Models\v1\Permission;
use App\Models\v1\PermissionRole;
use App\Helper\Token;

class PermissionController extends Controller
{
    /**
     * GET /permissions
     */
    public function index()
    {
        $data = Permission::findAll();
 		return $this->json($data->toArray());
    }

    /**
     * GET /permissions/{id}
     */
    public function view($role_id)
    {
        $data = PermissionRole::findAllByRoleId($role_id);
 		return $this->json($data->toArray());
    }


}