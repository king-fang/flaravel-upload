<?php

namespace Flaravel\Upload;

use Illuminate\Support\Facades\Facade;
/**
 * @method static object upload(object $file,string $path = '',$ext = null)
 * @method static bool delete(string $path)
 *------------------------------------------------------------------
 * @param string $prefix 你要列出的文件所在的目录名
 * @param string $nextMarker 从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表
 * @param string $delimiter 为行使文件夹功能的分割符号，如 /
 * @param number $maxKeys max-keys用于限定此次返回object的最大数
 *
 * @method static array getFileList($config)
 * -----------------------------------------------------------------
 * @method static bool fileExist($path)
 */
class Fupload extends Facade
{
     protected static function getFacadeAccessor() {

        return 'upload';
     }
}
