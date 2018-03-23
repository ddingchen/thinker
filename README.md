# SDK for Thinker UCenter

## 功能

- UCenter接口封装

## 安装

0. 暂仅支持 **Laravel 5.4**

1. 在项目package.json相应节点中添加下述内容
```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ddingchen/thinker"
        }
    ],
    "require": {
        "ddingchen/thinker": "dev-master"
    },
```

2. 在项目路径下使用Composer命令安装该依赖
```
> composer update ddingchen/thinker
```

3. 项目config/app.php中添加
```
    'providers' => [
        // ...
        Thinker\Providers\UCenterServiceProvider::class,
    ]
```

4. 在项目路径下使用Artisan命令部署项目配置文件
配置文件位置 /config/ucenter.php
```
> artisan vendor:publish --provider=UCenterServiceProvider
```

5. 支持在.env文件中配置这些节点
```
#UCENTER_ROOT=http://ucenter.test.thinkerx.com
UCENTER_CLIENT_ID=UC5ab1cd9841261
UCENTER_CLIENT_SECRET=6145e8e3deee8ca83e40870002d86f96
UCENTER_REDIRECT_URI=http://laravel-54.test/ucenter/login
```

## TODO LIST
```php
// 网页授权
// done UCenter::webAuth()->redirect();
// done $user = UCenter::webAuth()->user($code);

// 密码授权
// done $user = UCenter::apiAuth()->user($username, $password);

// 可用跳转
$user->redirect()->toChangeAccount();
$user->redirect()->toApp($appId, $domainId = null);

// 可用方法
// current user
// done $user->refresh();
// done $user->update(['username' => 'chen.d']);
// done $user->access_token;
// done $user->accessToken();
// done $user->accessToken()->refresh();

// all users
// done $user->users()->find($userId);
// done $user->users()->findByName($username);
// done $user->users()->findByPhone($phone);
// done $user->users()->findByNameAndPhone($username, $phone);
// done $user->users()->listInDomain($domainId);
// done $user->users()->register($phone, $password, $username);

// app
// done $user->apps()->listInDomain($domainId);
// done $user->apps()->selfRelated()->listInDomain($domainId);

// role
$user->roles()->list(); // current app
$user->roles()->inDomain($domainId)->list();
$user->roles()->inDomain($domainId)->withPermissions()->list();
$user->roles()->forUser($userId)->add('manager'); // forUser is optional, default self
$user->roles()->forUser($userId)->remove('admin'); // forUser is optional,default self
$user->roles()->forUser($userId)->clear(); // forUser is optional, default self

// domain
// done $user->domains()->list();
// done $user->domains()->search($name);
// done $user->domains()->find($domainId);
// done $user->domains()->create($name, $desc);
// done $user->domains()->updateDesc($forDomainId, "chen's domain");

// permission
$user->permissions()->listInDomain($domainId);
```
