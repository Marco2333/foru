$(function(){
    $('#slide-wrapper').carousel();
    
    if($.cookie('campusId')==null){
       $.cookie("campusId", 1, { expires: 7 });
    }
});
 if($.cookie('campusId')==null){
       $.cookie("campusId", 1, { expires: 7 });
 }
// $(document).ready(function() {

// 	var offset = $("#goods-count").offset();
// 	$(".cart-button").click(function(event) {
// 		var goodsCounts = parseInt($("#goods-count").text()) + 1;
// 		var addcar = $(this);
// 		var goodsPriceCount = parseFloat($("#price-count").text().toString().trim().substring(1));
// 		//alert(parseFloat(addcar.parents(".goods-info").find("span.goods-price").text().toString().trim().substring(1)));
// 		var goodsPrice = parseFloat(addcar.parents(".goods-info").find("span.goods-price").text().toString().trim().substring(1));
// 		var newPriceCount = goodsPriceCount + goodsPrice + "";

// 		$("#price-count").text("￥" + newPriceCount.substring(0, 5));
// 		$("#goods-count").text(goodsCounts);
// 		var img = addcar.parents(".goods-show").find('img').attr('src');
// 		var flyer = $('<img class="u-flyer" src="' + img + '">');
// 		flyer.fly({
// 			start : {
// 				left : event.pageX, //开始位置（必填）#fly元素会被设置成position: fixed
// 				top : event.pageY //开始位置（必填）
// 			},
// 			end : {
// 				left : offset.left + 10, //结束位置（必填）
// 				top : offset.top + 10, //结束位置（必填）
// 				width : 0, //结束时宽度
// 				height : 0 //结束时高度
// 			},
// 			onEnd : function() {//结束回调
// 				$(".shopping-msg").show().animate({
// 					width : '250px'
// 				}, 200).fadeOut(1000);
// 				//提示信息
// 				//addcar.css("cursor","default").unbind('click');
// 				this.destory();
// 				//移除dom
// 			}
// 		});

// 	});
// });

