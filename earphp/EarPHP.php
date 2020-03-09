<?php

namespace earphp;

use earphp\libs\EarController;

/**
 * Class EarPHP
 * @package earphp
 * @author dengxin
 */
class EarPHP
{
    public static function run(){
        self::initCharset();   //初始化字符集
        self::initPhpErr();    //初始化错误显示方式
        self::initConfig();    //初始化配置文件
        self::initFunction();  //初始化核心方法
        self::initRoute();     //解析URL路由参数
        self::initConst();     //初始化目录常量
        self::initAutoLoad();  //注册类的自动加载
        self::initDispatch();  //请求分发
    }

    /**
     * 设置字符集，开启session
     */
    private static function initCharset(){
        header("content-type:text/html;charset=utf-8");
        //开启SESSION会话
        session_start();
    }

    /**
     * 设置php错误显示方式
     */
    private static function initPhpErr(){
        //修改PHP的脚本级配置：是否显示错误
        ini_set("display_errors","on");
        //修改PHP的脚本配置：显示的错误等级
        ini_set("error_reporting",E_ALL | E_STRICT);
    }

    /**
     * 初始化引入配置文件信息
     */
    private static function initConfig(){
        $GLOBALS["config"] = require_once(ROOT_PATH."config".DS."config.php");
    }

    /**
     * 加载核心方法库
     */
    private static function initFunction(){
        require_once(ROOT_PATH."earphp".DS."function.php");
    }

    /**
     * 初始化路由参数
     */
    private static function initRoute()
    {
        //截取路由信息
        $REQUEST_URI = strpos($_SERVER['REQUEST_URI'], '?') === false ?
            $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'],0, strpos($_SERVER['REQUEST_URI'], '?'));
        $ROUTE = array_filter(explode("/",$REQUEST_URI));
        $p = isset($ROUTE[1]) ? $ROUTE[1] : $GLOBALS['config']['default_platform'];
        $c = isset($ROUTE[2]) ? $ROUTE[2] : $GLOBALS['config']['default_controller'];
        $a = isset($ROUTE[3]) ? $ROUTE[3] : $GLOBALS['config']['default_action'];
        define("PLAT",$p);
        define("CONTROLLER",$c);
        define("ACTION",$a);
    }

    /**
     * 初始化静态常量
     */
    private static function initConst()
    {
        define("EAR_PATH",ROOT_PATH."earphp".DS); //目录
        define("VIEW_PATH",APP_PATH.PLAT.DS."view".DS); //View目录
    }

    /**
     * 私有的静态类加载
     */
    private static function initAutoLoad()
    {
        spl_autoload_register(function($className){
            $filename = ROOT_PATH.str_replace("\\",DS,$className).".php";
            //判断类文件是否存在，如果存在，则加载
            if(file_exists($filename)) require_once($filename);
        });
    }

    /**
     * 私有的静态的分发路由
     */
    private static function initDispatch()
    {
        //构建类的完全路径
        $c = "\\application\\".PLAT."\\Controller\\".ucfirst(strtolower(CONTROLLER))."Controller";
        //创建控制器对象
        $controllerObj = new $c();
        //根据用户不同的动作，调用不同的方法
        $a = ACTION;
        $controllerObj->$a();
    }
}