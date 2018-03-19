<?php

namespace Thinker\Testing;

use Illuminate\Foundation\Auth\User as BaseUser;


/**
* User Model for testing
*/
class UserWithCustomUCenterId extends BaseUser
{
    
    protected $table = 'users';

    public $field_name_of_ucenter_id = 'uc_uid';

    public function getUCenterUserIdAttribute()
    {
        $fieldName = $this->field_name_of_ucenter_id;
        
        return $this->$fieldName;
    }

}
