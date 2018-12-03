<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 14:17
 */
?>
 <link rel="stylesheet" href="./static/css/bootstrap.min.css">
 <link rel="stylesheet" href="./static/css/site/main.css">
     <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="/static/css/Common.css?v=1.1"/>
 <style type="text/css">
   
   body{
    background:url(./static/images3/bgcolor.png) no-repeat fixed center; 
    background-size: 100% 100%;
    padding:2px;
    padding:0.125rem;
  }
  .chosen-container .chosen-drop {
    position: absolute;
    top: 100%;
    z-index: 1010;
    width: initial;
    min-width: 100%;
    border: 1px solid #131315;
    border-top: 0;
    background: #1c1e22;
    -webkit-box-shadow: 1 4px 5px rgba(0, 0, 0, 0.15);
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.15);
    color: #bababf;
    display: none;
}
.chosen-container .chosen-results li.no-results {
    color: #fff;
    display: list-item;
     background-color: #1c1e22;
}
 </style>

<div id='bodybox' style='width:100%;height:100%;      min-width: 1100px;'>
  

<div class='model' style='width:25%;min-width: 260px;'> 
  <div class='wdc_top transparency'>
  	  <div class="wdc_item" style='	border-bottom:1px solid #080808;'> 
  	     <div class="wdc_left" style='  padding:15px;padding-right:0px'>
<div style='width:10px;height:10px;background-color: #C74429;display: inline-block;border-radius: 2px; '> </div> 
  	     	 <p class='wdc_itemTxt'>今日数据
             <!-- <span style='font-size: 12px;'> 单位：<span style='color:#C74429'>袋</span> </span> -->
              </p>
             <div class='wdc_item_num'>
             	<p class='wdc_itemTbo'>用户数量:</p>
  	     	    	<p style='font-size:18px;color: #c74429;    margin-top: 12px;'   ><span id='wdcNUM'> 0</span></p>
             </div>
		</div>  	  	   
  	    <div class='wdc_right ' id='todayInfo'>
          <div class="tableText">
            <table style=' width: 90%;height: 100%;'>
              <tbody>
                <tr>
                  <td>运营中心：</td>
                  <td><span id='operateNum' style='color: #FEC751'>0</span> <div class='divNum'>家</div></td>
                </tr>
                <tr>
                  <td>水&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;厂：</td>
                  <td><span id='waterworksNum' style='color: #AE43CD'>0</span><div class='divNum'>家</div></td>
                </tr>
                <tr>
                  <td>服务中心：</td>
                  <td><span id='serviceNum' style='color: #EE5030'>0</span><div class='divNum'>家</div></td>
                </tr>
                <tr>
                  <td>设备厂家：</td>
                  <td><span id='equipmentNum' style='color: #3EE3E5'>0</span><div class='divNum'>家</div></td>
                </tr>
              </tbody>
            </table>
          </div>
  	    	 
  	    </div>
  	  </div>
  	  <div class="wdc_item">
        <div class="wdc_left" style=' padding:15px;padding-right:0px'>
              <div style='width:10px;height:10px;background-color: #3EE3E5;display: inline-block;border-radius: 2px; '> </div> 
  	     	 <p class='wdc_itemTxt'>实时数据 
            <!-- <span style='font-size: 12px;'> 单位：<span style='color:#C74429'>L</span> </span> -->
             </p>
             <div class='wdc_item_num'>
             	<p class='wdc_itemTbo'>今日销售额:</p>
  	     	 	<p style='font-size:18px;color: #47D2D3;    margin-top: 12px;'><span id='todayRmb'> 0</span>元</p>
             </div>
		   </div> 
		     <div class='wdc_right '>
            <div class="tableText">
  	    	 <table  style=' width: 90%;height: 100%;'>
            	<tbody>
            		<tr>
            			<td>今日销售量：</td>
            			<td><span id='todayVbepRmb' style='color: #FEC751'> 0</span><div class='divNum'>袋</div></td>
            		</tr>
            		<tr>
            			<td>今日用水量：</td>
            			<td><span id='todaWwaterRmb' style='color: #AE43CD'> 0</span><div class='divNum'>(L)</div</td>
            		</tr>
            		<tr>
            			<td>近30天销量：</td>
            			<td><span id='januaryVbepRmb' style='color: #EE5030'> 0</span><div class='divNum'>袋</div></td>
            		</tr>
            		<tr>
            			<td>近30天用水量：</td>
            			<td><span id='waterJanuaryRmb' style='color: #3EE3E5'> 0</span><div class='divNum'>(L)</div></td>
            		</tr>
            	</tbody>
            </table>
        </div>
  	    </div>
  	  </div>
  </div>
  <div class='ranking transparency'>
  	<!-- 服务中心销量排名 -->
	  <div class="wdc_item" style='	    padding: 10px;border-bottom:1px solid #080808;'> 
           <p style="position: relative; color: rgb(233,233,233);    margin-left: 10px; " class='wdc_itemTxt '><span class="hot"></span>服务中心销量排名（本月前五）</p>
            <div class=""   id='rankingsService' style='    padding: 20px 0;height: 100%;'>
          <div class="ranking-Percentage" style="position:relative;">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'+item_num/obj.total_sales+'" aria-valuemin="0" aria-valuemax="100" 
                style="width: 0%">
                 <span class="sr-only">0</span>
                 </div>
             </div><p class="rankingNum">0袋</p>
              <p style="margin-top: -25px;">太极兵服务中心</p> 
          </div>
          <div class="ranking-Percentage" style="position:relative">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'+item_num/obj.total_sales+'" aria-valuemin="0" aria-valuemax="100" 
                style="width: 0%">
                 <span class="sr-only">0</span>
                 </div>
             </div><p class="rankingNum">0袋</p>
          </div>
            <p style="margin-top: -25px;">太极兵服务中心</p>
          <div class="ranking-Percentage" style="position:relative">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'+item_num/obj.total_sales+'" aria-valuemin="0" aria-valuemax="100" 
                style="width: 0%">
                 <span class="sr-only">0</span>
                 </div>
             </div><p class="rankingNum">0袋</p>
          </div>
            <p style="margin-top: -25px;">太极兵服务中心</p>
          <div class="ranking-Percentage" style="position:relative">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'+item_num/obj.total_sales+'" aria-valuemin="0" aria-valuemax="100" 
                style="width: 0%">
                 <span class="sr-only">0</span>
                 </div>
             </div><p class="rankingNum">0袋</p>
          </div>
            <p style="margin-top: -25px;">太极兵服务中心</p>
          <div class="ranking-Percentage" style="position:relative">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'+item_num/obj.total_sales+'" aria-valuemin="0" aria-valuemax="100" 
                style="width: 0%">
                 <span class="sr-only">0</span>
                 </div>
             </div><p class="rankingNum">0袋</p>
          </div>
            <p style="margin-top: -25px;">太极兵服务中心</p>


            </div>


	  	
	  </div>
	  <!-- 运营中心销量排名 -->
	  <div class="wdc_item" style='padding: 10px 0;'> 
	  	 <p style="position: relative; color: rgb(233,233,233);  ;margin-left: 20px;"><span class="hot"></span>运营中心销量排名（本月前五）</p><br/	>
	  	  <div class='operate-ranking'   id='rankingsOperate' >
	           <div class="operate-item">
                  <p class="item-title" style="    padding-bottom: 10px;">0袋</p>
                   <div class="Middle-line">
                       <div class="operate-img" >
                            <img id="scream" src="/static/images3/Smallbell.png" class="Smallbell"  alt="The Scream" width="5">
                           <img src="/static/images3/Arrow.png" class="Arrow" alt="">
                       </div>
                    </div>
                  <p class="item-name">运营中心</p>
             </div>
             <div class="operate-item">
                  <p class="item-title" style="    padding-bottom: 10px;">0袋</p>
                   <div class="Middle-line">
                       <div class="operate-img" >
                            <img id="scream" src="/static/images3/Smallbell.png" class="Smallbell"  alt="The Scream" width="5">
                           <img src="/static/images3/Arrow.png" class="Arrow" alt="">
                       </div>
                    </div>
                  <p class="item-name">运营中心</p>
             </div>
             <div class="operate-item">
                  <p class="item-title" style="    padding-bottom: 10px;">0袋</p>
                   <div class="Middle-line">
                       <div class="operate-img" >
                            <img id="scream" src="/static/images3/Smallbell.png" class="Smallbell"  alt="The Scream" width="5">
                           <img src="/static/images3/Arrow.png" class="Arrow" alt="">
                       </div>
                    </div>
                  <p class="item-name">运营中心</p>
             </div>
             <div class="operate-item">
                  <p class="item-title" style="    padding-bottom: 10px;">0袋</p>
                   <div class="Middle-line">
                       <div class="operate-img" >
                            <img id="scream" src="/static/images3/Smallbell.png" class="Smallbell"  alt="The Scream" width="5">
                           <img src="/static/images3/Arrow.png" class="Arrow" alt="">
                       </div>
                    </div>
                  <p class="item-name">运营中心</p>
             </div>
             <div class="operate-item">
                  <p class="item-title" style="    padding-bottom: 10px;">0袋</p>
                   <div class="Middle-line">
                       <div class="operate-img" >
                            <img id="scream" src="/static/images3/Smallbell.png" class="Smallbell"  alt="The Scream" width="5">
                           <img src="/static/images3/Arrow.png" class="Arrow" alt="">
                       </div>
                    </div>
                  <p class="item-name">运营中心</p>
             </div>

  
	  	  </div>


	  </div>
 </div>
</div>
<!-- 太极兵全国地图 -->
<div class='model transparency' style='width:calc(50% - 3px);   width: -webkit-calc(50% - 3px);width: -moz-calc(50% - 3px);  margin-left:3px;padding:10px;border-radius:3px'>
	 <header class="" style='height:80px'>
	 	   <p class='htitle'>太极兵<span class="region">全国</span>运营中心</p>
	 	   <div class='hbody' id='provinceMap'>
         <span style='  display: block;  float: left; font-size: 15px;font-size: 1.5rem; line-height: 40px;padding-right: 10px;'><span class="region">全国</span>情况</span>
	 	   	<select  id='province' style='min-width: 60px;    padding: 5px;'>
             <option value="" selected>全国</option>
        </select>
        <!-- 	<div class="btn-group">
  				  <button  type="button"  class="btn btn-danger dropdown-toggle btnbottom" data-toggle="dropdown" aria-haspopup="true" style=' background: #c74429;color: #CEBBBC;  padding: 2px 10px;' aria-expanded="false">
  				    请选择 <span class="caret"></span>
  				  </button>
  				   <ul class="dropdown-menu" style="max-height: 250px;overflow: auto;">
  				  	
  				  </ul>
				</div> -->
		  	<span style='font-size: 12px;  font-size: 1.2rem;  line-height: 36px; padding-right:0 20px;'>&nbsp;<span id='current_time'></span></span>

        <div class="pull-right" style='    margin-right: 20px;'>
            <a href="/index.php?r=dev-manager/map&type=1"   id="normal-mode"> <img src="/static/images3/mapImg.png" alt=""><span style="color:rgb(233,233,233)">&nbsp;地图模式</span></a>  

        </div>
	 	   </div>
	 </header>
  <!-- 全国地图-->
	<div id="main" style="	height:calc(100% - 150px);  height: -webkit-calc(100% - 150px);height: -moz-calc(100% - 150px);"></div>
  	<div class='equipment-state'>
  		 <div class='equipment'>
  		 	<p style='background-color:rgba(0,139,248,0.6); ;'>已登记设备<br/> <span id='equipmentOne'>0</span>台	</p>
  		 	
  		 </div>
  		 <div class='equipment'>
  		 		<p style='background-color:rgba(221,31,255,0.6); '>正常设备<br/><span id='equipmentTwo'>0</span>台	</p>
  		 </div>
  		 <div class='equipment'>
  		 		<p style='background-color:rgba(255,230,0,0.6); '>预警设备<br/><span id='equipmentThree'>0</span>台	</p>
  		 </div>

  	</div>
</div>
<div class='model ' style='width: calc(25% - 3px); width: -webkit-calc(25% - 3px);width: -moz-calc(25% - 3px) ;margin-left:3px;'>
   <div	class='consumer transparency'>
  		 <div class='wdc_item' style='    border-bottom: 1px solid #080808;  padding: 10px 0;'>
  		      <div	class='consumer-head'>
  		      	   <p class= 'pull-left' style='color:rgb(233,233,233);font-size: 1.2rem; '><span class='hot'></span>  用户类型</p>
  		      	   <div	class='pull-right' style='font-size: 12px; font-size: 1.2rem; '>

  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#3EE3E5'></span> 	家庭</p>
  		      	    <p class= 'pull-left'><span class='hot' style='background-color:#FEC751'></span> 	单位</p>
  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#AE43CD'></span> 	集团</p>
                   <p class= 'pull-left'><span class='hot' style='background-color:#21f507'></span>   酒店</p>
  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#EE5030'></span> 	其他</p>
  		      	   </div>
  		    
  		      </div>
              <div id="echarts" style="height:80%; " ></div>
  		</div>
  		 <div class='wdc_item' style=' padding: 10px 0;' >
  		 	<div	class='consumer-head' style='position: absolute;    width: 100%' >
  		      	   <p class= 'pull-left' style=';color:rgb(233,233,233);font-size: 1.2rem; '><span class='hot'></span> 用户类型销量占比</p>
  		      	   <div	class='pull-right' style='font-size: 12px;  font-size: 1.2rem;margin-right:10px; '>

  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#3EE3E5'></span> 	家庭</p>
  		      	    <p class= 'pull-left'><span class='hot' style='background-color:#FEC751'></span> 	单位</p>
                 <p class= 'pull-left'><span class='hot' style='background-color:#AE43CD'></span>   集团</p>
  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#21f507'></span> 	酒店</p>
  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#EE5030'></span> 	其他</p>
  		      	   </div>
  		    
  		      </div>
              <div id="echarts2" style="height:100%; " ></div>

  		 </div>
   </div>
   <div	 class='consumer-bottom transparency'>
   	<br/>
  			 	<div	class='consumer-head' style='position: absolute;    width: calc(100% - 10px); width: -webkit-calc(100% - 10px);width: -moz-calc(100% - 10px)'>
  		      	   <p class= 'pull-left' style='color:rgb(233,233,233);font-size: 1.2rem; '><span class='hot'></span>  详情</p>
  		      	   <div	class='pull-right'  style='font-size: 12px;  font-size: 1.2rem; '>

  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#3EE3E5'></span> 	用户</p>
  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#AE43CD'></span> 	销量</p>
  		      	   <p class= 'pull-left'><span class='hot' style='background-color:#FEC751'></span> 	用水量</p>
  		      	  </div>
  		    
  		      </div>
  		         <div id="echarts3" style="height:100%; " ></div>
   </div>
</div>
</div>
<script>
    var role_id='<?=$role_id?>';
   var all_datas=<?=json_encode($all_datas)?>;
   // console.log(all_datas)

   var province=<?=json_encode($province)?>;
   if(province==null){
    province=''
   }
    // console.log(province);
</script>

<script type="text/javascript" src="./static/js/jquery.min.js"></script>


<script type="text/javascript" src="./static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>	
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>


<!-- <script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script> -->
<script type="text/javascript" src="./static/js/lib.js"></script>
<script type="text/javascript" src="./static/js/echarts/echarts.min.js"></script>
<script src="/static/js/echarts/dist/echarts.js"></script>
<script src="/static/js/echarts/dist/customed.js"></script>
<!-- <script type="text/javascript"  src="/static/css/site/main.js?v=1.2"></script> -->
<script>
  var provincefun =province;
  var numberMultiple=1;
  // 倍数
if(role_id==1||role_id==6){
     numberMultiple = 25;
}

console.log(role_id)
var reloadIframe = $('#reloadIframe', window.parent.document)
// // // console.log(reloadIframe)
// reloadIframe.click(function(){
//   console.log(5)
// // var Urla= location.href;
// // // console.log(Urla.indexOf("real_time=1"))
// //      // window.location.href=Urla
// // console.log(Urla.indexOf("real_time=1"))
// // // if(Urla.indexOf("real_time=1")>-1){
// // //       window.location.replace(Urla);
// // // }else{
// // //      window.location.replace(Urla+'&real_time=1');
// // // }
// //  return false;
// })
// 时间
  setInterval(function() {
  $('#current_time').text(getNowFormatDate())
  }, 1000);
  var _this = this;
     this.province = $("#province");//省份select对象
    _this.province.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
     _this.province.trigger("chosen:updated");
renderingData(all_datas,provincefun)
  $(window).resize(function() {
    // var ii = layer.msg("加载中……");
    var normal_mode_false = $('#FullScreen', window.parent.document).attr('datae')
    if (normal_mode_false == 'false') {
      $('#normal-mode').css('display', 'block')
    } else {
      $('#normal-mode').css('display', 'none')
    }
    var str = $(".region").eq(0).text()
    if (str == '全国'||str == '全国') {
      str = ''
    }
    renderingData(all_datas,str);
  });

$("#province").change(function(){
  var ii = layer.msg("加载中……");
  var province_val = $(this).val();
  var province = province_val
  if(province_val=='china'){
       province='全国'
  }
  $(".region").eq(0).text(province);
  var url = window.location.href;
window.location.href=url+"&province="+province;

      // renderingData(all_datas,province_val)
})

function renderingData(datas,obj){
      for(i in datas){
         // console.log(data[i])
         if(typeof(datas[i])=='string'){
                datas[i]=  $.parseJSON( datas[i])
            }
      }
   // console.log(data)   
    // 今日数据渲染
    if (datas.today_datas){
      var todaysData=datas.today_datas;
      $('#wdcNUM').text(todaysData.user_num*numberMultiple);
      $('#operateNum').text(todaysData.agenty_num)
      $('#waterworksNum').text(todaysData.factory_num)
      $('#serviceNum').text(todaysData.agentf_num)
      $('#equipmentNum').text(todaysData.devfactory_num)
    };


      // 实时数据渲染
    if (datas.RealTimeDatas) {
      var realTimeData=datas.RealTimeDatas;
      $('#todayRmb').text(Math.ceil(realTimeData.today_sales*10*numberMultiple));
      $('#todayVbepRmb').text(Math.ceil(realTimeData.today_sales*numberMultiple))
      $('#todaWwaterRmb').text(Math.ceil(realTimeData.today_wateruse*numberMultiple))
      $('#januaryVbepRmb').text(Math.ceil(realTimeData.total_sales *numberMultiple))
      $('#waterJanuaryRmb').text(Math.ceil( realTimeData.total_wateruse*numberMultiple))
    }

    // 服务中心销量排名（本月前五）

    if (datas.AgentfSales) {
      $('#rankingsService').empty();

   
      var data = datas.AgentfSales.datas;

      for (var i = 0; i < data.length; i++) {
        var item = data[i];
        var item_num = item.num ? item.num : 0;
     // console.log(item.Name );


        var html = '<div class="ranking-Percentage" style="position:relative">' +
            '<div class="progress">' +
            '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' + item_num / datas.AgentfSales.total_sales + '" aria-valuemin="0" aria-valuemax="100" '+
            'style="width: ' + item_num / datas.AgentfSales.total_sales*100  + '%">' +
            ' <span class="sr-only">' + item.num / datas.AgentfSales.total_sales + '% Complete (success)</span>' +
            ' </div>' + '</div>' + '<p class="rankingNum">' + Math.floor(item_num*numberMultiple)  + '袋</p><p style="margin-top: -1.2rem;">  ' + item.Name + '</p></div>' +
            '';
          $('#rankingsService').append(html)

      }
        // return
    }



        // 运营中心销量排名（本月前五）
    if (datas.AgentySales.datas) {
      $('#rankingsOperate').empty();
      var data = datas.AgentySales.datas;

      for (var i = 0; i < data.length; i++) {
        var item = data[i];
        var item_num = item.num ? item.num : 0;
        
        var html = '<div  class="operate-item">' +
          '<p class="item-title" style="padding-bottom: 10px; color:#A541C2;font-weight:400;font-size:12px;  font-size: 1.2rem; ">' +  Math.floor(item_num*numberMultiple) + '袋</p>' +
          '<div class="Middle-line">' +
          '<div class="operate-img" style="height:' + item_num/ datas.AgentySales.total_sales*100 + '%;    background: url(/static/images3/Arrow.png) no-repeat;background-size: 65% 100%;background-position: 40%;">' +
          '<img id="scream" src="/static/images3/Smallbell.png" class="Smallbell"  alt="The Scream" width="5">' +
          // '<img src="/static/images3/Arrow.png" class="Arrow" alt="">' +
          '</div>' +
          '</div>' +
          '<p class="item-name">' + item.Name + '</p>' +
          '</div>';
          $('#rankingsOperate').append(html)
      }
      if (datas.AgentySales.datas.length == 1) {

          $('#rankingsOperate .operate-item').css('marginLeft', '6em');

        } else if (datas.AgentySales.datas.length == 2) {
          $('#rankingsOperate .operate-item').css('marginLeft', '3em');
        } else if (datas.AgentySales.datas.length == 3) {
          $('#rankingsOperate .operate-item').css('marginLeft', '2em');

        } else if (datas.AgentySales.datas.length == 4) {
          $('#rankingsOperate .operate-item').css('marginLeft', '1em');
        }
      };

            // 地图地址
      if (datas.all_province.length) {

         $("#province").empty()
         $("#province").append('<option value="" selected>全国</option>')
         $.each(datas.all_province, function (index, item) {
                if (item) {
                    $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
                }
            });
         _this.province.val(obj)
         _this.province.trigger("chosen:updated");
      }


      // console.log(data.DevDistribution)

            // 地图渲染
      if(datas.DevDistribution){
        var platBloatedData=datas.DevDistribution;
        $("#equipmentOne").text(platBloatedData.not_active*1);
        $("#equipmentTwo").text(platBloatedData.dev_active*numberMultiple );
        $("#equipmentThree").text(platBloatedData.dev_warning *numberMultiple);

        var ProvinceNum = [];
        if(platBloatedData.datas){
           for (var i = 0; i < platBloatedData.datas.length; i++) {
            ProvinceNum.push(platBloatedData.datas[i].Province);
          };
        }
       

        var Province = unique(ProvinceNum)||[ ];
               // console.log(Province);
        var ProvinceTxt = [];
        var ProvinceP = []

        for (var i = 0; i < Province.length; i++) {
          ProvinceTxt.push(0);
          for (var y = 0; y < platBloatedData.datas.length; y++) {
            if (Province[i] === platBloatedData.datas[y].Province) {
              ProvinceTxt[i]++
            }
          }
          var num = Percentage3(ProvinceTxt[i], platBloatedData.datas.length)
          ProvinceP.push(num)
        };

        var placeList = [];
        var earlyWarning = [];

        if(platBloatedData.warning_devnos){
            for (var i = 0; i < platBloatedData.warning_devnos.length; i++) {
              earlyWarning.push({
                geoCoord: [platBloatedData.warning_devnos[i].BaiDuLng, platBloatedData.warning_devnos[i].BaiDuLat]
              })
            };
        }

        if(platBloatedData.dev_location){
        for (var i = 0; i < platBloatedData.dev_location.length; i++) {
          placeList.push({
              geoCoord: [platBloatedData.dev_location[i].BaiDuLng, platBloatedData.dev_location[i].BaiDuLat]
          })
        }
      }
        var reg;
        var province = '';
        if (obj != '') {
          var str = obj
          if (str.indexOf("省") != -1) {
            reg = new RegExp("省", "g");
            province = str.replace(reg, "");
          } else if (str.indexOf("市") != -1) {
            reg = new RegExp("市", "g");
            province = str.replace(reg, "");
          } else {
            province = str;
          }
          provincefun=province
        }


        if (province == '请选择' || province == '' || province == '全国') {
          province = 'china';
        };

        if(!obj){
          obj='china';
        }
          if(!provincefun){
          provincefun='china';
        }
        // console.log(provincefun)

        map(placeList, Province, ProvinceTxt, ProvinceP, provincefun, earlyWarning); 
      }

     // 饼图

     // console.log(datas.UserTypeSales)
         // return
      if(datas.UserTypeSales){
         var pieData=datas.UserTypeSales;
         var PieName = ['家庭', '单位', '集团', '酒店', '其他'];
         var PieNamenum = [0, 0, 0, 0, 0];


        if(pieData.usertype){
        for (var i = 0; i < pieData.usertype.length; i++) {
            var item = pieData.usertype[i];
            if (item.CustomerType == 1) {
              PieNamenum[0] = item.num
            } else if (item.CustomerType == 2) {
              PieNamenum[1] = item.num
            } else if (item.CustomerType == 3) {
              PieNamenum[2] = item.num
            } else if (item.CustomerType == 4) {
              PieNamenum[3] = item.num
            } else if (item.CustomerType == 99) {
              PieNamenum[4] = item.num
            };
        };


      }

  
        var histogram_daray = [0, 0, 0, 0, 0]
      if(pieData.datas){
        for (var i = 0; i < pieData.datas.length; i++) {
          var item = pieData.datas[i];
          if (item.CustomerType == 1) {
            histogram_daray[0] = item.num*numberMultiple 
          } else if (item.CustomerType == 2) {
            histogram_daray[1] = item.num*numberMultiple 
          } else if (item.CustomerType == 3) {
            histogram_daray[2] = item.num*numberMultiple 
          } else  if  (item.CustomerType == 4){
            histogram_daray[3] = item.num*numberMultiple 
          }else {
            histogram_daray[4] = item.num*numberMultiple 
          }
        };
      }





        barPieChart(PieName, PieNamenum);
      // console.log(PieName)

      // console.log(histogram_daray)
        


          histogram(PieName, histogram_daray);
      }



      // 折线
      if(datas.LineDatas){

        var brokenData=datas.LineDatas;

        console.log(brokenData)
        var userdarax = [];
        var userdaray = [];
        var waterdaray = [];
        var _Saledaray = [];
        NumberDays(15, userdarax);
        // // 用户增长
        for (var i = 0; i < userdarax.length; i++) {
          userdaray.push(0)
          var nowDate = Date.parse(userdarax[i]);
          if(brokenData.user_increase){
            for (var j = 0; j < brokenData.user_increase.length; j++) {
              TwoDate = Date.parse(brokenData.user_increase[j].Date);
              if (nowDate == TwoDate) {
                userdaray[i]++
              }
            }
          }
          waterdaray.push(0)
          var nowDate = Date.parse(userdarax[i]);
            if(brokenData.user_sales){
              for (var j = 0; j < brokenData.user_sales.length; j++) {
                TwoDate = Date.parse(brokenData.user_sales[j].Date);
                if (nowDate == TwoDate) {
                  waterdaray[i]++;
                }
              }
            }
          _Saledaray.push(0)
          var nowDate = Date.parse(userdarax[i]);
             if(brokenData.use_status){
                for (var j = 0; j < brokenData.use_status.length; j++) {
                  TwoDate = Date.parse(brokenData.use_status[j].ActDate);
                  if (nowDate == TwoDate) {
                    _Saledaray[i] = _Saledaray[i] * 1 + brokenData.use_status[j].WaterUse * 1;
                  }
                }
             }
        }
          for (var i = 0; i < userdarax.length; i++) {
                 userdaray[i]=userdaray[i]*numberMultiple;
                 _Saledaray[i]=_Saledaray[i]*numberMultiple;
                 waterdaray[i]=waterdaray[i]*numberMultiple;
          }
        // console.log(userdaray);
    var WaterUse=[];
    var WaterUseDate=[];
 // console.log(brokenData.use_status);
 // console.log(brokenData.use_status.length);
    for(var index=0;index<brokenData.use_status.length;index++){
        var item =brokenData.use_status[index];
         // console.log(index);
         WaterUse.push(item.WaterUse*numberMultiple);
         WaterUseDate.push(item.ActDate);
    }


 // console.log(WaterUseDate);月份时间
 // console.log(userdaray);//用户
 console.log(WaterUse);//用水量
 // console.log(waterdaray);//销量



          lineDiagram(WaterUseDate, userdaray, WaterUse, waterdaray);
          // lineDiagram(userdarax, userdaray, _Saledaray, waterdaray);






      }





}






function unique(data) {
  var res = [];
  var json = {};
  for (var p = 0; p < data.length; p++) {
    if (!json[data[p]]) {
      res.push(data[p]);
      json[data[p]] = 1;
    } else {}
  }
  return res;
};




function NumberDays(xin, _date) {
  for (var i = 0; i >= -xin + 1; i--) {
    _date.push(GetDateStr(i, 1))
  }
  _date.reverse();
  return _date;
};


function GetDateStr(AddDayCount, AddMonthCount) {
  var dd = new Date();
  dd.setDate(dd.getDate() + AddDayCount); //获取AddDayCount天后的日期
  var y = dd.getFullYear();
  var m = dd.getMonth() + AddMonthCount; //获取当前月份的日期
  var d = dd.getDate();
  if (String(d).length < 2) {
    d = "0" + d;
  }
  if (String(m).length < 2) {
    m = "0" + m;
  }
  return y + "-" + m + "-" + d;
};

    function Percentage3(number1, number2) {
      if (number2 <= 0) {
        number2 = 1
      }
      if (number1 <= 0) {
        number1 = 0
      }
      return (Math.round((number1 / number2) * 10000) / 100); // 小数点后两位百分比
    };







 function getNowFormatDate() {
  var date = new Date();
  var seperator1 = "-";
  var seperator2 = ":";
  var month = date.getMonth() + 1;
  var strDate = date.getDate();
  if (month >= 1 && month <= 9) {
    month = "0" + month;
  }
  if (strDate >= 0 && strDate <= 9) {
    strDate = "0" + strDate;
  }



  var dataget1 = date.getHours();
  var dataget2 = date.getMinutes();
  var dataget3 = date.getSeconds();

  if (dataget1 >= 1 && dataget1 <= 9) {
    dataget1 = "0" + dataget1;
  }
  if (dataget2 >= 0 && dataget2 <= 9) {
    dataget2 = "0" + dataget2;
  }
  if (dataget3 >= 0 && dataget3 <= 9) {
    dataget3 = "0" + dataget3;
  }

  var getDay = date.getDay();
  var show_day = new Array('星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');


  var getDay_day = getDay - 1;
  if (getDay_day < 0) {
    getDay_day = 6;
  };


  var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate +
    " " + show_day[getDay_day] + "  " + dataget1 + "  " + seperator2 + dataget2 + "   " +
    seperator2 + "   " + dataget3;
  return currentdate;
}

function map(placeList, Province, ProvinceTxt, ProvinceP, provincefun, earlyWarning) {
// console.log(placeList)
// console.log(Province)
// console.log(ProvinceTxt)
// console.log(ProvinceP)
// console.log(provincefun)
// console.log(earlyWarning)


if(provincefun==' '){
  provincefun='china';
}
else
    if(provincefun.indexOf('省')){
    var src_province_val=provincefun.split("省");
    provincefun= src_province_val[0];
  }
    if(provincefun.indexOf('自治区')){
    var src_province_val=provincefun.split("自治区");
    provincefun= src_province_val[0];
  }
     if(provincefun.indexOf('回')){
    var src_province_val=provincefun.split("回");
    provincefun= src_province_val[0];
  }
if(provincefun.indexOf('维')){
    var src_province_val=provincefun.split("维")
    provincefun= src_province_val[0];
  }
  if(provincefun.indexOf('特')){
    var src_province_val=provincefun.split("特");
    provincefun= src_province_val[0];

  }
  if(provincefun.indexOf('壮')){
    var src_province_val=provincefun.split("壮");
    provincefun= src_province_val[0];
  } 

// console.log(provincefun)
  require.config({
    paths: {
      echarts: '/static/js/echarts/dist'
    }
  });
  require(
    [
      'echarts',
      'echarts/chart/map',
      'echarts/config'
    ],
    function(ec) {
      var myChart = ec.init(document.getElementById('main'));

      var option = {
        backgroundColor: 'transparent',

        color: [

          '#FEC751'
        ],

        color: [
          '#9018A9',
          '#FEC751',
          '#0D64A5'
        ],


        legend: {
          orient: 'vertical',
          x: 'left',
          data: [],
          textStyle: {
            color: '#fff'
          }
        },

        toolbox: {
          show: true,
          orient: 'vertical',
          x: 'right',
          y: 'center',
          feature: {
            mark: {
              show: false
            },
            dataView: {
              show: false,
              readOnly: false
            },
            restore: {
              show: false
            },
            saveAsImage: {
              show: false
            }
          }
        },
        series: [{
            name: '正常设备',
            type: 'map',
            mapType: provincefun,
            hoverable: false,
            roam: false,

            itemStyle: {
              normal: {
                borderColor: ' rgba(37,40,45,0.68)',

                areaStyle: {
                  color: '#2F343A'
                }
              }
            },
            data: [],
            markPoint: {
              symbol: 'diamond',
              symbolSize: 6,
              large: true,
              effect: {
                show: true
              },
              data: (function() {
                var data = [];
                var len = placeList.length;
                var geoCoord
                while (len--) {
                  geoCoord = placeList[len % placeList.length].geoCoord;
                  data.push({
                    // name : placeList[len % placeList.length].name + len,
                    value: 10,
                    geoCoord: [
                      geoCoord[0],
                      geoCoord[1]
                    ]
                  })
                }
                // console.log(data)  
                return data;
              })()
            }
          }, {
            name: '预警设备',
            type: 'map',
            mapType: provincefun,
            hoverable: false,
            roam: false,
            itemStyle: {
              normal: {
                borderColor: ' rgba(37,40,45,0.68)',

                areaStyle: {
                  color: '#2F343A'
                }
              }
            },
            data: [],
            markPoint: {
              symbol: 'diamond',
              symbolSize: 3,
              large: true,
              effect: {
                show: true
              },
              data: (function() {
                var data = [];
                var len = earlyWarning.length;
                var geoCoord
                while (len--) {
                  geoCoord = earlyWarning[len % earlyWarning.length].geoCoord;
                  data.push({
                    // name : placeList[len % placeList.length].name + len,
                    value: 10,
                    geoCoord: [
                      geoCoord[0],
                      geoCoord[1]
                    ]
                  })
                }
                // console.log(data)  
                return data;
              })()
            }
          }


        ]
      };
      myChart.setOption(option, true);
    }

  )


};


function barPieChart(PieName, PieNamenum) {

  var myChart = echarts.init(document.getElementById('echarts'));


  var option = {
    tooltip: {
      trigger: 'item',
      formatter: "{a} <br/>{b} : ({d}%)",
      backgroundColor: 'rgba(203,73,46,0.9)',
      textStyle: {
        color: '#fff',

      }
    },
    // legend: {
    //   orient : 'vertical',
    //   x : 'right',
    //   y : 'bottom',
    //   data:['家庭','集团','公司','其他'],
    //   textStyle: {
    //   color: '#fff'
    //       },
    //   },
    toolbox: {
      show: false,
      feature: {
        mark: {
          show: false
        },
        dataView: {
          show: false,
          readOnly: true,

        },
        magicType: {
          show: false,
          type: ['pie', 'funnel'],
          option: {
            funnel: {
              x: '20%',
              width: '100%',
              funnelAlign: 'center',
              max: 1548
            }
          }
        },
        restore: {
          show: false,
          title: "刷新",
        },
        saveAsImage: {
          show: false
        }
      }
    },
    calculable: false,
    series: [{
        name: '用户类型',
        type: 'pie',
        radius: ['50%', '60%'],
        center: ['50%', '55%'],
        itemStyle: {
          normal: {
            label: {
              show: true,
              formatter: '{d}%'

            },
            labelLine: {
              show: true
            }
          },
          emphasis: {
            label: {
              show: false,
              position: 'center',
              textStyle: {
                fontSize: '30',
                fontWeight: 'bold'
              }
            }
          }
        },
        data: [{
            value: PieNamenum[0],
            name: PieName[0]
          }, {
            value: PieNamenum[1],
            name: PieName[1]
          }, {
            value: PieNamenum[2],
            name: PieName[2]
          }, {
            value: PieNamenum[3],
            name: PieName[3]
          }, {
            value: PieNamenum[4],
            name: PieName[4]
          }

        ]
      }



    ],
    color: ['#51F2F3', '#FEC751', '#C248DC','#21f507', '#EE5030']

  };


  myChart.setOption(option, true);



}

function histogram(PieName, histogram_daray) {


  var myChart2 = echarts.init(document.getElementById('echarts2'), 'customed');

  var option2 = {

    tooltip: {
      trigger: 'axis',
      backgroundColor: 'rgba(203,73,46,0.9)',
      textStyle: {
        color: '#fff',
      },
      formatter: function(params) {

        return params[0].name + '用户：' + params[0].data + '袋'
      }
    },
    grid:{
                    x:50,
                    borderWidth:1
                },
    xAxis: [{
      type: 'category',
      axisLabel: {
        show: true,
        textStyle: {
          color: 'rgb(233,233,233)',
        }
      },
      data: PieName
    }],
    yAxis: [{
      type: 'value',
      axisLabel: {
        show: true,
        textStyle: {
          color: 'rgb(233,233,233)',
        }
      }
    }],
    series: [{
      "name": "销量",
      'barWidth': 10,
      "type": "bar",
      itemStyle: {
        //通常情况下：
        normal: {　　　　　　　　　　　　 //每个柱子的颜色即为colorList数组里的每一项，如果柱子数目多于colorList的长度，则柱子颜色循环使用该数组
          color: function(params) {
            var colorList = ['#51F2F3', '#FEC751', '#C248DC','#21f507', '#EE5030']
       
            return colorList[params.dataIndex];
          }
        },
        //鼠标悬停时：
        emphasis: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: '#CB492E'
        }
      },
      "data": histogram_daray
    }]
  };

  // 为echarts对象加载数据 
  myChart2.setOption(option2, true);
}

// 折线图
function lineDiagram(userdarax, userdaray, Saledaray, waterdaray) {
  // 基于准备好的dom，初始化echarts图表
  var myChart = echarts.init(document.getElementById('echarts3'), 'customed');
  var option = {
    tooltip: {
      trigger: 'axis',
      backgroundColor: 'rgba(203,73,46,0.9)',
      textStyle: {
        color: '#fff',
      },
      formatter: function(params) {

        var html =params[0].name + '<br/>' +params[1].seriesName + ':' + Math.round((params[1].data) * 10000) / 10000 + '(L)<br/>'+
        params[2].seriesName + ':' + Math.round((params[2].data) * 10000) / 10000 + '(袋)<br/>' +
         params[0].seriesName + ':' + params[0].data + '家<br/>' 
        
        
          
        return html;
      }
    },
    grid:{
                    x:50,
                    borderWidth:1
                },

    toolbox: {
      show: false,
      feature: {
        mark: {
          show: true
        },
        dataView: {
          show: true,
          readOnly: false
        },
        magicType: {
          show: true,
          type: ['line', 'bar']
        },
        restore: {
          show: true
        },
        saveAsImage: {
          show: true
        }
      }
    },
    calculable: true,
    xAxis: [{
      type: 'category',
      boundaryGap: false,
      data: userdarax,
      axisLabel: {
        show: true,
        textStyle: {
          color: 'rgb(233,233,233)',
        }
      }
    }],
    yAxis: [{
      type: 'value',
      axisLabel: {
        show: true,
        textStyle: {
          color: 'rgb(233,233,233)',
        },
        formatter: '{value}'
      }
    }],
    series: [{
      name: '用户',
      type: 'line',
      center: ['20%', '20%'],
      data: userdaray,
      itemStyle: {
        normal: {
          color: "#3EE3E5",
          lineStyle: {
            color: "#3EE3E5"
          }
        }
      }

    }, {
      name: '用水量',
      type: 'line',
      data: Saledaray,
      itemStyle: {
        normal: {
          color: "#FEC751",
          lineStyle: {
            color: "#FEC751"
          }
        }
      }
    }, {
      name: '销量',
      type: 'line',
      data: waterdaray,
      itemStyle: {
        normal: {
          color: "#AE43CD",
          lineStyle: {
            color: "#AE43CD"
          }
        }
      }
      // markLine : {
      //     data : [
      //         {type : 'average', name : '平均值'}
      //     ]
      // }
    }]
  };

  // 为echarts对象加载数据 
  myChart.setOption(option);
  
}

</script>


