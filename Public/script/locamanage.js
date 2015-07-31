$(function(){
    cityChange('location1','location2');
    var $index;
	$("#person-location-info tbody .revise-button").on("click",function(){
        $("#change-location").show(300);
        $("#add-location").hide();

        var phone   = $(this).nextAll(".phone-none").val();
        var rank    = $(this).nextAll(".rank-none").val();

        reviseAddress(phone,rank);
        $("#recevier_submit_button_revise").unbind("click").bind("click",function(){
            var info = saveReviseLocation(phone,rank);
        });
    });
     

    $("#person-location-info tbody .delete-button").on("click",function(){
        var flag=confirm("确认删除？");
         if(flag){
            var phone   = $(this).nextAll(".phone-none").val();
            var rank    = $(this).nextAll(".rank-none").val();
            $(this).parent().parent().remove();
            deleteAddress(phone,rank);
        }
    });

    $("#change-location").hide();

    $("#add-location").bind("click",function(){
        $("#change-location").show(300);
        $(this).hide();

        $("#recevier_submit_button").removeClass("none");
        $("#recevier_submit_button_revise").addClass("none");
    });

    $("#cancel-button").bind("click",function(){
        $("#change-location").hide(300);
        $("#add-location").show();

        $("#recevier_submit_button").removeClass("none");
        $("#recevier_submit_button_revise").addClass("none");

        document.getElementById("userName").value   ="";
        document.getElementById("detailedLoc").value="";
        // document.getElementById("city-change").selected();
        // document.getElementById("campus-change").selected();
        document.getElementById("phoneNum").value   ="";
    });
});

function saveNewLocation(){
    var info = {
        userName:$('#userName').val(),
        location1:$('#location1').val(),
        location2:$('#location2').val(),
        detailedLoc:$('#detailedLoc').val(),
        phoneNum:$('#phoneNum').val()
    };

    $("#change-location").addClass("none");

    $.ajax({
        type:"POST",
        url:"../../Home/Person/saveLocation",
        data:info,
        success:function(data){
            document.getElementById("userName").value="";

            if (data['result'] != 0)
            {
	            info['phone']   = data['phone'];
	            info['rank']    = data['rank'];

	            var tr=$("<tr></tr>");
	            tr.append("<td>"+"收货人："+info['userName']+"<p>"+"联系电话："+info['phoneNum']+"</td>")
	              .append("<td>"+info['location1']+"</td>");
	            var td=$("<td></td>");

	            $("<button class='revise-button'>修改</button>").on("click",function(){
	                var phone   = $(this).nextAll(".phone-none").val();
	                var rank    = $(this).nextAll(".rank-none").val();

	                reviseAddress(phone,rank);
	            }).appendTo(td);
	            
	            $("<button class='delete-button'>删除地址</button>").on("click",function(){
                    
                        var phone   = $(this).nextAll(".phone-none").val();
                        var rank    = $(this).nextAll(".rank-none").val();
                        $(this).parent().parent().remove();
                        deleteAddress(phone,rank);
	            }).appendTo(td);

	            td.append("<input class='phone-none none' value="+info['phone']+">")
	              .append("<input class='rank-none none'  value="+info['rank']+">");

	            tr.append(td);

	            $("tbody").append(tr);

            }
            else
            {
            	alert("收货地址保存失败！");
            }
        }
    })
}

function saveReviseLocation(phone,rank){

    $("#change-location").addClass("none");

    var info = {
        phone:phone,
        rank:rank,
        userName:$('#userName').val(),
        location1:$('#location1').val(),
        location2:$('#location2').val(),
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

function addAddress(){
    $("#change-location").removeClass("none");
    $("#recevier_submit_button").removeClass("none");
    $("#recevier_submit_button_revise").addClass("none");
}

function reviseAddress(phone,rank){
    $("#change-location").removeClass("none");
    $("#recevier_submit_button").addClass("none");
    $("#recevier_submit_button_revise").removeClass("none");

    var info = {
        phone:phone,
        rank:rank
    };

    $.ajax({
        type:"POST",
        url:"../../Home/Person/getPhoneRank",
        data:info,
        success:function(data){
            var $city=$("#"+'location1');
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
            var $campus_rel=$('#'+'location2');
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