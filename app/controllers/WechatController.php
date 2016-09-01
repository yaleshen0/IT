<?php

use Overtrue\Wechat\Server;
use Overtrue\Wechat\Message;
use Overtrue\Wechat\Menu;
use Overtrue\Wechat\MenuItem;
use Overtrue\Wechat\Notice;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__.'/controllers/DemoController.php';

class WechatController extends BaseController
{
    /**
     * 处理微信的请求消息.
     *
     * @return string
     */
    public function index()
    {
        $appId = 'wx96ffd167888a9e0d';
        $secret = 'ec1b3fce8a48166e16fd11eb782cebab';
        $token = 'weixin';

        $encodingAESKey = 'EJThPazwzO4k1cyXJnwQtL60zBdhWvFaHb4emv0dLVN';
        $to = 'https://www.google.com/';
        $url = 'https://it.ngrok.io/';
        $scope = 'snsapi_userinfo';

        $server = new Server($appId, $token, $encodingAESKey);

      // 监听所有类型

      //创建menu

      // $menuService = new Menu($appId, $secret);
      // $button = new MenuItem("选择问题类型");
      // $menus = array(
      //       $button->buttons(array(
      //         new MenuItem('硬件', 'click', 'V0'),
      //         new MenuItem('软件', 'click', 'V1'),
      //         new MenuItem('其他', 'click', 'V2'),
      //     )),
      // );

      $menuService = new Menu($appId, $secret);
        $emergent = new MenuItem('特殊问题');
        $nonemergent = new MenuItem('一般问题');
        $menus = array(
            $emergent->buttons(array(
              new MenuItem('不能上网', 'click', 'wifi'),
              new MenuItem('QuickBook', 'click', 'qb'),
              new MenuItem('电话', 'click', 'phone'),
              new MenuItem('remote死机/电脑死机', 'click', 'rem/pc'),
              new MenuItem('EXCEL', 'click', 'excel'),
          )),
            $nonemergent->buttons(array(
              new MenuItem('无法登陆网站', 'click', 'website'),
              new MenuItem('Email', 'click', 'email'),
              new MenuItem('显示器问题', 'click', 'monitor'),
              new MenuItem('打印机问题', 'click', 'printer'),
              new MenuItem('其他', 'click', 'others'),
          )),
            new MenuItem("查询历史或者留言给IT", 'click', 'historyCheck'),
      );

        try {
            $menuService->set($menus);// 请求微信服务器
            // echo '设置成功！';
        } catch (\Exception $e) {
            // echo '设置失败：'.$e->getMessage();
        }
      // 监听指定类型
      // $server->on('message', 'text', function($message) {
      //     return Message::make('text')->content('我们已经收到您发送的消息！');
      // });
      $result = $server->serve();

        $demo = new wechatCallbackapiTest();
        echo $result;
    }
}
