$(function(){
	showStar();
	showRed();
	mouseStar();
	
});

function showStar(){
	var $grade=$("#thing_grade").html();
	if($grade=="null" || $grade==null){
		$grade=0;
	}else if($grade==0){
		$grade=0;
	}else{
		$grade=$grade-1;
	}
	var $data=".star:eq("+$grade+")";
	$($data).addClass("star-active");
}

/*从后台取得评分数据，然后运用脚本将星星点亮，星星点灯QAQ*/
function showRed(){
	$("span.height-star>span.star-active").addClass("show-color");
	$("span.height-star>span.star-active").prevAll().addClass("show-color");
}

/*用户可以评星*/
function mouseStar(){
	$("span.star-2>span.red-star").bind("mouseover",function(){
		$(this).addClass("special-red");
		$(this).prevAll().addClass("special-red");
	});
	$("span.star-2>span.red-star").bind("mouseout",function(){
		$("span.star-2>span.red-star").removeClass("special-red");
	});
	$("span.star-2>span.red-star").bind("click",function(){
		$("span.star-2>span.red-star").removeClass("special-click");
		$(this).addClass("special-click");
		$(this).prevAll().addClass("special-click");
		var $number=$(this).prevAll().length+1;
		$("#span-thing").html($number);
	});
}

function submitComment(){
	var $comment=$("textarea").val();
	var $order_id=$("#order_id").html();
	var $grade=$(".special-click").length;
	var $campus_id=$("#campus_id").html();
	var $tag=$('#thing_tag').html();
	var $food_id=$("#food_id").html();
	var $info={
		"food_id":$food_id,
		"order_id":$order_id,
		"comment":$comment,
		"grade":$grade,
		"campus_id":$campus_id,
		"tag":$tag,
	}
	$.ajax({
		type:"POST",
		data:$info,
		/*路径有时错误会报404错误*/
		url:'../Index/saveComment',
		success:function(data){
			if(data['value']=='success'){
				alert('评论成功');
			}else if(data['value']=='error'){
				alert('评论保存失败请重试！');
			}else{
				alert('未知错误，请截图联系管理员');
			}
		},
		error:function(){
			alert("不是正确连接，请稍后再试如果还是如此，请联系管理员");
		}
	});
}
