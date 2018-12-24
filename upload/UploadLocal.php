<?php

namespace Flaravel\Upload;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadLocal implements UploadLocalInterface
{

    public function lupload($file,$path = ''){

        return Storage::disk('public')->put($path,$file);
    }


    /**
     * 刪除本地public文件
     * @param  string $path 文件路径
     * @return bool       false|true
     */
    public function ldelete(string $path)
    {
        if(Str::contains($path,config('app.url')))
        {
            $path = Str::after($path,config('app.url').'storage/');
        }
        return Storage::disk('public')->delete($path);
    }
}
