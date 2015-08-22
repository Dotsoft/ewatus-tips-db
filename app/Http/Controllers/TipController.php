<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tip;
use App\Category;

class TipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
      if ((int) $request->input('category_id')) {
          return Tip::where('category_id', '=', (int) $request->input('category_id'))->get();
      }
      return Tip::all();
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
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return response($validator->messages(), 400);
        }
        return Tip::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Tip::find($id);
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
        $tip = Tip::find($id);
        $tip->update($data);
        return $tip;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Tip::find($id)->delete();
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
        $required = $id == 0 ? 'required' : '';
        $category_ids = Category::whereNull('parent_id')->lists('id')->toArray();
        $category_ids_str = implode(',', $category_ids);
        return Validator::make($data, [
           'title' => 'required|array',
           'description' => 'required|array',
           'category_id' => 'required|in:' . $category_ids_str,
        ]);
    }
}
