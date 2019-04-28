<?php

return [

    //local  oss
    //默认local
    'driver' => 'local',

    //访问域名
    'ossUrl' => '',

    //外网上传
    //外网 OSS_SERVICE
    //内网 OSS_SERVERINTERNAL
    'endpoint' => Flaravel\Upload\UploadOssInterface::OSS_SERVICE,

    'ossServer' => env('ALIOSS_SERVER', ''),                      // 外网

    'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', ''),      // 内网

    'AccessKeyId' => env('ALIOSS_KEYID', ''),                     // key

    'AccessKeySecret' => env('ALIOSS_KEYSECRET', ''),             // secret

    'BucketName' => env('ALIOSS_BUCKETNAME', '')                  // bucket
];
