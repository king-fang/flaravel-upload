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
     * @param string $path 文件后缀
     * @return mixed
     * @throws \Exception
     */
    public function upload($file,$path,$ext = null)
    {
        $this->setFileName($file,$path,$ext);
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

    //列举文件
    public function getFileList(array $config = []){

        if($this->upload instanceof UploadOssInterface)
        {
            return $this->upload->getOssFileList($config);
        }
        return [];
    }

    public function fileExist($object)
    {
        if($this->upload instanceof UploadOssInterface)
        {
            return $this->upload->ossFileExist($object);
        }
        return false;
    }

    /**
     * 设置文件名
     * @param object $file 文件对象
     * @param string $path 文件路径
     * @throws \Exception
     */
    private function setFileName($file,$path,$ext = null)
    {
        if(is_object($file) || is_string($file) || $file->isValid())
        {
            if(method_exists($file, 'getClientOriginalExtension'))
            {
                $ext = $file->getClientOriginalExtension();
            }else{
                if(is_null($ext)){
                    throw  new \Exception('The uploaded file is corrupted.');
                }
            }
            $this->filePath = $path.'/'.Str::uuid()->getHex().'.'. $ext;
        }else{
            throw  new \Exception('The uploaded file is corrupted.');
        }
    }
}
