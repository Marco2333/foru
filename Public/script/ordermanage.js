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
            url:deleteOrderUrl,
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

    $(".order-info-detailed .per-order-manage").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();

        var $href = goodPaymentsUrl+"?orderIds="+$order_id+"&campusId="+$.cookie('campusId');
        window.location.href=$href;        
    });
    
    $(".order-info-head .together-order-manage").unbind('click').on("click",function(){
        var $togetherId = $(this).attr('data-togetherId');
         window.location.href = goodPaymentsUrl+"?togetherId="+$togetherId;
    });

    $("#person-info-body .order-manage-4").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        var $togetherId= $(this).attr('data-togetherId');   //togetherId

        console.log($togetherId);
        if(typeof($togetherId)!="undefined"){
             console.log($togetherId);
            $.ajax({
                type:"POST",
                url:cancelOrderUrl,
                data:{togetherId:$togetherId},
                success:function(result){
                    if (result['status'] =="success") {
                        //将该记录消失
                      /*  var input = document.getElementById($order_id);
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
                        }*/
                        if(result['type']="refund"){
                            $('#info').show();
                            $('#info').css("width","380px").html("订单取消成功，请耐心等待退款处理");
                            setTimeout("$('#info').hide()", 3000 );
                        }else {
                            $('#info').show();
                            $('#info').html("订单取消成功");
                            setTimeout("$('#info').hide()", 2000 );
                        }         
                    }
                    else {
                        $('#info').show();
                        $('#info').css("width","220px").html("订单取消失败，请重试！");
                        setTimeout("$('#info').hide()", 2000 );
                    }
                }
            });
        }else{
            $.ajax({
                type:"POST",
                url:deleteOrderUrl,
                data:{order_id:$order_id},
                success:function(result){
                    if (result['status'] =="success") {
                        //将该记录消失
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
                        if(result['type']=="refund"){
                            $('#info').show();
                            $('#info').html("该订单已经付款，无法直接删除");
                            setTimeout("$('#info').hide()", 3000 );
                        }else {
                            $('#info').show();
                            $('#info').html("订单取消成功");
                            setTimeout("$('#info').hide()", 2000 );
                        }         
                    }
                    else {
                        $('#info').show();
                        $('#info').html("订单取消失败，请重试！");
                        setTimeout("$('#info').hide()", 2000 );
                    }
                }
            });
        }
        
    });

    $("#person-info-body .order-manage-5").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        
        if(!confirm("确认收货？")) {
            return;
        }
        $.ajax({
            type:"POST",
            url:confirmReceiveUrl,
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
                    var neworderNone = document.createElement("input");
                    neworderNone.setAttribute("class","order-none none");
                    neworderNone.setAttribute("id",$order_id);
                    neworderNone.setAttribute("value",$order_id);

                    newtd.appendChild(btn1);
                    newtd.appendChild(btn2);
                    newtd.appendChild(neworderNone);

                    var input = document.getElementById($order_id);

                    var td = input.parentNode;
                    var tr = input.parentNode.parentNode;
                    tr.replaceChild(newtd,td);

                    $("#person-info-body .order-manage-2").unbind('click').on("click",function(){
                        var $order_id = $(this).nextAll(".order-none").val();
                        $.ajax({
                            type:"POST",
                            url:deleteOrderUrl,
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
                                   
                                }
                            }
                        })        
                    });

                    $("#person-info-body .order-manage-6").unbind('click').on("click",function(){
                        var $order_id = $(this).nextAll(".order-none").val();
                        var $href = commentUrl+"?order_id="+$order_id+"&campusId="+$campusId;
                        window.location.href = $href;
                    });
                }
                else {
                   
                }
            }
        })
    });

    $("#person-info-body .order-manage-6").unbind('click').on("click",function(){
        var $order_id = $(this).nextAll(".order-none").val();
        var $href = commentUrl+"?order_id="+$order_id+"&campusId="+$campusId;
        window.location.href = $href;
    });

});


