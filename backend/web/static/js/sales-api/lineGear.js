   var linet={
      'time':'6',
      'role_id':'<?=$role_id?>',
      'LoginName':'<?=$LoginName ?>'
}
 var _date= []
function  NumberDays(xin){
       for (var i = 0 ; i >= -xin+1; i--) {
       _date.push( GetDateStr(i,1))  
       // console.log(GetDateStr(i,1))
       }
       _date.reverse();
    
}
NumberDays(7)
 var myChart2 = echarts.init(document.getElementById('charts2'));
  var myChart5 = echarts.init(document.getElementById('charts5'));
var option5 ;
 var option2;
javaData(_date)
$("#IsTurnOut").change(function () {  
        var ss = $(this).children('option:selected').val();  
        if (ss == "1") {
             
            xin = 1;
            // _date=['0:00','6:00','12:00','16:00','22:00'];
             _date=[]
            NumberDays(xin)
            javaData(_date)
        } else if (ss == "2") {  
              _date=[]
            xin = 2; 
           // date=['0:00','6:00','12:00','16:00','22:00'];
            NumberDays(xin)
           javaData(_date)

        } else if(ss == "3"){
            
            xin = 7;
             _date=[]
            NumberDays(xin)
          javaData(_date)
        } else if(ss == "4"){
            
            xin = 30;
             _date=[]
            NumberDays(xin)
          javaData(_date)
        } else if(ss == "5"){
            
            xin = 90;
             _date=[]
            NumberDays(xin)
          javaData(_date)
        } else if(ss == "6"){
            
            xin = 360;
             _date=[]
            NumberDays(xin)
          javaData(_date)
        }
          else{
            
              xin = 7;
             _date=[]
             NumberDays(xin)
             javaData(_date)
           }
        });  
     function javaData(_date){
    $.post('./?r=sales-api/sales-detail-line', linet,function(json){
                        var json =JSON.parse(json);
                        var user_1=0;//家庭
                        var user_2=0;//办公
                        var user_3=0;//集团
                        var user_4=0;//其他
                        var map=0;

                var sales_to=[];  
   
          for (var i = 0; i<json.length; i++) {
              console.log(json.length)  
             //    // //销量时间 （天）
                    var strjson= json[i].RowTime.split(" ");
                    var strjsondata =parseInt(Date.parse(strjson[0]));
              

                   for (var j = 0 ; j <_date.length; j++) {
                      sales_to.push('0');
                      var _datel_ratio = parseInt(Date.parse(_date[j])) ;
                      // console.log(_datel_ratio);
                         if(_datel_ratio==strjsondata){
                              sales_to[j]++
                          }
                      };
                       if(json[i].CustomerType=='undefined'){
                            json[i].CustomerType==[];
                        }
                        else if(json[i].CustomerType==1){
                            user_1 ++
                           }
                        else  if(json[i].CustomerType==2){
                             user_2 ++
                          }
                        else   if(json[i].CustomerType==3){
                             user_3++
                           }
                       else   if(json[i].CustomerType==99){
                           user_4++
                         }
      
           
                  if(_date.length<3){
                      _date=['0:00','6:00','12:00','16:00','22:00'];
                  }

                  option5 = {
                      title : {
                          text: '用户类型销量比',
                          textStyle:{
                              color:'#fff'
                          },
                          x:'center'
                      },
                      link: 'javascript:f_open(option03)',
                      // tooltip : {
                      //     trigger: 'item',
                      //     formatter: "{a} <br/>{b} : {c} ({d}%)"
                      // },
                      legend: {
                          orient : 'vertical',
                          x : 'right',
                          y : 'bottom',
                          data:['家庭','公司','集团','其他'],
                            textStyle:{
                              color:'#fff'
                          }
                      },
                      toolbox: {
                           show : true,
                           feature : {
                              mark : {show: false},
                              dataView : {show: true, readOnly: false},
                              magicType : {
                                  show: false, 
                                  type: ['pie', 'funnel'],
                                  option: {
                                      funnel: {
                                          x: '25%',
                                          width: '50%',
                                          funnelAlign: 'left',
                                          max: 1548
                                      }
                                  }
                              },
                              restore : {show: true},
                              saveAsImage : {show: true}
                          }
                      },
                      calculable : false,

                      series : [

                          {
                              name:'访问来源',
                              type:'pie',
                            
                              formatter: "{b} : {c} 亿元\n{d}%",
                              radius : '55%',
                              center: ['50%', '60%'],

                              itemStyle : {
                                  normal : {
                                      label : {
                                          show : false
                                      },
                                      labelLine : {
                                          show : false
                                      }
                                  }
                              }

                              ,
                              data:[
                                  {value:user_1, name:'家庭'},
                                  {value:user_2, name:'公司'},
                                  {value:user_3, name:'集团'},
                                  {value:user_4, name:'其他'}
                              ]

                          }
                      ]
                  };


                   myChart5.setOption(option5,true);     


             option2 = {
            tooltip : {
                trigger: 'axis'
            },
            toolbox: {
                show : false,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : false,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                   //data : selloutPackage.x,
                    data:_date,
                    axisLabel:{
                        //X轴刻度配置
                        interval:2//0：表示全部显示不间隔；auto:表示自动根据刻度个数和宽度自动设置间隔个数
                    },
                     axisLabel: {
                            show: true,
                            textStyle: {
                                color: '#fff'
                            }
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                    formatter: '{value} '
                },
                   
                    axisLabel: {
                            show: true,
                            textStyle: {
                                color: '#fff'
                            }
                        }
                }
            ],
            series : [
                {
                    name:'用水量',
                    type:'line',
                   //data:selloutPackage.y,
                    data:sales_to
                }
            ]
         };
       myChart2.setOption(option2, true);
           
    
     };

   })
 }  