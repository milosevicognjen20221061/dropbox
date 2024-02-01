<?php

namespace App\Http\Controllers;

use App\Http\Resources\Type\TypeCollection;
use App\Http\Resources\Type\TypeResource;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        if (is_null($types) || count($types) === 0) {
            return response()->json('No types found!', 404);
        }
        return response()->json([
            'types' => new TypeCollection($types)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255|unique:types',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $type = Type::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'Type created' => new TypeResource($type)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show($type_id)
    {
        $type = Type::find($type_id);
        if (is_null($type)) {
            return response()->json('Type not found', 404);
        }
        return response()->json([
            'type' => new TypeResource($type)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255|unique:types',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $type->name = $request->name;
        $type->save();

        return response()->json([
            'Type updated' => new TypeResource($type)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return response()->json('Type deleted');
    }
}
