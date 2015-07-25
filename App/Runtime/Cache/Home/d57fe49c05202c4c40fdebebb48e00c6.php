<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/foryou/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/foryou/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/foryou/Public/css/style.css" rel="stylesheet"/>
		<script type="text/javascript" src="/foryou/Public/script/plugins/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="/foryou/Public/script/personinfo.js"></script>
		<script src="/foryou/Public/bootstrap/js/bootstrap.min.js"></script>
		<title>For U</title>
	</head>
	<body data-spy="scroll" data-target="#nav-side">
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
					欢迎光临<span class="text-special">ForU</span>校园超市，请 <a class="text-special" href="<?php echo U('Login/index');?>">登录</a><a class="text-special" href="<?php echo U('Login/register');?>">注册</a>
					<span> </span>
				</div>
				
			</div>
		</div>
		<div id="index-header" >
			<div class="container header-bottom">
				<div id="header-botton-wrapper">
					<div id="log-wrapper" class="fl">
						<div id="header-logo" class="fl">
							<img src="/foryou/Public/img/logo.png" class="fl">
							<span class="text-special fl"><p>For优<br><span class="bold inline-block">为你更好的生活</span></span>
						</div>
						<div id="header-search" class="fl">
							<input name="keyword" type="text" placeholder="请输入要查找的商品">
							<button>
								搜索
							</button>
							<ul>
								<li><a href="">特色零食</a></li>
								<li><a>快递存取</a></li>
								<li><a>家政服务</a></li>
								<li><a>西瓜</a></li>
								<li><a>家政服务</a></li>
								<li><a>水果速递</a></li>
							</ul>
						</div>

						<div id="shopping-cart" class="drop-down" >
							<div class="drop-down-left">
								<img src="/foryou/Public/img/icon/shopping-cart.png" alt="">	
								<a target="_blank" href="">购物车 &gt;&gt;</a>
							</div>
							<div class="drop-down-layer">
								<div class="no-goods"><b></b>						购物车中还没有商品，赶紧选购吧！
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="w bground-special">
				<div id="nav-bar" class="wrapper nav-wrapper">
					<div class="fl">
						全部商品分类
					</div>
					<ul class="nav nav-pills">
						<li>
							<a href="#">主页</a>
						</li>
						<li>
							<a href="#">主题市场</a>
						</li>
						<li>
							<a href="#">优惠活动</a>
						</li>
						<li>
							<a href="">关于我们</a>
						</li>
						<li>
							<a href="">个人中心</a>
						</li>
						<li>
							<img src="/foryou/Public/img/icon/location.png" alt="">
							<select id="location" >
							  	<option value ="volvo">苏州大学独墅湖校区</option>
							  	<option value ="saab">苏州大学阳澄湖校区</option>
							  	<option value="opel">苏州大学本部</option>
							  	<option value="audi">苏州大学东校区</option>
							</select>
						<!-- 	<a href="">苏州大学独墅湖校区</a> -->
						</li>
					</ul>
				</div>
			</div>
			<div id="nav-breadcrumb" class="wrapper">
				<ul class="breadcrumb">
					<li>首页</li>
					<li>我的for优</li>
					<li>个人信息</li>
				</ul>
			</div>
		</div>
		<div class="wrapper clearfix" >
			<div id="person-nav-side">
				<ul>
					<span>我的订单</span>
					<li><a>全部</a></li>
					<li><a>待付款</a></li>
					<li><a>待确认</a></li>
					<li><a>配送中</a></a></li>
					<li><a>已完成</a></li>
				</ul>
				<ul>
					<span>资料管理</span>
					<li><a>个人信息</a></li>
					<li><a>地址管理</a></li>
					<li class="active"><a>账户安全</a></li>
				</ul>
				<ul>
					<span>服务中心</span>
					<li><a>联系客服</a></li>
					<li><a>关于我们</a></li>
					<li><a>意见反馈</a></li>
				</ul>
			</div>
			<div id="person-info-body">
				<div class="info-title">
					个人信息
				</div>
				<div class="tab-div">
					<button id="tab-1" class="active">
						基本资料
					</button>
					<button id="tab-2">
						更换头像
					</button>
				</div>
				<div id="person-basic-info">
					<div class="person-info-div clearfix" >
						<span class="personinfo-before">昵称:</span>
						<div class="fl">
							<input type="text" name="nick-name" />
						</div>
					</div>
					<div class="person-info-div clearfix" >
						<span class="personinfo-before">性别:</span>
						<div class="fl">
							<input type="radio" name="user-sex" /><label>男</label>
							<input type="radio" name="user-sex" /><label>女</label>
						</div>
					</div>
					<div class="person-info-div clearfix" >
						<span class="personinfo-before">学院:</span>
						<div class="fl">
							<input type="text" name="academy" />
						</div>
					</div>
					<div class="person-info-div clearfix" >
						<span class="personinfo-before">QQ号:</span>
						<div class="fl">
							<input type="text" name="qq-num" />
						</div>
					</div>
					<div class="person-info-div clearfix" >
						<span class="personinfo-before">微信号:</span>
						<div class="fl">
							<input type="text" name="weixin-num" />
						</div>
					</div>
					<div class="person-info-div clearfix" >
						<span class="personinfo-before"></span>
						<div class="fl">
							<input type="submit" name="weixin-num" />
						</div>
					</div>
				</div>
				<div id="change-image-wrapper" class="none">	
					<div id="change-image" class="clearfix">
						<div class="fl">
							<dl>
								<dd>当前头像</dd>
								<dt>
									<img src="/foryou/Public/img/headimage.png" alt="">
								</dt>
							</dl>
							<a href="javascript:;" class="file">
								选择上传的头像
							    <input type="file" name="" id="">
							</a>
						</div>
						<div class="fl">
							<dl>
								<dd>预览效果</dd>
								<dt>
									<img src="/foryou/Public/img/headimage.png" alt="">
								</dt>
								<span>
									*照片尺寸需要大于250*250像素，请使用JPG、GIF、JPEG、BMP格式图片，文件不要超过4M
								</span>
							</dl>
						</div>
					</div>
					<input type="submit" value="保存">
				</div>
			</div>
		</div>
		<footer>
			<div id="foot-part1" class="clearfix wrapper">
				<ul>
					<li>
						<dl>
							<dd><img src="/foryou/Public/img/footer/footer1.png" alt=""></dd>
							<dt>
								<div>正品保障</div>
								<div>全场正品，行货保障</div>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foryou/Public/img/footer/footer2.png" alt=""></dd>
							<dt>
								<div>新手指南</div>
								<div>快速登录，无需注册</div>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foryou/Public/img/footer/footer3.png" alt=""></dd>
							<dt>
								<div>货到付款</div>
								<div>货到付款，安心便捷</div>
							</dt>
						
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foryou/Public/img/footer/footer4.png" alt=""></dd>
							<dt>
								<div>维修保障</div>
								<div>服务保证，全国联保</div>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foryou/Public/img/footer/footer5.png" alt=""></dd>
							<dt>
								<div>无忧退货</div>
								<div>无忧退货，7日尊享</div>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foryou/Public/img/footer/footer6.png" alt=""></dd>
							<dt>
								<div>会员权益</div>
								<div>会员升级，尊贵特权</div>
							</dt>
						</dl>
					</li>
				</ul>
			</div>
			<div id="foot-part2" class="clearfix wrapper">
				<ul>
					<li>
						<dl>
							<dd>常用服务</dd>
							<dt>
								<ul>
									<li><a>问题咨询</a></li>
									<li><a>催办订单</a></li>
									<li><a>报修退换货</a></li>
									<li><a>上门安装</a></li>
								</ul>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd>购物</dd>
							<dt>
								<ul>
									<li><a>怎样购物</a></li>
									<li><a>积分优惠券介绍</a></li>
									<li><a>订单状态说明</a></li>
									<li><a>易迅礼品卡介绍</a></li>
								</ul>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd>付款</dd>
							<dt>
								<ul>
									<li><a>货到付款</a></li>
									<li><a>在线支付</a></li>
									<li><a>其他支付方式</a></li>
									<li><a>发票说明</a></li>
								</ul>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd>配送</dd>
							<dt>
								<ul>
									<li><a>配送服务说明</a></li>
									<li><a>价格保护</a></li>
								</ul>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd>售后</dd>
							<dt>
								<ul>
									<li><a>售后服务政策</a></li>
									<li><a>退换货服务流程</a></li>
									<li><a>优质售后服务</a></li>
									<li><a>特色服务指南</a></li>
									<li><a>服务时效承诺</a></li>
								</ul>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd>商家合作</dd>
							<dt>
								<ul>
									<li><a>企业采购</a></li>
								</ul>
							</dt>
						</dl>
					</li>
				</ul>
			</div>
			<div id="foot-part4" class="clearfix">
				<a>易迅简介</a>|<a>易迅公告</a>|招贤纳士<a>|<a>联系我们</a>|客服热线: 00-828-1878
			</div>
		</footer>
	</body>
</html>