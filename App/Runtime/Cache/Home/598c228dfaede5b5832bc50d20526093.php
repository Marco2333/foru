<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>For优 确认订单</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/foru/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/foru/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/foru/Public/css/style.css" rel="stylesheet"/>
		<link rel="stylesheet" href="/foru/Public/css/style_li.css" />

	</head>
	<body>
		
		<div class="public-top-layout" style="background-color: #fff">
	<div class="topbar">
		<div class="user-entry">
			<!-- <span class="glyphicon glyphicon-headphones"> </span>
			<span>(86)18896551234</span>
			<span>(Mon- Fri: 09.00 - 21.00)</span> -->
		</div>
		<div class="fr">
			<a class="text-special" href="">手机For优</a>
		</div>
		
		<!-- <div class="quick-menu">
			欢迎光临<span class="text-special">ForU</span>校园超市，请 <a class="text-special" href="<?php echo U('Login/index');?>">登录</a><a class="text-special" href="<?php echo U('Login/register');?>">注册</a>
			<span> </span>
		</div> -->
		
		<?php if(empty($_SESSION['username'])): ?><div class="quick-menu">
				欢迎光临<span class="text-special">ForU</span>校园超市，请 <a class="text-special" href="<?php echo U('Login/index');?>">登录</a><a class="text-special" href="<?php echo U('Login/register');?>">注册</a>
				<span> </span>
			</div>
			<?php else: ?> 
			<div class="quick-menu">
				尊敬的 &nbsp; <a href="<?php echo U('Person/personhomepage');?>"><?php echo (session('nickname')); ?></a> &nbsp;您好,欢迎来到 For优校园超市<a href="<?php echo U('Index/logout');?>" id="log-out">退出</a> <span class="spliter text-special"></span>
			</div><?php endif; ?> 
	</div>
</div>
			<div id="index-header" >
				<div class="container header-bottom">
	<div id="header-botton-wrapper">
		<div id="log-wrapper" class="fl">
			<div id="header-logo" class="fl">
				<a href="<?php echo U('/Home/Index');?>"><img src="/foru/Public/img/logo.png" class="fl"></a>
				<span class="text-special fl"><p>For优<br><span class="bold inline-block">为你更好的生活</span></span>
			</div>
			<div id="header-search" class="fl">
				<input name="keyword" type="text" placeholder="请输入要查找的商品" value="<?php echo ($search); ?>" list="search-record">

				<datalist id="search-record">
				
				</datalist>
					
				<button id="search">搜索</button>
				<ul>
					<?php if(is_array($category)): $i = 0; $__LIST__ = array_slice($category,1,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><li>
							<a href=""><?php echo ($vi["category"]); ?></a>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>

			<div id="shopping-cart" class="drop-down" >
				<div class="drop-down-left">
					<img src="/foru/Public/img/icon/shopping-cart.png" alt="">	
					<a target="_blank" href="<?php echo U('ShoppingCart/shoppingcart',array('campusId'=>cookie('campusId')));?>">购物车 &gt;&gt;</a>
				</div>
				<div class="drop-down-layer ">
				   <?php if(empty($cartGood)): ?><div class="no-goods">
						 购物车中还没有商品，赶紧选购吧！
					</div>
				    <?php else: ?>
				    	<div class="index-shopping-cart clearfix">							<!-- -->
				    		<ul class="clearfix">
				    		   <?php if(is_array($cartGood)): foreach($cartGood as $key=>$vo): ?><li id="<?php echo ($vo["order_id"]); ?>">
				    			   	    <div>
				    						<img src="<?php echo ($vo["img_url"]); ?>" alt="<?php echo ($vo["name"]); ?>">
				    						<div><?php echo ($vo["name"]); ?></div>
				    						<span class="goods-cost fl">
				    							￥<?php echo (number_format($vo["price"],1)); ?>×<?php echo ($vo["order_count"]); ?>
				    						</span>
				    						<span class="fr">
				    							<a data-href="<?php echo U('/Home/ShoppingCart/deleteOrders',array('orderIds'=>$vo['order_id']));?>">删除</a>
				    						</span>
				    					</div>
				    				</li><?php endforeach; endif; ?>
				    		</ul>
				    		<div class="shopping-cart-bottom">
				    			<span class="block ">合计: 
				    				<span class="total-cost">￥169.5</span>
				    			</span>
				    			<span class="block">
				    				原价: 
				    				<span class="pre-total-cost">￥269.5</span>
				    			</span>
				    			<span class="block clearfix">
				    				<a href="<?php echo U('ShoppingCart/shoppingcart');?>" class="fl">
				    					查看全部<span class="goods-count">9</span>件商品
				    				</a>
				    				<a href="<?php echo U('ShoppingCart/shoppingcart');?>" id="go-shopping-cart" class="fr">去购物车结算</a>
				    			</span>
				    		</div>
				    	</div><?php endif; ?>
					
				
				</div>
			</div>
		<!-- 	<div id="qr-code" class="fr" >
				<img src="/foru/Public/img/qrcode.png" alt="二维码">
			</div> -->
		</div>
	</div>
</div>

				<div class="w bground-special">
	<div id="nav-bar" class="wrapper nav-wrapper">
	    <?php if($categoryHidden != 1): ?><div class="fl">
			   商品分类
		    </div><?php endif; ?>
		
		<ul class="nav nav-pills">
			<li>
				<a href="<?php echo U('/Home/Index');?>">首页</a>
			</li>
			<li>
				<a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[4]['category_id'],'campusId'=>$module[4]['campus_id']));?>">小优推荐</a>
			</li>
			<li>
				<a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[5]['category_id'],'campusId'=>$module[5]['campus_id']));?>">最新体验</a>
			</li>
			<li>
				<a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[6]['category_id'],'campusId'=>$module[6]['campus_id']));?>">特惠秒杀</a>
			</li>
			<li>
				<a href="<?php echo U('Person/personhomepage');?>">个人中心</a>
			</li>
			<li>
				<img src="/foru/Public/img/icon/location.png" alt="">
				<span id="location" >
				  	<?php echo ($campus_name["campus_name"]); ?>
				</span>
			<!-- 	<a href="">苏州大学独墅湖校区</a> -->
			</li>
		</ul>
	</div>
</div>

				<div id="nav-breadcrumb" class="wrapper">
					<ul class="breadcrumb">
						<li><a href="<?php echo U('Index/index');?>">首页</a></li>
						<li><a href="<?php echo U('Shoppingcart/shoppingcart');?>">购物车</a></li>
						<li class="active"><a href="/foru/index.php/Home/Person/goodspayment">确认订单</a></li>
					</ul>
				</div>
			</div><!--.index-header-->

			<div class="main-wrapper">

				<div id="addressColumn" class="wrapper main-wrapper-1">
					<table>
						<colgroup>
							<col style="width: 300px;"/>
							<col style="width: 550px;"/>
							<col style="width: 250px;"/>
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
										收货人:<span><?php echo ($v["name"]); ?></span><br />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联系电话：<span><?php echo ($v["phone_id"]); ?></span>
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
							<label>城市：</label>
							<select  name="select-location-1" id="city-change">
	
							</select><!-- &nbsp;&nbsp;&nbsp;&nbsp; -->
							<label>校区：</label>
							<select  name="select-location-2" id="campus-change">
							</select><!-- &nbsp;&nbsp;&nbsp;&nbsp; -->
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
									<input type="radio" name="pay-way" value="支付宝支付" checked="checked"/>
									<img src="/foru/Public/img/zhifubao.png" alt="" />
									支付宝支付
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="pay-way" value="微信支付"/>&nbsp&nbsp&nbsp
									<img src="/foru/Public/img/weixin.png" alt="" />
									&nbsp&nbsp&nbsp&nbsp微信支付
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="personhome-order-info main-wrapper-4 wrapper">
					<table class="wrapper">
						<colgroup>
							<col style="width:400px;">
							<col style="width:230px;">
							<col style="width:230px;">
							<col style="width:240px;">
						</colgroup>
						<thead>
							<tr>
								<th>商品名称</th>
								<th>单价</th>
								<th>数量</th>
								<th>总价</th>
							</tr>
						</thead>
						<tbody>				
							<tr class="order-info-head">
								<td colspan="3">
									订单编号：<span><?php echo ($orderInfo["together_id"]); ?></span>
									提交时间：<span><?php echo ($orderInfo["together_date"]); ?></span>
									<input name="together-id" value="<?php echo ($orderInfo["together_id"]); ?>" class="none"/>
									<input name="orderIDstr" value="<?php echo ($orderIDstr); ?>" class="none"/>
								</td>
								<td colspan="1">
									
								</td>	
							</tr>
							<!-- 追加1 删除2 付款3 取消4 确认5  评价6-->
							<?php if(is_array($goodsInfo)): foreach($goodsInfo as $key=>$v): ?><tr class="order-info-detailed">
									<td>
										<img class="fl" src="<?php echo ($v["img_url"]); ?>" alt="">
										<div class="fl">
											<span class='b'><?php echo ($v["foodName"]); ?></span><p>
											<span><?php echo ($v["message"]); ?></span><p>
											<span>共<span><?php echo ($v["order_count"]); ?></span>件商品</span><p>
										</div>		
									</td>
									<td class='b'>
										<span class="gray move"><span>￥<?php echo ($v["discount_price"]); ?></span><span><del>原价：<?php echo ($v["price"]); ?></del></span></span>
									</td >
									<td>
										<span><?php echo ($v["order_count"]); ?></span>				
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
									<input type="radio" name="time" value="周一至周五(工作日)" checked="checked"/>
									周一至周五(工作日)
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="time" value="周六周日(休息日)"/>
									周六周日(休息日)
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="time" value="周一至周日均可"/>
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
			</form>
		</div>
			<!--li-->
		
		
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
	<!-- <div id="foot-part3" class="clearfix wrapper">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div> -->
	<div id="foot-part4" class="clearfix">
		<a>易迅简介</a>|<a>易迅公告</a>|招贤纳士<a>|<a>联系我们</a>|客服热线: 00-828-1878
	</div>
</footer>
		<div id="campus-background">
	<div id="campus">
		<div id="campus-close">
			×
		</div>
		<div id="campus-head">
			<span>请选择学校</span>
			<input type="text" id="campus-search" placeholder="请输入学校的名字"/>
		</div>
		<div id="campus-main">
			<div id="campus-item">
				<ul id="campus-location">
					<?php if(is_array($cities)): foreach($cities as $key=>$city): if(empty($_COOKIE['cityId'])): $_COOKIE['cityId'] = '1'; endif; ?>				
						<?php if(cookie('cityId') == $city['city_id']): ?><li data-city="<?php echo ($city["city_id"]); ?>" class="active"><?php echo ($city["city_name"]); ?></li>
							
							<?php else: ?><li data-city="<?php echo ($city["city_id"]); ?>"><?php echo ($city["city_name"]); ?></li><?php endif; endforeach; endif; ?>
				</ul>
			</div>

			<div id="campus-content">
				<ul>
					<?php if(is_array($campus)): foreach($campus as $key=>$vo): if(empty($_COOKIE['campusId'])): $_COOKIE['campusId'] = '1'; endif; ?>
						<?php if($vo["campus_id"] == cookie('campusId')): ?><li data-campusId="<?php echo ($vo["campus_id"]); ?>" class="active"><?php echo ($vo["campus_name"]); ?></li>
							<?php else: ?><li data-campusId="<?php echo ($vo["campus_id"]); ?>"><?php echo ($vo["campus_name"]); ?></li><?php endif; endforeach; endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>

		<script type="text/javascript" src="/foru/Public/script/plugins/jquery-1.11.2.js"></script>
		<script src="/foru/Public/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/foru/Public/script/common.js"></script>
		<script type="text/javascript" src="/foru/Public/script/goodsPayment.js"></script>
	</body>
</html>