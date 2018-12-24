<?php

return [

    //local  oss
    //默认local
    'driver' => 'local',

    //外网上传
    'endpoint' => \App\Libs\Upload\UploadOssInterface::OSS_SERVICE,

    'ossServer' => env('ALIOSS_SERVER', 'http://oss-cn-hangzhou.aliyuncs.com'),                      // 外网

    'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', 'http://oss-cn-hangzhou-internal.aliyuncs.com'),      // 内网

    'AccessKeyId' => env('ALIOSS_KEYID', 'LTAICg0llMn4ZL7e'),                     // key

    'AccessKeySecret' => env('ALIOSS_KEYSECRET', 'KedDhHyJmMJMV0Nmd9PvB8qVqnPAIZ'),             // secret

    'BucketName' => env('ALIOSS_BUCKETNAME', 'suxiangdai')                  // bucket
];
