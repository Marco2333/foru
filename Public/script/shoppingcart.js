$(document).ready(function(){
    $(".drop-down-left,.drop-down-layer").hover(function(){
      $(".drop-down-layer").show();
    },function(){
      $(".drop-down-layer").hide();  
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
      var v=$(this).next("input").val();
      if(parseInt(v)>1){
        $(this).next("input").val(parseInt(v)-1);
      }    
      caltotalCost();

      var $orderCount=$(this).next("input").val();
      var $orderId=$(this).attr('data-orderId');
      var $phone=$.cookie('username');

      $.post(
        '../../../../Home/ShoppingCart/saveOrderCount',
        {orderCount:$orderCount,orderId:$orderId,phone:$phone},
        function(data){
         
       }
       );
    });

    $('a.add-goods').on('click',function(){

      var v=$(this).prev("input").val();
      $(this).prev("input").val(parseInt(v)+1); 
      caltotalCost();

      var $orderCount=$(this).prev("input").val();
      var $orderId=$(this).attr('data-orderId');
      var $phone=$.cookie('username');

      $.post(
        '../../../../Home/ShoppingCart/saveOrderCount',
        {orderCount:$orderCount,orderId:$orderId,phone:$phone},
        function(data){
        
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
        $('#info').show();
        $('#info').html("选择的商品不能为空");
        setTimeout("$('#info').hide()", 3000 );
        return;
      }
      $(this).attr('href',"../../../../Home/Person/goodsPayment?orderIds="+orderIds+"&campusId="+$campusId);
    });

    $('a[name="deleteSmallOrder"]').on('click',function(){
      var datarow = $(this).parent().parent();
      var orderId=$(this).parent().parent().attr('data-orderId');
      console.log(datarow);
     
      $.post('../../../../Home/ShoppingCart/deleteOrders',{orderIds:orderId},function(json){
        if(json.status=="success"){
          $(datarow).remove();
          caltotalCost();
          $('#info').show();
          $('#info').html("删除成功！");
          setTimeout("$('#info').hide()", 2000 );
        }else{
          $('#info').show();
          $('#info').html("删除失败！");
          setTimeout("$('#info').hide()", 2000 );
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
        if(json.status=="success"){
          var trList = $(".order-info-detailed");
          for(var i = 0;i<trList.length;i++){
            if($(trList[i]).children("td").first().children("input").prop("checked")){
              $(trList[i]).remove();
            }
          }
          caltotalCost();
          $('#info').show();
          $('#info').html("删除成功！");
          setTimeout("$('#info').hide()", 2000 );
        }else{
           $('#info').show();
           $('#info').html("删除失败！");
           setTimeout("$('#info').hide()", 2000 );
        }
      });

     };
   });
});

function caltotalCost(){

    var fulldiscountList = $("#full-discount-price li");
    var discountPrice=new Array();
    for(var i=0;i<fulldiscountList.length;i++) {
      discountPrice[i] = $(fulldiscountList[i]).children("span").text()+","+$(fulldiscountList[i]).children("p").text();
    }

    var trList = $(".order-info-detailed");
    var totalCost = 0;
    var totalCostBef = 0;
    var fullDiscoutCount = 0;

    for(var i = 0;i<trList.length;i++){
      var isFulldiscount = $(trList[i]).attr("data-fulldiscount");

      if($(trList[i]).children("td").first().children("input").prop("checked")){
        var pricePer = $(trList[i]).children("td.good-price").children().first().text().substr(1);

        var pricePerBef = $(trList[i]).children("td.good-price").children().last().text().substr(4);

        var countPer = $(trList[i]).children("td").children("input.goods-count").val();
        var sumPer = parseFloat(pricePer)*parseInt(countPer);
        var sumPerBef = parseFloat(pricePerBef)*parseInt(countPer);

          totalCost += sumPer;
          totalCostBef += sumPerBef;

          if(isFulldiscount == 1) {
            fullDiscoutCount += sumPer;
          }
        }
    }

    var subprice = 0;
    for(var i=0;i<discountPrice.length;i++) {
      if(fullDiscoutCount >= parseFloat(discountPrice[i].split(",")[0])) {
        subprice = parseFloat(discountPrice[i].split(",")[1]);
        break;
      }
    }
    totalCost -= subprice;
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


