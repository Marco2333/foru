<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>注册|For优</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/Public/css/style.css" rel="stylesheet"/>	

		<style>
			body {
				background-color: rgba(248,248,248,.9);
			}
		</style>
	</head>
	<body>
		<div class="public-top-layout" style="background-color: #fff">
	<div class="topbar">
		<div class="user-entry"></div>
		<div class="fr">
			<a class="text-special" href="">手机For优</a>
		</div>
		
		<?php if(empty($_SESSION['username'])): ?><div class="quick-menu">
				欢迎光临<span class="text-special">ForU</span>校园超市，请 <a class="text-special" href="<?php echo U('Login/index');?>">登录</a><a class="text-special" href="<?php echo U('Login/register');?>">注册</a>
				<span> </span>
			</div>
			<?php else: ?> 
			<div class="quick-menu">
				尊敬的 &nbsp; <a href="<?php echo U('Person/personhomepage',array('campusId'=>cookie('campusId')));?>"><?php echo (session('nickname')); ?></a> &nbsp;您好,欢迎来到 For优校园超市<a href="<?php echo U('Index/logout');?>" id="log-out">退出</a> <span class="spliter text-special"></span>
			</div><?php endif; ?> 
	</div>
</div>

		<div id="register-logo" class="wrapper clearfix">
			<img src="/Public/img/logo.png"/>
			<span>欢迎注册</span>
		</div>
		<div id="register-main">
			<div id="register-info" class="fl">
				<form id="demoForm" action="/index.php/Home/Login/toRegister" method="post">
					<div class="user-info-div">
						<span class="userinfo-before">用户昵称:</span>
						<div class="fl">
							<input type="text" name="nickname" />
							<span class="glyphicon glyphicon-user userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind"> </span>
					</div>
					<div class="user-info-div">
						<span class="userinfo-before">设置密码:</span>
						<div class="fl">
							<input type="password" name="password" />
							<span class="glyphicon glyphicon-lock userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind">	8-20位字符，建议由数字，字母和符号两种以上组合。 </span>
					</div>
					<div class="user-info-div">
						<span class="userinfo-before">确认密码:</span>
						<div class="fl">
							<input type="password" name="confirm-password" />
							<span class="glyphicon glyphicon-lock userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind">请再次输入密码 </span>
					</div>
					<div id="phone-user-info" class="user-info-div">
						<span class="userinfo-before">手机号码:</span>
						<div class="fl">
							<input type="text" name="phone" />
							<span class="glyphicon glyphicon-phone userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind" name="message"> 请输入中国大陆手机号，可用于登陆和找回密码</span>
					</div>
					<!-- <div id="security-code">
						<span class="userinfo-before">邮箱验证:</span>
						<input type="text" name="security-code" />
						<span class="userinfo-behind"> </span>
						<span id="security-code-img"> </span>
						<button>获取短信验证码</button>
					</div> -->
					<div id="confirmcode" class="user-info-div">
						<span class="userinfo-before">短信验证:</span>
						<div class="fl">
							<input style="font-size: 12px; width:156px" type="text" name="confirmcode" placeholder="请输入收到的验证码"/>
						</div>
						<input type="button" id="resent-secword" value="发送验证码" class="bground-special fl"></button>
						<span class="userinfo-behind" name="message"></span>
					</div>
					<div id="user-protocol">
						<span class="userinfo-before"> </span>
						<input id="user-protocol-input" type="checkbox" name="user_protocol" />
						<span >我已阅读并同意<a href="<?php echo U('Login/protocol');?>">《ForU用户注册协议》</a> </span>
					</div>
					<div>
						<span class="userinfo-before"> </span>
						<input id="button-register" type="submit" name="submit" value="立即注册" />
					</div>
				</form>
			</div>
			<div class="fl">
				<span><a href="login.html">已有账号，返回登录>></a></span>
			</div>
		</div>

		<script type="text/javascript" src="/Public/script/plugins/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="/Public/script/plugins/jquery.validate.js"></script>
		<script type="text/javascript" src="/Public/script/register.js"></script>
	</body>
</html>