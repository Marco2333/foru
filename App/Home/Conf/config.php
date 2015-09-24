<?php
return array(
    'DB_TYPE' =>  'mysql',
    'DB_PORT'  =>  '3306',
     'DB_HOST' =>  '127.0.0.1',
    'DB_NAME' =>  'foru',
    'DB_USER' =>  'root',
    'DB_PWD'  =>  '',
   // 'SHOW_PAGE_TRACE' => true,  //开启调试模式
    'URL_CASE_INSENSITIVE' =>true,   //关闭大小写敏感
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误

    'view_filter' => array('Behavior\TokenBuild'),    //开启表单令牌功能，防止表单的重复提交

     'THINK_EMAIL' => array(

        //qq邮箱验证通过
      /* 'SMTP_HOST'   => 'smtp.exmail.qq.com', //SMTP服务器
       'SMTP_PORT'   => '465', //SMTP服务器端口
       'SMTP_USER'   => 'zhihao@silverhand.cn', //SMTP服务器用户名
       'SMTP_PASS'   => 'zc0829.', //SMTP服务器密码
       'FROM_EMAIL'  => 'zhihao@silverhand.cn', //发件人EMAIL
       'FROM_NAME'   => 'foryou,专属于您的线上超市', //发件人名称
       'REPLY_EMAIL' => 'zhihao@silverhand.cn', //回复EMAIL（留空则为发件人EMAIL）
       'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）*/

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

