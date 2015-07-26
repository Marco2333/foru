$(document).ready(function(){
 
 $(" a.sub-goods").click(function(){
      var v=$(this).next("input").val();
      if(parseInt(v)!=0){
          $(this).next("input").val(parseInt(v)-1);
      }    
      caltotalCost();
  });

  $(" a.add-goods").click(function(){
      var v=$(this).prev("input").val();
      $(this).prev("input").val(parseInt(v)+1); 
      caltotalCost();
  });
  
});

function mOver(obj)
{
  	var d1=document.getElementById("add-content")/*.className="add-content left-eva"*/;
  	d1.style.display="block";
}

function mOut(obj)
{
  	var d1=document.getElementById("add-content")/*.className="add-content left-eva none"*/;
  	d1.style.display="none";
}

function imgonover(obj){
  	obj.style.border="solid 1px #EEEEEE";
  	var url = $(this).attr("src");
  	alert(url);
  	document.getElementById("change-img-but").src=	"/foryou/PUBLIC/"+url.substring(11);
}
function imgonout(obj){
	  obj.style.border="none";
}


function imgbig(){
    var $url = $(this).attr("src");
    $(".goods-info-img-big").attr("src","__PUBLIC__/img/food3.png");
}
