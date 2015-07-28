<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/foru/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/foru/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/foru/Public/css/style.css" rel="stylesheet"/>
		<script type="text/javascript" src="/foru/Public/script/plugins/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="/foru/Public/script/locamanage.js"></script>
		<script src="/foru/Public/bootstrap/js/bootstrap.min.js"></script>
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
							<img src="/foru/Public/img/logo.png" class="fl">
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
								<img src="/foru/Public/img/icon/shopping-cart.png" alt="">	
								<a target="_blank" href="">购物车 &gt;&gt;</a>
							</div>
							<div class="drop-down-layer">
								<div class="no-goods"><b></b>								购物车中还没有商品，赶紧选购吧！
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
							<img src="/foru/Public/img/icon/location.png" alt="">
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
					<li class="active"><a>地址管理</a></li>
					<li><a>账户安全</a></li>
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
					地址管理
				</div>
				<div id="person-location-info">
					<table>
						<colgroup>
							<col width="300">
							<col width="350">
							<col width="250">
						</colgroup>
						<thead>
							<tr>
								<th>收货人</th>
								<th>地址</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
									<td>
										收货人：<?php echo ($v['name']); ?><p>
										联系电话：<?php echo ($v['phone_id']); ?>
									</td>
									<td><?php echo ($v['address']); ?></td>
									<td>
										<!-- <form action="<?php echo U('Person/deleteAddress');?>" method=post> -->
										
										<button class="revise-button">修改</button>
										<button class="delete-button">删除地址</button>
										<input class="phone-none none" value="<?php echo ($v["phone"]); ?>"> 
										<input class="rank-none none"  value="<?php echo ($v["rank"]); ?>"> 	
										<!-- </form> -->
									</td>
									
								</tr><?php endforeach; endif; ?>

							<!-- <tr>
								<td>
									收货人：包彬彬<p>
									联系电话：18625210240
								</td>
								<td>江苏省 工业园区 同源新花园10栋402室</td>
								<td>
									<button>修改</button>
									<button>删除地址</button>
								</td>							
							</tr>			 -->
						</tbody>
					</table>
					<!-- <form action="<?php echo U('Person/addOrReviseButton');?>" method=post> -->
						<button onclick="addAddress();" id="add-location">
							新增收货地址
						</button>
					<!-- </form> -->
				</div>
				<form id="receiver_form" action="<?php echo U('Person/addOrReviseSave');?>" method='post'>
					<div id="change-location" class="none">
						<div id="change-location-info">
							<div class="location-info-div clearfix" >
								<span class="locationinfo-before">收货人:</span>
								<div class="fl">
									<input type="text" id="userName" name="user-name" />
								</div>
							</div>
							<div class="location-info-div clearfix">
								<span class="locationinfo-before">选择地址:</span>
								<div class="fl">
									<select id="location1" name="select-location-1">
									  	<option value ="volvo">Volvo</option>
									  	<option value ="saab">Saab</option>
									  	<option value="opel">Opel</option>
									  	<option value="audi">Audi</option>
									</select>
									<select id="location2" name="select-location-2">
									  	<option value ="volvo">Volvo</option>
									  	<option value ="saab">Saab</option>
									  	<option value="opel">Opel</option>
									  	<option value="audi">Audi</option>
									</select>
									<select id="location3" name="select-location-3">
									  	<option value ="volvo">Volvo</option>
									  	<option value ="saab">Saab</option>
									  	<option value="opel">Opel</option>
									  	<option value="audi">Audi</option>
									</select>
								</div>
							</div>
							<div class="location-info-div clearfix">
								<span class="locationinfo-before">详细地址:</span>
								<div class="fl">
									<input type="text" id="detailedLoc" name="detailed-location" />
								</div>
							</div>
							<div class="location-info-div clearfix">
								<span class="locationinfo-before">手机号:</span>
								<div class="fl">
									<input type="text" id="phoneNum" name="phone-number" />
								</div>
							</div>

							<div class="location-info-div clearfix">
								<span class="locationinfo-before"></span>
								<div class="fl">
									<input type="text" id="page" name="page" value="0" class="none"/>
									<input type="submit" name="submit-location-info" value="保存" id="recevier_submit_button" class="" />
									<input type="submit" name="submit-location-info" value="保存" id="recevier_submit_button_revise" class="none" />
									<!-- <input id="phone-none" class="phone-none none" value=""> 
									<input id="rank-none" class="rank-none none"  value="">  -->
									<!-- <input id="userName-none" class="userName-none none" value=""> 
									<input id="location-none" class="location-none none" value="">
									<input id="phoneNum-none" class="phoneNum-none none" value=""> -->
									<input type="button" onclick="cancel();" value="取消" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<footer>
			<div id="foot-part1" class="clearfix wrapper">
				<ul>
					<li>
						<dl>
							<dd><img src="/foru/Public/img/footer/footer1.png" alt=""></dd>
							<dt>
								<div>正品保障</div>
								<div>全场正品，行货保障</div>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foru/Public/img/footer/footer2.png" alt=""></dd>
							<dt>
								<div>新手指南</div>
								<div>快速登录，无需注册</div>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foru/Public/img/footer/footer3.png" alt=""></dd>
							<dt>
								<div>货到付款</div>
								<div>货到付款，安心便捷</div>
							</dt>
						
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foru/Public/img/footer/footer4.png" alt=""></dd>
							<dt>
								<div>维修保障</div>
								<div>服务保证，全国联保</div>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foru/Public/img/footer/footer5.png" alt=""></dd>
							<dt>
								<div>无忧退货</div>
								<div>无忧退货，7日尊享</div>
							</dt>
						</dl>
					</li>
					<li>
						<dl>
							<dd><img src="/foru/Public/img/footer/footer6.png" alt=""></dd>
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