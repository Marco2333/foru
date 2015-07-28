<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/foru/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/foru/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/foru/Public/css/style.css" rel="stylesheet"/>
		<script type="text/javascript" src="/foru/Public/script/plugins/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="/foru/Public/script/goodsPayment.js"></script>
		<script src="/foru/Public/bootstrap/js/bootstrap.min.js"></script>
		
		<!--li-->
		<link rel="stylesheet" href="/foru/Public/css/style_li.css" />
		<!-- // <script type="text/javascript" src="/foru/Public/script/pay_li.js"></script> -->
	</head>
	<body data-spy="scroll" data-target="#nav-side">
		<div class="public-top-layout" style="background-color: #fff">
			<div class="topbar">
				<!-- <div class="user-entry">
					<span class="glyphicon glyphicon-headphones"> </span>
					<span>(86)18896551234</span>
					<span>(Mon- Fri: 09.00 - 21.00)</span>
				</div> -->
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
			<!-- <form action="<?php echo U('Person/payAtOnce');?>" method="POST"> -->
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
									<div class="no-goods"><b></b>							购物车中还没有商品，赶紧选购吧！
								
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
								<a href="#">首页</a>
							</li>
							<li>
								<a href="#">小优推荐</a>
							</li>
							<li>
								<a href="#">最新体验</a>
							</li>
							<li>
								<a href="">特惠秒杀</a>
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
						<li>购物车</li>
						<li>确认订单</li>
					</ul>
				</div>
			
				<!--li-->
				
				<div id="addressColumn" class="wrapper main-wrapper-1">
					<table>
						<colgroup>
							<col style="width: 300px;"/>
							<col style="width: 600px;"/>
							<col style="width: 200px;"/>
						</colgroup>
						<thead>
							<tr>
								<th colspan="3">收货信息</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($address)): foreach($address as $key=>$v): ?><tr>
									<td>
										<input type="radio" name="information" value="<?php echo ($v["rank"]); ?>" class="main-wrapper-1-radio"
										<?php
 if ($v['tag'] == 0) { echo "checked='checked'"; } ?>
										/>
										收货人:<span><?php echo ($v["receiverName"]); ?></span><br />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联系电话：<span><?php echo ($v["customer_phone"]); ?></span>
									</td>
									<td>
										<span><?php echo ($v["address"]); ?></span>
									</td>
									<td>
										<input type="button" value="修改" class="main-wrapper-1-btn-revise"/>
										<input type="button" value="删除路径" class="main-wrapper-1-btn-delete"/>
										<input class="phone-none none" value="<?php echo ($v["phone"]); ?>"> 
										<input class="rank-none none"  value="<?php echo ($v["rank"]); ?>">
									</td>
								</tr><?php endforeach; endif; ?>
							<!-- <tr>
								<td>
									<input type="radio" name="information" class="main-wrapper-1-radio"/>
									收货人:<span>包彬彬</span><br />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联系电话：<span>18625210240</span>
								</td>
								<td>
									<span>江苏省 工业园区 通园路新华宛10栋402室</span>
								</td>
								<td>
									<input type="button" value="修改" class="main-wrapper-1-btn"/>
									<input type="button" value="删除路径" class="main-wrapper-1-btn"/>
								</td>
							</tr> -->
						</tbody>
					</table>
				</div>
				
				<div class="wrapper main-wrapper-2-1">
						<input type="button" value="新增收货地址" id="new_address"/>
				</div>
				
				
				<div class="wrapper main-wrapper-2">
					<form action="<?php echo U('Person/addOrReviseSave');?>" method="POST">
						<div>
							<label for="li_person">收货人：</label>
							<input type="text" name="user-name" id="userName" class="person"/>
						</div>
						<div>
							<label>选择地址：</label>
							<select id="location1" name="select-location-1">
								<option value=""></option>
							</select><!-- &nbsp;&nbsp;&nbsp;&nbsp; -->
							<select id="location2" name="select-location-2">
								<option value=""></option>
							</select><!-- &nbsp;&nbsp;&nbsp;&nbsp; -->
							<select id="location3" name="select-location-3">
								<option value=""></option>
							</select>
						</div>
						<div>
							<label for="li_address">详细地址：</label>
							<input type="text" name="detailed-location" id="detailedLoc" class="address"/>
						</div>
						<div>
							<label for="li_phone">手机号：</label>
							<input type="text" name="phone-number" id="phoneNum" class="phone"/>
						</div>
						<div class="div_but">
							<input type="text" id="page" name="page" value="1" class="none"/>
							<input type="submit" id="save_submit" value="保存"   class="but but-submit"/>
							<input type="submit" id="revise_submit" value="保存" class="but but-submit none" />
							<input type="button" id="" value="取消"  class="but but-button"/>
						</div>
					</form>
				</div>
			<form action="<?php echo U('Person/payAtOnce');?>" method="POST">
				<div class="wrapper main-wrapper-3">
					<table class="wrapper">
						<colgroup>
							<col style="width: 400px;"/>
						</colgroup>
						<thead>
							<tr>
								<th>支付方式</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="radio" name="pay_way" checked="checked"/>
									<img src="/foru/Public/img/zhifubao.png" alt="" />
									支付宝支付
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="pay_way"/>&nbsp&nbsp&nbsp
									<img src="/foru/Public/img/weixin.png" alt="" />
									&nbsp&nbsp&nbsp&nbsp微信支付
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="personhome-order-info main-wrapper-4">
					<table>
						<colgroup>
							<col style="width:420px;">
							<col style="width:140px;">
							<col style="width:140px;">
							<col style="width:200px;">
							<col style="width:200px;">
						</colgroup>
						<thead>
							<tr>
								<th>商品名称</th>
								<th>分类</th>
								<th>单价</th>
								<th>数量</th>
								<th>总价</th>
							</tr>
						</thead>
						<tbody>				
							<tr class="order-info-head">
								<td colspan="3">
									订单编号：<span><?php echo ($orderInfo["order_id"]); ?></span>
									提交时间：<span><?php echo ($orderInfo["order_time"]); ?></span>	
								</td>
								<td colspan="2">
									
								</td>	
							</tr>
							<!-- 追加1 删除2 付款3 取消4 确认5  评价6-->
							<?php if(is_array($goodsInfo)): foreach($goodsInfo as $key=>$v): ?><tr class="order-info-detailed">
									<td>
										<img class="fl" src="<?php echo ($v["foodImg"]); ?>" alt="">
										<div class="fl">
											<span class='b'><?php echo ($v["foodName"]); ?></span><p>
											<span><?php echo ($v["message"]); ?></span><p>
											<span>共<span><?php echo ($v["number"]); ?></span>件商品</span><p>
										</div>		
									</td>
									<td class='b'><span class="gray move">颜色分类：黄色</span></td>
									<td class='b'>
										<span class="gray move"><span>￥<?php echo ($v["d_price"]); ?></span><span><del>原价：<?php echo ($v["price"]); ?></del></span></span>
									</td >
									<td>
										<span><?php echo ($v["number"]); ?></span>				
									</td>
									<td class="b">
										<span class="move"><span class="red_price">￥<?php echo ($v["discountPrice"]); ?></span><span class="gray"><del>原价：<?php echo ($v["totalPrice"]); ?></del></span></span>
									</td>
								</tr><?php endforeach; endif; ?>		
						</tbody>
					</table>
				</div>
				
				<div class="wrapper main-wrapper-5">
					<table class="wrapper">
						<colgroup>
							<col style="width: 400px;"/>
						</colgroup>
						<thead>
							<tr>
								<th>送达时间</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="radio" name="time" checked="checked"/>
									周一至周五(工作日)
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="time"/>
									周六周日(休息日)
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="time"/>
									周一至周日均可
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				
				<div class="wrapper main-wrapper-6">
					<table class="wrapper">
						<colgroup>
							<col style="width: 1100px;"/>
						</colgroup>
						<thead>
							<tr>
								<th>备注留言</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<textarea name="message" rows="4" cols="10" placeholder="输入备注信息"></textarea>
								</td>
								
							</tr>
						</tbody>
					</table>
				</div>
				
				
				<div class="wrapper main-wrapper-7 ">
					<div class="main-wrapper-7-main">
						<span class="zhe"><span>合计：</span><span class="price">￥</span><span class="price"><?php echo ($price['discountPrice']); ?></span><span class="price">元</span><br /></span>
						<span class="yuan"><del>原价：￥<span><?php echo ($price['totalPrice']); ?></span>元</del></span><br />
						<input type="submit" value="立即支付"/>
					</div>
				</div>
			</div>
			</form>
			<!--li-->
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