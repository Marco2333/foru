$(function(){
    cityChange('city-change','campus-change');

	$(".main-wrapper-2").hide();
	$(".main-wrapper-2-1").bind("click",function(){
		$(".main-wrapper-2").slideDown(300);
		$(this).slideUp();

		$("#save_submit").removeClass("none");
        $("#revise_submit").addClass("none");
	});

	$(".main-wrapper-1-btn-revise").bind("click",function(){
		$(".main-wrapper-2").slideDown(300);
        $(".main-wrapper-2-1").slideUp();

		var phone   = $(this).nextAll(".phone-none").val();
        var rank    = $(this).nextAll(".rank-none").val();

        reviseAddress(phone,rank);

        /*$("#revise_submit").unbind('click').on("click",function(){
            var info = saveReviseLocation(phone,rank);
        });*/
	});

	$(".main-wrapper-2 .but-button").bind("click",function(){
		$(".main-wrapper-2").slideUp(300);
		$(".main-wrapper-2-1").slideDown();

		$("#save_submit").removeClass("none");
        $("#revise_submit").addClass("none");

        document.getElementById("userName").value   ="";
        document.getElementById("detailedLoc").value="";
        // document.getElementById("city-change").selected();
        // document.getElementById("campus-change").selected();
        document.getElementById("phoneNum").value   ="";
        document.getElementById("rank").value   ="0";
	});
	
	$(".main-wrapper-1-btn-delete").on("click",function(){
        var phone   = $(this).nextAll(".phone-none").val();
        var rank    = $(this).nextAll(".rank-none").val();
        $(this).parent().parent().remove();
        deleteAddress(phone,rank);
    });

    $("#submitPay").on("click",function(){
        var $togetherId=$('input[name="together-id"').val();
        var $orderIdstr=$("input[name='orderIDstr']").val();
        var $pay_way=$("input[type='radio'][name='pay-way']").val();
        var $rank=$(".main-wrapper-1-radio:checked").val();
        var $reserveTime=$("input[name='time']:checked").val();
        var $message=$("textarea[name='message']").val();

        if(typeof($rank)=="undefined"){
            $('#info').show();
            $('#info').html("请添加一个收货地址！");
            setTimeout("$('#info').hide()", 2000 );
            return;
        }
        var data={
            togetherId:$togetherId,
            orderIdstr:$orderIdstr,
            pay_way:$pay_way,
            rank:$rank,
            campusId:$campusId,
            message:$message,
            reserveTime:$reserveTime
        };

         $.ajax({
            url:payAtOnceUrl,
            data:data,
            success:function(data){
                if(data.status == 2){
                    pingpp.createPayment(data.charge, function(result, err) {
                       console.log(result);
                       console.log(err);
                    });
                }else if(data.status == -1){
                   $('#info').show();
                   $('#info').html("支付失败，请重试");
                   setTimeout("$('#info').hide()", 2000 );
                }else if(data.status == 1) {
                    $('#info').show();
                    $('#info').html("亲,收货地址超出配送范围哦");
                    setTimeout("$('#info').hide()", 2000 );
                }else if(data.status == 0) {
                    $('#info').show();
                    $('#info').html("亲，休息喽，下次再来");
                    setTimeout("$('#info').hide()", 2000 );
                }else if(data.status == 3){
                    $('#info').show();
                    $('#info').css('width','300px').html("该笔订单已经支付过了，不要重复支付哦。");
                    setTimeout("$('#info').hide()", 2000 );
                }
            }
        });
    });
});

function reviseAddress(phone,rank){
    $("#save_submit").addClass("none");
    $("#revise_submit").removeClass("none");

    var info = {
        phone:phone,
        rank:rank
    };

    $.ajax({
        type:"POST",
        url:getPhonerankUrl,
        data:info,
        success:function(data){
            var $city=$("#"+'city-change');
            $.ajax({
                type:"post",
                data:{'':''},
                url:selectCityUrl,
                success:function(city){
                    $city.empty();
                    for(var i=0;i<city.length;i++){
                        var op=document.createElement('option');
                        if(city[i]['city_name']==data['city']){
                                op.setAttribute("selected","selected");
                        }
                        op.innerHTML=city[i]['city_name'];
                        $city.append(op);
                    }
                },
            });
            var $campus_rel=$('#'+'campus-change');
        	if (data['result'] != 0)
        	{
            	document.getElementById("userName").value    =data['name'];
                var info = {
                    cityID:data['city_id'],
                };
                $.ajax({
                    type:"post",
                    url:selectCampusUrl,
                    data:info,
                    success:function(campus){
                        for(var i=0;i<campus.length;i++){
                            var op=document.createElement('option');
                            if(campus[i]['campus_name']==data['campus']){
                                op.setAttribute("selected","selected");
                            }
                            op.innerHTML=campus[i]['campus_name'];
                            $campus_rel.append(op);
                        }
                    },
                });
            	document.getElementById("detailedLoc").value =data['detailedLoc'];
                document.getElementById("phoneNum").value    =data['phone_id'];   
                document.getElementById("rank").value    =data['rank'];   		
            }

        }
    })
}

function saveReviseLocation(phone,rank){

    $("#save_submit").removeClass("none");
    $("#revise_submit").addClass("none");

    var info = {
        phone:phone,
        rank:rank,
        userName:$('#userName').val(),
        location1:$('#city-change').val(),
        location2:$('#campus-change').val(),
        detailedLoc:$('#detailedLoc').val(),
        phoneNum:$('#phoneNum').val()
    };

    $.ajax({
        type:"POST",
        url:"../../Home/Person/reviseLocation",
        data:info,
        success:function(data){
            if (data['result'] != 0)
            {

                return info;
            }
            else
            {
               $('#info').show();
               $('#info').html("修改收货地址失败");
               setTimeout("$('#info').hide()", 2000 );
            }

        }
    })
}

function deleteAddress(phone,rank){
    var info = {
        phone:phone,
        rank:rank
    };

    $.ajax({
        type:"POST",
        url:deleteLocationUrl,
        data:info,
        success:function(data){
            console.log(data);
        	if (data['result'] != 0)
        	{
        	   $('#info').show();
               $('#info').html("删除收货地址成功");
               setTimeout("$('#info').hide()", 2000 );
        	}
        	else
        	{
        	   $('#info').show();
               $('#info').html("删除收货地址失败");
               setTimeout("$('#info').hide()", 2000 );
        	}
        }
    })
}

function cityChange(city,campus){
    var $city=$("#"+city);
    var $campus=$('#'+campus);
    var $value;
    /*$city.find("option").remove();*/
    $.ajax({
        type:"post",
        data:{'':''},
        url:selectCityUrl,
        success:function(data){
            $value=data[0]['city_id'];
            var $city=$("#"+city);
            for(var i=0;i<data.length;i++){
                var op=document.createElement('option');
                op.innerHTML=data[i]['city_name'];
                $city.append(op);
            }
            $campus.find("option").remove();

            var info = {
                cityID:$value,
                };
            $.ajax({
                type:"post",
                url:selectCampusUrl,
                data:info,
                success:function(data){
                    for(var i=0;i<data.length;i++){
                        var op=document.createElement('option');
                        op.innerHTML=data[i]['campus_name'];
                        $campus.append(op);
                    }
                },
            });
        },
    });
    $city.change(function(){
        $campus.empty();
        var $value=$(this).prop('selectedIndex')+1;
        var info = {
            cityID:$value,
        };
        $.ajax({
            type:"post",
            url:selectCampusUrl,
            data:info,
            success:function(data){
                for(var i=0;i<data.length;i++){
                    var op=document.createElement('option');
                    op.innerHTML=data[i]['campus_name'];
                    $campus.append(op);
                }
            },
        });
    });
}









