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
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
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




  #dvCBs{
 
      width: 100%;
      margin:0 auto;
      padding-left:5px;    display: inline;
  }
  
   #dvCBs .radio_btn{
     background: #2D3136;
     display: inline-block;
     width: 30px;
     height: 30px;
     border-radius: 30px;
     position: relative;
     vertical-align: middle;
     margin-top: -20px;
  }
    #dvCBs input{
     width: 100%;
     height: 100%;
     position: absolute;
     top: 0;
     left: 0;
     z-index: 100;
     opacity: 0;
  }
    #dvCBs span{
     background: #EE5030;
     width: 10px;
     height: 10px;
    display: inline-block;
     position: absolute;
     z-index: 1;
     top: 10px;
     left: 10px;
     border-radius: 10px;
  }
   #dvCBs input[type="radio"] + span{
     opacity: 0;
  }
  #dvCBs input[type="radio"]:checked + span{
     opacity: 1;

  }
  #dvCBs label {
    position: relative;
    margin-left: 15px;
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
</style>





<div class="wrapper wrapper-content">
        <div class="form-group " >
            <div class="condition" style="height: 120px;">
            <form action="/index.php?r=dev-manager/dynamic" method="post">
            <div class="col-sm-12" style="margin-bottom:20px;">
<!--               <span><label>设备手机号:</label> <input name="tel" type="text" id="tel" placeholder="设备手机号" value="--><?//=$tel?><!--"/></span>-->
                <span style="padding-left:5px; display:inline-block"><label>搜索内容:</label><input name="content" type="text"  id="content" placeholder="设备编号或用户" value="<?=$content?>"/></span>
                 <span style="padding-left:5px;margin-top: 10px;display:inline-block">
                     <span style="padding-left:10px;margin-top: 10px;"><label>时间段:</label><input type="text" placeholder="选择时间" name="selecttime"  readonly  unselectable="on"  id="selecttime" /></span>
                <label>地区:</label>
                 <select class="control-label" name="province"  id="province">
                     <option value="">请选择</option>
                 </select>
                 <select class="control-label" name="city" id="city">
                    <option value="">请选择</option>
                </select>
                <select class="control-label" name="area" id="area">
                    <option value="">请选择</option>
                </select>

        </span>  
                   <input type="submit" class="btn" value="查询" id="btn" style="height:26px;line-height:14px;width:75px"/>
 

            <br/>
            <br/>

		             <div id="dvCBs"  style="">
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
             
            </div>
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
        <th style="width: 100px"><a id="sort" href="">最近操作时间</a></th>
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
                        <td><p>".(getActType($val["ActType"]))."</p></td>              
                        <td><p>".(empty($val["WaterUse"])?"——":$val["WaterUse"])."</p></td>
                        <td><p>".(empty($val["VlNum"])?"——":round($val["VlNum"] ,2))."</p></td>
                        <td><p>".(empty($val["Dts2"])?"——":$val["Dts2"])."</p></td>
                        <td><p>".($val["Degrees"]==0.00?"——":$val["Degrees"])."</p></td>
                        <td><p>".($val["Province"].'-'.$val["City"].'-'.$val["Area"])."</p></td>
                        <td><p>".$val["Address"]."(".$val["Lat"].",".$val["Lng"].")</p></td>
                        <td><p>".$val["UserName"]."</p></td>
                        <td><p>".$val["Tel"]."</p></td>
                        <td><p>".$val["ActTime"]."</p></td>
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
 

</script>
<script>
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
   layer.close(ii)

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

  
     $(this).attr('href','index.php?r=dev-manager/detail&excel=xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz&per-page=<?=$total?>&selecttime='+selecttime+'&province='+provincese+'&city='+cityse+'&area='+arease+'&content='+contentse);
    })

    
});

    initProvince();
    initListener();
    initAddress();
    //排序
    $('#sort').click(function(){
        sort++;
        var content=$('#content').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();
        $(this).attr('href','./?r=dev-manager/dynamic&sort='+sort+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&state='+state);

    });

    $(function(){
        $('.pagination a').click(function(){

            var content=$('#content').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();
            var page_size=$('#page_size option:selected').val();

            var href=$(this).attr('href');

            $(this).attr('href',href+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&per-page='+page_size+'&state='+state);

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
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px;height:100px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
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
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&state='+state);
        var href2=$(this).attr('href');
//            alert(href2);

    });
</script>