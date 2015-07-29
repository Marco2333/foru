$(function(){
	$("#person-info-body-form-phone").bind("blur",function(){
		var $phone=$("#person-info-body-form-phone").val();
		var $check=$("#check-image-input").val();
		
		if($phone.trim()==""){
			$("#form-1-span-1").text("号码不能为空")
			.addClass("text-alert")
			.removeClass("text-ok");
			return;
		}
		if(/^[1][2358][0-9]{9}$/.test($phone)){
			$("#form-1-span-1").removeClass("text-alert");

			$.ajax({
				type:"post",
				data:{"phone":$phone,"check":$check},
				url:"../../Home/Person/phone",
				success:function(data){
					if(data['value']=='success'){
						$("#form-1-span-1").text("√")
						.addClass("text-ok")
						.removeClass("text-alert");		
						showPage2();
					}else{
						$("#form-1-span-1").text("号码输入错误")
						.addClass("text-alert")
						.removeClass("text-ok");	
					}
				},
				error:function(){
					alert("数据获取失败，请重试！");
				}
			});
		}else{
			$("#form-1-span-1").text("请输入规范的号码")
			.addClass("text-alert")
			.removeClass("text-ok");
		}
	});
});

function showPage2(){
	$("#body-form-1-button").bind("click",function(){
		var $check=$("#check-image-input").val();
		if($check==""){
			alert("验证码不能为空");
			return;
		}else{
			$.ajax({
				type:"post",
				data:{"check":$check},
				url:"../Person/check",
				success:function(data){
					if(data['value']=='success'){
						$("#dl-1").removeClass('active');
						$("#dl-2").addClass('active');
						$(".person-info-body-page1").css({'display':'none'});
						$(".person-info-body-page2").css({'display':'block'});
					}else if(data['value']=='error'){
						alert("验证码错误");
						return;
					}
					else{
						alert('未知错误,请刷新页面重试');
					}
				},
				error:function(){
					alert("验证失败，请重试！");
				}
			});
		}
	});
		
	$("#person-info-body-form-message").bind("click",function(){
			$("#body-form-2-button").bind("click",function(){
				showPage3();
			});
	});
}

function showPage3(){
	$("#dl-2").attr('class','');
	$("#dl-3").attr('class','active');
	$(".person-info-body-page2").css({'display':'none'});
	$(".person-info-body-page3").css({'display':'block'});
	$("#body-form-3-button").bind("click",function(){
		var $password1=$("#person-info-body-form-paword-1").val();
		var $password2=$("#person-info-body-form-paword-2").val();
		if(!((/^\S{8,20}$/.test($password1)) && (/^\S{8,20}$/.test($password2)))){
			alert("密码格式不对，请重新输入");
		}else if(!($password1==$password2)){
			alert("两次输入密码不对，请重新输入");
		}else if((($password1==$password2)) && ((/^\S{8,20}$/.test($password1)) && (/^\S{8,20}$/.test($password2)))){
			$.ajax({
				type:"POST",
				data:{"pword":$password1},
				url:"../Person/changePWord",
				success:function(data){
					if(data['value']=='success'){
						showPage4();
					}else if(data['value']=='error'){
						alert("修改密码失败，请重试！");
					}else{
						alert("不知名错误，请刷新页面重试！！！");
					}
				},
				error:function(){
					alert("连接数据库失败，请重试！");
				}
			});
		}else{
			alert("未知错误");
		}
	});
}

function showPage4(){
	$("#dl-3").attr('class','');
	$("#dl-4").attr('class','active');
	$(".person-info-body-page3").css({'display':'none'});
	$(".person-info-body-page4").css({'display':'block'});
}
