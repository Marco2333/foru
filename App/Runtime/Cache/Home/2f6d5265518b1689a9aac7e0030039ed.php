<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/foryou/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/foryou/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/foryou/Public/css/style.css" rel="stylesheet"/>
		<script type="text/javascript" src="/foryou/Public/script/plugins/jquery-1.11.2.js"></script>
		<script src="/foryou/Public/bootstrap/js/bootstrap.min.js"></script>
		<script src="/foryou/Public/script/shoppingcart.js"></script>
		<script type="text/javascript" src="/foryou/Public/script/common.js"></script>
		<link href="/foryou/Public/css/style-y.css" rel="stylesheet"/>
		<title>For优 购物车</title>
		<style>
			body{
				background-color: #fff;
			}
		</style>
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
				尊敬的 &nbsp; <a href="<?php echo U('Person/personhomepage');?>"><?php echo (session('username')); ?></a> &nbsp;您好,欢迎来到 For优校园超市<a href="<?php echo U('Index/logout');?>" id="log-out">退出</a> <span class="spliter text-special"></span>
			</div><?php endif; ?> 
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
				<button id="search">搜索</button>
				<ul>
					<?php if(is_array($category)): $i = 0; $__LIST__ = array_slice($category,1,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><li>
							<a href=""><?php echo ($vi["category"]); ?></a>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>

			<div id="shopping-cart" class="drop-down" >
				<div class="drop-down-left">
					<img src="/foryou/Public/img/icon/shopping-cart.png" alt="">	
					<a target="_blank" href="">购物车 &gt;&gt;</a>
				</div>
				<div class="drop-down-layer ">
					<div class="no-goods none">
						 购物车中还没有商品，赶紧选购吧！
					</div>
					<div class="index-shopping-cart clearfix">							<!-- -->
						<ul class="clearfix">
							<li>
								<div>
									<img src="/foryou/Public/img/goods.png" alt="">
									<div>								 LED百变耳机台灯创意可以做耳机的台灯</div>
									<span class="goods-cost fl">
										￥3.5×3
									</span>
									<span class="fr">
										<a>删除</a>
									</span>
								</div>
							</li>
							<li>
								<div>
									<img src="/foryou/Public/img/goods.png" alt="">
									<div>								 LED百变耳机台灯创意可以做耳机的台灯</div>
									<span class="goods-cost fl">
										￥3.5×3
									</span>
									<span class="fr">
										<a>删除</a>
									</span>
								</div>
							</li>
							<li>
								<div>
									<img src="/foryou/Public/img/goods.png" alt="">
									<div>								 LED百变耳机台灯创意可以做耳机的台灯</div>
									<span class="goods-cost fl">
										￥3.5×3
									</span>
									<span class="fr">
										<a>删除</a>
									</span>
								</div>
							</li>
							<li>
								<div>
									<img src="/foryou/Public/img/goods.png" alt="">
									<div>								 LED百变耳机台灯创意可以做耳机的台灯</div>
									<span class="goods-cost fl">
										￥3.5×3
									</span>
									<span class="fr">
										<a>删除</a>
									</span>
								</div>
							</li>		
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
								<a href="<?php echo U('Person/shoppingcart');?>" class="fl">
									查看全部<span class="goods-count">9</span>件商品
								</a>
								<a href="<?php echo U('Person/shoppingcart');?>" id="go-shopping-cart" class="fr">去购物车结算</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		<!-- 	<div id="qr-code" class="fr" >
				<img src="/foryou/Public/img/qrcode.png" alt="二维码">
			</div> -->
		</div>
	</div>
</div>

			<div class="w bground-special">
	<div id="nav-bar" class="wrapper nav-wrapper">
		<div class="fl">
			商品分类
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
				<a href="<?php echo U('/Home/Person/personhomepage');?>">个人中心</a>
			</li>
			<li>
				<a href="<?php echo U('Person/personhomepage');?>">个人中心</a>
			</li>
			<li>
				<img src="/foryou/Public/img/icon/location.png" alt="">
				<select id="location" >
				  	<?php if(is_array($campus)): foreach($campus as $key=>$vo): ?><option value ="<?php echo ($vo["campus_id"]); ?>" <?php if(cookie('campusId')==$vo['campus_id']) echo "selected=selected"; ?>><?php echo ($vo["campus_name"]); ?></option><?php endforeach; endif; ?>
				</select>
			<!-- 	<a href="">苏州大学独墅湖校区</a> -->
			</li>
		</ul>
	</div>
</div>

			<div id="nav-breadcrumb" class="wrapper">
				<ul class="breadcrumb">
					<li><a href="<?php echo U('Index/index');?>">首页</a></li>
					<li><a href="#">小优推荐</a></li>
					<li class="active"><a href="#">有机草莓</a></li>
				</ul>
			</div>
		</div>

		<div class="wrapper">
			<div class="goods-info-index w clearfix">
				<div class="goods-info-img fl">
					<dl>
						<dt>
							<img src="/foryou/Public/img/goods/good.png" alt="">
						</dt>
						<dd>
							<div>
								<ul>
									<li><img src="/foryou/Public/img/goods/good1.png" alt=""></li>
								</ul>
								<ul>
									<li><img src="/foryou/Public/img/goods/good2.png" alt=""></li>
								</ul>
								<ul>
									<li><img src="/foryou/Public/img/goods/good3.png" alt=""></li>
								</ul>
								<ul>
									<li><img src="/foryou/Public/img/goods/good4.png" alt=""></li>
								</ul>
							</div>
						</dd>
					</dl>
				</div>
				<div class="goods-info-detailed fl">
					<div class="img-and-detailed-head">
						<h1>新鲜有机奶油大草莓4盒装 蛋糕装饰 防癌降脂水果</h1>
						<p>草莓功效：1.新鲜有机奶油大草莓4盒装防癌降脂水果 2.新鲜有机奶油大草莓4盒装 蛋糕装饰</p>
					</div>
					<div class="img-and-detailed-body">
						<dl class="clearfix">
							<dt>价格:</dt>
							<dd>
								<span class="discount-price">￥23</span>
								<span class="bef-price">￥30</span>
							</dd>
						</dl>
						<dl  class="clearfix">
							<dt>评价:</dt>
							<dd>
								<span class="glyphicon glyphicon-star-empty"></span>
								<span class="glyphicon glyphicon-star-empty"></span>
								<span class="glyphicon glyphicon-star-empty"></span>
								<span class="glyphicon glyphicon-star-empty"></span>
								<span class="glyphicon glyphicon-star-empty"></span>
								<span>4分</span>
							</dd>
						</dl>
						<dl  class="clearfix">
							<dt>配送至:</dt>
							<dd>
								<select id="location" >
								  	<option value ="volvo">苏州大学独墅湖校区</option>
								  	<option value ="saab">苏州大学阳澄湖校区</option>
								  	<option value="opel">苏州大学本部</option>
								  	<option value="audi">苏州大学东校区</option>
								</select>
							</dd>
						</dl>
						<dl  class="clearfix">
							<dt>数量:</dt>
							<dd>
								<td>
									<a class="sub-goods">-</a>
									<input class="goods-count" type="text" value="1" disabled="true">
									<a class="add-goods">+</a>
								</td>
							</dd>
						</dl>
						<div>
							<button>立即购买</button>
							<button>加入购物车</button>
						</div>
					</div>
				</div>
			</div>
			<div class="img-and-evaluate w">
				
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
	</body>
</html>