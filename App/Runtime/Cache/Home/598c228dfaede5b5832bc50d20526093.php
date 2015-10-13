<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>For优 确认订单</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/Public/css/commonstyle.css" rel="stylesheet" />
		<link href="/Public/css/style.css" rel="stylesheet"/>
		<link rel="stylesheet" href="/Public/css/style_li.css" />
		<link rel="icon" href="/favicon.ico" type="image/x-icon" />
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
						<li><a href="<?php echo U('Index/index',array('campusId'=>$campusId));?>">首页</a></li>
						<li><a href="<?php echo U('ShoppingCart/shoppingcart',array('campusId'=>$campusId));?>">购物车</a></li>
						<li class="active"><a href="/index.php/Home/Person/goodsPayment?orderIds=1444725826000&campusId=1">确认订单</a></li>
					</ul>
				</div>
			</div>
            <div id="info"></div>
			<div class="main-wrapper">

				<div id="addressColumn" class="wrapper main-wrapper-1">
					<table>
						<colgroup>
							<col width="300"/>
							<col width="550"/>
							<col width="250"/>
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
					<form action="<?php echo U('Person/addOrReviseSave',array('campusId'=>$campusId,togetherId=>$orderInfo['together_id']));?>" method="GET">
					    <div class="none">
							<label for="rank">rank:</label>
							<input type="text" name="rank" id="rank" class="person" value="0"/>
						</div>
						<div>
							<label for="userName">收货人：</label>
							<input type="text" name="user-name" id="userName" class="person" required/>
						</div>
						<div>
							<label>城市：</label>
							<select  name="select-location-1" id="city-change">
							</select>
							<label>校区：</label>
							<select  name="select-location-2" id="campus-change">
							</select>
						</div>
						<div>
							<label for="detailedLoc">详细地址：</label>
							<input type="text" name="detailed-location" id="detailedLoc" class="address" required/>
						</div>
						<div>
							<label for="phoneNum">手机号：</label>
							<input type="text" pattern="1[0-9]{10}"name="phone-number" id="phoneNum" class="phone" required/>
						</div>
						<div class="div_but">
							<input type="text" id="page" name="page" value="1" class="none"/>
							<input type="submit" id="save_submit" value="保存"   class="but but-submit"/>
							<input type="submit" id="revise_submit" value="保存" class="but but-submit none" />
							<input type="button" id="" value="取消"  class="but but-button"/>
						</div>
					</form>
				</div>
			<form>
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
									<input type="radio" name="pay-way" value="alipay_pc_direct" checked="checked"/>
									<img src="/Public/img/zhifubao.png" alt="" />
									支付宝支付
								</td>
								<!-- <td>
									<input type="radio" name="pay-way" value="alipay_qr"/>
									<img src="/Public/img/zhifubao.png" alt="" />
									支付宝扫码支付
								</td> -->
							</tr>
							<!-- <tr>
								<td>
									<input type="radio" name="pay-way" value=""/>&nbsp;&nbsp;&nbsp;<img src="/Public/img/weixin.png" alt="" />&nbsp;&nbsp;&nbsp;&nbsp;微信支付
								</td>
							</tr> -->
						</tbody>
					</table>
				</div>
				
				<div class="personhome-order-info main-wrapper-4 wrapper">
					<table class="wrapper">
						<colgroup>
							<col width="400">
							<col width="260">
							<col width="170">
							<col width="270">
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
											<span class='font-14'><?php echo ($v["foodname"]); ?></span><p>
											<span><?php echo ($v["message"]); ?></span><p>
											<?php if($v["is_full_discount"] == 1): ?><div class="full-discount-wrapper">
													<span class="full-discount">
														减
													</span>
													<span>
														<?php if(is_array($preferential)): foreach($preferential as $key=>$vi): ?>满<?php echo ($vi["need_number"]); ?>减<?php echo ($vi["discount_num"]); ?>&nbsp;<?php endforeach; endif; ?>
													</span>
												</div><?php endif; ?>
										</div>		
									</td>
									<td>
										<span class="gray move">
											<?php if($v["is_discount"] == 1): ?><span class="text-subspecial">￥<?php echo ($v["discount_price"]); ?></span>
												<span><del>￥<?php echo ($v["price"]); ?></del></span>
												<?php else: ?><span class="text-subspecial">￥<?php echo ($v["price"]); ?></span><?php endif; ?>
										</span>
									</td>
									<td>
										<span><?php echo ($v["order_count"]); ?></span>		
									</td>
									<td>
										<span class="move">
											<?php if($v["is_discount"] == 1): ?><span class="text-subspecial">￥<?php echo ($v["discountPrice"]); ?></span>
												<span><del>￥<?php echo ($v["totalPrice"]); ?></del></span>
												<?php else: ?><span class="text-subspecial">￥<?php echo ($v["discountPrice"]); ?></span><?php endif; ?>
										</span>
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
								<th colspan="2">送达时间</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="radio" name="time" value="立即送达" checked="checked"/>
									立即送达
								</td>
								<td>
									<input type="radio" name="time" value="一个小时后"/>
									一个小时后
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="time" value="一个半小时后"/>
									一个半小时后
								</td>
								<td>
									<input type="radio" name="time" value="两小时后"/>
									两小时后
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
						<span class="zhe"><span>合计：</span><span class="price">￥<?php echo ($price); ?></span><br /></span>
						<input id="submitPay" type="button" value="立即支付"/>
					</div>
				</div>
			</form>
		</div>
		<div class="mask none">
			<div class="loder center"></div>
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
		<script type="text/javascript" src="/Public/script/plugins/jquery.cookie.js"></script>
		<script type="text/javascript">
             var $campusId=$("#index-header").attr("data-campusId");
             var payAtOnceUrl="<?php echo U('/Home/Person/payAtOnce');?>";
             var getPhonerankUrl="<?php echo U('/Home/Person/getPhoneRank');?>";
             var selectCityUrl="<?php echo U('/Home/Person/selectCity');?>";
             var selectCampusUrl="<?php echo U('/Home/Person/selectCampus');?>";   
             var deleteLocationUrl="<?php echo U('/Home/Person/deleteLocation');?>";
		</script>
		<script type="text/javascript" src="/Public/script/pingpp-pc.js"></script>
		<script type="text/javascript" src="/Public/script/common.js"></script>
		<script type="text/javascript" src="/Public/script/goodsPayment.js"></script>
	</body>
</html>