<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     */
    public function storetag(Request $request)
    {
        // dd("tt");
        $rules = [
            'name' => 'required',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return $this->respondWithError($errors);
        }

        Tag::create($data);

        return $this->respondWithSuccess("Category added successfully!");
    }

    public function getTag(Request $request)
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
    }}
