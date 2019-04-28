<?php

namespace Flaravel\Upload;

use Illuminate\Support\Str;
use OSS\Core\OssException;
use OSS\OssClient;

class UploadOss implements UploadOssInterface
{
    private $bucketName;

    private $ossClient;

    private $endpoint;

    public function __construct()
    {
        if(config('upload.endpoint') == self::OSS_SERVICE)
        {
            $this->endpoint = config('upload.ossServer');
        }else if(config('upload.endpoint') == self::OSS_SERVERINTERNAL){
            $this->endpoint = config('upload.ossServerInternal');
        }else{
            $this->endpoint = config('upload.ossServer');
        }
        $this->bucketName = config('upload.BucketName');
        $this->ossClient = new OssClient(config('upload.AccessKeyId'),config('upload.AccessKeySecret'),$this->endpoint);
    }

    /**
     * 普通文件上传
     * @param  object $file 文件对象
     * @param  string $path 文件路径名称
     * @return array       返回OSS content
     * @throws \Exception
     */
    public function supload($file,$path = '/')
    {
        if(is_string($file))
        {
            return $this->strupload($file,$path);
        }
        try {
            return $this->ossClient->uploadFile($this->bucketName,$path,$file);
        } catch (OssException $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function strupload($file,$path = '/')
    {
        try {
            return $this->ossClient->putObject($this->bucketName,$path,$file);
        } catch (OssException $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    /**
     * 文件删除
     * @param string $path 文件路径
     * @return bool|null
     * @throws \Exception
     */
    public function sdelete($path)
    {
        try {
            $path = Str::after($path,'com/');
            $res = $this->ossClient->deleteObject($this->bucketName,$path);
            if(isset($res['info']))
            {
                return true;
            }
            return false;
        } catch (OssException $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    /**
     * 列举oss 文件
     * @param string $prefix 你要列出的文件所在的目录名
     * @param string $nextMarker 从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表
     * @param string $delimiter 为行使文件夹功能的分割符号，如 /
     * @param number $maxKeys max-keys用于限定此次返回object的最大数
     */
    public function getOssFileList($config = [])
    {

        $list = [];

        if(isset($config['prefix']) && !empty($config['prefix']))
        {
            $options = [
                'delimiter' => $config['delimiter'] ?? '/',
                'prefix'    => $config['prefix'],
                'max-keys'  => $config['maxKeys'] ?? 10,
                'marker'    => $config['nextMarker'] ?? ''
            ];
        }
        try {
            $listObjectInfo = $this->ossClient->listObjects($this->bucketName, $options ?? '');
        } catch (OssException $e) {
           throw new \Exception($e->getMessage(), 1);
        }
        $nextMarker = $listObjectInfo->getNextMarker();
        $lastMarker = $listObjectInfo->getMarker();
        $objectList = $listObjectInfo->getObjectList(); // object list
        $prefixList = $listObjectInfo->getPrefixList(); // directory list

        $list['nextMarker'] = $nextMarker;
        $list['lastMarker'] = $lastMarker;

        if (!empty($prefixList)) {
            foreach ($prefixList as $prefixInfo) {
                $list['prefix'][] = $prefixInfo->getPrefix();
            }
        }
        if (!empty($objectList)) {
            foreach ($objectList as $key => $objectInfo) {
                if($objectInfo->getSize() == 0)
                {
                    continue;
                }
                $list['files'][] = [
                    'name' => $objectInfo->getKey(),
                    'size' => $objectInfo->getSize(),
                    'image' => config('upload.ossUrl').$objectInfo->getKey(),
                    'lastModified' => $objectInfo->getLastModified(),
                ];
            }
        }else{
            $list['files'] = [];
        }
        return $list;
    }

    /**
     * 检测当前文件夹下面文件是否存在
     * @param  string $object 文件
     * @return bool
     */
    public function ossFileExist($object)
    {
        try{
            $exist = $this->ossClient->doesObjectExist($this->bucketName, $object);
        } catch(OssException $e) {
            throw new \Exception($e->getMessage(), 1);
        }
        return $exist;
    }
}
