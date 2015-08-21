$(function(){

	$("#body-form-1-button").click(function(){
		var $phone=$("#person-info-body-form-phone").val();
		var $check=$("#check-image-input").val();
		if($phone.trim()==""){
			$("#form-1-span-1").text("邮箱不能为空")
			.addClass("text-alert")
			.removeClass("text-ok");
			return;
		}
		if($check.trim()==""){
			$('#info').show();
	        $('#info').html("验证码不能为空");
	        setTimeout("$('#info').hide()", 2000 );
			return;
		}

		$.ajax({
			type:"post",
			data:{
					"phone":$phone,
					"check":$check
			},
			url:checkpwordUrl,
			success:function(data){
				if(data['value']=='success'){
					if(data['status']='success'){
						 $("#dl-1").removeClass('active');
						 $("#dl-2").addClass('active');
						 $(".person-info-body-page1").addClass("none");
						 $(".person-info-body-page2").removeClass("none");
					}else{
						$('#info').show();
						        $('#info').html("邮件发送失败，请重新提交");
						        setTimeout("$('#info').hide()", 2000 );
					}
				}else if(data['value']=='phoneerror'){
					$("#form-1-span-1").text("邮箱输入错误")
					.addClass("text-alert")
					.removeClass("text-ok");	
				}else if(data['value']=='checkerror'){
					$('#info').show();
			        $('#info').html("验证码输入错误");
			        setTimeout("$('#info').hide()", 2000 );
				}
				else {
					$('#info').show();
				    $('#info').html("验证码和号码都不正确");
				    setTimeout("$('#info').hide()", 2000 );
				}
			},
			error:function(){
				$('#info').show();
		        $('#info').html("数据获取失败，请重试！");
		        setTimeout("$('#info').hide()", 2000 );
			}
		});	
	});
	

	$("#resent-secword").click(function(){
		$(this).text("59秒后重新发送").addClass("sub-number")
			.attr("disabled",true);
		var a = setInterval(function(){
			var num = $("#resent-secword").text().substr(0,2);

			if(parseInt(num)-1<10) {
				$("#resent-secword").text("0"+parseInt(num)-1+"秒后重新发送");
			}
			else if (parseInt(num)-1 > 10) {
				$("#resent-secword").text(parseInt(num)-1+"秒后重新发送");
			}
			if(parseInt(num)==0) {
				clearInterval(a);
				$("#resent-secword").text("重新获取验证码")
				.removeClass("sub-number").attr("disabled",false);
			}
			
			
		},1000);
	});

	

	$("#person-info-body-form-phone").blur(function(){
		var $phone=$("#person-info-body-form-phone").val();
		if($phone.trim()==""){
			$("#form-1-span-1").text("邮箱不能为空")
			.addClass("text-alert")
			.removeClass("text-ok");
			return;
		}
		if(/\w*@\w*\.\w+/.test($phone)){
			$("#form-1-span-1").removeClass("text-alert")
			.text("√").addClass("text-ok");		
		}
		else {
			$("#form-1-span-1").text("请输入规范的邮箱格式")
			.addClass("text-alert")
			.removeClass("text-ok");
		}
	});

	$("#body-form-2-button").bind("click",function(){
        $postcode=$("input[name='mailcode']").val();
		$.post(
            checkMailPostUrl,
            {postcode:$postcode},
            function(data){
            	console.log(data);
                if(data.status=='success'){
                	$("#dl-2").removeClass('active');
                	$("#dl-3").addClass('active');
                	$(".person-info-body-page2").addClass("none");
                	$(".person-info-body-page3").removeClass("none");	
                }else{
                    $('#info').show();
			        $('#info').html("邮件验证码输入错误");
			        setTimeout("$('#info').hide()", 2000 );
                }
            }
		);
	});


	$("#body-form-3-button").click(function(){
		var $password1=$("#person-info-body-form-paword-1").val();
		var $password2=$("#person-info-body-form-paword-2").val();

		if(!(/^\S{8,20}$/.test($password1))){
			$('#info').show();
			$('#info').html("密码格式不对，请重新输入");
			setTimeout("$('#info').hide()", 2000 );
		}else if(!($password1==$password2)){
			$('#info').show();
			$('#info').css("width","260px").html("两次输入密码不相同，请重新输入");
			setTimeout("$('#info').hide()", 2000 );
		}else{
			$.ajax({
				type:"POST",
				data:{"pword":$password1},
				url:changepwordUrl,
				success:function(data){
					if(data['value']=='success'){
						$("#dl-3").removeClass('active');
						$("#dl-4").addClass('active');
						$(".person-info-body-page3").addClass("none");
						$(".person-info-body-page4").removeClass("none");
					}else {
						$('#info').show();
						$('#info').css("width","400px").html("修改密码失败，请重试！(不能输入和上次相同的密码)");
						setTimeout("$('#info').hide()", 2000 );
					}
				},
				error:function(){
					$('#info').show();
					$('#info').html("修改密码失败");
					setTimeout("$('#info').hide()", 2000 );
				}
			});
		}
	});
});
