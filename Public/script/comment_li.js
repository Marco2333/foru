$(function(){
	showStar();
	showRed();
	mouseStar();
	
});

function showStar(){
	var $grade=Number($("#thing_grade").text());
	
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

/*从后台取得评分数据，然后运用脚本将星星点亮*/
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
		$('#info').show();
         $('#info').html("不可以重复评价QAQ");
         setTimeout("$('#info').hide()", 2000 );
		return;
	}
	if($grade == 0 && $grade ==""){
		 $('#info').show();
         $('#info').html("请打点分吧QAQ");
         setTimeout("$('#info').hide()", 2000 );
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
			   $('#info').show();
               $('#info').html("评价成功QAQ");
               setTimeout(function(){
                   $('#info').hide();
                     location.href =personOrderInfoUrl;
               },2000);
               //setTimeout("$('#info').hide();location.href ="+personOrderInfoUrl+";", 2000 );
			}else if(data['value']=="hasComment"){
			   $('#info').show();
               $('#info').html("不可以重复评价QAQ");
               setTimeout("$('#info').hide()", 2000 );
			}else{
			   $('#info').show();
               $('#info').html("评价失败，请重新评价");
               setTimeout("$('#info').hide()", 2000 );
			}
		},
		error:function(){
			   $('#info').show();
               $('#info').html("评价失败,请重新评价");
               setTimeout("$('#info').hide()", 2000 );
		}
	});
}
