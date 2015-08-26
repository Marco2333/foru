$(function(){
    cityChange('location1','location2');

	$("#person-location-info tbody .revise-button").on("click",function(){     //修改地址
        $("#change-location").show(300);
        $("#add-location").hide();

        var rank    = $(this).nextAll(".rank-none").val();
        reviseAddress(rank);   //修改

        /*$("#recevier_submit_button_revise").unbind('click').on("click",function(){

            //var info = saveReviseLocation(rank);
        });*/
    });

    $("#person-location-info tbody .delete-button").on("click",function(){  //删除地址
        var rank    = $(this).nextAll(".rank-none").val();
        
        deleteAddress(rank);  
        $(this).parent().parent().remove();
        
    });


    //点击的变化
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
        document.getElementById("rank").value="0";
        // document.getElementById("city-change").selected();
        // document.getElementById("campus-change").selected();
        document.getElementById("phoneNum").value   ="";
    });
});

/*function saveReviseLocation(rank){

    $("#change-location").addClass("none");

    var info = {
        rank:rank
    };

    $.ajax({
        type:"POST",
        url:"../../../../Home/Person/addOrReviseSave",
        data:info,
        success:function(data){
            if (data['result'] != 0)
            {
                $('#info').show();
               $('#info').html("修改收货地址成功");
               setTimeout("$('#info').hide()", 2000 );
                return info;
            }
            else
            {
              /* $('#info').show();
               $('#info').html("修改收货地址失败");
               setTimeout("$('#info').hide()", 2000 );*/
           /* }

        }
    })
}*/

function addAddress(){
    $("#change-location").removeClass("none");
    $("#recevier_submit_button").removeClass("none");
    $("#recevier_submit_button_revise").addClass("none");
}

function reviseAddress(rank){                //修改地址
    $("#change-location").removeClass("none");
    $("#recevier_submit_button").addClass("none");
    $("#recevier_submit_button_revise").removeClass("none");

    var info = {
        rank:rank
    };

    $.ajax({
        type:"POST",
        url:"../../../../Home/Person/getPhoneRank",
        data:info,
        success:function(data){
            var $city=$("#"+'location1');
            $.ajax({
                type:"post",
                data:{'':''},
                url:"../../../../Home/Person/selectCity",
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
                    url:"../../../../Home/Person/selectCampus",
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
                document.getElementById("detailedLoc").value =data['address'];
                document.getElementById("phoneNum").value    =data['phone'];  
                document.getElementById('rank').value=data['rank'];           
            }
            else
            {
               $('#info').show();
               $('#info').html("获取收货地址失败");
               setTimeout("$('#info').hide()", 2000 );
            }
        }
    })
}

function deleteAddress(rank){
    var info = {
        rank:rank
    };

    $.ajax({
        type:"POST",
        url:"../../../../Home/Person/deleteLocation",
        data:info,
        success:function(data){
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
        url:"../../../../Home/Person/selectCity",
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
                url:"../../../../Home/Person/selectCampus",
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
            url:"../../../../Home/Person/selectCampus",
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