<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Jenssegers\Mongodb\Model as Eloquent;

class Knowledge extends Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'Knowledge';

    public function createFill($param)
    {
        $string_array = ['title', 'content', 'category', 'submit_by', 'comment'];
        foreach ($string_array as $key) {
            $this->$key = Utility::getArrayStringValue($param, $key);
        }

        //对于不需要特别处理的numeric处理的值，我们就直接循环赋值
        $numeric_array = ['categorytype_numbers'];
        foreach ($numeric_array as $key) {
            $this->$key = Utility::getArrayDoubleOrIntValue($param, $key);
        }

        return $this;
    }
}
