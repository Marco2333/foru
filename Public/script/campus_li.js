$(function(){
	$("#location").bind("click",function(){
		$("#campus-background").show(300);
	});
	$(".campus-close").bind("click",function(){
		$(this).parent().hide(300);
	});
});
