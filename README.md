项目下载和运行
----
- PHP >= 7.0
- flaravel5.*

- 拉取项目代码
```bash
composer require flaravel/upload
```

- 配置文件
```
php artisan vendor:publish --provider=Flaravel\Upload\UploadServiceProvider
```

- 配置 oss
```
return [
    //local  oss
    //默认local
    'driver' => 'oss',

    //外网上传
    //OSS_SERVERINTERNAL 内网
    //OSS_SERVICE 外网
    'endpoint' => Flaravel\Upload\UploadOssInterface::OSS_SERVICE,

    'ossServer' => env('ALIOSS_SERVER', ''),                      // 外网

    'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', ''),      // 内网

    'AccessKeyId' => env('ALIOSS_KEYID', ''),                     // key

    'AccessKeySecret' => env('ALIOSS_KEYSECRET', ''),             // secret

    'BucketName' => env('ALIOSS_BUCKETNAME', ''),                  // bucket
];
```

- 文件上传  oss/local
```php
Fupload::upload($file, $path, is_string($file)? : $file->getClientOriginalExtension());
```

- 文件删除 oss/local
```php
Fupload::delete($deletePath)；
```

- 列举文件 仅限 oss
```php
Fupload::getFileList($config);
```

- 检测文件是否存在 仅限 oss
```php
Fupload::fileExist($path);
```

