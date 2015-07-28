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

  // $(".order-info-detailed td:last-child").click(function(){
   
  // });
 

  /*  背景变色*/
  // $("table").mouseenter(function(){
  //   $(this).css("background-color","#F1F1F1");
  // });
  // $("table").mouseleave(function(){
  //   $(this).css("background-color","white");
  // });
$('a.sub-goods').on('click',function(){
  var $orderCount=$('input.goods-count').val();
  var $orderId=$('a.sub-goods').attr('data-orderId');
  var $phone=$.cookie('username');

  $.post(
    '../../Home/ShoppingCart/saveOrderCount',
    {orderCount:$orderCount,orderId:$orderId,phone:$phone},
    function(data){
     console.log(data.status);
   }
   );
});
$('a.add-goods').on('click',function(){
  var $orderCount=$('input.goods-count').val();
  var $orderId=$('a.add-goods').attr('data-orderId');
  var $phone=$.cookie('username');

  $.post(
    '../../Home/ShoppingCart/saveOrderCount',
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
  $(this).attr('href',"../../../Home/Person/goodsPayment/orderIds/"+orderIds);
});

$('a[name="deleteSmallOrder"]').on('click',function(){
  var orderId=$(this).parent().parent().attr('data-orderId');

  $.post('../ShoppingCart/deleteOrders',{orderIds:orderId},function(json){
    if(json.status=="success"){
      $(this).parent(".order-info-detailed").remove();
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
        alert($(this).prop('checked'));
        if($(this).prop('checked')==true){
          var smallOrderId=$(this).parent().parent().attr('data-orderId');
          
           console.log(smallOrderId);
          if(orderIds==""){
            orderIds=smallOrderId;
          }else{
            orderIds=orderIds+","+smallOrderId;
          }
        }                       
      });
      //console.log(orderIds);
      if (confirm('是否删除？')) {
       $.post('../ShoppingCart/deleteOrders',{orderIds:orderIds},function(json){
        alert(json);
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
  // alert("dd");
  var trList = $(".order-info-detailed");
  // console.log(trList);
  var totalCost = 0;
  var totalCostBef = 0;
  for(var i = 0;i<trList.length;i++){
    // console.log($(trList[i]).children("td").first().children("input").prop("checked"));
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
    // console.log($(trList[i]).children("td.good-price").children().first().text());

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




/*全选*/
// function checka(b)
// {
//     var input = document.getElementsByTagName("input");

//     for (var i=0;i<input.length ;i++ )
//     {
//         if(input[i].type=="checkbox")
//             input[i].checked = b;
//     }
// }




