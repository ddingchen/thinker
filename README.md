# V2 TODO：

## 1、API重构
### AccessToken API:
```php
$accessToken->refresh();
$accessToken->resource('mine'); // 等价于 new MyResource($accessToken)
$accessToken->resource('user'); // 等价于 new UserResource($accessToken) 以下方法类推
$accessToken->resource('domain');
$accessToken->resource('app');
$accessToken->resource('role');
```

### MyResource API:
```php
$resource->profile();
$resource->updateProfile(['field1' => 'value1', 'field2' => 'value2']);
$resource->bindWechat($openid);
$resource->unbindWechat($openid);
$resource->domains();
$resource->apps($domainId = null);
$resource->roles($domainId = null);
$resource->rolesWithPermissions($domainId = null);
```

### UserResource API:
```php
$resource->list($domainId); // 获取指定域的所有用户
$resource->find($userId); // 查找指定ID的用户
$resource->findByName($name); // 查找指定名字的用户
$resource->findByPhone($phone); // 查找指定电话的用户
$resource->register($phone, $password, $username = null); // 注册用户
$resource->delete($userId, $domainId); // 删除指定域的用户（的角色）
```

### DomainResource API:
```php
$service->search($keyword); // 获取包含指定关键字的所有域
$service->find($domainId); // 查找指定ID的用户
$service->create($name, $desc = null); // 创建域
$service->updateDesc($domainId, $desc); // 更新域描述
```

### AppResource API:
```php
$service->list($domainId = null); // 获取指定域的所有应用
```

### RoleResource API:
```php
$service->list(); // 获取所有角色（当前应用）
$service->listInDomain($domainId); // 获取指定域的所有角色（当前应用）
$service->listOfUser($userId, $appId); // 获取某个用户的所有角色（指定应用）
$service->addForUser($userId, $role, $domainId); // 设置用户在指定域的角色
$service->removeForUser($userId, $role, $domainId); // 移除用户在指定域的角色
$service->clearForUser($userId, $domainId); // 移除用户在指定域的所有角色
```

## 2、授权前增加可选自定义配置
```php
UCenter::webAuth()->token(request('code'));
UCenter::mergeConfig(['field1' => 'value1', 'field2' => 'value2'])->webAuth()->token(request('code'));
```
