<?php

class Utility
{
    //send to user function
    public function sendToUser($id, $comment)
    {
        $GLOBALS['ID']= $id;
        // ID number
        $ID = (new Utility)->get_string_between($comment, 'ID:', '--');
        // $a = '<a>'.$ID.'</a>';
        // echo $a;
        //id 为 $id的ticket & 获取ticket里的from user name
        $ticket = Tickets::where('_id', $id)->first();
        $from_user_name = $ticket['from_user_name'];
        // 通过from user name找到UserModel 并 取出nickname
        $user = UserModel::where('openid', $from_user_name)->first();
        $nickname = $user['nickname'];
        $postdata = '{"touser":"'.$from_user_name.'","msgtype":"text","text":{"content":"'.$comment.'"}}';
        // $postdata = json_decode($postdata, true);
        // 微信api主动 给用户为 touser 的人 发送信息
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
        // access token更新如果已过期 然后发送
        $access_token = (new Utility())->accessToken();
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token.'', true, $context);
            // dd($result);
        echo $result;
    }
    public function sendToIT($from_user_name1, $from_user_name2, $comment)
    {
        $postdata = '{"touser":["'.$from_user_name1.'","'.$from_user_name2.'"],"msgtype":"text","text":{"content":"'.$comment.'"}}';
        // $postdata = json_decode($postdata, true);
        // 微信api主动 给用户为 touser 的人 发送信息
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
        // access token更新如果已过期 然后发送
        $access_token = (new Utility())->accessToken();
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$access_token.'', true, $context);

            // dd($result);
        echo $result;
    }
    // get string between
    public function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public function accessToken()
    {
        $tokenFile = storage_path().'/access_token.txt';//缓存文件名

        $data = json_decode(file_get_contents($tokenFile));
        if (isset($data) && $data->expire_time < time() or !$data->expire_time) {
            $appid = 'wx96ffd167888a9e0d';
            $appsecret = 'ec1b3fce8a48166e16fd11eb782cebab';

            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
            $res = json_decode(file_get_contents($url), true);

            $access_token = $res['access_token'];
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen($tokenFile, 'w');
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }

        return $access_token;
    }
    public function startsWith($haystack, $needle) 
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
    public function endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
    return $needle === '' || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
    public static function logChange($t)
    {
        // dd(json_encode($ticket_operation->toArray()));
        if (isset($t['action'])) {
            $log = (new LogModel());
            $log->action = $t['action'];
            $log->operation_id = $t->id;
                // $log->action = $ticket_operation['action'];
                $log->username = Auth::user()->username;
            $log->save();
        }
    }
    //获取array中的某个字段，赋予默认值
    public static function getArrayNumericValue($array = array(), $attribute)
    {
        if (isset($array[$attribute]) && is_string($array[$attribute])) {
            $array[$attribute] = (int) $array[$attribute];
        }

        return (isset($array[$attribute]) && is_numeric($array[$attribute])) ? $array[$attribute] : 0;
    }

    public static function getArrayDoubleOrIntValue($array = array(), $attribute)
    {
        if (isset($array[$attribute]) && is_string($array[$attribute])) {
            $array[$attribute] = $array[$attribute];
        }

        return (isset($array[$attribute]) && is_numeric($array[$attribute])) ? $array[$attribute] + 0 : 0;
    }

    public static function getArrayArrayValue($array = array(), $attribute)
    {
        if (isset($array[$attribute])) {
            if (is_array($array[$attribute])) {
                return $array[$attribute];
            } else {
                return self::convertToArray($array[$attribute]);
            }
        } else {
            return array();
        }
    }

    public static function getNumeric($val)
    {
        if (is_numeric($val)) {
            return $val + 0;
        }

        return 0;
    }

    public static function getArrayStringValue($array = array(), $attribute, $filter = true, $filter_empty = false, $filter_time = false)
    {
        $value = (isset($array[$attribute])) && !is_array($array[$attribute]) && !is_object($array[$attribute]) ? (string) $array[$attribute] : '';
        if ($filter) {
            $value = e($value);
        }
        //针对日期特殊处理
        if (((ends_with($attribute, '_date') || ends_with($attribute, '_at')) && $filter_time) || ($value == '' && $filter_empty)) {
            $value = null;
        }

        return $value;
    }

    public static function getArrayStringValueOrDefault($array = array(), $attribute, $default = '')
    {
        $value = (isset($array[$attribute])) && is_string($array[$attribute]) ? (string) $array[$attribute] : $default;

        return $value;
    }

    // 针对日期进行处理，负时区的需要进一天，正时区要去某天时间
    public static function getMongoArrayStringValue($array = array(), $attribute, $filter = true)
    {
        $value = (isset($array[$attribute])) ? $array[$attribute] : '';

        //针对日期特殊处理
        if ((ends_with($attribute, 'date') || ends_with($attribute, '_at'))) {
            if (is_string($value)) {
                return new MongoDate(strtotime($value));
            } else {
                return $value;
            }
        }

        return $value;
    }

    public static function isEmptyString($value)
    {
        if ($value == '' && is_string($value)) {
            return true;
        }

        return false;
    }

    public static function getArrayBooleanValue($array = array(), $attribute)
    {
        return (isset($array[$attribute]) && is_bool($array[$attribute]) && $array[$attribute]) ? true : false;
    }

    //这样就可以接受单个输入的参数，也可以接受一组，就可以批量操作了
    public static function convertToArray($array)
    {
        if (!is_array($array)) {
            if ($array) {
                $array = array($array);
            } else {
                return [];
            }
        }

        return $array;
    }

    //为图片随机产生文件名字
    public static function getFileName($image)
    {
        return date('His').'_'.strtolower(str_random(5)).'.'.$image->getClientOriginalExtension();
    }

    //打印执行过的sql用于排错
    public static function printSqlLog($connection = null)
    {
        if ($connection) {
            $queries = \DB::connection($connection)->getQueryLog();
        } else {
            $queries = \DB::getQueryLog();
        }
        Log::info($queries);
        $sqls = array();
        $time = 0;
        foreach ($queries as $query) {
            // 处理方法参考 http://stackoverflow.com/a/25183270/1373875
            $sql = $query['query'];
            foreach ($query['bindings'] as $val) {
                $sql = preg_replace('/\?/', "'{$val}'", $sql, 1);
            }
            $sqls[] = $sql;
            $sqls[] = $query['time'];
            $time += $query['time'];
        }
        $sqls['total_time'] = $time.'s';
        Log::info($sqls);
        dd($sqls);
        die();
    }

    //获得当前时间
    public static function getTime()
    {
        return date('Y-m-d H:i:s');
    }

    //获得当前用户id
    public static function getID()
    {
        //return 1; //现在先统一返回1，方便测试
        return Auth::id();
    }

    //抛出错误
    public static function throwError($error_message = '')
    {
        throw new CustomedException($error_message);
    }

    //抛出确认信息。。
    public static function throwConfirm($error_message = '')
    {
        App::abort(422, $error_message);
        // throw new CustomedException($error_message, 409);
    }

    //获得月份，年份或者天
    public static function getTimePart($date, $part = 'year')
    {
        $time = strtotime($date);

        //without leading zeros to fit mysql's month function
        if ($part == 'month') {
            return date('n', $time);
        }
        if ($part == 'year') {
            return date('Y', $time);
        }
        if ($part == 'day') {
            return date('j', $time);
        }
        self::throwError(trans('miscellaneous.invalid_format'));
    }

    public static function dd($array = array())
    {
        echo json_encode($array);
        die();
    }

    //根据语言来获得具体的文字，取名字为d就是少打一点字。。。
    public static function d($name = '', $param = array())
    {
        $lang = self::getLang();
        if (in_array($lang, BaseModel::$language_conversion)) {
            return Lang::get($name, $param, array_search($lang, BaseModel::$language_conversion));
        }

        return Lang::get($name, array(), 'en');
    }

    public static function isEmpty($string)
    {
        return (!$string || $string == '') ? true : false;
    }

    //抽取tag，并且换成对应的格式，产品详情那里需要的
    public static function formatDescription($data, $var = '')
    {
        preg_match_all('~<'.$var.'>(.*)</'.$var.'>~Ui', $data, $domains);
        $result = $domains[1];
        if (!count($result)) {
            return '';
        }

        return array_pop($result);
    }

    //对多个字段合并为一个字段
    public static function getDescription($description, $data, $var = '')
    {
        $description = $description.'<'.$var.'>'.self::getArrayStringValue($data, $var, false).'</'.$var.'>';

        return $description;
    }

    //获取所有id，针对category的
    public static function getAllIDs($category)
    {
        $result = array();
        self::getRecursiveID($category, $result);

        return $result;
    }
    private static function getRecursiveID($category, &$result)
    {
        $result[] = $category->id;
        foreach ($category->recursive_children as $category_child) {
            self::getRecursiveID($category_child, $result);
        }

        return $result;
    }

    //检查是否符合日期格式
    public static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }
    //检查是否符合电邮格式
    public static function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
    //用于提取省略，获取前面N个字符
    public static function extract($string, $length = 5, $tail = '...')
    {
        return mb_strimwidth("$string", 0, $length, $tail);
    }
    //判断是否为mobile
    public static function isMobile()
    {
        $tablet_browser = 0;
        $mobile_browser = 0;

        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower(self::getArrayStringValue($_SERVER, 'HTTP_USER_AGENT')))) {
            ++$tablet_browser;
        }

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower(self::getArrayStringValue($_SERVER, 'HTTP_USER_AGENT')))) {
            ++$mobile_browser;
        }

        if ((strpos(strtolower(self::getArrayStringValue($_SERVER, 'HTTP_ACCEPT')), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            ++$mobile_browser;
        }

        $mobile_ua = strtolower(substr(self::getArrayStringValue($_SERVER, 'HTTP_USER_AGENT'), 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-', );

        if (in_array($mobile_ua, $mobile_agents)) {
            ++$mobile_browser;
        }

        if (strpos(strtolower((self::getArrayStringValue($_SERVER, 'HTTP_USER_AGENT'))), 'opera mini') > 0) {
            ++$mobile_browser;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                ++$tablet_browser;
            }
        }

        if ($tablet_browser > 0 || $mobile_browser > 0) {
            return true;
        }

        return false;
    }

    //处理星期
    public static function handleWeekdays(&$input)
    {
        $array = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($array as $day) {
            if (self::getArrayStringValue($input, $day) == $day) {
                $input[$day] = 1;
            } else {
                $input[$day] = 0;
            }
        }
    }

    // 返回一年中所有给定星期几的日期
    public static function handleYearWeeks($product_id, $startday, $endday)
    {
        list($product, $routes, $transportations) = User::getProduct($product_id);
        $product = $product->toArray();
        // 判断此产品周几有出发
        $weekdays = [];
        foreach (BaseModel::$days as $key) {
            if ($product[$key] != null) {
                $weekdays[$key] = $key;
            }
        }
        $start = new \Carbon();
        $end = new \Carbon();
        if (!$startday) {
            $start = $start->startOfYear();
            $end = $end->endOfYear();
        } else {
            $start = $start->parse($startday);
            $end = $end->parse($endday);
        }
        $tmp = $start;
        $days = array();
        $array = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        while ($tmp->lte($end)) {
            $weekday = $tmp->dayOfWeek;
            if (in_array($array[$weekday], array_keys($weekdays))) {
                // $days[] = $tmp->toDateTimeString();
                $days[$tmp->toDateString()] = $weekdays[$array[$weekday]];
            }
            $tmp->addDay();
        }

        return $days;
    }

    public static function allFrameRefresh()
    {
        $url = URL::route('admin.index');
        echo "<script type='text/javascript'>";
        echo "window.open('$url', '_top');";
        echo '</script>';
    }

    public static function leftmainFrameRefresh($url = 'admin.main')
    {
        $left = URL::route('admin.left');
        $main = URL::route($url);
        echo "<script type='text/javascript'>";
        echo "window.open('$left', 'leftFrame');";
        echo "window.open('$main', 'mainFrame');";
        echo '</script>';
    }
    public static function reloadFrame()
    {
        echo "<script type='text/javascript'>";
        echo 'history.back();';
        echo 'location.reload();';
        echo '</script>';
    }

    public static function checkisphone($phone)
    {
        $pp = "#([^\d\-])#s";
        if (preg_match($pp, $phone)) {
            self::throwError(trans('miscellaneous.phone_format_error'));
        }
    }

    public static function getDayNumberName($number = 0)
    {
        if (User::getLang() == 'English') {
            return (int) $number.'-day Trip';
        } else {
            return (int) $number.'天團';
        }
    }

    public static function getCityName($city = '')
    {
        if (User::getLang() == 'English') {
            return (string) 'Start From '.$city;
        } else {
            return (string) $city.'出發';
        }
    }

    // Returns a file size limit in bytes based on the PHP upload_max_filesize
    // and post_max_size
    public static function file_upload_max_size()
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $max_size = self::parse_size(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        self::throwError(self::d('admin.upload_max', array('size' => $max_size)));
    }

    public static function parse_size($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    public static function findautocompleteid($array, $id)
    {
        foreach ($array as $key => $value) {
            if ($value['id'] == $id) {
                return $key;
            }
        }

        return 0;
    }
    public static function parseArray($array, $item)
    {
        $tmp = array();
        foreach ($array as $value) {
            $tmp[$value] = $item;
        }

        return $tmp;
    }

    public static function getWeekRange($date, $weekday)
    {
        $date_obj = \Carbon::parse($date->toDateTime()->format('Y-m-d'));
        if ($weekday == 'wednesday') {
            $start_date = $date_obj->startOfWeek()->toDateString();
            $end_date = $date_obj->endOfWeek()->toDateString();
        } elseif ($weekday == 'saturday') {
            $start_date = $date_obj->previous(\Carbon::THURSDAY)->toDateString();
            $end_date = $date_obj->next(\Carbon::WEDNESDAY)->toDateString();
        } else {
            self::throwError(self::d('miscellaneous.not_seating'));
        }
        $array = array('start_date' => $start_date, 'end_date' => $end_date);

        return $array;
    }

    // 获取本日之后的今年内所有周三周六日
    public static function getWSDays($start = null, $end = null)
    {
        if ($start) {
            $start = \Carbon::parse($start);
        } else {
            $start = \Carbon::now()->startOfDay();
        }
        // dd($start);
        if ($end) {
            $end = \Carbon::parse($end);
        } else {
            $end = \Carbon::now()->endOfYear();
        }
        $array = [];
        while ($start->lte($end)) {
            if ($start->dayOfWeek == \Carbon::WEDNESDAY || $start->dayOfWeek == \Carbon::SATURDAY) {
                $array[$start->toDateString()] = array('mongo_date' => new MongoDate($start->timestamp), 'weekday' => $start->dayOfWeek);
            }
            $start->addDay();
        }

        return $array;
    }

    public static function curl_get_contents($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    // 获取是时区的差别
    public static function get_timezone_offset($remote_tz, $origin_tz = null)
    {
        if ($origin_tz === null) {
            if (!is_string($origin_tz = date_default_timezone_get())) {
                return false; // A UTC timestamp was returned -- bail out!
            }
        }
        $origin_dtz = new DateTimeZone($origin_tz);
        $remote_dtz = new DateTimeZone($remote_tz);
        $origin_dt = new DateTime('now', $origin_dtz);
        $remote_dt = new DateTime('now', $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);

        return $offset;
    }

    public static function getNextGuestSequence($field)
    {
        return Guest::raw(function ($collection) use ($field) {
            $seq = $collection->findAndModify(
                array('_id' => $field),
                array('$inc' => array('seq' => 1)),
                null,
                array('new' => true, 'upsert' => true)
            );

            return $seq['seq'];
        });
    }

    public static function getNextSequence($field)
    {
        return Counter::raw(function ($collection) use ($field) {
            $seq = $collection->findAndModify(
                array('_id' => $field),
                array('$inc' => array('seq' => 1)),
                null,
                array('new' => true, 'upsert' => true)
            );

            return $seq['seq'];
        });
    }

    public static function count($field, $inc = true, $type = 'Notification')
    {
        $counter = Counter::where('_id', $field)->where('type', $type)->first();
        if (!$counter) {
            $counter = new Counter();
            $counter->_id = $field;
            $counter->type = $type;
            $counter->seq = 0;
            $counter->save();
        }
        ($inc) ? $counter->increment('seq') : $counter->decrement('seq');
    }

    // 根据输入的数字返回一个翻译的房间名和人数的数组
    public static function checkRoomType($num)
    {
        switch ($num) {
        case 1:
            $name = '单人房';
            break;
        case 2:
            $name = '双人房';
            break;
        case 3:
            $name = '三人房';
            break;
        case 4:
            $name = '四人房';
            break;
        case 0.1:
            $name = self::d('admin.single_woman');
            break;
        case 0.01:
            $name = self::d('admin.single_man');
            break;
        }

        return array('name' => $name, 'people_num' => 0);
    }

    //判断某个价格是否在对应的时间段内
    public static function isInTimeRange($priceModel, $start_date)
    {
        if ($start_date >= $priceModel['start_date'] && $start_date <= $priceModel['end_date']) {
            $start_date = \Carbon::createFromTimeStamp($start_date->toDateTime()->getTimestamp());
            //$start_date = \Carbon::parse($start_date);
            foreach (BaseModel::$days as $key => $day) {
                if ($start_date->dayOfWeek == $key + 1 && $priceModel->$day == 'on') {
                    return true;
                }
            }

            return false;
        }
    }

    // 转换textarea 填入的数据， 解决换行的问题
    public static function parseHtmlFormatOfTextArea($value)
    {
        $value = e($value);
        $value = preg_replace('(\\r\\n)', '<br>', $value);

        return $value;
    }

    // 转换下数据库读出来的东西为html的，主要是换行和空格之类的
    public static function parseHtmlFormat($value)
    {
        $value = e($value);
        $value = str_replace('\n', '<br>', $value);

        return $value;
    }

    public static function parseBreakLine($value)
    {
        $value = preg_replace("([\n\r])", '<br>', $value);

        return $value;
    }

    public static function parseExcelFormat($value)
    {
        $value = e($value);
        $value = str_replace('\n', "\n", $value);

        return $value;
    }

    //获得语言
    public static function getLang()
    {
        //$lang = App::getLocale();
        //$lang = Session::get('lang', 'en');
        $lang = Cookie::get('lang', 'en');
        if (isset(BaseModel::$language_conversion[$lang])) {
            return BaseModel::$language_conversion[$lang];
        }

        return 'English';
    }
    //设置语言
    public static function setLang($lang = 'en')
    {
        //App::setLocale($lang);
        //Session::put('lang', $lang);
        //Cookie::forget('lang');
        Cookie::queue('lang', $lang, Config::get('settings.cookie_time'));
    }

    // 为了兼容Ids还是int和string都一起穿进去吧
    public static function parseIdsToStrInt($values)
    {
        $values = (array) $values;
        $ids_int = array_map(function ($value) {return (int) $value;}, $values);
        $ids_string = array_map(function ($value) {return (string) $value;}, $values);
        $values = array_merge($ids_int, $ids_string);

        return $values;
    }
}
