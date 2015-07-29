$(function(){
	$(".main-wrapper-2").hide();
	$(".main-wrapper-2-1").bind("click",function(){
		$(".main-wrapper-2").show(300);
		$(this).hide();

		document.getElementById("save_submit").className="but but-submit";
    	document.getElementById("revise_submit").className="but but-submit none";
	});

	$(".main-wrapper-1-btn-revise").bind("click",function(){
		$(".main-wrapper-2").show(300);
		// $(this).hide();

		var phone   = $(this).nextAll(".phone-none").val();
        var rank    = $(this).nextAll(".rank-none").val();

        reviseAddress(phone,rank);

        $("#revise_submit").on("click",function(){
            var info = saveReviseLocation(phone,rank);
        });
	});

	$(".main-wrapper-2 .but-button").bind("click",function(){
		$(".main-wrapper-2").hide(300);
		$(".main-wrapper-2-1").show();

		document.getElementById("save_submit").className="but but-submit";
    	document.getElementById("revise_submit").className="but but-submit none";
	});

	// $("#addressColumn tbody .main-wrapper-1-btn").on("click",function(){
 //        var phone   = $(this).nextAll(".phone-none").val();
 //        var rank    = $(this).nextAll(".rank-none").val();

 //        reviseAddress(phone,rank);

 //        $("#revise_submit").on("click",function(){
 //            var info = saveReviseLocation(phone,rank);
 //        });
 //    });
	
	$(".main-wrapper-1-btn-delete").on("click",function(){
        var phone   = $(this).nextAll(".phone-none").val();
        var rank    = $(this).nextAll(".rank-none").val();
        $(this).parent().parent().remove();
        deleteAddress(phone,rank);
    });


});

function addOrRevise(){
    document.getElementById("change-location").className="";
}

function reviseAddress(phone,rank){
    // addOrRevise();

    document.getElementById("save_submit").className="but but-submit none";
    document.getElementById("revise_submit").className="but but-submit";

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

function saveReviseLocation(phone,rank){
	// alert(phone);
    // alert(rank);

    document.getElementById("save_submit").className="but but-submit";
    document.getElementById("revise_submit").className="but but-submit none";

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

function deleteAddress(phone,rank){
    var info = {
        phone:phone,
        rank:rank
    };

    // alert(phone);
    // alert(rank);

    $.ajax({
        type:"POST",
        url:"../../Home/Person/deleteLocation",
        data:info,
        success:function(data){
            // console.log(data);
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
