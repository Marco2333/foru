<?php
return array(
    'DB_TYPE' =>  'mysql',
    'DB_HOST' =>  '120.26.213.172',
    'DB_NAME' =>  'foryou',
    'DB_USER' =>  'changyu2015',
    'DB_PWD'  =>  'changyu15',
    'DB_PORT'  =>  '3306',
    'SHOW_PAGE_TRACE' => true,  //开启调试模式

    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误

    'view_filter' => array('Behavior\TokenBuild'),    //开启表单令牌功能，防止表单的重复提交
);