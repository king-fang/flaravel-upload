<?php

namespace Flaravel\Upload;

use App\Http\Controllers\Controller;
use Flaravel\Upload\UploadInterface;
use Flaravel\Upload\UploadOssInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OSS\Core\OssException;
use Psy\Reflection\ReflectionLanguageConstruct;

class Upload
{

    protected $upload;

    protected $filePath;

    protected $file;

    public function __construct(UploadInterface $upload)
    {
        $this->upload = $upload;
    }

    /**
     * 普通文件上传
     * @param object $file 文件对象
     * @param string $path 文件路径
     * @return mixed
     * @throws \Exception
     */
    public function upload($file,$path)
    {
        $this->setFileName($file,$path);
        if($this->upload instanceof UploadLocalInterface)
        {
            $this->file = $this->upload->lupload($file,$path);
            return asset('storage/'.$this->file);
        }elseif($this->upload instanceof UploadOssInterface)
        {
            $this->file = $this->upload->supload($file,$this->filePath);
            return $this->file['info']['url'];
        }
    }

    public function delete($path)
    {
        if($this->upload instanceof UploadLocalInterface)
        {
            return $this->upload->ldelete($path);
        }elseif($this->upload instanceof UploadOssInterface)
        {
            return $this->upload->sdelete($path);
        }
    }
    /**
     * 设置文件名
     * @param object $file 文件对象
     * @param string $path 文件路径
     * @throws \Exception
     */
    private function setFileName($file,$path)
    {
        if(is_object($file) && $file->isValid())
        {
            $this->filePath = $path.'/'.Str::uuid()->getHex().'.'.$file->getClientOriginalExtension();
        }else{
            throw  new \Exception('The uploaded file is corrupted.');
        }
    }
}
