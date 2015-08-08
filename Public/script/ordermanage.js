$(function(){
    var status = $(".tab-div").attr("data-status");
    $(".tab-div > .button").removeClass("active");
    $(".tab-div > .button:eq("+(parseInt(status))+")").addClass("active");
    $("#person-nav-side li").removeClass("active");
    $("#person-nav-side li:eq("+(parseInt(status))+")").addClass("active");

    $(".tab-div > .button").click(function(){
        $(this).siblings().removeClass("active");
        $(this).addClass("active"); 
        // $("#person-nav-side li").removeClass("active");
        // var prevAll = $(this).prevAll();
        // $("#person-nav-side li:eq("+prevAll.length+")").addClass("active");

    });

    $("#person-nav-side li").click(function(){
    	$(this).siblings().removeClass("active");
    	$(this).addClass("active");
    	// $(".tab-div > .button").removeClass("active");
    	// var prevAll = $(this).prevAll();
    	// $(".tab-div > .button:eq("+(prevAll.length-1)+")").addClass("active");
    });

    $("#person-info-body .order-manage-1").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
        $.ajax({
            type:"POST",
            url:"../../Home/Peron/deleteOrder",
            data:{order_id:$order_id},
            success:function(result){
                if (result['result'] != 0) {

                }
                else {

                }
            }
        })
    });

    $("#person-info-body .order-manage-2").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
    });

    $("#person-info-body .order-manage-3").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
    });

    $("#person-info-body .order-manage-4").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
    });

    $("#person-info-body .order-manage-5").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
    });

    $("#person-info-body .order-manage-6").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
    });

});


