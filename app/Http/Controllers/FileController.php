<?php

namespace App\Http\Controllers;

use App\Exports\FileExport;
use App\Http\Resources\File\FileCollection;
use App\Http\Resources\File\FileResource;
use App\Models\File;
use App\Models\Folder;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CSV;



class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();
        if (is_null($files) || count($files) === 0) {
            return response()->json('No files found!', 404);
        }
        return response()->json([
            'files' => new FileCollection($files)
        ]);
    }

    public function indexPaginate()
    {
        $files = File::all();
        if (is_null($files) || count($files) === 0) {
            return response()->json('No files found!', 404);
        }
        $files = File::paginate(5);
        return response()->json([
            'files' => new FileCollection($files)
        ]);
    }

    public function exportCSV()
    {
        return CSV::download(new FileExport, 'files.csv');
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
                'name' => 'required|string|max:255|unique:files',
                'size' => 'required|integer|between:1,1023',
                'unit' => 'required|string|in:b,kb,mb,gb,tb',
                'folder_id' => 'required|integer',
                'type_id'  => 'required|integer'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $folder = Folder::find($request->folder_id);
        if (is_null($folder)) {
            return response()->json('Folder not found!', 404);
        }

        $type = Type::find($request->type_id);
        if (is_null($type)) {
            return response()->json('Type not found!', 404);
        }

        $file = File::create([
            'name' => $request->name,
            'size' => $request->size,
            'unit' => $request->unit,
            'folder_id' => $request->folder_id,
            'type_id' => $request->type_id,
        ]);

        return response()->json([
            'File created' => new FileResource($file)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show($file_id)
    {
        $file = File::find($file_id);
        if (is_null($file)) {
            return response()->json('File not found', 404);
        }
        return response()->json([
            'file' => new FileResource($file)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'size' => 'required|integer|between:1,1023',
                'unit' => 'required|string|in:b,kb,mb,gb,tb',
                'folder_id' => 'required|integer',
                'type_id'  => 'required|integer'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $folder = Folder::find($request->folder_id);
        if (is_null($folder)) {
            return response()->json('Folder not found!', 404);
        }

        $type = Type::find($request->type_id);
        if (is_null($type)) {
            return response()->json('Type not found!', 404);
        }

        $file->name = $request->name;
        $file->size = $request->size;
        $file->unit = $request->unit;
        $file->folder_id = $request->folder_id;
        $file->type_id = $request->type_id;
        $file->save();

        return response()->json([
            'File updated' => new FileResource($file)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();
        return response()->json('File deleted');
    }
}
