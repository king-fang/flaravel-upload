<?php

namespace Flaravel\Upload;

use Illuminate\Support\Facades\Facade;
/**
 * @method static object upload(object $file,string $path = '')
 * @method static bool delete(string $path)
 */
class Fupload extends Facade
{
     protected static function getFacadeAccessor() {

        return 'upload';
     }
}
