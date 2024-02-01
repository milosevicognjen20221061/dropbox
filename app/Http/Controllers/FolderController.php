<?php

namespace App\Http\Controllers;

use App\Http\Resources\Folder\FolderCollection;
use App\Http\Resources\Folder\FolderResource;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = Folder::all();
        if (is_null($folders) || count($folders) === 0) {
            return response()->json('No folders found!', 404);
        }
        return response()->json([
            'folders' => new FolderCollection($folders)
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
                'name' => 'required|string|max:255|unique:folders',
                'description' => 'required|string|max:255',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $folder = Folder::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'Folder created' => new FolderResource($folder)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show($folder_id)
    {
        $folder = Folder::find($folder_id);
        if (is_null($folder)) {
            return response()->json('Folder not found', 404);
        }
        return response()->json([
            'folder' => new FolderResource($folder)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $folder->name = $request->name;
        $folder->description = $request->description;
        $folder->save();

        return response()->json([
            'Folder updated' => new FolderResource($folder)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();
        return response()->json('Folder deleted');
    }
}
