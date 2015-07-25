<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>注册|ForU</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/foryou/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/foryou/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/foryou/Public/css/style.css" rel="stylesheet"/>
		<script src="/foryou/Public/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/foryou/Public/script/plugins/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="/foryou/Public/script/plugins/jquery.validate.js"></script>
		<script type="text/javascript" src="/foryou/Public/script/register.js"></script>
		<style>
			body {
				background-color: rgba(248,248,248,.9);
			}
		</style>
	</head>
	<body>
		<div class="public-top-layout" style="background-color: #fff">
			<div class="topbar">
				<div class="user-entry">
					<span class="glyphicon glyphicon-headphones"> </span>
					<span>(86)18896551234</span>
					<span>(Mon- Fri: 09.00 - 21.00)</span>
				</div>
				<div class="fr">
					<a class="text-special" href="">手机For优</a>
				</div>
				<div class="quick-menu">
					欢迎光临<span class="text-special"><a href="<?php echo U('Index/index');?>">For优</a></span>校园超市，请 <a class="text-special" href="login.html">登录</a><a class="text-special" href="register.html">注册</a>
					<span> </span>
				</div>		
			</div>
		</div>
		<div id="register-logo" class="wrapper clearfix">
			<img src="/foryou/Public/img/logo.png"/>
			<span>欢迎注册</span>
		</div>
		<div id="register-main">
			<div id="register-info" class="fl">
				<form id="demoForm" action="/foryou/index.php/Home/Login/toRegister" method="post">
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
							<input type="text" name="password" />
							<span class="glyphicon glyphicon-lock userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind">	6-12位字符，建议由数字，字母和符号两种以上组合。 </span>
					</div>
					<div class="user-info-div">
						<span class="userinfo-before">确认密码:</span>
						<div class="fl">
							<input type="text" name="confirm-password" />
							<span class="glyphicon glyphicon-lock userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind">请再次输入密码 </span>
					</div>
					<div class="user-info-div">
						<span class="userinfo-before">手机号码:</span>
						<div class="fl">
							<input type="text" name="phone" />
							<span class="glyphicon glyphicon-phone userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind"> 请输入中国大陆手机号，可用于登陆和找回密码</span>
					</div>
					<div id="security-code">
						<span class="userinfo-before">短信验证:</span>
						<input type="text" name="security-code" />
						<!-- <span class="userinfo-behind"> </span> -->
						<!-- <span id="security-code-img"> </span> -->
						<button>获取短信验证码</button>
					</div>
					<div id="user-protocol">
						<span class="userinfo-before"> </span>
						<input id="user-protocol-input" type="checkbox" name="user-protocol" />
						<span >我已阅读并同意<a>《ForU用户注册协议》</a> </span>
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
	</body>
</html>