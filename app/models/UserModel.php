<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Jenssegers\Mongodb\Model as Eloquent;

class UserModel extends Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'UserModels';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');
    public function createFill($param)
    {
        $string_array = ['username', 'password', 'nickname', 'language', 'city', 'province', 'country', 'headimgurl', 'openid'];
        foreach ($string_array as $key) {
            $this->$key = Utility::getArrayStringValue($param, $key);
        }
        $numeric_array = ['created_at', 'sex'];
        foreach ($numeric_array as $key) {
            $this->$key = Utility::getArrayDoubleOrIntValue($param, $key);
        }

        return $this;
    }
}
