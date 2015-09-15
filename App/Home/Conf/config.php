<?php
return array(
    'DB_TYPE' =>  'mysql',
    'DB_HOST' =>  '120.26.213.172',
    //'DB_HOST' =>  '127.0.0.1',
    'DB_NAME' =>  'foryou',
    'DB_USER' =>  'changyu2015',
    'DB_PWD'  =>  'changyu15',
    'DB_PORT'  =>  '3306',
    'DEFAULT_FILTER'  =>  'htmlspecialchars',
    'DATA_CACHE_TIME'=>60,        //设置缓存时间为60s
    'DB_SQL_BUILD_CACHE' => true,  //开启sql解析缓存
    'DB_SQL_BUILD_LENGTH' => 20, // SQL缓存的队列长度
    //'SHOW_PAGE_TRACE' => true,  //开启调试模式
    'URL_CASE_INSENSITIVE' =>true,   //关闭大小写敏感
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误
    
     'TMPL_EXCEPTION_FILE' => 'Public:error', // 定义公共错误模板
     'TMPL_ACTION_ERROR' => 'Public:error', // 默认错误跳转对应的模板文件
   
    'view_filter' => array('Behavior\TokenBuild'),    //开启表单令牌功能，防止表单的重复提交

     'THINK_EMAIL' => array(            //邮箱验证

       'SMTP_HOST'   => 'smtp.126.com', //SMTP服务器
       'SMTP_PORT'   => '465', //SMTP服务器端口
       'SMTP_USER'   => 'coryphaei@126.com', //SMTP服务器用户名
       'SMTP_PASS'   => 'myymvnopqpqbymfm', //SMTP服务器密码
       'FROM_EMAIL'  => 'coryphaei@126.com', //发件人EMAIL
       'FROM_NAME'   => 'ForU', //发件人名称
       'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
       'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
      
    ), 
);