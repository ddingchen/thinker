# Thinker用户中心SDK

用户中心接口封装

## 使用须知

+ 需依赖Laravel框架运行
+ **Laravel 5.4+**
+ SDK本身不维护AccessToken的缓存

## 安装

1. 添加下述配置至```{project}/package.json```
```diff
    "repositories": [
+       {
+           "type": "vcs",
+           "url": "https://github.com/ddingchen/thinker"
+       }
    ],
```

项目目录下执行下述命令进行安装
```
$ composer require ddingchen/thinker
```

2. 添加下述代码至```{project}/config/app.php```
```diff
     'providers' => [
+        Thinker\Providers\UCenterServiceProvider::class,
     ]
```

3. 项目目录下执行下述命令部署配置文件 ```{project}/config/ucenter.php```
```
$ artisan vendor:publish --provider="Thinker\Providers\UCenterServiceProvider"
```

4. （可选）在.env文件中覆盖默认配置
```
#UCENTER_ROOT=http://my.ucenter.domain
UCENTER_CLIENT_ID=YOUR_CLIENT_ID
UCENTER_CLIENT_SECRET=YOUR_CLIENT_SECRET
UCENTER_REDIRECT_URI=http://laravel-54.test/ucenter/login
```
