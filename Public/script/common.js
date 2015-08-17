$(document).ready(function(){

  $(".drop-down-left,.drop-down-layer").hover(function(){
      $(".drop-down-layer").show();
      $.post(
          '/index.php/Home/ShoppingCart/getCartGood',
          {campusId:$campusId},
          function(json){
               $('.index-shopping-cart ul').empty();
               if(json.length==0) {
                  $(".no-goods").removeClass("none");
                  $(".index-shopping-cart").addClass("none");
                  return;
               }
               else {
                  $(".no-goods").addClass("none");
                  $(".index-shopping-cart").removeClass("none");
               }
               for (var i = 0; i <json.length; i++) {
                  if(i>5)break;
                  var price;
                  if(json[i].is_discount==1){
                      price=new Number(json[i].discount_price).toFixed(1);
                  }else{
                      price=new Number(json[i].price).toFixed(1);
                  }
                  $(".index-shopping-cart ul").append(
                    '<li id="'+json[i].order_id+'"><div class="smallgood"><img src="'+json[i].img_url+'" alt="'+json[i].name+'"><div>'+json[i].name+'</div><span class="goods-cost fl">￥'+price+'×'+json[i].order_count+'</span><span class="fr"><a>删除</a></span></div></li>');
              };
              $(".goods-count").text(json.length);
              //为新添加的删除按钮添加监听
              $(".smallgood span a").on('click',function(){
                // "/Home/ShoppingCart/deleteOrders',array('orderIds'=>$vo['order_id']"
                  
                   var orderId=$(this).parent().parent().parent().attr('id');
                   $.post(
                      '/index.php/Home/ShoppingCart/deleteOrders',{orderIds:orderId},
                      function(data){
                        if(data.status=='success') {
                            $(this).parent().parent().parent().remove();
                        }
                   });
              });
      });
  },function(){
      $(".drop-down-layer").hide();  
  });

  $(".smallgood span a").on('click',function(){   
       var orderId=$(this).parent().parent().parent().attr('id');
       console.log(orderId);
       $.post(
          '/index.php/Home/ShoppingCart/deleteOrders',{orderIds:orderId},
          function(data){
             if(data.status=='success') {
                 $(this).parent().parent().parent().remove();
             }
       });
  });

  $("#search").on('click',function(){
      $search = $("input[name='keyword']").val();
      if($search != ""){
          record = $.cookie("record");

          if(record == null) {
              var record = $search;
              $.cookie("record", record,{ expires: 14 });
          }
          else {     
              var recordList = record.split(",");
              var newrecord = "";
              for(var i=0;i<recordList.length;i++){
                  if(recordList[i] != $search.trim()){
                      newrecord += recordList[i] + ",";
                  }
              }
              newrecord += $search.trim();

              recordList = newrecord.split(",");
              if(recordList.length > 6){                  
                  newrecord = newrecord.substr(newrecord.indexOf(",")+1);
              }
              $.cookie("record", newrecord,{ expires: 14 });    
          } 
      }
      window.location.href="/index.php/Home/Index/goodslist?search="+$search+"&categoryName="+$search;
  });

  $("#header-search input").focus(function(){

      record = $.cookie("record");

      if(record != null){

          var recordList = record.split(",");

          $("#search-record option").remove();
          for(var i = recordList.length-1;i>=0;i--){
              $("<option>").val(recordList[i]).appendTo( $("#search-record"));
          } 
      }
  });

  $("#campus-location li").click(function(){

      var $city=$(this).attr('data-city');
      $.cookie("cityId", $city,{ expires: 14 });

      $.post("/index.php/Home/Index/getCampusByCity?cityId="+$city,
         {cityId:$city},
         function(data){

            var campusList = data.campus;
            $("#campus-content ul").empty();
            var flag = false;
            for(var i=0;i<campusList.length;i++){
                if(campusList[i].campus_id == $.cookie('campusId')){
                    flag = true;
                    $("#campus-content ul").append('<li class="active" data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                }else{
                    $("#campus-content ul").append('<li data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                }
            }
            if(flag == false) {
                $("#campus-content li").first().addClass("active");
            }
            $("#campus-content li").on('click',function(){
                 $(this).siblings().removeClass("active");
                 $(this).addClass("active");
            });          
        });
    });

    $("input[name='keyword']").on('keydown',function(e){
        if(e.keyCode==13){

          $search=$("input[name='keyword']").val();

          if($search != null && $search != ""){
              record = $.cookie("record");
              if(record == null) {
                  var record = $search;
                  $.cookie("record", record,{ expires: 14 });
              }
              else {
                  var recordList = record.split(",");
                  var newrecord = "";
                  for(var i=0;i<recordList.length;i++){
                      if(recordList[i] != $search.trim()){
                          newrecord += recordList[i] + ",";
                      }
                  }
                  newrecord += $search.trim();

                  recordList = newrecord.split(",");
                  if(recordList.length > 6){                  
                      newrecord = newrecord.substr(newrecord.indexOf(",")+1);
                  }
                  // record[record.length] = $search;
                  $.cookie("record", newrecord,{ expires: 14 });  
              } 
              window.location.href="/index.php/Home/Index/goodslist?search="+$search+"&categoryName="+$search;
          }
        }
    });

    $("#location").bind("click",function(){

        $("#campus-background").show(300);

        var $city = $("#campus-location li.active").attr('data-city');
        
        $.cookie("cityId", $city,{ expires: 14 });

        $.post("/index.php/Home/Index/getCampusByCity?cityId="+$city,
          {cityId:$city},
          function(data){

              var campusList = data.campus;
              $("#campus-content ul").empty();
              var flag = false;
              for(var i=0;i<campusList.length;i++){
                  if(campusList[i].campus_id == $.cookie('campusId')){
                      flag = true;
                      $("#campus-content ul").append('<li class="active" data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                  }else{
                      $("#campus-content ul").append('<li data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                  }
              }
              if(flag == false) {
                  $("#campus-content li").first().addClass("active");
              }
                 
              $("#campus-content li").on('click',function(){
                   $(this).siblings().removeClass("active");
                   $(this).addClass("active"); 
              }); 
         });         
    });

    $("#campus-main li").click(function(){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
    });

    $("#campus-close").bind("click",function(){
        var campus_id = $("#campus-content li.active").attr("data-campusId");
        console.log(campus_id);
        console.log($.cookie("campusId"));
        if($.cookie("campusId") != campus_id){
            $.cookie("campusId", campus_id,{ expires: 14});

            if(campus_id != null) {
               $.post(                                                     //改变session里面的campusId
                  '/index.php/Home/index/changeCampus',
                  {campusId:campus_id},
                  function(data){
                     window.location.href="/index.php/Home/Index/index";
                  }
                );
                 $("#location").text($("#campus-content li.active").text());
            }
        }
        $("#campus-background").hide(300);    
    });

    $('#campus-search').bind('input propertychange', function() {

        var searchValue = $("#campus-search").val();
        var re=/[^\u4e00-\u9fa5]/;
        if(re.test(searchValue)){
          return;
        }
        $("#campus-location li").removeClass("active");

        $.ajax({
            type:"POST",
            url:"/index.php/Home/Index/searchCampus",
            data:{
              name:searchValue
            },
            success:function(data){
                if(data.status=='failure') {
                    return;
                }
                else {
                   $("#campus-content ul").empty();
                  var campusList = data.campus;
                  for(var i=0;i<campusList.length;i++){
                      $("#campus-content ul").append('<li data-campusId="'+campusList[i].campus_id+'">'+campusList[i].campus_name+'</li>');
                  }

                  $("#campus-content li").click(function(){
                      $(this).siblings().removeClass("active");
                      $(this).addClass("active");
                  });
               }  
            }
        });
    }); 
  
});

String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, '');
}
