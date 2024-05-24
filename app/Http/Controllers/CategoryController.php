<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     */
    public function storeCategory(Request $request)
    {
        
        $rules = [
            'name' => 'required',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return $this->respondWithError($errors);
        }

        Category::create($data);

        return $this->respondWithSuccess("Category added successfully!");
    }

    public function getCategory(Request $request)
    {
        $data = Category::Active()->get();
        if ($data) {

            $data->makeHidden('status');
            $data->makeHidden('slug');
            $data->makeHidden('created_at');
            $data->makeHidden('updated_at');
            return $this->respondWithData($data);
        } else {
            return $this->respondWithError(['Category Not Found']);
        }
    }

    // Other controller methods...
}
