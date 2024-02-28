<?php

namespace App\Http\Controllers\UploadDump;

use App\FirebaseStorage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadDumpController extends Controller
{
    public function index(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        $storage = FirebaseStorage::initialize();
        $bucket = $storage->bucket('irrigation-upload-dump.appspot.com');
        $file = $request->file('image');

        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;

        $bucket->upload(fopen($file->getPathname(), 'r'), [
            'name' => 'image/' . $filename,
        ]);

        $imageUrl = 'https://storage.googleapis.com/irrigation-upload-dump.appspot.com/image' . $filename;

        return response()->json(['image_url' => $imageUrl], 201);
    }

    public function update(Request $request, $id)
    {
    }

    public function delete($id)
    {
    }
}
