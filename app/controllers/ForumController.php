<?php
/**
 *
 */
class ForumController extends BaseController
{
    public function index()
    {
        $articles = Articles::all();
        $users = User::all();
        return View::make('forum.index')
        ->with('articles', $articles);
    }

    public function create()
    {
        return View::make('forum.create');
    }

    public function save()
    {  
        $rules = [  
            'title'   => 'required|max:100',  
            'content' => 'required',   
        ];  
        
        
        $validator = Validator::make(Input::all(), $rules);
        $param = Input::all();
        // dd($_FILES);
        $num = sizeof($_FILES['files']['name']);
        $name = array();
        $typeArr = array();
        for($x = 0; $x<$num; $x++){
            $typeArr[$x] = explode("/", $_FILES['files']['type'][$x]);
            $name[$x] = explode(".", $_FILES['files']['name'][$x]);
        }
        if ($validator->passes()) {  
            $addTags = Utility::getArrayArrayValue($param, 'tag');
            $article = (new Articles)->createFill($param);
            $c = empty($article->tags) ? [] : $article->tags; 
            if(!empty($addTags)){
                foreach($addTags as $key=>$value){
                    $c[] = $value;
                } 
            }
            $i = empty($article->images) ? [] : $article->images;
            
            // dd($num);

            for($x = 0; $x<$num; $x++){
                if(isset($typeArr[$x][1])){
                    $imgname = "public/Images/".time().$name[$x][0].".".$typeArr[$x][1];
                    $i[] = $imgname;
                    $bol = move_uploaded_file($_FILES['files']['tmp_name'][$x], $imgname);
                    // dd($_FILES['files']['tmp_name'][0]);
                }
            }
            $article->images = $i;
            $article->tags = $c;
            $article->auth = Auth::user()->username;  
            $article->title = Input::get('title');
            $article->content = Input::get('content');
            $article->id = Utility::getNextSequence('id');
            $article->create_time = Carbon::now()->toDateTimeString(); 
            $article->save();   
            return Redirect::to('/forum/index');  
        } else {  
            return Redirect::to('/forum/create');  
        }  
    }

    public function show($id)
    {
        $article= Articles::where('_id', $id)->first();
        return View::make('forum.article_show')
        ->with('article',$article);
    }


    public function edit($id)
    {

        $article= Articles::where('_id', $id)->first();
       
        return View::make('forum.article_edit')
        ->with('article',$article);


    }

    public function editsave($id)
    {  
        $rules = [  
            'title'   => 'required|max:100',  
            'content' => 'required',   
        ];  
        $validator = Validator::make(Input::all(), $rules);
        $param = Input::all(); 
        //旧的 pics
        $imgs = Utility::getArrayArrayValue($param, 'Img_');
        $numOfOld = sizeof($imgs);
        // 新的
        $new = sizeof($_FILES['files']['name']);
        $name = array();
        $typeArr = array();
        for($x = 0; $x<$new; $x++){
            $typeArr[$x] = explode("/", $_FILES['files']['type'][$x]);
            $name[$x] = explode(".", $_FILES['files']['name'][$x]);
        }
        if ($validator->passes()) {  
            $addTags = Utility::getArrayArrayValue($param, 'tag');
            $article = Articles::where('_id', $id)->first();
            // tags处理
            $c = []; 
            if(!empty($addTags)){
                foreach($addTags as $key=>$value){
                    $c[] = $value;
                } 
            }
            // dd($c);
            $article->tags = $c;
            // 图片处理
            $i = [];
            for($x = 0; $x<$numOfOld; $x++){
                $location = $param['Img_'][$x]['name'];
                $i[] = $location;
            }
            for($x = 0; $x<$new; $x++){
                $imgname = "public/Images/".time().$name[$x][0].".".$typeArr[$x][1];
                // dd($imgname);
                $i[] = $imgname;
                $bol = move_uploaded_file($_FILES['files']['tmp_name'][$x], $imgname);
                // dd($_FILES['files']['tmp_name'][0]);
            }
            $article->images = $i;
            $article->title = Input::get('title');
            $article->content = Input::get('content');
            $article->create_time = Carbon::now()->toDateTimeString(); 
            $article->save();   
            return Redirect::to('/forum/index');  
        } else {  
            return Redirect::to('/forum/article/'.$article['_id'].'/edit');  
        }  
        
    }



    public function delete($id)
    {  
        DB::table('Articles')->where('_id', '=', $id)->delete();
        // $article = Articles::where('_id', $id)->first()->delete();


// dd($article);
        return Redirect::to('/forum/index'); 
    }
    public function uploadImage()
    {
        // var_dump(json_encode($_FILES));
        // print_r($_FILES);
        $file = $_FILES['img'];
        // dd($file);
        //error 0 or 1
        if($file['error'] == 0){
            //成功
            // 判断传输的文件是否是图片，类型是否合适
            // 获取传输的文件类型
            $typeArr = explode("/", $file["type"]);
            if($typeArr[0] == 'image'){
                //如果是图片类型
                $imgType = array('png', 'jpg', 'jpeg');
                if(in_array($typeArr[1], $imgType)){// 图片格式是数组中的一个
                    //类型检查好后保存到文件夹内 并且给文件定一个新的名字（用时间戳 防止重复）
                    $imgname = "Images/".time().".".$typeArr[1];
                    //将上传文件写入文件夹中
                    // 参数1: 图片在服务器缓存地址
                    // 参数2: 图片中的目的地址（最终保存位置）
                    // 最终回返回一个布尔值
                    $bol = move_uploaded_file($file['tmp_name'], $imgname);
                    if($bol){
                        echo "<script type=\"text/javascript\">
            alert('上传成功');
            </script>";

                    } else {
                        echo "<script type=\"text/javascript\">
            alert('上传失败');
            </script>";
                    }
                }
            } else {
                // 不是图片类型
                echo "<script type=\"text/javascript\">
            alert('上传的文件非图片类型');
            </script>";
            }
        } else {
            echo '<script type=\"text/javascript\">
            var error = $file["error"];
            alert(error);
            </script>';
        }
        return Redirect::to('forum/create');
    }
}
