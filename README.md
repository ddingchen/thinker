# SDK for Thinker UCenter

## 功能

- UCenter接口封装
- 网页授权中间件
- 便捷获取当前用户相关信息

## 安装

0. 暂仅支持 **Laravel 5.4**

1. 在项目package.json相应节点中添加下述内容
```json
    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/ddingchen/thinker"
        }
    ],
    "require": {
        ...
        "ddingchen/thinker": "dev-master"
    },
```

2. 在项目路径下使用Composer命令安装该依赖
```sh
> composer update ddingchen/thinker
```

3. 项目config/app.php中添加
```
    'providers' => [
        ...
        Thinker\Providers\UCenterServiceProvider::class,
    ]
```

4. 在项目路径下使用Artisan命令部署项目配置文件
配置文件位置 /config/ucenter.php
```sh
> artisan vendor:publish --provider=UCenterServiceProvider
```

5. 支持在.env文件中配置这些节点
```ini
#UCENTER_ROOT=http://ucenter.test.thinkerx.com
UCENTER_CLIENT_ID=UC5ab1cd9841261
UCENTER_CLIENT_SECRET=6145e8e3deee8ca83e40870002d86f96
UCENTER_REDIRECT_URI=http://laravel-54.test/ucenter/login
```

## 使用

+ 网页授权中间件
在App\Http\Kernel.php中，添加对应中间件的定义
```php
    protected $routeMiddleware = [
        ...
        'ucenter.auth' => \Thinker\Middleware\OAuth::class,
    ];
```

+ 在routes/web.php路由定义中使用中间件
```php
Route::group(['middleware' => 'ucenter.auth'], function () {
    Route::get('ucenter/login'); 
    // 必须，用于接收授权回调，地址应与授权参数redirect_uri指向的地址一致
    
    // 其他需要验证的路由定义
});
```

