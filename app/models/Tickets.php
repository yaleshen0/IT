<?php
/**
 *
 */
use Jenssegers\Mongodb\Model as Eloquent;

class Tickets extends Eloquent
{
    protected $collection = 'Tickets';

    //创建的时候进行填充
    public function createFill($param)
    {

        //对于不需要特别处理的string处理的值，我们就直接循环赋值
        //action_status-> ticket状态（hold？picketed up？）
        $string_array = ['content', 'submit_by', 'action', 'category', 'closed_by', 'to_user_name', 'from_user_name', 'MsgType', 'status', 'bstatus', 'referTo', 'opened_by', 'picture_content', 'used_time', 'hold_time', 'unhold_time', 'used_holdingtime'];
        foreach ($string_array as $key) {
            $this->$key = Utility::getArrayStringValue($param, $key);
        }

        //对于不需要特别处理的numeric处理的值，我们就直接循环赋值
        //接收ticket日期，优先级，开始处理时间，结束时间，花费时间，hold时间，hold start时间， hold end时间, tickets总数, closed tickets, category种类数量
        $numeric_array = ['received_time','pickup_time','finished_time','MsgId', 'auto_id','lasttime_active', 'priority', 'idforwaiting'];

        foreach ($numeric_array as $key) {
            $this->$key = Utility::getArrayDoubleOrIntValue($param, $key);
        }

        return $this;
    }
}
