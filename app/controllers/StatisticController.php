<?php
/**
 *
 */
class StatisticController extends BaseController
{
    public function basic()
    {
        //closed by YY
        $closed_by_YY = Tickets::where('closed_by', 'YY')->get();
        $num_of_YY = sizeof($closed_by_YY);
        //closed by TT
        $closed_by_TT = Tickets::where('closed_by', 'TT')->get();
        $num_of_TT = sizeof($closed_by_TT);
        //closed by BB
        $closed_by_BB = Tickets::where('closed_by', 'BB')->get();
        $num_of_BB = sizeof($closed_by_BB);

        // number of all tickets
        $tickets = Tickets::get();
        // number of all closed tickets
        $closed_tickets = Tickets::where('bstatus', 'Finished')->get()->toArray();
        // number of last 7days tickets && last 30days
        $number_7days = sizeof(Tickets::where('created_at', '>=', Carbon::now()->subWeek())->get());
        $number_30days = sizeof(Tickets::where('created_at', '>=', Carbon::now()->subMonth())->get());
        $chosen_tickets = NULL;
        $closed_chosen_tickets = NULL;
        $param = Input::all();
        //date range search
        if (Utility::getArrayStringValue($param, 'start_date') && Utility::getArrayStringValue($param, 'end_date')) {
            $start = Utility::getArrayStringValue($param, 'start_date');
            $start = new MongoDate(strtotime($start));
            $end = Utility::getArrayStringValue($param, 'end_date');
            $end = new MongoDate(strtotime($end));
            $chosen_tickets = Tickets::whereBetween('created_at', array($start, $end))->get();
            $closed_chosen_tickets = Tickets::whereBetween('created_at', array($start, $end))->where('bstatus', 'Finished')->get();
        } else{
            $chosen_tickets = NULL;
            $closed_chosen_tickets = NULL;
        }
        $users = User::all();
        return View::make('statistic.basic')
        ->with('users', $users)
        ->with('num_of_YY', $num_of_YY)
        ->with('num_of_TT', $num_of_TT)
        ->with('num_of_BB', $num_of_BB)
        ->with('search_array', $param)
        ->with('closed_tickets', $closed_tickets)
        ->with('chosen_tickets', $chosen_tickets)
        ->with('closed_chosen_tickets', $closed_chosen_tickets)
        ->with('tickets', $tickets)
        ->with('number_7days', $number_7days)
        ->with('number_30days', $number_30days);
    }
    public function employee()
    {
        $alltickets = Tickets::all();
        $yy = User::where('username', 'YY')->first();
        $tt = User::where('username', 'TT')->first();
        $bb = User::where('username', 'BB')->first();
        return View::make('statistic.employee')
        ->with('alltickets', $alltickets)
        ->with('yy', $yy)
        ->with('tt', $tt)
        ->with('bb', $bb);
    }
    public function index()
    {
        $users = User::all();
        $tickets = Tickets::get();
        //closed by YY
        $closed_by_YY = Tickets::where('closed_by', 'YY')->get();
        $num_of_YY = sizeof($closed_by_YY);
        //closed by TT
        $closed_by_TT = Tickets::where('closed_by', 'TT')->get();
        $num_of_TT = sizeof($closed_by_TT);
        //closed by BB
        $closed_by_BB = Tickets::where('closed_by', 'BB')->get();
        $num_of_BB = sizeof($closed_by_BB);
        $wifi = Tickets::where('category', 'wifi')->get();
        $qb = Tickets::where('category', 'qb')->get();
        $phone = Tickets::where('category', 'phone')->get();
        $rempc = Tickets::where('category', 'rem/pc')->get();
        $excel = Tickets::where('category', 'excel')->get();
        $website = Tickets::where('category', 'website')->get();
        $email = Tickets::where('category', 'email')->get();
        $monitor = Tickets::where('category', 'monitor')->get();
        $printer = Tickets::where('category', 'printer')->get();
        $others = Tickets::where('category', 'others')->get();
        // referring & referred
        $YY = User::where('username', 'YY')->first();
        $YY_refer = sizeof($YY['referId']);
        $YY_referred = sizeof($YY['referredId']);
        $TT = User::where('username', 'TT')->first();
        $TT_refer = sizeof($TT['referId']);
        $TT_referred = sizeof($TT['referredId']);
        $BB = User::where('username', 'BB')->first();
        $BB_refer = sizeof($BB['referId']);
        $BB_referred = sizeof($BB['referredId']);
        return View::make('statistic.index')
        ->with('users', $users)
        ->with('tickets', $tickets)
        ->with('num_of_YY', $num_of_YY)
        ->with('num_of_TT', $num_of_TT)
        ->with('num_of_BB', $num_of_BB)
        ->with('YY_refer', $YY_refer)
        ->with('YY_referred', $YY_referred)
        ->with('TT_refer', $TT_refer)
        ->with('TT_referred', $TT_referred)
        ->with('BB_refer', $BB_refer)
        ->with('BB_referred', $BB_referred)
        ->with('wifi', $wifi)
        ->with('qb', $qb)
        ->with('phone', $phone)
        ->with('rempc', $rempc)
        ->with('excel', $excel)
        ->with('website', $website)
        ->with('email', $email)
        ->with('monitor', $monitor)   
        ->with('printer', $printer)
        ->with('others', $others);
    }
}
