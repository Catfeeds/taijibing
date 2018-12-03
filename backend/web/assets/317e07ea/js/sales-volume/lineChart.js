 // 折线图

  function FoldLineDiagram(darax,daray){
  var myChart = echarts.init(document.getElementById('main')); 
           var option = {
                   title: {
                       text: "",
                       x: "center",
                               textStyle: {
                   color: '#fff',
                   x: '100px',
           },
                   },
                   tooltip: {
           trigger: 'axis'
         },

                   xAxis: [
                       {
                           type: "category",
                           axisLabel: {
                     //X轴刻度配置
                   interval: 2 //0：表示全部显示不间隔；auto:表示自动根据刻度个数和宽度自动设置间隔个数
                 },

                           splitLine: {show: false},
                           data: darax,
                 axisLabel: {
                   show: true,
                   textStyle: {
                     color: '#fff'
                   }
           }
                       }
                   ],
    
                      yAxis: [{
                 type: 'value',
                 axisLabel: {
                   show: true,
                   textStyle: {
                     color: '#fff'
                   }
                 }
               }],
                    toolbox: {
                       show: true,
                       feature: {
                           mark: {
                               show: false
                           },
                           dataView: {
                               show: false,
                               readOnly: false,
                              

                           },
                           restore: {
                               show: false
                           },
                           saveAsImage: {
                               show: false
                           }
                       },

                   },
                   calculable: true,
         series: [{
           name: '销量',
           type: 'line',
           //data:selloutPackage.y,
           data: daray
         }]
                };
                // 为echarts对象加载数据 
                myChart.setOption(option); 

  } 


function PieChart($name,$data){
    var myChart = echarts.init(document.getElementById('echarts3')); 

               var option = {
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient : 'vertical',
                        x : 'left',
                        data:['家庭','集团','公司','其他'],
                        textStyle: {
             color: '#fff'
           }
                    },
                    toolbox: {
                        show : true,
                        feature : {
                            mark : {show: false},
                            dataView : {
                                show: true, 
                                readOnly: false,
                                      optionToContent: function(opt) {
                                console.log(opt)
                                // var axisData = opt.xAxis[0].data;

                                // console.log(axisData)
                                  var series = opt.series;


                                 console.log(series[0].data.length)
                                 var table = '<table style="width:100%;text-align:center;border:1px #000 solid"><tbody><tr>'
                                 //             + '<td>' + series[0].name + '</td>'
                                             + '<th  colspan="2">' + series[0].name + '</th>'
                                             + '</tr>'
                                             +'<tr>'
                                             + '<td>key值</td>'
                                             + '<td>value值</td>'
                                             + '</tr>';
                                for (var i = 0, l = series[0].data.length; i < l; i++) {
                                    table += '<tr>'
                                             + '<td>' + series[0].data[i].name + '</td>'
                                             + '<td>' + series[0].data[i].value + '</td>'
                                             + '</tr>';
                                }
                                table += '</tbody></table>';
                                return table;
                            }

                            },
                            magicType : {
                                show: false, 
                                type: ['pie', 'funnel'],
                                option: {
                                    funnel: {
                                        x: '25%',
                                        width: '50%',
                                        funnelAlign: 'center',
                                        max: 1548
                                    }
                                }
                            },
                            restore : {show: true, title:"刷新",  },
                            saveAsImage : {show: false}
                        }
                    },
                    calculable : true,
                    series : [
                        {
                            name:'销量类型',
                            type:'pie',
                            radius : ['50%', '70%'],
                            itemStyle : {
                                normal : {
                                    label : {
                                        show : false
                                    },
                                    labelLine : {
                                        show : false
                                    }
                                },
                                emphasis : {
                                    label : {
                                        show : false,
                                        position : 'center',
                                        textStyle : {
                                            fontSize : '30',
                                            fontWeight : 'bold'
                                        }
                                    }
                                }
                            },
                            data:[
                                {value:$data[0], name:'家庭'},
                                {value:$data[1], name:'集团'},
                                {value:$data[2], name:'公司'},
                                {value:$data[3], name:'其他'}
                      
                            ]
                        }
                    ]
                  };
                // 为echarts对象加载数据 
                myChart.setOption(option); 
}