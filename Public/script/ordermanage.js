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
        
    });

    $("#person-info-body .order-manage-2").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();

        $.ajax({
            type:"POST",
            url:"../../../../../../Home/Person/deleteOrCancelOrder",
            data:{order_id:$order_id},
            success:function(result){
                if (result['result'] != 0) {
                    var input = document.getElementById($order_id);
                    var tr    = input.parentNode.parentNode;
                    var tbody = input.parentNode.parentNode.parentNode;

                    var trs   = tbody.childNodes;
                    var cnt = 0;
                    for (i = 0;i < trs.length;i++) {
                        if (trs[i].nodeName == "TR") {
                            cnt++;
                        }
                    }

                    if (cnt <= 2) {
                        var table = tbody.parentNode;

                        table.removeChild(tbody);
                    }
                    else {
                        tbody.removeChild(tr);
                    }
                }
                else {
                    // alert("订单取消失败，请重试！");
                }
            }
        })        
    });

    $("#person-info-body .order-manage-3").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();

        var $href = "../../../../../../Home/Person/goodsPayment?orderIds="+$order_id+"&campusId="+$.cookie('campusId');
        window.location.href=$href;        
    });

    $("#person-info-body .order-manage-4").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();

        $.ajax({
            type:"POST",
            url:"../../../../../../Home/Person/deleteOrCancelOrder",
            data:{order_id:$order_id},
            success:function(result){
                if (result['result'] != 0) {
                    var input = document.getElementById($order_id);
                    var tr    = input.parentNode.parentNode;
                    var tbody = input.parentNode.parentNode.parentNode;

                    var trs   = tbody.childNodes;
                    var cnt = 0;
                    for (i = 0;i < trs.length;i++) {
                        if (trs[i].nodeName == "TR") {
                            cnt++;
                        }
                    }

                    if (cnt <= 2) {
                        var table = tbody.parentNode;

                        table.removeChild(tbody);
                    }
                    else {
                        tbody.removeChild(tr);
                    }
                }
                else {
                    // alert("订单取消失败，请重试！");
                }
            }
        })        
    });

    $("#person-info-body .order-manage-5").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
        $.ajax({
            type:"POST",
            url:"../../../../../../Home/Person/confirmReceive",
            data:{order_id:$order_id},
            success:function(result){
                if (result['result'] != 0) {
                    var btn1 = document.createElement("button");
                    var btn2 = document.createElement("button");
                    btn1.setAttribute("class","order-manage-button order-manage-6");
                    btn2.setAttribute("class","order-manage-button order-manage-2");
                    btn1.innerHTML = "立即评价";
                    btn2.innerHTML = "删除订单";

                    var newtd = document.createElement("td");
                    newtd.appendChild(btn1);
                    newtd.appendChild(btn2);

                    var input = document.getElementById($order_id);

                    var td = input.parentNode;
                    var tr = input.parentNode.parentNode;
                    tr.replaceChild(newtd,td);
                }
                else {
                    // alert("确认收货失败，请重试！");
                }
            }
        })
    });

    $("#person-info-body .order-manage-6").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
        var $href = "../../../../../../Home/Index/comment?order_id="+$order_id+"&campusId="+$.cookie('campusId');;
        window.location.href = $href;
    });

});


