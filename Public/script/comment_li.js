$(function(){
	showStar();
	showRed();
	mouseStar();
	
});

function showStar(){
	var $grade=$("#thing_grade").text();
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
	var $order_id=$("#order_id").text();
	var $grade=$(".special-click").length;
	var $campus_id=$("#campus_id").text();
	var $tag=$('#thing_tag').text();
	var $food_id=$("#food_id").text();
	var $is_remarked=$("#is_remarked").text();
	if($is_remarked != 0){
		$("#fix-warn").html("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>sorry！</strong>你已经评价过了，不可以重评奥^_^。</div>").removeClass('none');
		setTimeout(function(){
			$("#fix-warn").addClass('none');
		},2000);
		return;
	}
	if($grade == 0 && $grade ==""){
		$("#fix-warn").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>sorry！</strong>请打点分吧^_^。</div>").removeClass('none');
		setTimeout(function(){
			$("#fix-warn").addClass('none');
		},2000);
		return;
	}
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
				$("#fix-warn").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>成功！</strong>恭喜你评论成功，页面将在5秒后跳转。</div>").removeClass('none');
				setTimeout(function(){
					location.href = '../Index/index';
				},3000);
			}else{
				$("#fix-warn").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>sorry！</strong>没有评论成功QAQ。</div>").removeClass('none');
			}
		},
		error:function(){
				$("#fix-warn").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>sorry！</strong>没有评论成功QAQ。</div>").removeClass('none');
		}
	});
}
