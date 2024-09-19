<?php

namespace App\Helpers;

use Image;
use Request;
use Illuminate\Support\Facades\File;

class UploadHelper
{

    /**
     * upload Upload Any Types of File. It's not checking the file type which may be checked before pass here in validation
     * @param  [type] $files            [array of file names => files]
     * @param  [type] $target_location [location where files will store]
     * @return [type]                  [filenames]
     */
    public static function multi_upload($files, $target_location)
    {
        $filenames = [];

        foreach ($files as $key => $file) {
            $filenames[$key] = self::upload($file, $key, $target_location);
        }
        return $filenames;
    }
    /**
     * upload Upload Any Types of File. It's not checking the file type which may be checked before pass here in validation
     * @param  [type] $f               [request for file or not]
     * @param  [type] $file            [pdf file]
     * @param  [type] $name            [filename]
     * @param  [type] $target_location [location where file will store]
     * @return [type]                  [filename]
     */
    public static function upload($file, $name, $target_location)
    {
        $filename = $name . '.' . $file->getClientOriginalExtension();
        $extension = $file->getClientOriginalExtension();
        $file->move(public_path($target_location), $filename);
        return $filename;
    }
    /**
     * upload Upload Any Types of File. It's not checking the file type which may be checked before pass here in validation
     * @param  [type] $f               [request for file or not]
     * @param  [type] $file            [pdf file]
     * @param  [type] $name            [filename]
     * @param  [type] $target_location [location where file will store]
     * @return [type]                  [filename]
     */
    public static function api_upload($file, $name, $target_location)
    {

        $filename = $name . '.' . $file->getClientOriginalExtension();
        $extension = $file->getClientOriginalExtension();
        $file->move(public_path($target_location), $filename);
        return $filename;
    }


    /**
     * [update file]
     * @param  [type] $f               [request for file or not]
     * @param  [type] $file            [pdf file]
     * @param  [type] $name            [filename]
     * @param  [type] $target_location [location where file will store]
     * @param  [type] $old_location    [file location which will delete]
     * @return [type]                  [filename]
     */
    public static function update($file, $name, $target_location, $old_location = null)
    {
        if(is_null($old_location)){
            $old_location = $target_location;
        }
        //delete the old notice file
        $target_location = public_path($target_location) . '/';
        if (File::exists($target_location . $old_location)) {
            File::delete($target_location . $old_location);
        }

        $filename = $name . '.' . $file->getClientOriginalExtension();
        $file->move($target_location, $filename);
        return $filename;
    }


    /**
     * [delete file]
     * @param  [type] $location [file location that will delete]
     * @return [type]                  [null]
     */
    public static function deleteFile($location)
    {
        if (File::exists(public_path($location))) {
            File::delete(public_path($location));
        }
    }
}
