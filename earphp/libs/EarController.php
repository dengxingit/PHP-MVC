<?php
namespace earphp\libs;
use earphp\vendor\Smarty;

/**
 * 基础控制器
 * Class EarController
 * @package earphp\libs
 * @author dengxin
 */
class EarController
{
    //受保护的Smarty对象属性
    protected $smarty = null;

    /**
     * EarController constructor.
     */
    public function __construct()
    {
        $this->initSmarty();
    }
    /**
     * 初始化smarty
     */
    protected function initSmarty()
    {
        //创建Smarty对象，并进行配置
        $smarty = new Smarty();
        $smarty->left_delimiter = "{{";
        $smarty->right_delimiter = "}}";
        $smarty->setTemplateDir(VIEW_PATH);
        $smarty->setCompileDir(sys_get_temp_dir().DS."view_c".DS);
        //给$smarty属性赋值
        $this->smarty = $smarty;
    }

    /**
     * 用于显示模板
     * @param null $tpl_path 模板路径
     */
    public function display($tpl_path = null){
        if(empty($tpl_path)){
           $tpl_path = CONTROLLER."/".ACTION.".".$GLOBALS['config']['default_template_suffix'];
        }else{
            $tpl_path .= ".".$GLOBALS['config']['default_template_suffix'];
        }
        $this->smarty->display($tpl_path);
    }

    /**
     * 分配模板数据
     * @param $key
     * @param $value
     */
    public function assign($key,$value){
        $this->smarty->assign($key,$value);
    }

}