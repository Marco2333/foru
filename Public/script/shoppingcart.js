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

  $(".order-info-detailed td:last-child").click(function(){
      $(this).parent(".order-info-detailed").remove();
      caltotalCost();
  });
  $(".deletegoods").click(function(){
      var trList = $(".order-info-detailed");
      for(var i = 0;i<trList.length;i++){
        if($(trList[i]).children("td").first().children("input").prop("checked")){
          $(trList[i]).remove();
        }
      }
      caltotalCost();
  });

/*  背景变色*/
  // $("table").mouseenter(function(){
  //   $(this).css("background-color","#F1F1F1");
  // });
  // $("table").mouseleave(function(){
  //   $(this).css("background-color","white");
  // });
  
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
  $(".pricefin").text(totalCost+"元");
  $(".orgin-price").text(totalCostBef+"元");
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


