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


alert(1)

       var _url;
          if(role_id_texe){
            _url = './?r=sales-api/datas'

            }else{
              _url = './?r=sales-api/get-user'
            }
            var parameter={
             'startime':GetDateStr(1,0),
             'endtime':GetDateStr(1,1)

            }

        // 数组去空
         Array.prototype.notempty = function(){
                 return this.filter(t => t!=undefined && t!==null);
              }

           // 数组去重

          Array.prototype.unique = function(){
             var res = [];
             var json = {};
          
             for(var p = 0;p< this.length; p++){
              if(!json[this[p]]){
               res.push(this[p]);
               json[this[p]] = 1;
              }
              else{ 
              }
             }
              return res;
            }
        $.post('./?r=sales-api/datas',  parameter,function(data){
             
             if(data){
                var data = JSON.parse(data);
                var _dataLength=data.length;
                var _mapDataA=[]//定义一个人地图省级数组 名字
                var _mapDatab=[]//定义一个人地图市级数组 名字
              
                for(var i=0;i<data.length;i++){
                  _mapDataA.push(data[i].Province)
                  _mapDatab.push(data[i].City)
                 }
                //+'返回json'
               
                var _mapDataAnum=[]//定义一个人地图市级数组 个数
                var _mapDatabnum=[]//定义一个人地图市级数组 个数
              _mapDataA=_mapDataA.notempty().unique();
              _mapDatab=_mapDatab.notempty().unique();
                for(var i=0;i<_mapDataA.length;i++){
                       _mapDataAnum.push(0)
                     for(var j=0;j<_dataLength;j++){
                        if(_mapDataA[i]==data[j].Province){
                            _mapDataAnum[i]++
                        // console.log(data[i].Province)
                        }
                     }
                var scaling=_mapDataAnum[i]/_dataLength*100;
                var Percentage_html ='<div class="container-fluid">'+
                '<div class="row" style="text-align: content">'+
                '<div class="col-sm-2 col-xs-2">'+_mapDataA[i]+'</div>'+
                '<div class="col-sm-6 col-xs-6">'+
                ' <div class="progress">'+
                ' <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:'+scaling+'%;">'+
                ' </div>'+
                ' </div>'+
                '</div>'+
                ' <div class="col-sm-2 col-xs-2">'+scaling+'%</div>'+
                ' </div>'+
                ' </div>'
                $("#Percentage").append(Percentage_html)
                }
              
               for(var i=0;i<_mapDatab.length;i++){
                       _mapDatabnum.push(0)
                     for(var j=0;j<_dataLength;j++){
                        if(_mapDatab[i]==data[j].City){
                            _mapDatabnum[i]++
                        // console.log(data[i].Province)
                        }
                     }
                }
                
             }
           
        require.config({
            paths: {
                echarts: 'http://echarts.baidu.com/build/dist'
            }
        });
        // 使用
        require(
            [
                'echarts',
                'echarts/chart/map' // 使用柱状图就加载bar模块，按需加载
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('charts')); 
                
               var ecConfig = require('echarts/config');
                    var zrEvent = require('zrender/tool/event');
                    var curIndx = 0;
                    var mapType = [
                        'china',
                        // 23个省
                        '广东', '青海', '四川', '海南', '陕西', 
                        '甘肃', '云南', '湖南', '湖北', '黑龙江',
                        '贵州', '山东', '江西', '河南', '河北',
                        '山西', '安徽', '福建', '浙江', '江苏', 
                        '吉林', '辽宁', '台湾',
                        // 5个自治区
                        '新疆', '广西', '宁夏', '内蒙古', '西藏', 
                        // 4个直辖市
                        '北京', '天津', '上海', '重庆',
                        // 2个特别行政区
                        '香港', '澳门'
                    ];
                    document.getElementById('charts').onmousewheel = function (e){
                       return false
                    };
                      myChart.on(ecConfig.EVENT.MAP_SELECTED, function (param){
                        var len = mapType.length;
                        var mt = mapType[curIndx % len];
                        if (mt == 'china') {
                            // 全国选择时指定到选中的省份
                            var selected = param.selected;
                            for (var i in selected) {
                                if (selected[i]) {
                                    mt = i;
                                    while (len--) {
                                        if (mapType[len] == mt) {
                                            curIndx = len;
                                        }
                                    }
                                   break;
                                }
                            };
                          option.tooltip.formatter = function(data){
                          if(_mapDatab){

                               for(var i=0;i<_mapDatab.length;i++){
                                     while (_mapDatab[i]==data[1]){
                                     return '设备分布情况：<br/>'+data[1]+'分布'+_mapDatabnum[i]+'台 <br/>本市占比'+(_mapDatabnum[i]/_dataLength)*100+'%;'    
                                   }
                              }return  '本地区还没有开放';
                           }
                         };
                        }
                        else {
                            curIndx = 0;
                            mt = 'china';
                            // option.tooltip.formatter = '设备分布情况：<br/>{b}分布888台<br/>全国占比50%';
                             option.tooltip.formatter = function(data){
                          if(_mapDataA){
                               for(var i=0;i< _mapDataA.length;i++){
                               
                                     while (_mapDataA[i]==data[1]+'省'){
                                     return '设备分布情况：<br/>'+data[1]+'分布'+_mapDataAnum[i]+'台 <br/>全国占比'+(_mapDataAnum[i]/_dataLength)*100+'%;'    
                                   }
                              }return  '本地区还没有开放';
                           }
                         };
                        }
                        option.series[0].mapType = mt;
                        // option.title.subtext = mt + ' （滚轮或点击切换）';
                        myChart.setOption(option, true);
                    });
                    option = {
                        title: {
                            text : '全国设备分布情况',
                            textStyle:{
                                color:'#fff'
                            },
                            // subtext : 'china （滚轮或点击切换）'
                        },
                        tooltip : {
                            trigger: 'item',
                            // formatter: '设备分布情况：<br/>{b}分布888台<br/>全国占比50%'
                              formatter: function(data){
                          if(_mapDataA){

                               for(var i=0;i< _mapDataA.length;i++){
                               
                                     while (_mapDataA[i]==data[1]+'省'){
                                         
                                     return '设备分布情况：<br/>'+data[1]+'分布'+_mapDataAnum[i]+'台 <br/>全国占比'+(_mapDataAnum[i]/_dataLength)*100+'%;'    
                                   }
                              }return  '本地区还没有开放';
                           }
                         }
                        },
                        legend: {
                            orient: 'vertical',
                            x:'right',
                            data:['']
                        },
                        dataRange: {
                            min: 0,
                            max: 1000,
                            color:['orange','yellow'],
                            text:['高','低'],           // 文本，默认为数值文本
                            calculable : true
                        },
                        series : [
                            {
                                name: '分布情况',
                                type: 'map',
                                mapType: 'china',
                                selectedMode : 'single',
                                itemStyle:{
                                    normal:{label:{show:true}},
                                    emphasis:{label:{show:true}}
                                },
                                data:[

                                    {name: '定安县',value: Math.round(Math.random()*1000)},
                                    {name: '保亭黎族苗族自治县',value: Math.round(Math.random()*1000)},
                                    {name: '五指山市',value: Math.round(Math.random()*1000)}
                                ]
                            }
                        ]
                    };
             // 为echarts对象加载数据 
                myChart.setOption(option); 
            })
      })