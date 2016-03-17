<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use App\Models\v1\Role;
use App\Models\v1\PermissionRole;
use App\Models\v1\Account;

class RoleController extends Controller
{
    public function create()
    {   
        $rules = [
            'name' => 'required|unique:.roles|string|min:1'
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        if ($model = Role::toCreate($this->request->all()))
        {
            return $this->json($model->formatBody());
        }

        return $this->error(self::UNKNOWN_ERROR);
    }



    /**
     * GET /roles
     */
    public function index()
    {
        $model = Role::findAll();
 		return $this->json($model->toArray());
    }


    /**
     * GET /roles/:id
     */
    public function view($id)
    {   
        if ($model = Role::findOne($id)) {
            return $this->json($model->formatBody());
        }

        return $this->error(self::NOT_FOUND);
    }

    
    /**
     * PUT /roles/:id
     */
    public function update($id)
    {
        $rules = [
            'name' => 'required|string|min:1'
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        if ($model = Role::toUpdate($id, $this->validated)) {
            return $this->json($model->formatBody());
        }
        return $this->error(self::UNKNOWN_ERROR);
    }

    /**
     * DELETE /roles/:id
     */
    public function destory($id)
    {
        if ($model = Role::findOne($id)) {
            if (!$data = Account::findByRoleId($id)) {
                $model->delete();
            }else{
                return $this->error(self::UNKNOWN_ERROR);
            }
        }

        return $this->json([]);
    }

    /**
     * PUT /roles/{id}/permissions
     */
    public function changepermissions($roles_id)
    {
        $rules = [
            'permissions' => 'required|array'
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        extract($this->request->all());

        if ($model = PermissionRole::toUpdate($roles_id,$permissions)) {
            return $this->json([]);
        }
        return $this->error(self::UNKNOWN_ERROR);
    }
    
}