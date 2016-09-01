<?php
/**
 *
 */
class LoginController extends BaseController
{
    public function index()
    {
        return View::make('/index');
    }
    //register page
    public function register()
    {
        return View::make('login.register');
    }
    //landing page
    public function landing()
    {
        // 说明 username和 password必须填写
        $rules = array(
            'username' => 'required',
            'password' => 'required',
            );
        $validation = Validator::make(Input::all(), $rules);
        $category1_tickets = Tickets::where('category', '硬件')->get();
        $category2_tickets = Tickets::where('category', '软件')->get();
        $tickets = Tickets::all();
        // 判断是否用户名 密码都填写了
            if ($validation->passes()) {
                //假如都填写了，判断是否通过验证
                    if (Auth::attempt(array(

                        'username' => Input::get('username'),
                        'password' => Input::get('password'),

                        ))) {
                        //假如通过验证，转到landing的url
                    return View::make('login.landing')
                    ->with('tickets', $tickets)
                    ->with('category1_tickets', $category1_tickets)
                    ->with('category2_tickets', $category2_tickets);
                    } else {
                        // 假如不通过验证，转到 / 的url
                        return Redirect::to('/index')
                        ->withInput()->with('message', '用户名 or 密码错误');
                    }
            } else {
                //假如两个没有都填写完全，转到 / 的url
                    return Redirect::to('/index')
                    ->withInput()->withErrors($validation);
            }
    }
    public function historyCheck($FromUserName)
    {
        //满足条件的from user name 的ticekts
        $tickets = Tickets::where('from_user_name', $FromUserName);
        // 一周之内的tickets
        $tickets = $tickets->where('created_at', '>', new Carbon('last week'))->get();        
        return View::make('/history')
        ->with('tickets', $tickets);
    }
    public function historyDetails($id)
    {
        $ticket = Tickets::where('_id', $id)->first();
        return View::make('tickets.historyDetails')
        ->with('ticket', $ticket);
    }
}
