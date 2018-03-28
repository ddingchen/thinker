# Thinker用户中心SDK

用户中心接口封装

## 使用须知

+ 需依赖Laravel框架运行
+ 暂仅支持 **Laravel 5.4**
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
    "require": {
+       "ddingchen/thinker": "dev-master"
    },
```

项目目录下执行下述命令进行安装
```
$ composer update ddingchen/thinker
```

2. 添加下述代码至```{project}/config/app.php```
```diff
     'providers' => [
+        Thinker\Providers\UCenterServiceProvider::class,
     ]
```

3. 项目目录下执行下述命令部署配置文件（```{project}/config/ucenter.php```）
```
$ artisan vendor:publish --provider=UCenterServiceProvider
```

4. （可选）在.env文件中覆盖默认配置
```
#UCENTER_ROOT=http://ucenter.test.thinkerx.com
UCENTER_CLIENT_ID=UC5ab1cd9841261
UCENTER_CLIENT_SECRET=6145e8e3deee8ca83e40870002d86f96
UCENTER_REDIRECT_URI=http://laravel-54.test/ucenter/login
```

## 使用

完整文档参考[Wiki](https://github.com/ddingchen/thinker/wiki)
