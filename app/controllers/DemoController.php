<?php

use Overtrue\Wechat\Message;
use Overtrue\Wechat\Auth;
use Overtrue\Wechat\Server;

// include 'key.php';
define('redirect_url', 'https://it.ngrok.io/');
define('url', 'http://it.book2us.com/');
define('TOKEN', 'weixin');
define('scope', 'snsapi_userinfo');
define('appId', 'wx96ffd167888a9e0d');
define('secret', 'ec1b3fce8a48166e16fd11eb782cebab');
// // 三、通过code获取网页授权access_token和openid

// if(($pos = strpos($content, "ID-")) !== FALSE){
//     $ticket = Tickets::where('auto_id', (int)substr($content, $pos+3))->first();
//     $user = UserModel::where('openid', $ticket['from_user_name'])->first();
//     $fuck = Comments::where('ticket_id', $ticket['_id'])->first();
//     dd($fuck);
// }
// $access_token = (new Utility)->accessToken();
// dd($access_token);
// dd("https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token."");
$auth = new Auth('wx96ffd167888a9e0d', 'ec1b3fce8a48166e16fd11eb782cebab');
$wechatObj = new wechatCallbackapiTest();
// dd(strtotime(Carbon::now()));
// session_start();
// if(empty($_SESSION['logged_user'])){
//     $user = $auth->authorize($to = url, $scope = scope, $state = '1');
//     $_SESSION['logged_user'] = $user->all();
//     (new UserModel)->createFill($user)->save();
// } else {
//     $user = $_SESSION['logged_user'];
// }
if (!isset($_GET['echostr'])) {                                //从微信服务器(你的公众号)获取随机字符$echostr；isset()判断参数是否设置，参数存在且有值为true
    $wechatObj->responseMsg();
                               //若没有echostr，表示已经通过验证，直接调用responseMsg()方法
} else {
    $wechatObj->valid();                  //若存在echostr，表示第一次提交验证申请，调用验证方法valid()，判断微信服务器(你的公众号)与网站服务器的是否连通。
}
class wechatCallbackapiTest
{
    //验证消息
    public function valid()
    {
        $echoStr = Input::get('echostr');
        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }
    //检查签名
    //官网可下载代码——http://mp.weixin.qq.com/wiki/4/2ccadaef44fe1e4b0322355c2312bfa8.html
    private function checkSignature()
    {
        $signature = Input::get('signature');
        $timestamp = Input::get('timestamp');
        $nonce = Input::get('nonce');
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function responseMsg()
    {

      //get post data, May be due to the different environments  
      $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents('php://input'); //接收微信发来的XML数据  
 //  $postStr = '<xml>
 // <ToUserName><![CDATA[toUser]]></ToUserName>
 // <FromUserName><![CDATA[fromUser]]></FromUserName> 
 // <CreateTime>1348831860</CreateTime>
 // <MsgType><![CDATA[text]]></MsgType>
 // <Content><![CDATA[haoxiang还是？不行 ID-86]]></Content>
 // <MsgId>1234567890123456</MsgId>
 // </xml>';
     //extract post data 
      $textTpl = '<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>';

        if (!empty($postStr)) {
            //解析post来的XML为一个对象$postObj 
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName; //请求消息的用户  
            $toUsername = $postObj->ToUserName; //"我"的公众号id  
            $content = trim($postObj->Content); //消息内容  
            $eventKey = $postObj->EventKey;
            $picUrl = $postObj->PicUrl;
            $time = time(); //时间戳  
            $msgType = 'text'; //消息类型：文本

            if (trim($postObj->Event) == 'subscribe') {
                $contentStr = '感谢关注IT系统,请从底部［常见问题］或者［一般问题］选择问题类型开始提问';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                exit();
            }
            //如果时间为CLICK 

            if ($postObj->Event == 'CLICK' && ($eventKey == 'wifi' or $eventKey == 'rem/pc' or $eventKey == 'phone' or $eventKey == 'qb' or $eventKey == 'excel' or $eventKey == 'website' or $eventKey == 'email' or $eventKey == 'monitor' or $eventKey == 'printer' or $eventKey == 'others')) {
                //click event触发ticket流程 回复contentStr
                $contentStr = '请提供问题详述 ';
                // $resultStr = wechatCallbackapiTest::getTextMsg('ohUVfwOQhJPheGUSO1qaags8jCps', 'gh_d062c1fab77b', $time, $contentStr);
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                // dd($resultStr);
                echo $resultStr;
                //start ticket model赋值status＝new 保存
                $ticket = (new Tickets())->createFill($postObj);
                $ticket->status = 'update';
                $ticket->bstatus = 'New';
                $ticket->category = (String) $eventKey;

                if ($ticket['category'] == 'wifi') {
                    $ticket->priority = 9;
                } elseif ($ticket['category'] == 'rem/pc') {
                    $ticket->priority = 8;
                } elseif ($ticket['category'] == 'phone') {
                    $ticket->priority = 7;
                } elseif ($ticket['category'] == 'qb') {
                    $ticket->priority = 6;
                } elseif ($ticket['category'] == 'excel') {
                    $ticket->priority = 5;
                } elseif ($ticket['category'] == 'others') {
                    $ticket->priority = 4;
                } else {
                    $ticket->priority = 3;
                } 
                $ticket->from_user_name = trim($fromUsername);
                $ticket->to_user_name = trim($toUsername);
                $ticket->auto_id = Utility::getNextSequence('ticketIn_id');
                $ticket->save();
                exit();
            } elseif ($postObj->Event == 'CLICK' && $eventKey == 'historyCheck') {
                $contentStr = 'http://it.ngrok.io/history'.$fromUsername.'  点击查询';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                exit();
            }
            // $ticket = ($pos = strpos($content, "ID-")) !== FALSE ? Tickets::where('auto_id', (int)substr($content, $pos+3))->get() : Tickets::all()->last();
            $ticket = Tickets::all()->last();
            // 循环order_tickets，求得前面有多少人，存入到auto_id
            $order_tickets = Tickets::where('to_user_name', 'gh_d062c1fab77b')->orderBy('priority', 'desc')->get();
            $i = 0;
            $ticket->idforwaiting = 0;
            foreach ($order_tickets as $order_ticket) 
            {
                if($order_ticket['bstatus'] != 'Finished')
                {
                    if($order_ticket['priority'] > $ticket['priority'])
                    {
                        $i = $i + 1;
                    }elseif($ticket['priority'] == $order_ticket['priority'])
                    {
                        if($ticket['created_at'] > $order_ticket['created_at'])
                        {
                             $i = $i + 1;
                        }

                    }
                }
            }
            $ticket['idforwaiting'] = $i;
            $ticket->save();
            $now = Carbon::now();
            // $nowSubTwo = new DateTime(date_format(Carbon::now()->subHours(2), 'Y-m-d H:i:s'));
            // $receive = new DateTime($ticket['lasttime_active']);
            // $interval = $nowSubTwo->diff($receive);
            if($ticket['status']=='update' && ($content =='提交' || $content =='Submit'))
            { 
                $contentStr = "您此次提交的ticket的id为".$ticket['auto_id']."，问题提交成功，马上处理. 您前面还有 ".$ticket['idforwaiting']."人，如果有进一步问题，请联系客服";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);  
                echo $resultStr;
                $from_user_name1 = 'ohUVfwOQhJPheGUSO1qaags8jCps';
                $from_user_name2 = '';
                $comment = 'new tickets coming';
                (new Utility)->sendToIT($from_user_name1, $from_user_name2, $comment);
                // 如果结束问题提交 更新状态＝waiting
                $ticket->status = 'waiting';
                $ticket->save();
                exit();
            }
            
            // 如果状态为update content＝Y 代表想提供问题详述
            
            // 默认的update状态会存入content
            elseif ($ticket['status'] == 'update') {
                $contentStr = '. 请提供截图'."\r\n".'. 或者提供详细的error讯息帮助IT解决问题'."\r\n".'. 或者输入[提交]OR[Submit]来完成提交';  //因为发现不echo？会一直post数据？ 
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                $c = empty($ticket->content) ? [] : $ticket->content;
                // $c[] = !is_null($content)
                if (empty($content)) {
                    $c[] = $picUrl;
                } else {
                    $content = urldecode($content);
                    $c[] = $content;
                }
                $ticket->content = $c;
                $ticket->save();
                exit();
            }elseif(($pos = strpos($content, "ID-")) !== FALSE){
                $ticket = Tickets::where('auto_id', (int)substr($content, $pos+3))->first();
                if(!isset($ticket)){
                    $contentStr = '请输入正确的ID';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit();
                }
                if(isset($ticket['lasttime_active']) && (strtotime(Carbon::now()) - $ticket['lasttime_active']) < 7200) {
                    //找到YY回票的那个人
                    $contentStr = '    ';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    $from_user_name = $ticket['from_user_name'];
                    $user = UserModel::where('openid', $from_user_name)->first();
                    $nickname = $user['nickname'];
                    $fuck = Comments::where('ticket_id', $ticket['_id'])->first();
                    $comm = $fuck['comment'];
                    $ccc = array(
                            'text' => $content,
                            'name' => $nickname,
                            'time' => Carbon::now()->toDateTimeString(),
                        );
                    $comm[] = $ccc;
                    $fuck->comment = $comm;
                    $fuck->save();
                    echo $resultStr;
                    exit();
                }elseif ($ticket['lasttime_active'] == 0) {
                    $contentStr = '你的问题已经提交成功。如果有进一步问题 请联系客服';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit();
                }
            }elseif($ticket['status'] =='waiting'){
                $contentStr = "您的问题已经提交完成，如有疑问请尝试联系客服人员 或 检查是否忘记添加回复ID号";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);  
                echo $resultStr;
                exit();
            } else {
                
                $contentStr = '请按提示输入有效内容';  //因为发现不echo？会一直post数据？ 
                $resultStr = sprintf($textTpl, $postObj['FromUserName'], $postObj['ToUserName'], time(), 'text', $contentStr);
                echo $resultStr;
                    exit();
            }
        } 
    }

    //取得微信返回的JSON数据
    // public function getJson($url){
    // 　　$ch = curl_init();
    //     // dd(curl_init());
    // 　　curl_setopt($ch, CURLOPT_URL, $url);
    // 　　curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    // 　　curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    // 　　curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 　　$output = curl_exec($ch);
    // 　　curl_close($ch);
    // 　　return json_decode($output, true);
    // }
    // 回复文字消息
    public function makeText($text = '')
    {
        $time = time();
        $FuncFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA['gh_d062c1fab77b']]></ToUserName>
            <FromUserName><![CDATA['ohUVfwOQhJPheGUSO1qaags8jCps']]></FromUserName>
            <CreateTime>{$time}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";

        return sprintf($textTpl, $text, $FuncFlag);
    }
    //回复多客服消息
    public function getTextMsg($to, $from, $time, $content)
    {
        $tpl = '<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>';

        return sprintf($tpl, $to, $from, $time, $content);
    }
    private function transmitService($object)
    {
        $serviceTpl = '<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[transfer_customer_service]]></MsgType>
            </xml>';
        $result = sprintf($serviceTpl, $object->FromUserName, $object->ToUserName, time());

        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = '<Image>
                    <MediaId><![CDATA[%s]]></MediaId>               
                    </Image>';

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>              
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    $item_str                                           
                    </xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());

        return $result;
    }
}
