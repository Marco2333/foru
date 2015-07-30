$(function(){
	$("#person-location-info tbody .revise-button").on("click",function(){
        var phone   = $(this).nextAll(".phone-none").val();
        var rank    = $(this).nextAll(".rank-none").val();
    
        reviseAddress(phone,rank);

        $("#recevier_submit_button_revise").on("click",function(){
            var info = saveReviseLocation(phone,rank);
        });

        // alert("I am here");
        // var userName = document.getElementById("userName-none").value();
        // // var location = document.getElementById("location-none").value();
        // var phoneNum = document.getElementById("phoneNum-none").value();
        // alert(userName);
        // alert(phoneNum);

        // $(this).parent().parent().children().first().html("hello");
    });

    $("#person-location-info tbody .delete-button").on("click",function(){
        var phone   = $(this).nextAll(".phone-none").val();
        var rank    = $(this).nextAll(".rank-none").val();
        $(this).parent().parent().remove();
        deleteAddress(phone,rank);
    });
});

function cancel(){
    document.getElementById("change-location").className+=" none";
}

function saveNewLocation(){
    // alert("I am here");
    var info = {
        userName:$('#userName').val(),
        location1:$('#location1').val(),
        location2:$('#location2').val(),
        location3:$('#location3').val(),
        detailedLoc:$('#detailedLoc').val(),
        phoneNum:$('#phoneNum').val()
    };

    cancel();

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

	            // td.append("<button class='revise-button'>修改</button>");
	            // td.append("<button class='delete-button'>删除地址</button>");

	            $("<button class='revise-button'>修改</button>").on("click",function(){
	                var phone   = $(this).nextAll(".phone-none").val();
	                var rank    = $(this).nextAll(".rank-none").val();
	                // alert(phone);
	                // alert(rank);
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
	            // test.html("");
	            $("tbody").append(tr);

	            // document.getElementById("userName").value="";
	            // document.getElementById("userName").value="";
	            // document.getElementById("userName").value="";
	            // document.getElementById("userName").value="";
            
            	// alert("收货地址保存成功！");

            }
            else
            {
            	alert("收货地址保存失败！");
            }
        }
    })
}

function saveReviseLocation(phone,rank){
    // alert(phone);
    // alert(rank);

    cancel();

    var info = {
        phone:phone,
        rank:rank,
        userName:$('#userName').val(),
        location1:$('#location1').val(),
        location2:$('#location2').val(),
        location3:$('#location3').val(),
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
    $("recevier_submit_button_revise").addClass("none");
}

function reviseAddress(phone,rank){
    
    $("#change-location").removeClass("none");

    $("#recevier_submit_button").addClass("none");
    $("recevier_submit_button_revise").removeClass("none");

    var info = {
        phone:phone,
        rank:rank
    };

    $.ajax({
        type:"POST",
        url:"../../Home/Person/getPhoneRank",
        data:info,
        success:function(data){
        	if (data['result'] != 0)
        	{
            	document.getElementById("userName").value=data['name'];
            	// document.getElementById("userName").value=data['name'];
            	// document.getElementById("userName").value=data['name'];
            	// document.getElementById("userName").value=data['name'];
            	// document.getElementById("userName").value=data['name'];	
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