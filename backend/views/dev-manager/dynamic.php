<?php
use yii\widgets\LinkPager;
function getActType($type){
    $desc="";
    switch($type){
        case 1:$desc="开关机";break;
        case 2:$desc="调温";break;
        case 4:$desc="加热";break;
        case 8:$desc="消毒";break;
        case 16:$desc="抽水";break;
        case 99:$desc="上传";break;
    }
    return $desc;
}
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="/static/css/Common.css?v=1.1"/>
<script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
<style type="text/css">
.table{
    position:relative;
    text-align: center;

}
.table td{
        color: rgb(186, 186, 191)
}
.table td:first-child{
    border-left: 3px rgb(186, 186, 191) solid;
}
#method{
       position: absolute;
       cursor: pointer;
       z-index: 1000
       bottom:0;
       right:0;
       color: #fff;

       margin-top: 0px;
}
#method a{
	    color: rgb(186, 186, 191);
	    display: block;
	    height: 30px;
	    margin-top: 0px;
	    line-height: 30px;
		padding: 0 5px;
		text-decoration: none;
		text-align: center;
		margin-right: 20px;
}
#method a:hover{
		background-color: #292834;
		text-decoration:none;
};
select{
     width: initial;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
    border:none;  text-align: center;
}
.boootn{
   width:10px;
   display: inline-block;
   height:10px;
   border-radius:50px;
   background-color:#fff;
}
.form-group {
     margin-bottom: 0px; 
}
.wrap_line{
     border-radius: 4px;
    background-color: #2d3136;
    border: 1px solid #2d3136;
    display: inline-block;
}   
select,.chosen-container{
        width: inherit;
        min-width: 100px;
}
label{
    width:65px;
}


</style>
<div class="wrapper wrapper-content">
        <div class="form-group " >
            <div class="condition" style="height: 120px;">
            <form action="/index.php?r=dev-manager/dynamic" method="post">
            <div class="col-sm-12" style="margin-bottom:20px;">
<!--               <span><label>设备手机号:</label> <input name="tel" type="text" id="tel" placeholder="设备手机号" value="--><?//=$tel?><!--"/></span>-->
                <span style="padding-left:5px; display:inline-block"><label>搜索内容:</label> <input name="content" type="text"  id="content" placeholder="设备编号或用户" value="<?=$content?>"/></span>
                     <span style="padding-left:5px;margin-top: 10px;display:inline-block">
                         <span style="padding-left:10px;margin-top: 10px;"><label>时间段:</label> 
                            <input type="text" placeholder="选择时间" name="selecttime"  readonly  unselectable="on"  id="selecttime" />
                        </span>
                      </span>  


             <input  style="display: none" type="text" name="real_search" value="1">
            <div  style="display:inline-block; margin-left: 1%;">
                  <label>设备状态:</label>
               <select class="control-label" name="state" id="state">
                    <option value="1" selected>正常设备</option>
                    <option value="2">已初始化设备</option>
                    <option value="3">未激活设备</option>
                </select>               
            </div>

                     <div style='margin-left: 5px;margin-top:15px; margin-right: 30%;'>
                        <div style='float: left;'>
                            
                       
                       <label >地区:</label>
                      <div class="wrap_line" >

                         <select class="control-label" name="province"  id="province">
                             <option value="" selected>请选择省</option>
                         </select>
                        <select class="control-label" name="city" id="city">
                            <option value="">请选择市</option>
                        </select>
                        <select class="control-label" name="area" id="area">
                             <option value="">请选择区县</option>
                        </select>
                     </div>
 </div>
                     <div class="submitBtn"  style='display: inline-block; float: left;' >
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input style="padding:2px 10px;border: none;" type="submit" value="查询" id="btn"/>
                        &nbsp;&nbsp;
                        <button type="text" style="    background-color: #E46045;    color: #fff;    margin-top: -3px;height: 30px;" class="btn" id="removerSub">清空条件</button>
                     </div>

                     <div style='clear:both '>
                         
                     </div>
                
                   </div>


                    
          

		            <!--  <div id="dvCBs"  style="">
		                <span class='radio_btn'> 
		                	<input name="state" type="radio" value="1"  id="state1" />
		                	<span></span>
		                
		                </span>
		                	 <label for="state1" >正常用户</label>
		                 <span class='radio_btn'>
		                  	<input name="state" type="radio" value="2"  id="state2" />
		 				     <span></span>
		                   </span>
		                   <label for="state2">已初始化用户 </label>
		                 <span class='radio_btn'> 
		                 	<input name="state" type="radio" value="3"  id="state3" />
		                 	           <span></span>
		                  </span>
		                  <label  for="state3">显示全部设备 </label>

		            </div>
		            <span style="font-weight: bold;">（此选项为单选项   注释：<span class='boootn'></span>正常设备 &nbsp;   <span style="width: 50px;height:1px;text-decoration:line-through;color:#49CECF">&nbsp;&nbsp;&nbsp;</span>&nbsp;已初始化设备 ）</span>
             
            </div> -->
            </form>

   
         </div>
    </div>
    <table class="table table-hover" style="width: 100%;">

     <div  id="method" style="margin-top: -65px;" class="pull-right">
        <a href="">
              <img src="/static/images3/biao.png" alt="">&nbsp;&nbsp;&nbsp;导出表格
        </a>

    </div>
        <thead>
        <th style="width: 45px">序号</th>
        <th style="width: 80px">设备编号</th>
        <th style="width: 80px">ICCID</th>
        <th style="width: 80px">最近操作</th>

<!--        <th>操作日志</th>-->
        <th style="width: 60px">用水量</th>
        <th style="width: 70px">剩余水量</th>
        <th style="width: 45px">TDS</th>
        <th style="width: 45px">水温</th>
<!--         -->
        <th style="width: 90px">所在区域</th>
        <th style="width: 200px">位置信息</th>
        <th style="width: 80px">用户姓名</th>
        <th style="width: 60px">手机号</th>
        <th style="width: 100px"><a id="sort" href="">最近上传时间</a></th>
        <th style="width: 80px">操作日志</th>
        </thead>
        <tbody>
        <?php
        $str='';
        $no=1;


        foreach($model as $key=>$val)
        {
            $str.= "<tr ".(in_array($val['DevNo'],$users_of_init)?"date = '1'":'').">
                        <td><p>".$no."</p></td>
                        <td><p>".$val["DevNo"]."</p></td>
                        <td><p>".$val["Iccid"]."</p></td>
                        <td><p>".(getActType($val["ActType"]))."</p></td>
                        <td><p>".(empty($val["WaterUse"])?"——":$val["WaterUse"])."</p></td>
                        <td><p>".(empty($val["VlNum"])?"——":round($val["VlNum"] ,2))."</p></td>
                        <td><p>".(empty($val["Dts2"])?"——":$val["Dts2"])."</p></td>
                        <td><p>".($val["Degrees"]==0.00?"——":$val["Degrees"])."</p></td>
                        <td><p>".($val["Province"].'-'.$val["City"].'-'.$val["Area"])."</p></td>
                         <td><p>".$val["Address"]."(".$val["Lat"].",".$val["Lng"].")</p></td>
                        <td><p>".$val["UserName"]."</p></td>
                        <td><p>".$val["Tel"]."</p></td>
                        <td><p>".$val["RowTime"]."</p></td>
                        <th><p><a href='./?r=dev-manager/detail&DevNo=".$val["DevNo"]."'>详情</a></p></th>
                    </tr>";
            $no++;

        }
        echo $str;
        ?>
       
        </tbody>
    </table>
    <table>
        <th></th>
    </table>
</div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js?v=4"></script>
<script>
 var ii = layer.msg('加载中....');

    var data =<?=json_encode($areas)?>;
//    var areas=<?//=json_encode($areas)?>//;
    var province=<?=json_encode($province)?>;
    var city=<?=json_encode($city)?>;
    var area=<?=json_encode($area)?>;
    var sort=<?=$sort?>;
     var total=<?=$total?>;
    var state='<?=$state?>';
   var selecttime ='<?=$selecttime?>';
console.log(state)
</script>
<script>


        var content ='<?=$content?>';
        var where_datas={
            province:province,
            city:city,
            area:area,
            content:content,
            selecttime:selecttime,
        };
// console.log(where_datas)
var url='';
// var result = JSON.stringify(where_datas)
for(var i in where_datas){
  if(where_datas[i]==null){
     where_datas[i]=''
  }
  url= url +"&"+ i+'='+where_datas[i]
}

$(".table  td a").click(function(){
    var _thisURl = $(this).attr('href');
      var Urlobj = encodeURIComponent(url);
    $(this).attr('href',_thisURl+"&Url="+Urlobj)
})












$("#removerSub").click(function(event) {
    /* Act on the event */
    $("#content").val('')
    $("#selecttime").val('')
});
// 地址渲染 
addressResolve(data,province,city,area);
$("#state").chosen({no_results_text: "没有找到",disable_search_threshold: 10})
if(state){
     if(state==3){
        $(".table tr td").css("color",'red')
     }
    $("#state").val(state);
     $("#state").trigger("chosen:updated");
}

$(function(){
    $(".table tbody").children("tr").each(function(index){
        if( $(this).attr("date")==1){
            // $(this).parent().parent().line();
             // $(this).children().attr("disabled", "disabled").children().attr("disabled", "disabled");
                    var t = $(this).offset().top + $(this).height()/2 -160;//1、获得对应行，第一列相对于浏览器顶部的位移
                    var l = $(this).offset().left;//2、获得对应行，第一列相对于浏览器左侧的位移
                    var w = $(this).width();//3、获得对应行的宽度 
                 
                // $(this).after("<div style='outline:#BABABF solid 1px; position:absolute;top:" + t+ "px;width:" + w + "px;'></div>")
                $( 'p',  this).css({'borderBottom':'1px solid #49CECF','display':'inlineBlock',' paddingBottom':'10px','color':'#49CECF',"textAlign":'center'})
                $( 'td:first-child',  this).css('borderLeft', '3px solid #49CECF')
        }
    })
   // layer.close(ii)
})
$(function(){
  var selecttime='';
    var dateRange = new pickerDateRange('selecttime', {
        aRecent7Days : '', //最近7天
        isTodayValid : true,

        //startDate : '2013-04-14',
        //endDate : '2013-04-21',
        //needCompare : true,
        //isSingleDay : true,
        //shortOpr : true,
        defaultText : '至',
        inputTrigger : 'selecttime',
        theme : 'ta',
        success : function(obj) {
//                startTimeStr = obj.startDate;
//                endTimeStr = obj.endDate;

           selecttime = $("#selecttime").val()
 

        }
    });

   


$("#selecttime").val('<?=$selecttime?>');
 $("#method a").click(function(){
       var  provincese = $("#province").val()
       var  cityse = $("#city").val()
       var  arease = $("#area").val()
       var  contentse = $("#content").val()
     $(this).attr('href','index.php?r=dev-manager/detail&excel=xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz&per-page=<?=$total?>&selecttime='+selecttime+'&province='+provincese+'&city='+cityse+'&area='+arease+'&content='+contentse+'&real_search=1');
    })

    
});

    //排序
    $('#sort').click(function(){
        sort++;
        var content=$('#content').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();
        $(this).attr('href','./?r=dev-manager/dynamic&sort='+sort+'&selecttime='+selecttime+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&state='+state+'&real_search=1');

    });

    $(function(){
        $('.pagination a').click(function(){

            var content=$('#content').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();
            var page_size=$('#page_size option:selected').val();

            var href=$(this).attr('href');

            $(this).attr('href',href+'&content='+content+'&selecttime='+selecttime+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&per-page='+page_size+'&state='+state+'&real_search=1');

        });
    });



function initAddress() {
    $("#province").val(province);
    initCityOnProvinceChange();
    $("#city").val(city);
    initThree();
    $("#area").val(area);

  if(state){
     $("#dvCBs input").eq(state-1).attr("checked","checked")
  }


}

function getAddressIdByName(_name) {
    _name = $.trim(_name);
    if (_name == "") {
        return 0;
    }
    for (var index = 0; index < data.length; index++) {
        var item = data[index];
        var name = $.trim(item.Name);
        if (name != "" && name == _name) {
            return item.Id;
        }
    }
    return 0;
}
function initListener() {
    $("#province").on("change", function () {
        initCityOnProvinceChange();
    });
    $("#city").on("change", function () {
        initThree();
    });
//    $("#queryBtn").on("click",function(){
//        query();
//    });
}
function initCityOnProvinceChange() {
    var pid = getAddressIdByName($("#province").val());
    $("#city").empty();
    $("#area").empty();
    $("#area").append("<option value='' selected>请选择</option>");
    $("#city").append("<option value='' selected>请选择</option>");
    if (pid == 0) {
        return;
    }
    for (var index = 0; index < data.length; index++) {
        var item = data[index];
        if (item.PId != 0 && item.PId == pid) {
            $("#city").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            initThree()
        }
    }
}
function initThree() {
    var pid = getAddressIdByName($("#city").val());
    $("#area").empty();
    $("#area").append("<option value='' selected>请选择</option>");
    if (pid == 0) {
        return;
    }
    for (var index = 0; index < data.length; index++) {
        var item = data[index];
        if (item.PId != 0 && item.PId == pid) {
            $("#area").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
        }
    }
}
function initProvince() {
    for (var index = 0; index < data.length; index++) {
        var item = data[index];
        if (item.PId == 0) {
            $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
        }
    }
}
</script>
<?php
echo "";
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px;height:100px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;border:none;padding:5px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=dev-manager/dynamic' id='butn'>确定</a></span>
</dev>"
?>

<script>
    //分页
    $('#page_size').val(<?=$page_size?>);
    $('#butn').click(function () {
        var content=$('#content').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
         $(this).attr('href',href+'&page='+pages+'&content='+content+'&selecttime='+selecttime+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&per-page='+page_size+'&state='+state+'&real_search=1');
        var href2=$(this).attr('href');
//            alert(href2);
    });
    $(".pagination>li>a, .pagination>li>span").click(function(){
          var href=$(this).attr('href');
        $(this).attr('href',href+'&real_search=1')
          // real_search
    })

</script>