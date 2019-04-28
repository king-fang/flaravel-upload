<?php

return [

    //local  oss
    //默认local
    'driver' => 'local',

    //外网上传
    'endpoint' => Flaravel\Upload\UploadOssInterface::OSS_SERVICE,

    'ossServer' => env('ALIOSS_SERVER', ''),                      // 外网

    'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', ''),      // 内网

    'AccessKeyId' => env('ALIOSS_KEYID', ''),                     // key

    'AccessKeySecret' => env('ALIOSS_KEYSECRET', ''),             // secret

    'BucketName' => env('ALIOSS_BUCKETNAME', '')                  // bucket
];
