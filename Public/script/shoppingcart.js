$(document).ready(function(){
    $(".drop-down-left,.drop-down-layer").hover(function(){
      $(".drop-down-layer").show();
    },function(){
      $(".drop-down-layer").hide();  
    });

    $(".order-info-detailed a.sub-goods").click(function(){
      var v=$(this).next("input").val();
      if(parseInt(v)!=0){
        $(this).next("input").val(parseInt(v)-1);
      }    
      caltotalCost();
    });

    $(".order-info-detailed a.add-goods").click(function(){
      var v=$(this).prev("input").val();
      $(this).prev("input").val(parseInt(v)+1); 
      caltotalCost();
    });

    $("#checkall input").click(function(){
      // alert($(this).prop("checked"));
      if(document.getElementById("checkall-input").checked){
        $(".check-good").prop("checked",true);
      }
      else{
        $(".check-good").prop("checked",false);
      }
      caltotalCost();
    });

    $(".check-good").click(function(){

      if(!$(this).prop("checked")){
        $("#checkall input").prop("checked",false);
      }
      else{
        var checkboxList=$(".check-good");
        var flag=true;
        for(var i=0;i<checkboxList.length;i++){
          if(!checkboxList[i].checked){
            flag=false;
          }
        }
        if(flag){
          $("#checkall input").prop("checked",true);
        }
        else{
          $("#checkall input").prop("checked",false);
        }
      }
      caltotalCost();
    });

    $('a.sub-goods').on('click',function(){
      var $orderCount=$(this).next("input").val();
      var $orderId=$(this).attr('data-orderId');
      var $phone=$.cookie('username');

      $.post(
        '../../../../Home/ShoppingCart/saveOrderCount',
        {orderCount:$orderCount,orderId:$orderId,phone:$phone},
        function(data){
         console.log(data.status);
       }
       );
    });

    $('a.add-goods').on('click',function(){
      var $orderCount=$(this).prev("input").val();
      var $orderId=$(this).attr('data-orderId');
      var $phone=$.cookie('username');

      $.post(
        '../../../../Home/ShoppingCart/saveOrderCount',
        {orderCount:$orderCount,orderId:$orderId,phone:$phone},
        function(data){
         console.log(data.status);
       }
       );
    });

    $(".buttonright").on('click',function(){
      var arrChk=$("input[name='isChecked']:checkbox");
      var orderIds="";
      $(arrChk).each(function(){
        if($(this).prop('checked')==true){
          var smallOrderId=$(this).parent().parent().attr('data-orderId');
          if(orderIds==""){
            orderIds=smallOrderId;
          }else{
            orderIds=orderIds+","+smallOrderId;
          }
        }                       
      });
      if(orderIds==""){
        alert("选择的商品不能为空");
        return;
      }
      $(this).attr('href',"../../../../Home/Index/comment?orderIds="+orderIds+"&campusId="+$.cookie('campusId'));
    });

    $('a[name="deleteSmallOrder"]').on('click',function(){
      var datarow = $(this).parent().parent();
      var orderId=$(this).parent().parent().attr('data-orderId');
      console.log(datarow);
     
      $.post('../../../../Home/ShoppingCart/deleteOrders',{orderIds:orderId},function(json){
        if(json.status=="success"){
          $(datarow).remove();
          caltotalCost();
          console.log("删除成功!");
        }else{
          console.log("删除失败");
        }
      });
    });

    $(".deletegoods").on('click',function(){
      var arrChk=$("input[name='isChecked']:checkbox");
      console.log(arrChk);
      var orderIds="";
      $(arrChk).each(function(){
        if($(this).prop('checked')==true){
          var smallOrderId=$(this).parent().parent().attr('data-orderId');
          if(orderIds==""){
            orderIds=smallOrderId;
          }else{
            orderIds=orderIds+","+smallOrderId;
          }
        }                       
      });
     
      if (confirm('是否删除？')) {
       $.post('../../../../Home/ShoppingCart/deleteOrders',{orderIds:orderIds},function(json){
        console.log("删除失败");
        if(json.status=="success"){
         

          var trList = $(".order-info-detailed");
          for(var i = 0;i<trList.length;i++){
            if($(trList[i]).children("td").first().children("input").prop("checked")){
              $(trList[i]).remove();
            }
          }
          caltotalCost();
          console.log("删除成功!");
        }else{
          console.log("删除失败");
        }
      });

     };
   });
});

function caltotalCost(){
    var trList = $(".order-info-detailed");
    var totalCost = 0;
    var totalCostBef = 0;
    for(var i = 0;i<trList.length;i++){
      if($(trList[i]).children("td").first().children("input").prop("checked")){
        var pricePer = $(trList[i]).children("td.good-price").children().first().text().substr(1);

        var pricePerBef = $(trList[i]).children("td.good-price").children().last().text().substr(4);

        var countPer = $(trList[i]).children("td").children("input.goods-count").val();
          // alert(countPer);
          var sumPer = parseFloat(pricePer)*parseInt(countPer);
          var sumPerBef = parseFloat(pricePerBef)*parseInt(countPer);
          // alert(sumPer);
          totalCost += sumPer;
          totalCostBef += sumPerBef;
        }
    }
    $(".pricefin").text(totalCost.toFixed(1)+"元");
    $(".orgin-price").text(totalCostBef.toFixed(1)+"元");
}

/*增加和减少商品数量*/
function minus(){
  	var value = document.getElementById("goods-amount1").value;
  	var value1 = parseInt(value);
  	value1 = value1 - 1;
  	document.getElementById("goods-amount1").value=value1;
}

function plus(){
  	var value = document.getElementById("goods-amount1").value;
  	var value1 = parseInt(value);
  	value1 = value1 + 1;
  	document.getElementById("goods-amount1").value=value1;
}


