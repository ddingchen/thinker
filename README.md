
<!-- user -->
UCenter::webAuth()->redirect();
UCenter::webAuth()->user($code);
UCenter::webAuth()->user($code)->login();
UCenter::apiAuth()->user($username, $password);
UCenter::apiAuth()->user($username, $password)->login();
UCenter::accountChange()->redirect();
UCenter::goto($appId, $domainId)->redirect();

UCenter::user();
UCenter::user()->profile();
UCenter::user()->profile()->update(['username' => 'chen.d']);
UCenter::user()->accessToken()->token;
UCenter::user()->accessToken()->refresh();
UCenter::user()->apps();
UCenter::user()->app()->roles();
UCenter::user()->domains();
UCenter::user()->domain($domainId)->withPermissions()->roles();
UCenter::user()->domain($domainId)->permissions();

<!-- admin -->
UCenter::register($phone, $password, $username);

UCenter::users()->search($phone);
UCenter::users()->searchByName($username);
UCenter::user($userId)->profile();
UCenter::user($userId)->roles()->add('manager');
UCenter::user($userId)->roles()->remove('admin');
UCenter::user($userId)->roles()->clear();

$domain = Domain::create($name, $desc);
$domain->updateDesc("chen's domain");
$domain->apps();
$domain->users();
$domain->roles();

UCenter::domains()->search($name);
UCenter::domain($domainId);


TODO LIST:
UCenter::user()->wechat()->bind($openid, $data);
UCenter::user()->wechat()->unbind($openid);
