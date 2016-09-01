<?php
/**
 *
 */
use Jenssegers\Mongodb\Model as Eloquent;

class Comments extends Eloquent
{
    protected $collection = 'Comments';

    //创建的时候进行填充
    public function createFill($param)
    {
        $string_array = ['comment', 'name', 'ticket_id', 'notice'];
        foreach ($string_array as $key) {
            $this->$key = Utility::getArrayStringValue($param, $key);
        }

        $numeric_array = [];
        foreach ($numeric_array as $key) {
            $this->$key = Utility::getArrayDoubleOrIntValue($param, $key);
        }

        return $this;
    }
    public function ticket()
    {
        return $this->belongsTo('Tickets');
    }
}
