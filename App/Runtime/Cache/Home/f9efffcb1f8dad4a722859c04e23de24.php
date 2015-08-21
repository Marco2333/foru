<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>请登录|ForU</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/Public/css/style.css" rel="stylesheet"/>

		<style>
			body {
				background-color: rgba(250,250,250,.9);
			}
		</style>
	</head>
	<body>
	    <div id="info"></div>
		<div class="wrapper">
			<div id="login-top">
				<div class="fl">
					<a href="<?php echo U('/Home/Index/Index');?>"><img src="/Public/img/logo.png" /></a>
					<a href="<?php echo U('/Home/Index/Index');?>"><span class="text-special"> For优 </span></a> <span>您的专属校园超市</span>
				</div>
				<!-- <div class="fr">
					<span><span class="glyphicon glyphicon-thumbs-up"> </span>最廉价的商品 </span>
					<span><span class="glyphicon glyphicon-heart"> </span>最周到的服务 </span>
					<span>欢迎您的加入 </span>
				</div> -->
			</div>
			<div id="login-main">
				<div class="fl">
					<img src="/Public/img/login-show.png" />
					<div>为你，为更好地生活</div>
				</div>
				<div class="fr">
					<h1>For优会员</h1>
					<div class="user-info-div">
						<div class="fl">
							<input id="username" class="user-info" type="text" name="username" placeholder="请输入手机号"/>
							<span class="glyphicon glyphicon-user userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind"> </span>
					</div>
					<div class="user-info-div">
						<div class="fl">
							<input id="userpassword" class="user-info" type="password" name="password" placeholder="密码" />
							<span class="glyphicon glyphicon-lock userinfo-logo"> </span>
						</div>
						<span class="userinfo-behind"> </span>
					</div>
					<div id="security-code">
						<input type="text" name="verify" placeholder="验证码"/>
						<span id="security-code-img"><img src=" /index.php/Home/Login/verify/id/'+Math.random()" onclick="this.src='/index.php/Home/Login/verify/id/'+Math.random()"/> </span><!-- <span><a >看不清，换一张</a> </span> -->
					</div>
					<div id="remember-password-div">
						<input id="ck_rmbUser" class="fl" type="checkbox" name="remember-password" />
						<span class="fl">记住密码</span>
						<span id="forget-password" class="fr"><a>忘记密码</a><span class="spliter"> </span><a href="<?php echo U('Login/register');?>">立即注册</a> </span>
					</div>
					<div class="fl">
						<button id="button-login" onclick="login();">
							立即登录
						</button>
					</div>
				</div>
			</div>
		</div>
	    <script type="text/javascript">
             var toLoginUrl="<?php echo U('/Home/Login/toLogin');?>";
             var  toIndexUrl="<?php echo U('/Home/Index/index');?>";
	    </script>
		<script type="text/javascript" src="/Public/script/plugins/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="/Public/script/plugins/jquery.cookie.js"></script>
		<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/Public/script/login.js"></script>
	</body>
</html>