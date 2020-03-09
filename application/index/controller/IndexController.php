<?php
namespace application\index\controller;
use application\index\model\UserModel;
use earphp\libs\EarController;

class IndexController extends EarController
{
    public function index(){
        dd("123124");
//        $model = UserModel::getInstance();
//        dd($model->fetchAll());
//        $this->assign("title","你好我是数据显示");
//        $this->display();
    }

    public function add(){
        echo "add";
    }
}