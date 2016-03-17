<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helper\Token;

use App\Models\v1\Example;

class ExampleController extends Controller
{
    /**
     * GET /examples
     */
    public function index()
    {
        $rules = [
            'page' => 'required|integer|min:1',
            'per_page' => 'required|integer'
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        extract($this->request->all());

        $data = Example::paginate($per_page)->toArray();

        $ext = ['key' => 'value'];
    
        return $this->json($data['data'], $ext, $this->formatPaged($page, $per_page, $data['total']));
    }

    /**
     * GET /examples/:id
     */
    public function view($id)
    {
        if (!$model = Example::findOne($id)) {
            return $this->error(self::NOT_FOUND);
        }
        return $this->json($model->formatBody());
    }

    /**
     * POST /examples
     */
    public function create()
    {
        $rules = [
            'test' => 'required|string|min:1'
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        if ($model = Example::toCreate($this->validated))
        {
            return $this->json($model->formatBody());
        }

        return $this->error(self::UNKNOWN_ERROR);
    }

    /**
     * PUT /examples/:id
     */
    public function update($id)
    {
        $rules = [
            'test' => 'required|string|min:1'
        ];

        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        if ($model = Example::toUpdate($id, $this->validated))
        {
            return $this->json($model->formatBody());
        }

        return $this->error(self::UNKNOWN_ERROR);
    }

    /**
     * DELETE /examples/:id
     */
    public function destory($id)
    {
        if (Example::toDelete($id)) {
            return $this->json();
        }

        return $this->error(self::NOT_FOUND);
    }

    /**
     * GET /examples/token
     */
    public function token()
    {
        $token = Token::encode(['uid' => 1]);
        
        return $this->json(['token' => $token]);
    }
}