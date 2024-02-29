<?php

namespace App\Models\File;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadDump extends Model
{
    use HasFactory;
    protected $table = 'file.upload_dump';
    protected $keyType = 'string';
    public $incrementing = true;

    protected $fillable  = [
        'filename',
        'file_type',
        'size',
        'folder',
        'rel_path',
        'uploader_ip',
        'uploader_status',
        'created_at',
        'updated_at',
    ];
}
