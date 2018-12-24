<?php

namespace Flaravel\Upload;

interface UploadLocalInterface extends UploadInterface
{

    public function lupload($file,$path = '');

     public function ldelete(string $path);
}
