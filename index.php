<?php
//应用常量定义
define("DS",DIRECTORY_SEPARATOR);//斜线(/、\)，根据操作系统决定
define("ROOT_PATH",getcwd().DS);//网站根目录
define("APP_PATH",ROOT_PATH."application".DS);//应用目录、平台目录
//define("PLATFORM",'index');
require_once(ROOT_PATH."earphp".DS."EarPHP.php");
//核心类库
\earphp\EarPHP::run();

