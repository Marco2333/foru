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

        $("#revise_submit").unbind('click').on("click",function(){
            var info = saveReviseLocation(phone,rank);
        });
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
	});
	
	$(".main-wrapper-1-btn-delete").on("click",function(){
        var phone   = $(this).nextAll(".phone-none").val();
        var rank    = $(this).nextAll(".rank-none").val();
        $(this).parent().parent().remove();
        deleteAddress(phone,rank);
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
        url:"../../Home/Person/getPhoneRank",
        data:info,
        success:function(data){
            var $city=$("#"+'city-change');
            $.ajax({
                type:"post",
                data:{'':''},
                url:"../../Home/Person/selectCity",
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
                    url:"../../Home/Person/selectCampus",
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
            }
            else
            {
            	alert("原收货地址获取失败！");
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
                // alert("修改收货地址成功！");

                return info;
            }
            else
            {
                alert("修改收货地址失败！");
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
        url:"../../Home/Person/deleteLocation",
        data:info,
        success:function(data){
            console.log(data);
        	if (data['result'] != 0)
        	{
        		// alert("收货地址删除成功！");
        	}
        	else
        	{
        		alert("收货地址删除失败！");
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
        url:"../../Home/Person/selectCity",
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
                url:"../../Home/Person/selectCampus",
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
            url:"../../Home/Person/selectCampus",
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










