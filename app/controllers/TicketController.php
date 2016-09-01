<?php
/**
 *
 */

// use app\controllers\AccessTokenController;
define('TOKEN', 'weixin');
define('scope', 'snsapi_userinfo');
define('appId', 'wx96ffd167888a9e0d');
define('secret', 'ec1b3fce8a48166e16fd11eb782cebab');

class TicketController extends BaseController
{
    public function index()
    {
        $rules = array(
            'username' => 'required',
            'password' => 'required',
            );
        $validation = Validator::make(Input::all(), $rules);
        $category1_tickets = Tickets::where('category', 'excel')->get();
        $category2_tickets = Tickets::where('category', '软件')->get();
        $tickets = Tickets::all();
        //$order_tickets = Tickets::all();
        $order_tickets = Tickets::where('to_user_name', 'gh_d062c1fab77b')->orderBy('priority', 'desc')->get();
        //dd(json_encode($order_tickets));
        $UserModels = UserModel:: all();
        // 判断是否用户名 密码都填写了
        //dd($Usermodels);
        if ($validation->passes()) {
        //     //假如都填写了，判断是否通过验证
                if (Auth::attempt(array(

                    'username' => Input::get('username'),
                    'password' => Input::get('password'),

                    ))) {
        //             //假如通过验证，转到landing的url
        return View::make('/tickets/index')
        ->with('tickets', $tickets)
        ->with('UserModels', $UserModels)
        ->with('category1_tickets', $category1_tickets)
        ->with('order_tickets', $order_tickets)
        ->with('category2_tickets', $category2_tickets);
                } else {
        //             // 假如不通过验证，转到 / 的url
                    return Redirect::to('/index')
                    ->withInput()->with('message', '用户名 or 密码错误');
                }
        } else {
        //     //假如两个没有都填写完全，转到 / 的url
                return Redirect::to('/index')
                ->withInput()->withErrors($validation);
        }
    // dd(Auth::user());
    }
    public function getIndex()
    {
        $category1_tickets = Tickets::where('category', '硬件')->get();
        $category2_tickets = Tickets::where('category', '软件')->get();
        $tickets = Tickets::all();
        $UserModels = UserModel:: all();
        $order_tickets = Tickets::where('to_user_name', 'gh_d062c1fab77b')->orderBy('priority', 'desc')->get();


        return View::make('tickets.index')
        ->with('UserModels', $UserModels)
        ->with('tickets', $tickets)
        ->with('order_tickets', $order_tickets)
        ->with('category1_tickets', $category1_tickets)
        ->with('category2_tickets', $category2_tickets);
    }
    public function updateOpen($id, $employee, $time)
    {
        //open action后会给微信用户返回提示表明票正在被处理
        $employee = json_decode($employee);
        $ticket = Tickets::where('_id', $id)->first();
        $postdata = '{"touser":"'.$ticket['from_user_name'].'","msgtype":"text","text":{"content":"'.$employee.'正在处理您id为'.$ticket['auto_id'].'的ticket"}}';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'Content-Length' => strlen($postdata),
                'Host' => 'api.weixin.qq.com',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'Content-Type' => 'application/json',
                'content' => $postdata,
            ),
        );
        $context = stream_context_create($opts);
        $access_token = (new Utility())->accessToken();
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token.'', true, $context);
        echo $result;
        // $wechatObj->sendToUser($employee);
        $pickup_time = Carbon::now()->toDateTimeString();
        $ticket = Tickets::where('_id', $id)->first();
        $ticket->bstatus = 'Processing';
        $ticket->status = 'Processing';
        $ticket->openedby = $employee;
        $ticket->pickup_time = $pickup_time;
        $ticket->save();

        return Redirect::to('/tickets/index');
    }
    public function updateHold($id)
    {
        $holdtime = Carbon::now()->toDateTimeString();
        $ticket = Tickets::where('_id', $id)->get();
        $ticket = $ticket[0];
        dd(strtotime($ticket['updated_at']));
        $comment = '您的Id为'.$ticket['auto_id'].'的ticket，我们正在处理，不过可能需要更长的时间';
        (new Utility)->sendToUser($id, $comment);
        $ticket->hold_time = $holdtime;
        $ticket->bstatus = 'Holding';
        $ticket->status = 'Holding';
        $ticket->save();

        return Redirect::to('/tickets/index');
    }
    public function updateUnhold($id)
    {
        $unholdtime = Carbon::now()->toDateTimeString();
        $ticket = Tickets::where('_id', $id)->get();
        $ticket = $ticket[0];
        $ticket->bstatus = 'Processing';
        $ticket->status = 'Processing';
        $ticket->unhold_time = $unholdtime;

        $enddate= $unholdtime;
        $startdate= $ticket['hold_time'];
        $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
        $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
        $minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
        if($minute < 10){
            $minute = 0 . $minute;
        }
        $second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
        if($second < 10){
            $second = 0 . $second;
        }
        $hour = $date*24+$hour;
        if($hour < 10){
            $hour = 0 . $hour;
        }
        $ticket->used_holdingtime = ''.$hour.':'.$minute.':'.$second.'';

        $ticket->save();

        return Redirect::to('/tickets/index');
    }
    public function updateClose($id, $employee)
    {
        $employee = json_decode($employee);
        $finished_time = Carbon::now()->toDateTimeString();
        $ticket = Tickets::where('_id', $id)->get();
        $ticket = $ticket[0];
        $comment = '您的Id为'.$ticket['auto_id'].'的ticket已经被处理好,感谢使用IT系统';
        (new Utility)->sendToUser($id, $comment);
        $ticket->bstatus = 'Finished';
        $ticket->status = 'Finished';
        $ticket->closed_by = $employee;
        $ticket->finished_time = $finished_time;
        $enddate= $finished_time;
        $startdate= $ticket['pickup_time'];

        if($startdate == 0)
        {
            $ticket->used_time = '00:00:00';
            $ticket->pickup_time ='NULL';

        } else{
            // $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
            // $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
            // $minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
            // if($minute < 10){
            //     $minute = 0 . $minute;
            // }
            // $second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
            // if($second < 10){
            //     $second = 0 . $second;
            // }
            // $hour = $date*24+$hour;
            // if($hour < 10){
            //     $hour = 0 . $hour;
            // }
            $ticket->used_time = gmdate('H:i:s', strtotime($enddate)-strtotime($startdate));
        }


        $ticket->save();
        return Redirect::to('/tickets/index');
    }
    public function updateRefer($option, $employee, $id)
    {
        $ticket = Tickets::where('_id', $id)->get();
        $ticket = $ticket[0];
        $ticket->openedby = '';
        $ticket->bstatus = 'New';
        $auto_id = $ticket['auto_id'];
        $ticket->referTo = $option;
        $ticket->save();
        //referring Id
        $user = User::where('username', $employee)->get();
        $user = $user[0];
        $c = !isset($user->referId) ? [] : $user->referId;
        if(empty($c)){
            $c[] = $id;
        }else{
            foreach ($user['referId'] as $key => $value) {
                if($value !== $id){
                    $c[] = $id;
                }
            }
        }
        $user->referId = $c;
        $user->save();
        // referred ID
        $usered = User::where('username', $option)->get();
        $usered = $usered[0];
        $c = !isset($usered->referredId) ? [] : $usered->referredId;
        if(empty($c)){
            $c[] = $id;
        }else{
            foreach ($usered['referredId'] as $key => $value) {
                if($value !== $id){
                    $c[] = $id;
                }
            }
        }
        $usered->referredId = $c;
        $usered->save();
        $comment = '您的Id:'.$auto_id.'的票已经转交给'.$option.'';
        (new Utility)->sendToUser($id, $comment);
        return Redirect::to('/tickets/index');
    }
    public function details($id)
    {
        $comm = Comments::where('ticket_id', $id)->first();
        $ticket = Tickets::where('_id', $id)->get();
        $ticket = $ticket[0];

        return View::make('tickets.details')
        ->with('ticket', $ticket)
        ->with('comm', $comm);
    }
    public function comment($id, $comment)
    {
        $ticket = Tickets::where('_id', $id)->get();
        $ticket = $ticket[0];
        $ticket->lasttime_active = strtotime(Carbon::now());
        $ticket->save();
        $fuck = Comments::where('ticket_id', $id)->first();
        //utility sendtouser function
        $text = "ID:".$ticket['auto_id']."--".$comment."";
        (new Utility())->sendToUser($id, $text);

        if (isset($fuck['ticket_id'])) {
            // $message = Comments::where('ticket_id', '5798d54683533ed63a0041a8')->get();
            $comm = empty($fuck['comment']) ? [] : $fuck['comment'];
            $ccc = array(
                    'text' => $text,
                    'name' => 'YY',
                    'time' => Carbon::now()->toDateTimeString(),
                );
            $comm[] = $ccc;
            $fuck->comment = $comm;
            $fuck->save();
        } else {
            $fuck = new Comments();
            $fuck['ticket_id'] = $id;
            $comm = empty($fuck['comment']) ? [] : $fuck['comment'];
            $ccc = array(
                    'text' => $text,
                    'name' => 'YY',
                    'time' => Carbon::now()->toDateTimeString(),
                );
            $comm[] = $ccc;
            $fuck->comment = $comm;
            $fuck->save();
        }
    }
    public function commentToIt($id, $employee, $comment)
    {
        $ticket = Tickets::where('_id', $id)->first();
        $fuck = Comments::where('ticket_id', $id)->first();
        //find user
        $user = UserModel::where('openid', $employee)->first();
        $user = $user['nickname'];
        $text = "ID:".$ticket['auto_id']."--".$comment."";
        if (isset($fuck['ticket_id'])) {
            // $message = Comments::where('ticket_id', '5798d54683533ed63a0041a8')->get();
            $comm = empty($fuck['comment']) ? [] : $fuck['comment'];
            $ccc = array(
                    'text' => $text,
                    'name' => $user,
                    'time' => Carbon::now()->toDateTimeString(),
                );
            $comm[] = $ccc;
            $fuck->comment = $comm;
            $fuck->save();
        } else {
            $fuck = new Comments();
            $fuck['ticket_id'] = $id;
            $comm = empty($fuck['comment']) ? [] : $fuck['comment'];
            $ccc = array(
                    'text' => $text,
                    'name' => $user,
                    'time' => Carbon::now()->toDateTimeString(),
                );
            $comm[] = $ccc;
            $fuck->comment = $comm;
            $fuck->save();
        }
    }
    public function notice($id, $notice)
    {
        $ticket = Tickets::where('_id', $id)->first();
        $ticket->notice = "ON";
        $ticket->save();
        $fuck = Comments::where('ticket_id', $id)->first();
        //utility sendtouser function
        $text = "ID:".$ticket['auto_id']."--".$notice."";
        if (isset($fuck['ticket_id'])) {
            // $message = Comments::where('ticket_id', '5798d54683533ed63a0041a8')->get();
            $comm = empty($fuck['notice']) ? [] : $fuck['notice'];
            $ccc = array(
                    'text' => $text,
                    'name' => 'YY',
                    'time' => Carbon::now()->toDateTimeString(),
                );
            $comm[] = $ccc;
            $fuck->notice = $comm;
            $fuck->save();
        } else {
            $fuck = new Comments();
            $fuck['ticket_id'] = $id;
            $comm = empty($fuck['notice']) ? [] : $fuck['notice'];
            $ccc = array(
                    'text' => $text,
                    'name' => 'YY',
                    'time' => Carbon::now()->toDateTimeString(),
                );
            $comm[] = $ccc;
            $fuck->notice = $comm;
            $fuck->save();
        }   
    }
    public function changeCategory($option, $employee, $id)
    {  
        $Usermodels = UserModel:: all();
        $users = User:: all();
        $tickets = Tickets::all();
        $ticket = Tickets::where('_id', $id)->get();
        $ticket = $ticket[0];
        $ticket->category = $option;
        $ticket->save();
        return View::make('tickets.closed')
        ->with('Usermodels', $Usermodels)
        ->with('tickets', $tickets)
        ->with('users', $users);
    }
    //search by category
    public function searchCateg($cate)
    {
        $types = array();
        $UserModels = UserModel::all();
        $order_tickets = Tickets::where('to_user_name', 'gh_d062c1fab77b')->orderBy('priority', 'desc');
        $order_tickets = $order_tickets->where('category', $cate)->get();
        $types[] = $cate;
        // dd($order_tickets->toArray());
        return View::make('tickets.search')
        ->with('types', $types)
        ->with('UserModels', $UserModels)
        ->with('order_tickets', $order_tickets);
    }
    //edit page 筛选
    public function searchMultiCateg($array)
    {
        $array = json_encode($array);
        dd($array);
        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
        
        echo (get_string_between($array, '+', ' '));
        //url tickets/cArray{$array}Search
        return View::make('tickets.editsearch');
    }
    // search by priority
    public function searchPrior($prior)
    {
        $types = array();
        $UserModels = UserModel::all();
        $order_tickets = Tickets::where('to_user_name', 'gh_d062c1fab77b')->orderBy('priority', 'desc');
        $range = [5, 8];
        if($prior == 'high'){
            $order_tickets = $order_tickets->where('priority', '>', 7)->get();
        } elseif($prior == 'normal'){
            $order_tickets = $order_tickets->whereBetween('priority', $range)->get();
        } elseif($prior == 'low'){
            $order_tickets = $order_tickets->where('priority', '<', 5)->get();
        } 
        $types[] = $prior;
        return View::make('tickets.search')
        ->with('types', $types)
        ->with('UserModels', $UserModels)
        ->with('order_tickets', $order_tickets);
    }
    public function closed()
    {
        $tickets = Tickets::all();
        $Usermodels = UserModel:: all();
        $users = User:: all();

        return View::make('tickets.closed')
        ->with('tickets', $tickets)
        ->with('Usermodels', $Usermodels)
        ->with('users', $users);
    }
}
