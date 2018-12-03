 


 new pickerDateRange('date_demo2', {
      // aRecent7Days : 'aRecent7DaysDemo', //最近7天
      isTodayValid: true,
      startDate: '',
      endDate:'',
      //needCompare : true,
      //isSingleDay : true,
      //shortOpr : true,
      //autoSubmit : true,
      defaultText: ' 至 ',
      // format : 'YYYY-MM-DD HH:mm:ss', //控件中from和to 显示的日期格式
      inputTrigger: 'input_trigger_demo',
      theme: 'ta',
      success: function(obj) {
          $("#time1sub2").val(obj.startDate)
          $("#time2sub2").val(obj.endDate)
      $('.dataUlLI .activer').removeClass('activer');  
          if(!obj.endDate){
                 $("#time2sub2").val(GetDateStr(0,1))  
                 obj.endDate= GetDateStr(0,1);
                  $("#date_demo2").html(obj.startDate + '至' + obj.endDate);
            }
      }
    });

$("#date_demo,#date_demo2").text('请选择时间段')
$("#time1sub,#time1sub2").val(GetDateStr(-6,1))
$("#time2sub,#time2sub2").val(GetDateStr(0,1))   








 // 同期

	   	$.get('./index.php?r=dev-statistics/sales-detail', function(data) {
	   		/*optional stuff to do after success */
	   		// console.log(data)
      layer.close(ii)  
	   		if(data){
	   			var data=JSON.parse(data) ;  //返回一个新对象
				 // console.log(data);
              $("#dev_register").text(data.dev_register);
               $("#dev_init").text(data.dev_init);
               $("#dev_growth").text(data.dev_register-data.dev_init);
               $("#dev_total").text(data.dev_total);
              $("#add_today").html(percenttage(data.add_today,data.add_yesterday));
              $("#add_seven_days").html(percenttage(data.add_seven_days,data.add_fourteen_days));
              $("#add_thirty_days").html(percenttage(data.add_thirty_days,data.add_sixty_days));
              $("#init_today").html(percenttage(data.init_today,data.init_yesterday));
              $("#init_seven_days").html(percenttage(data.init_seven_days,data.init_fourteen_days));
              $("#init_thirty_days").html(percenttage(data.init_thirty_days,data.init_sixty_days));
               $("#add_today_today").html(percenttage(data.add_today-data.init_today,data.add_yesterday-data.init_yesterday));
               $("#add_seven_days_days").html(percenttage(data.add_seven_days-data.init_seven_days,data.add_fourteen_days-data.init_fourteen_days));
               $("#add_thirty_days_days").html(percenttage(data.add_thirty_days-data.init_thirty_days,data.add_sixty_days-data.init_sixty_days));
	   		}
	   	});

$("#IsTurnOut").change(function(){
    var  startDate_this = $(this).val();
        if(startDate_this==1){
           $("#time1sub").val(GetDateStr(0,1))
           $("#time2sub").val(GetDateStr(0,1))   
        }else if(startDate_this==2){
           $("#time1sub").val(GetDateStr(-6,1))
           $("#time2sub").val(GetDateStr(0,1))   
        }else if(startDate_this==3){
           $("#time1sub").val(GetDateStr(-29,1))
           $("#time2sub").val(GetDateStr(0,1))   
        }else{
           $("#time1sub").val(GetDateStr(-6,1))
           $("#time2sub").val(GetDateStr(0,1)) 
        }
        $("#date_demo").text('请选择时间段')


salesDetailLine()

})
$("#dev_state").change(function(){
    salesDetailLine()
})


$(document).on('click',".connect",function(){
   var sort_this = Number($(this).attr('date')) ;
   var sort_text = $(this).text() ;
  alert(sort_text)
      sort_this++
      if(sort_this>2){
        sort_this=1
      }
      $(".connect").attr('date',sort_this);


// if(sort_text=='激活时间'){
//   $(".navdata").attr('column','ActiveTime')
// }else if(sort_text=='家庭用户'){

// }

          switch(sort_text)
            {
            case '激活时间':
              $(".navdata").attr('column','ActiveTime')
              break;
            case '家庭用户':
                  $(".navdata").attr('column','family_sales')
              break;
              case '公司用户':
               $(".navdata").attr('column','company_sales')
              break;
               case '集团用户':
              $(".navdata").attr('column','group_sales')
              break;
               case '其他用户':
              $(".navdata").attr('column','other_sales')
              break;
                case '酒店用户':
              $(".navdata").attr('column','hotel_sales')
              break;
                case '总设备数':
              $(".navdata").attr('column','total_sales')
              break;
              default:
          
             };



})
var   dataUlLIactiveNum=1;
$(".dataUlLI li").on('click', function() {
        dataUlLIactiveNum = ($(".dataUlLI li").index(this)) + 1;
// alert(dataUlLIactiveNum)
            if(dataUlLIactiveNum==1){
                 $("#time1sub2").val(GetDateStr(0,1))
                 $("#time2sub2").val(GetDateStr(0,1))


            }else if(dataUlLIactiveNum==2){
                 $("#time1sub2").val(GetDateStr(-1,1))
                 $("#time2sub2").val(GetDateStr(-1,1))
            }else if(dataUlLIactiveNum==3){
                 $("#time1sub2").val(GetDateStr(-6,1))
                 $("#time2sub2").val(GetDateStr(0,1))
            }else if(dataUlLIactiveNum==4){
                 $("#time1sub2").val(GetDateStr(-29,1))
                 $("#time2sub2").val(GetDateStr(0,1))
            }else if(dataUlLIactiveNum==5){
                 $("#time1sub2").val(GetDateStr(-89,1))
                 $("#time2sub2").val(GetDateStr(0,1))
            }
      $('.dataUlLI  .activer').removeClass('activer');
      $(this).addClass('activer');
      $('.dataUlLI li p').css('borderRight', "1px #000 solid");
      $(".dataUlLI li:last-of-type p").css('borderRight', "0px #000 solid");
      $(this).prev().find('p').css('border', "none");
      $(this).find('p').css('border', "none");
      $("#date_demo2").text('请选择时间段')

})

var  activeNum=1;
$(".navdata li").on('click', function() {
   var ii=layer.msg("加载中……");
    activeNum = ($(".navdata ul li").index(this)) + 1;
     $(".navdata .active").removeClass('active');

      // alert(activeNum ) 
    if(activeNum==1){
      $(".navdata").attr('column','ActiveTime')
    }else{
      $(".navdata").attr('column','total_sales')
    }


     $(this).addClass('active')
    var time1subDate=  $("#time1sub2").val();
     var time2subDate=  $("#time2sub2").val();
        var parameter = {
        "state": activeNum,
        "starttime": time1subDate,
        "endtime": time2subDate,
        "offset": 0,
        'limit': 10,
        'sort':'1',
        "search": $("#search").val(),
        'sort':$(".connect").attr('date'),
        'column':$(".navdata").attr('column')
      }
       console.log(parameter)
       rendering(parameter)
       renderingTotal(parameter)
})

$("#removerSub").click(function() {
      // $("#adddate").val('')
     $("#searchp").val('')

        $("#time1sub2").val(GetDateStr(-6,1))
        $("#time2sub2").val( GetDateStr(-0,1))
       $('.dataUlLI .activer').removeClass('activer');  
       $('.dataUlLI li').eq(2).addClass('activer');  
      $("#date_demo2").text('请选择时间段')
})

$("#submit").click(function(){

  // alert($(".connect").attr('date'))
   var obj={

      "state": activeNum,
      starttime:$("#time1sub2").val(),
      endtime:$("#time2sub2").val(),
      search:$("#search").val(),
      "offset": 0,
      'limit': 10,
      'sort':'1',
      sort:$(".connect").attr('date'),
      column:$(".navdata").attr('column')
   }
   console.log(obj)
    rendering(obj)
    renderingTotal(obj);
})

  var obj={
      starttime:$("#time1sub2").val(),
      endtime:$("#time2sub2").val(),
      search:$("#search").val(),
       "offset": 0,
        'limit': 10,
        'sort':'1',
      sort:$(".connect").attr('date'),
      column:'ActiveTime'
   }
rendering(obj);
renderingTotal(obj);

function   renderingTotal(parameter){
      $.ajax
       ({cache: false,
           async: false,
           type: 'post',
           data:parameter,
           url: "./?r=dev-statistics/datas",
           success: function (data) {
                 var objdata = JSON.parse(data);
                 console.log(objdata)
                  total=objdata.total*1;
                   paging({
                          pageNo: 1,
                          totalPage: Math.ceil(total / 10),
                          totalLimit: 10,
                          totalSize: total,
                          callback: function(num, nbsp) {
                                var obj={
                                    starttime:$("#time1sub2").val(),
                                    endtime:$("#time2sub2").val(),
                                    search:$("#search").val(),
                                    sort:$(".connect").attr('date'),
                                    column:$(".navdata").attr('column'),
                                    state:activeNum,
                                    offset: num * nbsp - nbsp,
                                    limit: nbsp
                                 }



                                console.log(obj);


                                rendering(obj)

                          }
                    })
    
           }
       });
};

function   rendering(parameter){
     // console.log(parameter)
       var ii= layer.msg("加载中……");
      $.ajax
       ({
           cache: false,
           async: false,
           type: 'post',
           data:parameter,
           url: "./?r=dev-statistics/datas",
           success: function (data) {

                var objdata = JSON.parse(data);
                 console.log(objdata)
                 total=objdata.total*1;
                  var role_id=0;
                  if(objdata.role_id){
                    role_id=objdata.role_id
                  }
              dev_listdata(objdata.users,role_id,objdata.all_use_type)

               layer.close(ii)  
           }
       });
}
function dev_listdata(data,role_id,use_type) {
var tableTheadOneData   =['序号','用户姓名','联系电话','设备编号','设备商品型号','设备品牌','服务中心','运营中心','地区','购水套餐','用户类型','激活时间'];
var tableTheadTwoData   =['序号','服务中心','联系电话','运营中心','地区','家庭用户','公司用户','集团用户','其它','总设备数'];
var tableTheadThreeData =['序号','运营中心','联系电话','地区','家庭用户','公司用户','集团用户','其它','酒店','总设备数'];
var tableTheadFourData =['序号','设备厂家','联系电话','地区','家庭用户','公司用户','集团用户','其它','酒店','总设备数'];
var tableTheadFiveData =['序号','设备投资商','联系电话','地区','家庭用户','公司用户','集团用户','其它','酒店','总设备数'];
var tableTheadSixData =['序号','酒店中心','联系电话','地区','总设备数'];
var tableTheadSevenData =['序号','片区中心','联系电话','地区','家庭用户','公司用户','集团用户','其它','酒店','总设备数'];
  function custType(Type) {
    // console.log(Type)
  // var CustomerType;
  if (Type == 1) {
    Type= '家庭';
  } else if (Type == 2) {
    Type = '办公';
  } else if (Type == 3) {
    Type= '集团';
  } else if (Type == 4) {
    Type= '酒店';
  } else if (Type == 99) {
    Type = '其他';
  }else{
    Type ==Type
  }
      // console.log(CustomerType)  
   return Type;
}

function use_typeArr(type,use_type){

    var use_typeObj=''
     for(var j=0;j<use_type.length;j++){

      // console.log(use_type[j].code)
        if(type==use_type[j].code){
            use_typeObj=use_type[j].use_type;
            break
        }
     }
return use_typeObj;

}





var tableThead=tableTheadOneData;
if(activeNum==1){
  tableThead=tableTheadOneData;
}else if(activeNum==2){
  tableThead=tableTheadTwoData;
}else  if(activeNum==3){
  tableThead=tableTheadThreeData;
}else  if(activeNum==4){
  tableThead=tableTheadFourData;
}else  if(activeNum==5){
  tableThead=tableTheadFiveData;
}else  if(activeNum==6){
  tableThead=tableTheadSixData;
}else  if(activeNum==7){
  tableThead=tableTheadSevenData;
};
  var html = ' <tr>';
   for(var y=0;y<tableThead.length;y++){
       var head_item = tableThead[y];
       // console.log(head_item)
          if(activeNum==1){
             if(y>=tableThead.length-1){
                 html+='<th ><a href="javascript:void(0)"><p class="connect" date="2">'+head_item+'<p></a></th>';
             }else{
               html+='<th ><p>'+head_item+'<p></th>';
             }
          }else if(activeNum==2){
             if(y>=5){
                 html+='<th ><a href="javascript:void(0)"><p class="connect"  date="2">'+head_item+'<p></a></th>';
             }else{
               html+='<th ><p>'+head_item+'<p></th>';
             }
          }

          else{
            if(y>=4){
                 html+='<th ><a href="javascript:void(0)"><p class="connect"  date="2">'+head_item+'<p></a></th>';
             }else{
               html+='<th ><p>'+head_item+'<p></th>';
             }
          }
   }
    html+='</tr>';
   // console.log(html)
   // if(sort<2){
       $("#table thead").html(html)
   // }


$("#tableBoxData").empty();

       for(var i=0;i<data.length;i++){
         var item = data[i];
         for (var z in item) {
            if (item[z] == null) {
              item[z] = '--'
            }
          }
   var CustomerType = custType(item.CustomerType)  ;
    var bodyHtml = ' <tr>';
        bodyHtml += '<td>'+(i+1)+'</td>';
    if(activeNum==1){
      bodyHtml += '<td>'+item.Name +'</td>';
    }else{
       bodyHtml += '<td><a href="./index.php?r=dev-statistics/index&role_id=' + role_id + '&LoginName=' + item.LoginName + '"><p>'+item.Name +'</p></a></td>';
                   
     }

      bodyHtml += '<td>'+item.Tel +'</td>';

if(activeNum==1){
        bodyHtml += '<td>'+item.DevNo +'</td>';
        bodyHtml += '<td>'+item.GoodsName +'</td>';
        bodyHtml += '<td>'+item.BrandName +'</td>';
        bodyHtml += '<td>'+item.agentFname +'</td>';
        bodyHtml += '<td>'+item.agentYname +'</td>';
        bodyHtml += '<td>'+item.Province +item.City +item.Area +'</td>';
        bodyHtml += '<td>'+use_typeArr(item.UseType,use_type) +'</td>';   
        bodyHtml += '<td>'+CustomerType +'</td>';
        bodyHtml += '<td>'+item.ActiveTime +'</td>';   
}else if(activeNum==2){
        bodyHtml += '<td>'+item.agentYname +'</td>';
        bodyHtml += '<td>'+item.Province +item.City +item.Area +'</td>';
        bodyHtml += '<td>'+item.family_sales +'</td>';
        bodyHtml += '<td>'+item.company_sales +'</td>';
        bodyHtml += '<td>'+item.group_sales +'</td>';   
        bodyHtml += '<td>'+item.other_sales +'</td>';  
        bodyHtml += '<td>'+item.total_sales +'</td>';  
}else if(activeNum==6){
    bodyHtml += '<td>'+item.Province +item.City +item.Area +'</td>';
    bodyHtml += '<td>'+item.total_sales +'</td>';  

}


else {
        bodyHtml += '<td>'+item.Province +item.City +item.Area +'</td>';
        bodyHtml += '<td>'+item.family_sales +'</td>';
        bodyHtml += '<td>'+item.company_sales +'</td>';
        bodyHtml += '<td>'+item.group_sales +'</td>';   
        bodyHtml += '<td>'+item.other_sales +'</td>';  
        bodyHtml += '<td>'+item.hotel_sales +'</td>';  
        bodyHtml += '<td>'+item.total_sales +'</td>';  
}

     
        


        bodyHtml += '</tr>';

        $("#tableBoxData").append(bodyHtml)
       }
  }
$("#dev_state").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
$("#IsTurnOut").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
salesDetailLine()





function salesDetailLine(){
  var obj ={
     starttime:$("#time1sub").val(),
     endtime:$("#time2sub").val(),
     dev_state:$("#dev_state").val(),
  }

// 图标接口
  $.get('./index.php?r=dev-statistics/sales-detail-line',obj, function(data) {
    /*optional stuff to do after success */
       // console.log(data)
         var dataArr = data.line_datas;
           if($("#dev_state").val()==3){
              // 当有注销设备的时候
               if(dataArr.init.length){
                   // dataArr=dataArr.init;
                   dataArr= arrayObjUnique(dataArr.add,dataArr.init)
               }else{
                 dataArr=dataArr.add;
               }
           }
        // console.log(dataArr)
         javaData(dataArr)
   });
}








