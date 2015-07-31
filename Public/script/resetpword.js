$(function(){
	$("#body-form-1-button").click(function(){
		var $phone=$("#person-info-body-form-phone").val();
		var $check=$("#check-image-input").val();
		if($phone.trim()==""){
			$("#form-1-span-1").text("号码不能为空")
			.addClass("text-alert")
			.removeClass("text-ok");
			return;
		}
		if($check.trim()==""){
			alert("验证码不能为空");
			return;
		}

		$.ajax({
			type:"post",
			data:{
					"phone":$phone,
					"check":$check
			},
			url:"../../Home/Person/phone",
			success:function(data){
				if(data['value']=='success'){
					$("#dl-1").removeClass('active');
					$("#dl-2").addClass('active');
					$(".person-info-body-page1").addClass("none");
					$(".person-info-body-page2").removeClass("none");		
				}else if(data['value']=='phoneerror'){
					$("#form-1-span-1").text("号码输入错误")
					.addClass("text-alert")
					.removeClass("text-ok");	
				}else if(data['value']=='checkerror'){
					alert('验证码输入错误！');
				}
				else {
					alert('验证码和号码都不正确');
				}
			},
			error:function(){
				alert("数据获取失败，请重试！");
			}
		});	
	});

	$("#person-info-body-form-phone").blur(function(){
		var $phone=$("#person-info-body-form-phone").val();
		if($phone.trim()==""){
			$("#form-1-span-1").text("号码不能为空")
			.addClass("text-alert")
			.removeClass("text-ok");
			return;
		}
		if(/^[1][2358][0-9]{9}$/.test($phone)){
			$("#form-1-span-1").removeClass("text-alert")
			.text("√").addClass("text-ok");
			
		}
		else {
			$("#form-1-span-1").text("请输入规范的号码")
			.addClass("text-alert")
			.removeClass("text-ok");
		}
	});

	$("#body-form-2-button").bind("click",function(){
		$("#dl-2").removeClass('active');
		$("#dl-3").addClass('active');
		$(".person-info-body-page2").addClass("none");
		$(".person-info-body-page3").removeClass("none");	
	});

	$("#body-form-3-button").click(function(){
		var $password1=$("#person-info-body-form-paword-1").val();
		var $password2=$("#person-info-body-form-paword-2").val();

		if(!(/^\S{8,20}$/.test($password1))){
			alert("密码格式不对，请重新输入");
		}else if(!($password1==$password2)){
			alert("两次输入密码不相同，请重新输入");
		}else{
			$.ajax({
				type:"POST",
				data:{"pword":$password1},
				url:"../Person/changePWord",
				success:function(data){
					if(data['value']=='success'){
						$("#dl-3").removeClass('active');
						$("#dl-4").addClass('active');
						$(".person-info-body-page3").addClass("none");
						$(".person-info-body-page4").removeClass("none");
					}else {
						alert("修改密码失败，请重试！(不能输入和上次相同的密码)");
					}
				},
				error:function(){
					alert("修改密码失败！");
				}
			});
		}
	});
});


