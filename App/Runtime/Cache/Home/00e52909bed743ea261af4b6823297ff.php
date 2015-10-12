<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		 <script type="text/javascript">
		 	//   var browser={
		 	//     versions:function(){ 
	 	 //           var u = navigator.userAgent, app = navigator.appVersion; 

	 	 //           var info = {
	 	 //           		trident: u.indexOf('Trident') > -1, //IE内核
	 	 //                presto: u.indexOf('Presto') > -1, //opera内核
	 	 //                webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
	 	 //                gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
	 	 //                mobile: !!u.match(/AppleWebKit.*Mobile.*/)||!!u.match(/AppleWebKit/), //是否为移动终端
	 	 //                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
	 	 //                android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
	 	 //                iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
	 	 //                iPad: u.indexOf('iPad') > -1, //是否iPad
	 	 //                webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
	 	 //           };
	 	 //           return info;
	 	 //         }(),
	 	 //         language:(navigator.browserLanguage || navigator.language).toLowerCase()
		 	// } 

		 	// console.log(browser.versions);
		 	// if(browser.versions.android || browser.versions.iPhone||screen.width < 700) {
		 	// 		window.location.href = "../../../../fuwebapp/index.php";
		 	// }
		 	if(screen.width < 500) {
		 			window.location.href = "../../../../fuwebapp/index.php";
		 	}
        </script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/Public/css/style.css" rel="stylesheet"/>
		<link rel="icon" href="/favicon.ico" type="image/x-icon" />
		<script type="text/javascript" src="/Public/script/plugins/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="/Public/script/plugins/jquery.cookie.js"></script>
		<script src="/Public/bootstrap/js/bootstrap.min.js"></script>

		<title>For优 首页</title>
		<style>
			body {
				background-color: rgb(249,249,249);
			}
		</style>
	</head>
	<body data-spy="scroll" data-target="#nav-side">
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

		<div id="index-header" >

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
			
			<div id="list-slide" class="wrapper clearfix">
				<div class="side-nav">
					<ul class="primary_nav_list">
						<?php if(is_array($category)): foreach($category as $key=>$vo): ?><li class="primary_nav_li">
								<a href="<?php echo U('/Home/Index/goodslist',array('categoryId'=>$vo['category_id'],'campusId'=>$vo['campus_id']));?>"><?php echo ($vo["category"]); ?></a>
							</li><?php endforeach; endif; ?>
						
					</ul>
				</div>
				<div id="slide-wrapper" class="carousel slide">
					<!-- 轮播（Carousel）指标 -->
					<ol class="carousel-indicators">
						<?php if(is_array($main_image)): foreach($main_image as $key=>$v): ?><li data-target="#slide-wrapper" data-slide-to="<?php echo ($key); ?>" <?php if(key==0) echo 'class="active"';?>></li><?php endforeach; endif; ?>
					</ol>
					<!-- 轮播（Carousel）项目 -->
					<div class="carousel-inner">
						<?php if(is_array($main_image)): foreach($main_image as $key=>$v): if($key == 0): ?><div class="item active">
						    <?php else: ?><div class="item"><?php endif; ?>
							<img src="<?php echo ($v["img_url"]); ?>" alt="<?php echo ($key); ?> slide">
							</div><?php endforeach; endif; ?>
					</div>
					<!-- 轮播（Carousel）导航 -->
					<a class="carousel-control left" href="#slide-wrapper"data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"> </span> <span class="sr-only">Previous</span> </a>
					<a class="carousel-control right" href="#slide-wrapper"data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"> </span> <span class="sr-only">Previous</span> </a>
				</div>
			</div>
		</div>
			
		<div id="index-body" class="clearfix" data-campusId="<?php echo ($campusId); ?>">
			<div id="nav-side" class="fl">
				<ul class="nav nav-tabs nav-stacked" data-spy="affix" data-offset-top="800">
				<?php if(is_array($homeGood)): foreach($homeGood as $key=>$vo): if($key == 0): ?><li class="active">
				     <?php else: ?><li><?php endif; ?>
				     <a href="#class-<?php echo ($key+1); ?>-top"><?php echo ($key+1); ?>F</a></li><?php endforeach; endif; ?>
				</ul>
			</div>
			<div class="wrapper">
				<div id="medium-part" class="clearfix">
					<div>
						<dl>
							<dt><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[4]['category_id'],'campusId'=>$module[4]['campus_id']));?>"><img src="/Public/img/medium1.png" alt=""></a></dt>
							<dd><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[4]['category_id'],'campusId'=>$module[4]['campus_id']));?>">小优推荐</a></dd>
						</dl>
					</div>
					<div>
						<dl>
							<dt><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[5]['category_id'],'campusId'=>$module[5]['campus_id']));?>"><img src="/Public/img/medium2.png" alt=""></a></dt>
							<dd><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[5]['category_id'],'campusId'=>$module[5]['campus_id']));?>">最新体验</a></dd>
						</dl>
					</div>
					<div>
						<dl>
							<dt><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[6]['category_id'],'campusId'=>$module[6]['campus_id']));?>"><img src="/Public/img/medium3.png" alt=""></a></dt>
							<dd><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[6]['category_id'],'campusId'=>$module[6]['campus_id']));?>">特惠秒杀</a></dd>
						</dl>
					</div>
					<div>
						<dl>
							<dt><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[0]['category_id'],'campusId'=>$module[0]['campus_id']));?>"><img src="/Public/img/medium4.png" alt=""></a></dt>
							<dd><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[0]['category_id'],'campusId'=>$module[0]['campus_id']));?>">早餐上门</a></dd>
						</dl>
					</div>
					<div>
						<dl>
							<dt><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[1]['category_id'],'campusId'=>$module[1]['campus_id']));?>"><img src="/Public/img/medium5.png" alt=""></a></dt>
							<dd><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[1]['category_id'],'campusId'=>$module[1]['campus_id']));?>">家政服务</a></dd>
						</dl>
					</div>
					<div>
						<dl>
							<dt><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[2]['category_id'],'campusId'=>$module[2]['campus_id']));?>"><img src="/Public/img/medium6.png" alt=""></a></dt>
							<dd><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[2]['category_id'],'campusId'=>$module[2]['campus_id']));?>">水果上门</a></dd>
						</dl>
					</div>
					<div>
						<dl>
							<dt><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[3]['category_id'],'campusId'=>$module[3]['campus_id']));?>"><img src="/Public/img/medium7.png" alt=""></a></dt>
							<dd><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[3]['category_id'],'campusId'=>$module[3]['campus_id']));?>">快递代取</a></dd>
						</dl>
					</div>
					<div>
						<dl>
							<dt><a href="<?php echo U('/Home/index/goodslist',array('categoryId'=>$module[7]['category_id'],'campusId'=>$module[7]['campus_id']));?>"><img src="/Public/img/medium8.png" alt=""></a></dt>
							<dd>更多</dd>
						</dl>
					</div>
				</div>

				<?php if(is_array($homeGood)): foreach($homeGood as $key=>$cate): ?><div id="class-<?php echo ($key+1); ?>-top" class="class-n-top w clearfix fr">
						<span class="spliter fl"></span>
						<span class="class-n-f fl"><?php echo ($key+1); ?>F</span>
						<span class="class-header fl"><?php echo ($cate["category"]); ?></span>
						<span class="fr"><a href="<?php echo U('/Home/Index/goodslist',array('categoryId'=>$cate['category_id'],'campusId'=>cookie('campusId')));?>">更多&gt;&gt;</a></span>
				    </div>
				    <div id="class-<?php echo ($key+1); ?>" class="class-n">
				    	<div class="goods-row">
							<?php if(is_array($goodlist[$key])): foreach($goodlist[$key] as $key=>$good): ?><div class="goods-show">
									<dl>
										<dd>
											<a href="<?php echo U('/Home/Index/goodsInfo',array('goodId'=>$good['food_id'],'campusId'=>$good['campus_id']));?>"><img src="<?php echo ($good["img_url"]); ?>"/></a>
										</dd>
										<dt>
											<div class="goods-info ">
												<div class="goods-price clearfix">
												   <?php if($good["is_discount"] == 1): ?><span class="present-price">￥<?php echo (number_format($good["discount_price"],1)); ?></span>
													    <span class="before-price">原价：<?php echo (number_format($good["price"],1)); ?>元</span>
												   <?php else: ?><span class="present-price">￥<?php echo (number_format($good["price"],1)); ?></span><?php endif; ?>
													
													<!-- <span class="googs-volume">销量(1306)</span> -->
												</div>
												<div  class="goods-name">
													<a href="<?php echo U('/Home/Index/goodsInfo',array('goodId'=>$good['food_id'],'campusId'=>$good['campus_id']));?>"><?php echo ($good["name"]); ?></a>
												</div>
										    </div>
										</dt>
									</dl>
							   </div><?php endforeach; endif; ?>
						</div>
					</div><?php endforeach; endif; ?>
				</div>
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

        <script type="text/javascript">
            var $campusId=$("#index-body").attr('data-campusId');
        </script>
		<script type="text/javascript" src="/Public/script/index.js"></script>
		<script type="text/javascript" src="/Public/script/common.js"></script>
		
	</body>
</html>