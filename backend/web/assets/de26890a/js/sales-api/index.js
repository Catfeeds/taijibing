
 
 // 、、当前时间
function GetDateStr(AddDayCount,AddMonthCount) {
    var dd = new Date();
    dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期
    var y = dd.getFullYear();
    var m = dd.getMonth()+AddMonthCount;//获取当前月份的日期
    var d = dd.getDate();
   if(String(d).length<2){
   	 d="0"+d;
   }
   if(String(m).length<2){
        m="0"+m ;
    }
    return y+"-"+m+"-"+d;
}





//获取当月的天数
function getDays() {
            //构造当前日期对象
            var date = new Date();
            //获取年份
            var year = date.getFullYear();
            //获取当前月份
            var mouth = date.getMonth() + 1;
            //定义当月的天数；
            var days;
            //当月份为二月时，根据闰年还是非闰年判断天数
            if (mouth == 2) {
                days = year % 4 == 0 ? 29 : 28;
            }
            else if (mouth == 1 || mouth == 3 || mouth == 5 || mouth == 7 || mouth == 8 || mouth == 10 || mouth == 12) {
                //月份为：1,3,5,7,8,10,12 时，为大月.则天数为31；
                days = 31;
            }
            else {
                //其他月份，天数为：30.
                days = 30;
 
            }
            return days;
        }


// 今日时间戳
 var nowDate = Date.parse(GetDateStr(1,1))
 // 作日时间戳
 var tomorrowDate = Date.parse(GetDateStr(-1,1))
 // 前日时间戳
 var FrontrowDate = Date.parse(GetDateStr(-2,1))
 // 本周时间戳
 var weekDate = Date.parse(GetDateStr(-7,1))
  // 上周时间戳
 var upperDate = Date.parse(GetDateStr(-14,1))
  // 本月时间戳
 var monthDate = Date.parse(GetDateStr(1,0))
   // 上月时间戳
 var uppermonthDate = Date.parse(GetDateStr(1,-1))
   // 一季度时间戳
 var quarterDate = Date.parse(GetDateStr(1,-3))
    // 上季度时间戳
 var upperquarterDate = Date.parse(GetDateStr(1,-7))

// console.log(GetDateStr(1,-1))

var now = 0,tomorrow=0,week=0,month=0,quarter=0;
if(upperquarterDate<quarterDate<uppermonthDate<monthDate<upperDate<weekDate<FrontrowDate<nowDate){

	var ttt=new Date(FrontrowDate).toLocaleString(); 
	var tttt=new Date(tomorrowDate).toLocaleString(); 
}
var salesVolume=[0,0,0,0,0,0,0,0,0];
// var synchronism=[0,0,0,0,0];
//伪类
function   _hover( Class,ClassText){

	Class.hover(function(){
	    ClassText.css("display","block");
	},function(){
	    ClassText.css("display","none");
	});
}
_hover( $(".volumeHover"),$(".volumeText"))
_hover( $(".compareHover"),$(".compareText"))
_hover( $(".AverageHover"),$(".AverageText"))
// 访问--数据计算

var namrId



if(role_id_texe){
   namrId={

'LoginName':LoginName,
"role_id":role_id_texe
}
}else{

  namrId={

'LoginName':'',
"role_id":''
}

}
    $.post('./?r=sales-api/sales-detail',namrId, function(json){
                if(json != null){
               var json = JSON.parse(json); 
               // console.log(json.user_number)
               // alert(typeof(json))
              for (var i = 0; i<json.datas.length; i++) {
                //销量时间 （天）
              var strs= json.datas[i].RowTime.split(" ");   
          // 判断是否和当前时间对比
                   // 用户销量
                  // 扫码时间戳
                   var str =Date.parse(strs[0]) ;
                  // 今天
                   if(nowDate<=str){
                         salesVolume[0]++
                   }
                   // 昨天一天
                  if(tomorrowDate<=str&&str<nowDate){
                   var tt=new Date(str).toLocaleString().replace(/\//g, "-"); 
  
                       salesVolume[1]++
              // 前天到昨天
                   }else if(FrontrowDate<=str&&str<tomorrowDate){
                       salesVolume[2]++
                   }
                   // 一周到今天  七天前
                   if(weekDate<=str){
                      salesVolume[3]++
                   }
                   // 两周
                   else if(upperDate<=str&&str<weekDate){
                        salesVolume[4]++
                   }
                   // 一月
                   if(monthDate<=str){
                        salesVolume[5]++
                   }

                   // 两月
                   else if(uppermonthDate<=str&&str<monthDate){
                       salesVolume[6]++
                   }
                   // 一季度到今天
                   if(quarterDate<str){
                    salesVolume[7]++
                   }
                   // 上个季度到这个季度
                   else if(upperquarterDate<=str&&str<quarterDate){
                    salesVolume[8]++
                   }
              }
         var sales_volume ={"volume":[

                salesVolume[0], //今天销量
                salesVolume[0]+salesVolume[1],//两天的销量
                salesVolume[3], //一周的销量
                salesVolume[5], //一个月的销量
                salesVolume[7] //一个季度的销量
                  ],
                  "compare":[
                salesVolume[1]/(salesVolume[0])*100,  //今日同期
                salesVolume[2]/(salesVolume[1])*100,  //昨日同期
                salesVolume[4]/(salesVolume[3])*100,  //一周同期
                salesVolume[6]/(salesVolume[5])*100,  //一月同期
                salesVolume[8]/salesVolume[7]*100 //一季度同期
                  ],
                  //均销量
                  "Average":[
                      salesVolume[0]/json.user_number,
                      (salesVolume[0]+salesVolume[1])/json.user_number,
                      salesVolume[3]/json.user_number,
                      salesVolume[5]/json.user_number,
                      salesVolume[7]/json.user_number,
                  ]
                   };
           nnn(sales_volume.volume,$(".consumer td"))    
           
           nnn(sales_volume.Average,$(".equally td"))  
           //渲染同期
           for (var i = 0 ; i<sales_volume.compare.length; i++) {
             if(isNaN(sales_volume.compare[i])){
                  sales_volume.compare[i]=0;
              }
            var sales_volume_num=Math.ceil  (sales_volume.compare[i]*100) 
          
            if(!sales_volume.compare[i]){

              $(".relatively td").eq(i+1).html(sales_volume_num/100+'% &nbsp;<img src="/static/images3/rectangle.png">')

            }else if(sales_volume.compare[i]<0){

              $(".relatively td").eq(i+1).html(sales_volume_num/100+'%&nbsp;<img src="/static/images3/Arrowb.png">')
            }else{
              $(".relatively td").eq(i+1).html(sales_volume_num/100+'%&nbsp;<img src="/static/images3/arrowA.png">')

               }
             }
          }
        

    })










function nnn($data ,$e){
for (var i = 0 ; i<$data.length; i++) {
	 if(isNaN($data[i])){
        $data[i]=0;
    }
  $e.eq(i+1).text(Math.ceil($data[i]))
 }
}
function getresult(num,n){
return num.toString().replace(new RegExp("^(\\-?\\d*\\.?\\d{0,"+n+"})(\\d*)$"),"$1")+0;
}









