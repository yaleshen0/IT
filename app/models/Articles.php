<?php

use Jenssegers\Mongodb\Model as Eloquent;
  
class Articles extends Eloquent {  
  
    use SoftDeletingTrait;  

    protected $collection = 'Articles';
        //创建的时候进行填充
    public function createFill($param)
    {
        $string_array = ['title', 'content', 'auth', 'tags'];
        foreach ($string_array as $key) {
            $this->$key = Utility::getArrayStringValue($param, $key);
        }

        $numeric_array = ['id','create_time'];
        foreach ($numeric_array as $key) {
            $this->$key = Utility::getArrayDoubleOrIntValue($param, $key);
        }

        return $this;
    }
  
    //protected $fillable = ['title', 'content'];   
  
    public function user()  
    {  
        return $this->belongsTo('User');  
    }  
} 