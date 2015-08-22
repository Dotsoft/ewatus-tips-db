<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->input('nested')) {
            return Category::whereNull('parent_id')->with('children.children.children')->get();
        }
        return Category::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // $validator = $this->validator($data);
        // if ($validator->fails()) {
        //     return response($validator->messages(), 400);
        // }
        // $data['title'] = json_encode($data['title']);
        // $data['description'] = json_encode($data['description']);
        return Category::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Category::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = $this->validator($data, $id);
        if ($validator->fails()) {
            return response($validator->messages(), 400);
        }
        $category = Category::find($id);
        $category->update($data);
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
    }

    /**
     * Get a validator.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
     protected function validator(array $data, $id = 0)
     {
         $parent_ids = Category::whereNull('parent_id')->where('id', '<>', $id)->lists('id')->toArray();
         $parent_ids_str = implode(',', $parent_ids);
         return Validator::make($data, [
             'title' => 'required',
             'description' => 'required',
             'parent_id' => 'sometimes|in:' . $parent_ids_str
         ]);
     }
}
