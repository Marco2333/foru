<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/Public/css/style.css" rel="stylesheet"/>
		<link rel="icon" href="/favicon.ico" type="image/x-icon" />
		<title>For优 商品列表</title>
		<style>
			body{
				background-color: #fff;
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
		<div id="index-header" data-campusId="<?php echo ($campusId); ?>">
			<div class="container header-bottom">
	<div id="header-botton-wrapper">
		<div id="log-wrapper" class="fl">
			<div id="header-logo" class="fl">
				<a href="<?php echo U('/Home/Index/index',array('campusId'=>$campusId));?>"><img src="/Public/img/logo.png" class="fl"></a>
				<span class="text-special fl"><p>For优<br><span class="bold inline-block">为你更好的生活</span></span>
			</div>
			<div id="header-search" class="fl">
			    <?php if($searchHidden == 1): ?><input name="keyword" type="text" placeholder="请输入要查找的商品" value="" list="search-record">
			    <?php else: ?><input name="keyword" type="text" placeholder="请输入要查找的商品" value="<?php echo ($search); ?>" list="search-record"><?php endif; ?>
			

				<datalist id="search-record">
				
				</datalist>
					
				<button id="search">搜索</button>
				<ul>
					<?php if(is_array($hotSearch)): $i = 0; $__LIST__ = $hotSearch;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><li>
						    <a href="<?php echo U('/Home/Index/goodslist',array('search'=>$vi['search_tag'],'campusId'=>$campusId,'categoryName'=>$vi['display_name'],'searchHidden'=>1));?>"><?php echo ($vi["display_name"]); ?></a>
					    </li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>

			<div id="shopping-cart" class="drop-down" >
				<div class="drop-down-left">
					<img src="/Public/img/icon/shopping-cart.png" alt="">
					<a target="_blank" href="<?php echo U('/Home/Shoppingcart/shoppingcart',array('campusId'=>$campusId));?>">购物车 &gt;&gt;</a>
				</div>
				<div class="drop-down-layer ">
				   <?php if(empty($cartGood)): ?><div class="no-goods">
						 	当前校区购物车中还没有商品，赶紧去选购吧！
						</div>
						<div class="index-shopping-cart clearfix none">							<!-- -->
				    		<ul class="clearfix">
				    		   
				    		</ul>
				    		<div class="shopping-cart-bottom">
				    			<span class="block clearfix">
				    				<a href="<?php echo U('/Home/Shoppingcart/shoppingcart',array('campusId'=>$campusId));?>" class="fl">
				    					查看全部<span class="goods-count"><?php echo (count($cartGood)); ?></span>件商品
				    				</a>
				    				<a href="<?php echo U('/Home/Shoppingcart/shoppingcart',array('campusId'=>$campusId));?>" id="go-shopping-cart" class="fr">去购物车结算</a>
				    			</span>
				    		</div>
				    	</div>
				    <?php else: ?>
				    	<div class="no-goods none">
						 	当前校区购物车中还没有商品，赶紧去选购吧！
						</div>
				    	<div class="index-shopping-cart clearfix">							<!-- -->
				    		<ul class="clearfix">
				    		   <?php if(is_array($cartGood)): foreach($cartGood as $key=>$vo): if($key < 5): ?><li id="<?php echo ($vo["order_id"]); ?>">
					    			   	    <div class="smallgood" data-orderId="<?php echo ($vo["order_id"]); ?>">
					    						<img src="<?php echo ($vo["img_url"]); ?>" alt="<?php echo ($vo["name"]); ?>">
					    						<div><?php echo ($vo["name"]); ?></div>
					    						<span class="goods-cost fl">
					    						  <?php if($vo['is_discount'] == 1): ?>￥<?php echo (number_format($vo["discount_price"],1)); ?>×<?php echo ($vo["order_count"]); ?>
                                                  <?php else: ?>￥<?php echo (number_format($vo["price"],1)); ?>×<?php echo ($vo["order_count"]); endif; ?>	
					    						</span>
					    						<span class="fr">
					    							<a data-href="<?php echo U('/Home/Shoppingcart/deleteOrders',array('orderIds'=>$vo['order_id']));?>">删除</a>
					    						</span>
					    					</div>
					    				</li><?php endif; endforeach; endif; ?>
				    		</ul>
				    		<div class="shopping-cart-bottom">
				    			<span class="block clearfix">
				    				<a href="<?php echo U('Shoppingcart/shoppingCart',array('campusId'=>$campusId));?>" class="fl">
				    					查看全部<span class="goods-count"><?php echo (count($cartGood)); ?></span>件商品
				    				</a>
				    				<a href="<?php echo U('/Home/Shoppingcart/shoppingcart',array('campusId'=>$campusId));?>" id="go-shopping-cart" class="fr">去购物车结算</a>
				    			</span>
				    		</div>
				    	</div><?php endif; ?>				
				</div>
			</div>
		<!-- 	<div id="qr-code" class="fr" >
				<img src="/Public/img/qrcode.png" alt="二维码">
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
				<a href="<?php echo U('Person/personhomepage',array('campusId'=>$campusId));?>">个人中心</a>
			</li>

			<?php if($hiddenLocation != 1): if(($campusId == null) OR (cookie('campusId') == undefined)): ?><li>
					  	<?php if(is_array($campusList)): foreach($campusList as $key=>$vo): if($vo["campus_id"] == 1): ?><img src="/Public/img/icon/location.png" alt="">
					   	   		<span id="location" >
					   	   		  	<?php echo ($vo["campus_name"]); ?>
					   	   		</span><?php endif; endforeach; endif; ?>		
					</li>
					<?php else: ?>

					<li>
					   <?php if(is_array($campusList)): foreach($campusList as $key=>$vo): if($vo["campus_id"] == $campusId): ?><img src="/Public/img/icon/location.png" alt="">
					   	   		<span id="location" >
					   	   		  	<?php echo ($vo["campus_name"]); ?>
					   	   		</span><?php endif; endforeach; endif; ?>
					</li><?php endif; ?>

				<?php else: ?><li></li><?php endif; ?>
		</ul>
	</div>
</div>

			<div id="nav-breadcrumb" class="wrapper">
				<ul class="breadcrumb">
					<li><a href="<?php echo U('Index/index');?>">首页</a></li>
					<li class="active"><a href="#"><?php echo ($categoryName); ?></a></li>
				</ul>
			</div>
		</div>

		<div class="wrapper clearfix">
			<div class="goods-list-side">
				<ul>
				   <?php if(is_array($classes)): foreach($classes as $key=>$vo): ?><li>
						  <a href="<?php echo U('/Home/Index/goodslist',array('categoryId'=>$vo['category_id'],'campusId'=>$vo['campus_id']));?>"><?php echo ($vo["category"]); ?></a>	
					   </li><?php endforeach; endif; ?>					
				</ul>	
			</div>
			<div class="goods-list-info clearfix fl">
			   <?php if(empty($goods)): ?><!-- 设置空样式 -->
			       <div class="empty-out w">
						<dl class="">
							<dt>
								<img src="/Public/img/icon/outnone.png" alt="">
							</dt>
							<dd>没有符合条件的商品哦</dd>
						</dl>
			       		
			       </div>
			      <?php else: ?>
			          <?php if(is_array($goods)): foreach($goods as $key=>$v): ?><div class="goods-info-item">
			      			<dl>
			      				<dt>
			      					<a href="<?php echo U('/Home/Index/goodsInfo',array('goodId'=>$v['food_id'],'campusId'=>$v['campus_id']));?>"><img src="<?php echo ($v["img_url"]); ?>" alt=""></a>
			      				</dt>
			      				<dd>
			      					<p><a href="<?php echo U('/Home/Index/goodsInfo',array('goodId'=>$v['food_id'],'campusId'=>$v['campus_id']));?>"><?php echo ($v["name"]); ?></a></p>
			      					<p><?php if(strlen($v['message'])>84) echo substr($v['message'], 0,78)."...."; else echo $v['message']; ?>
			      						</p>
			      					<p>  <?php if($v['is_discount'] == 1): ?><span>￥<?php echo (number_format($v["discount_price"],1)); ?></span>
			      						    <span>原价:<?php echo (number_format($v["price"],1)); ?>元</span>
			      						    <?php else: ?><span>￥<?php echo (number_format($v["price"],1)); ?></span><span></span><?php endif; ?>
			      						
			      						<span>销量:<?php echo ($v["sale_number"]); ?></span>
			      					</p>
			      				</dd>
			      			</dl>
			      	   </div><?php endforeach; endif; endif; ?> 
			    	
			</div>
				
		</div>
		<div class="msg-page">
			   <div class="page"><?php echo ($page); ?></div>
		 </div>
		
		<footer>
	<div id="foot-part2" class="clearfix wrapper">
		<ul>
			<li>
				<dl>
					<dd>常用服务</dd>
					<dt>
						<ul>
							<li><a href="<?php echo U('Document/documents1',array('status'=>1,'flag'=>1,'campusId'=>$campusId));?>">常见问题咨询</a></li>
							<li><a href="<?php echo U('Document/documents1',array('status'=>2,'flag'=>1,'campusId'=>$campusId));?>">平台使用说明</a></li>
						</ul>
					</dt>
				</dl>
			</li>
			<li>
				<dl>
					<dd>购买说明</dd>
					<dt>
						<ul>
							<li><a href="<?php echo U('Document/documents2',array('status'=>1,'flag'=>2,'campusId'=>$campusId));?>">如何购买</a></li>
							<!-- <li><a>会员制度</a></li>
							<li><a>积分优惠券介绍</a></li> -->
							<li><a href="<?php echo U('Document/documents2',array('status'=>4,'flag'=>2,'campusId'=>$campusId));?>">订单状态说明</a></li>
						</ul>
					</dt>
				</dl>
			</li>
			<li>
				<dl>
					<dd>付款说明</dd>
					<dt>
						<ul>
							<!-- <li><a>货到付款</a></li> -->
							<li><a href="<?php echo U('Document/documents3',array('status'=>1,'flag'=>3,'campusId'=>$campusId));?>">在线支付</a></li>
							<!-- <li><a>服务说明</a></li> -->
							<li><a href="<?php echo U('Document/documents3',array('status'=>2,'flag'=>3,'campusId'=>$campusId));?>">退款服务</a></li>
						</ul>
					</dt>
				</dl>
			</li>
			<li>
				<dl>
					<dd>关于配送</dd>
					<dt>
						<ul>
							<li><a href="<?php echo U('Document/documents4',array('status'=>1,'flag'=>4,'campusId'=>$campusId));?>">使用说明</a></li>
							<li><a href="<?php echo U('Document/documents4',array('status'=>2,'flag'=>4,'campusId'=>$campusId));?>">时间选择</a></li>
						</ul>
					</dt>
				</dl>
			</li>
			<li>
				<dl>
					<dd>售后服务</dd>
					<dt>
						<ul>
							<li><a href="<?php echo U('Document/documents5',array('status'=>1,'flag'=>5,'campusId'=>$campusId));?>">申请售后</a></li>
						</ul>
					</dt>
				</dl>
			</li>
			<li>
				<dl>
					<dd>关于我们</dd>
					<dt>
						<ul>
							<li><a href="<?php echo U('Document/documents6',array('status'=>1,'flag'=>6,'campusId'=>$campusId));?>">商家合作</a></li>
							<li><a href="<?php echo U('Document/documents6',array('status'=>2,'flag'=>6,'campusId'=>$campusId));?>">联系客服</a></li>
							<li><a href="<?php echo U('Document/documents6',array('status'=>3,'flag'=>6,'campusId'=>$campusId));?>">加入我们</a></li>
							<li><a href="<?php echo U('Document/documents6',array('status'=>4,'flag'=>6,'campusId'=>$campusId));?>">公司介绍</a></li>
						</ul>
					</dt>
				</dl>
			</li>
		</ul>
	</div>
	
	<div id="foot-part4" class="clearfix text-light">
		<span>©2015苏州英爵伟信息科技服务有限公司</span>
		<a href="http://www.miitbeian.gov.cn">苏ICP备15042109号</a>
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
					
				</ul>
			</div>
		</div>
	</div>
</div>
		
		<script type="text/javascript" src="/Public/script/plugins/jquery-1.11.2.js"></script>
		<script type="text/javascript">
               var $campusId=$("#index-header").attr('data-campusId');
		</script>
		<script src="/Public/script/shoppingcart.js"></script>
		<script type="text/javascript" src="/Public/script/plugins/jquery.cookie.js"></script>
		<script type="text/javascript" src="/Public/script/common.js"></script>
	</body>
</html>