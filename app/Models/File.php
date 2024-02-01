<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'unit',
        'folder_id',
        'type_id'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public static function getAllFiles()
    {
        $result = DB::table('files')
            ->select('id', 'name', 'size', 'unit')
            ->get()->toArray();
        return $result;
    }
}
