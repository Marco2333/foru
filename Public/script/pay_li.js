$(function(){
	$(".main-wrapper-2").hide();
	$(".main-wrapper-2-1").bind("click",function(){
		$(".main-wrapper-2").show(300);
		$(this).hide();
	});
	$(".main-wrapper-2 .but-button").bind("click",function(){
		$(".main-wrapper-2").hide(300);
		$(".main-wrapper-2-1").show();
	});
});
