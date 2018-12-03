<?php
use yii\widgets\LinkPager;
use feehi\widgets\Bar;
?>
 <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
 <style type="text/css" media="screen">
 	.wrapper-box{
 		width:50%;
       height:600px;
 		background-color:#393E45;
 		float:left;

 	}
 	.table{
 		  border-collapse: collapse; 
 	}
 	.table td{
 		text-align:left;
 	}
 	.tableA td:first-child{
         border-right:1px solid #666;
 	}
 	#sub{
 		display: block;
    width: 150px;
    font-size: 15px;
    margin: auto;
    padding: 11px 20px;
    border-radius: 5px;
    color: #fff;
    background-color: #393e45;
 	}
 	.table>tbody>tr ,#content,.table>tbody>tr:hover{
background-color: transparent; 

}
 </style>
<div class="wrapper wrapper-content">
    <div style="text-align: right;margin-bottom: 10px">
        <!-- <?=\yii\bootstrap\Html::a('返回',['dev-warning/index'],['class'=>'btn btn-primary'])?> -->
              <a class="btn btn-primary" href="index.php?r=dev-warning/index<?=$url?>">返回</a>     
            
        </div>
   <!-- <h1 style="margin-left: 40px;color: red;">预警详情:</h1>-->
  <div class='wrapper-box'>
    	<div id="charts" style="height:400px;width:100%;padding:10px;    margin-top: -10%;"></div>
    	<table class="table tableA table-hover" style=" width:80%;margin: 0 auto;background-color:#393E45;text-align:left;">
    	<tr>
            <td width='100'>用户</td>
            <td><?=$model['Name']?></td>
        </tr>
         <tr>
            <td>手机号</td>
            <td><?=$model['Tel']?></td>
        </tr>
        <tr>
            <td>设备编号</td>
            <td><?=$model['DevNo']?></td>
        </tr>
        <tr>
            <td>设备机型</td>
            <td><?=$model['DevType']?></td>
        </tr>
         <tr>
            <td>设备厂家</td>
            <td><?=$model['DevFactory']?></td>
        </tr>
          <tr>
            <td>最近状态</td>
            <td><?=$model['LastStatus']?></td>
        </tr>
            <tr>
             <td>预警类型</td>
             <td><?=$model['Type']?></td>
        </tr>

        </table>
    </div>

    <div class='wrapper-box' style='background-color:#2D3136;'>
 		 <table class="table  table-hover" style=" width:80%;margin: 0 auto;background-color:#2D3136;text-align:left;    height: 500px;    margin-top: 14px;">
 			 <tr>
                <td width='100' >预警设备详情:</td>
                <td><?=$model['Detail']?></td>
            </tr>
            <tr>
	            <td>处理描述:</td>
	            <td><textarea   rows="4" cols="80" id="content" style='      height: 170px;  width: 100%;'></textarea></td>
	        </tr>
	         <tr>
            <td>是否处理</td>
            <td><input type="radio" name="act" <?= $model['State']==0?'checked':''?> value="0">
        
            	未处理
                <input type="radio" name="act" <?= $model['State']==1?'checked':''?> value="1">已处理
                <input type="radio" name="act" <?= $model['State']==2?'checked':''?> value="2">已解决
            </td>
        </tr>
        </table>
            <div style="text-align: center;margin: 20px auto"><a href="javascript:void(0);" id="sub">确定</a></div>
    </div>





   <!-- <table class="table table-hover" style=" ;margin: 0 auto">
        <tr>
            <td>用户</td>
            <td><?=$model['Name']?></td>
        </tr>
        <tr>
            <td>手机号</td>
            <td><?=$model['Tel']?></td>
        </tr>
        <tr>
            <td>设备编号</td>
            <td><?=$model['DevNo']?></td>
        </tr>
        <tr>
             <td>预警类型</td>
             <td><?=$model['Type']?></td>
        </tr>
        <tr>
            <td>预警级别</td>
            <td id='Level'><?php
                if($model["Level"]==3){echo '<span style="color: red">高<span>';}
                elseif($model["Level"]==2){echo '<span style="color: blue">中<span>';}
                elseif($model["Level"]==1){echo '<span style="color: blueviolet">低<span>';}
                ?>
            </td>	
        </tr>
        <tr>
            <td>预警设备详情</td>
            <td><?=$model['Detail']?></td>
        </tr>
        <tr>
            <td>最近状态</td>
            <td><?=$model['LastStatus']?></td>
        </tr>
        <tr>
            <td>设备机型</td>
            <td><?=$model['DevType']?></td>
        </tr>
        <tr>
            <td>设备厂家</td>
            <td><?=$model['DevFactory']?></td>
        </tr>
        <tr>
            <td>处理描述</td>
            <td><text-alignrea rows="4" cols="80" id="content"></textarea></td>
        </tr>
        <tr>
            <td>是否处理</td>
            <td><input type="radio" name="act" <?= $model['State']==0?'checked':''?> value="0">未处理
                <input type="radio" name="act" <?= $model['State']==1?'checked':''?> value="1">已处理
                <input type="radio" name="act" <?= $model['State']==2?'checked':''?> value="2">已解决
            </td>
        </tr>

    </table>-->


    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script src="/static/js/echarts/echarts.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>

    <script>
 




       $('#sub').click(function() {

            var content=$.trim($('#content').val());

           if(content==''){
               layer.msg('请填写处理描述');

           }else{
                var DevNo=<?=$model['DevNo']?>;
                var Type='<?=$model['Type']?>';
                var BarCode='<?=$model['BarCode']?>';
//               alert(BarCode);
                var State=$("input[name='act']:checked").val();
               $.get('./?r=dev-warning/handle',{'DevNo':DevNo,'Type':Type,'State':State,'content':content,'BarCode':BarCode},function(data){
                   if(data==1){
                         layer.msg('保存成功');
                        window.location.replace("/index.php?r=dev-warning/index");
                    }
                   if(data==-1){
                        layer.msg('该数据不存在');
                       window.location.replace("/index.php?r=dev-warning/index");
                   }
                   if(data==0){
                         layer.msg('失败')
                    }
               });
           }
       });



   var phpdata= <?php  if($model["Level"]==3){echo '90';} elseif($model["Level"]==2){echo '50';}  elseif($model["Level"]==1){echo '10';} ?>;

    var myChart = echarts.init(document.getElementById('charts'));
        var option = {
 
    toolbox: {
        show : false,
        feature : {
            mark : {show: true},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    series : [
        {
            name:'',
            type:'gauge',
            startAngle: 180,
            endAngle: 0,
            center : ['50%', '85%'],    // 默认全局居中
            radius :200,
            axisLine: {      
                  // 坐标轴线
                  show : false,
                lineStyle: {       // 属性lineStyle控制线条样式
                    width: 30,
                          color: [[0.2, '#4ADCDD'], [0.8, '#E46045'], [1, '#E951FF']]
                }
            },
         
            axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
                formatter: function(v){
                    switch (v+''){
                        case '10': return '低';
                        case '50': return '中';
                        case '90': return '高';
                        default: return '';
                    }
                },
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: '#fff',
                    width:5,
                    fontSize: 12,
                   // fontWeight: 'bolder'
                }
            },
            pointer: {
                width:10,
                length: '70%',
                color: 'rgba(255, 255, 255, 0.8)',

            },
            title : {
                show : true,
                offsetCenter: [0, '-60%'],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: '#fff',
                    fontSize: 30,

                }
            },

            data:[{value: phpdata,name: '预警级别'}]
        }
    ]
};
 myChart.setOption(option,true);
//clearInterval(timeTicket);
//timeTicket = setInterval(function (){
 //   option.series[0].data[0].value = (Math.random()*100).toFixed(2) - 0;
 //   myChart.setOption(option,true);
//},2000)
                    


    </script>
 