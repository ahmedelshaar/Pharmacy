<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Helpers
{
    public static function uploadFile($file, $folder): string
    {
        $fileName = time() . '.' . $file->extension();
        $file->move(public_path($folder), $fileName);
        return $folder . '/' . $fileName;
    }

    public static function deleteFile($file): bool
    {
        if ($file && file_exists(public_path($file))) {
            unlink(public_path($file));
            return true;
        }
        return false;
    }

    public static function hashPassword(Request $request): void
    {
        if($request->has('password')){
            $request->merge(['password' => Hash::make($request->password)]);
        }
    }
}
