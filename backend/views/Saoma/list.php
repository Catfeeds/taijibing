<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="/static/css/Common.css?v=1.1"/>

    <style type="text/css">
    input[type="radio"] {
 
  /*display: none;*/
}
.radiotitle{
    width:30px;
    height:30px;
    background-color: #00f
 }
 #dvCBs label{
  position: relative;
  margin-left: 35px;
 }
#dvCBs .radio-title{
 
      display: inline-block;
    padding: 10px;
    background-color: #2D3136;
    border-radius: 25px;
    position: absolute;
    top: -2px;
    left: -35px;
 
     /*   height: 20px;line-height: 20px;
        text-indent:20px;*/
}

#method{
      width: 150px;
    height: 50px;
    display: inline-block;
    padding: 10px;
    margin-top: -40px;
    line-height: 40px;
    
}

#method a{
	    color: #fff;
    display: block;
    height: 30px;
    margin-top: 10px;
    line-height: 30px;

    padding: 0 5px;
      text-decoration: none;
         text-align: center;

}

#method a:hover{
	background-color: #292834;
	text-decoration:none;


};



	.boootn{
	width:10px;
	display: inline-block;
	height:10px;
	border-radius:50px;
	background-color:#fff;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
	border:none;
	}

	.table td:first-child {
	border-left: 2px solid rgb(233,233,233);
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
    <div style="margin-bottom:10px;position:relative" class="condition ">
        <form method="post" action="/index.php?r=saoma/list">
<!--        <span><label>水厂:</label><input type="text" placeholder="请输入水厂名称" name="waterfname" value="--><?//=$waterfname?><!--"/></span>-->
<!--        <span style="padding-left:10px;"><label>县区运营中心:</label><input type="text" placeholder="请输入水厂名称" name="xname" value="--><?//=$xname?><!--"/></span>-->
<!--        <span style="padding-left:10px;"><label>社区服务中心:</label><input type="text" placeholder="请输入水厂名称" name="sname" value="--><?//=$sname?><!--"/></span>-->
        <span style="padding-left:10px;"><label>搜索内容:</label><input type="text" placeholder="请输入关键词" id="content" name="content" value="<?=$content?>"/></span>
        <span style="padding-left:10px;margin-top: 10px;"><label>时间段:</label><input type="text" placeholder="选择时间" readonly  unselectable="on"  name="selecttime" id="selecttime" /></span>

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



<!-- 
            <div style="display:inline-block ; margin-left: 1%;">



	                        <label>地区:</label>
	                      <div class="wrap_line">
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
                    <div class="submitBtn"  style='display: inline-block; float: right;' >
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input style="padding:2px 10px;border: none;" type="submit" value="查询" id="btn"/>
                        &nbsp;&nbsp;
                        <button type="text" style="    background-color: #E46045;    color: #fff;    margin-top: -3px;height: 30px;" class="btn" id="removerSub">清空条件</button>
                        </div>
	           </div>
          

        
	       <div style='margin-left: 5px;margin-top:15px; margin-right: 5%;'>
                  <label>设备状态:</label>
               <select class="control-label" name="state" id="state">
                    <option value="1" selected>正常设备</option>
                    <option value="2">初始化设备</option>
                    <option value="3">未登记设备</option>

                </select>   


            </div> -->






        </form>

       <div  id="method"  class="pull-right">


           <a href="?r=saoma/detail&excel=xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz&per-page=<?=$total?>">
               <img src="/static/images3/biao.png" alt="">&nbsp;&nbsp;&nbsp;导出表格
            </a>
      </div>
      <div	style='position:absolute;width:100%;left:0;background-color: #393e45;height: 12px;bottom: -11px;'> </div>
    </div>
        <table class="table table-hover">
            <thead style='    border-spacing: 0px ;'>
            <th style="width: 5%">序号</th>
            <th style="width: 9%">水厂条码</th>
            <th style="width: 8%">设备编号</th>
            <th style="width: 8%">ICCID</th>
            <!-- <th style="width: 80px">设备厂家</th>-->
            <th style="width: 9%">设备投资商</th>
            <th style="width: 8%">运营中心</th>
            <th style="width: 8%">服务中心</th>
            <th style="width: 8%">所在区域</th>
            <th style="width: 12%">位置信息</th>
            <th style="width: 8%">用户姓名</th>
            <th style="width: 8%">手机号</th>
            <!--            <th>水厂</th>  <td>".$val["factoryName"]."</td>-->
            <th style="width: 9%"><a id="sort" href="">最近扫码时间</a></th>
            <th style="width: 8%">历史扫码</th>
            </thead>
            <tbody>
            <?php
            $str='';
            $no=1;
            foreach($model as $key=>$val)
            {
                $str.= "<tr ".(in_array($val['DevNo'],$users_of_init)?"date = 1":'').">
                            <td><p>".$no."</p></td>
                            <td><p>".$val["BarCode"]."</p></td>
                            <td><p>".$val["DevNo"]."</p></td>
                            <td><p>".$val["Iccid"]."</p></td>
                            <td><p>".$val["investor"]."</p></td>
                            <td><p>".$val["agentpname"]."</p></td>
                            <td><p>".$val["agentname"]."</p></td>
                            <td><p>".$val["Province"]."-".$val["City"]."-".$val["Area"]."</p></td>
                            <td><p>".$val["Address"]."</p></td>
                            <td><p>".$val["Name"]."</p></td>
                            <td><p>".$val["Tel"]."</p></td>
                            <td><p>".$val["RowTime"]."</p></td>
                            <th><p><a href='./?r=saoma/detail&DevNo=".$val["DevNo"]."'>详情</a></p></th>
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

<style type="text/css">
 

</style>


<?php
echo "";

echo "<dev style='float:left;margin-top: 22px;margin-left: 50px;padding-bottom: 50px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;border:none;padding:5px;border-radius:2px'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
<span style='margin-left: 0px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>跳转到：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=saoma/list' id='butn'>确定</a></span>
</dev>"

?>



<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>
<script type="text/javascript" src="/static/js/Common2.js?v=4"></script>
    <script>
        var data=<?=json_encode($areas)?>;
        var province=<?=json_encode($province)?>;
        var city=<?=json_encode($city)?>;
        var area=<?=json_encode($area)?>;
//        var areas=<?//=json_encode($areas)?>//;
 
    var sort=<?=$sort?>;
     var total=<?=$total?>;
    var state='<?=$state?>';
 var state=<?=$state?>;

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

    </script>
<script type="text/javascript">

$(function(){

$("#removerSub").click(function(event) {
    /* Act on the event */
    $("#content").val('')
    $("#selecttime").val('')
});

    $(".table tbody").children("tr").each(function(index){
        if( $(this).attr("date")==1){
                    var t = $(this).offset().top + $(this).height()/2;//1、获得对应行，第一列相对于浏览器顶部的位移
                    var l = $(this).offset().left;//2、获得对应行，第一列相对于浏览器左侧的位移
                    var w = $(this).width();//3、获得对应行的宽度 
                  //   $(this).after("<div style='outline:#BABABF solid 1px; position:absolute;top:" + t+ "px;width:" + w + "px;'></div>")
                 $( 'p',  this).css({'borderBottom':'1px solid #49CECF','display':'inlineBlock',' paddingBottom':'10px','color':'#49CECF',"textAlign":'center'})
                $( 'td:first-child',  this).css('borderLeft', '3px solid #49CECF')
        }
    })

})




    //排序
    $('#sort').click(function(){
        sort++;
        var content=$('#content').val();
        var selecttime=$('#selecttime').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        $(this).attr('href','./?r=saoma/list&sort='+sort+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&selecttime='+selecttime+'&state='+state+'&real_search=1');
    });

    $(function(){
        $('.pagination a').click(function(){
            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();
            var page_size=$('#page_size option:selected').val();

            var href=$(this).attr('href');

            $(this).attr('href',href+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&selecttime='+selecttime+'&per-page='+page_size+'&state='+state+'&real_search=1');
//                var href2=$(this).attr('href');
//                alert(href2)
        });
    });



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
     $(this).attr('href','index.php?r=saoma/detail&excel=xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz&per-page=<?=$total?>&selecttime='+selecttime+'&province='+provincese+'&city='+cityse+'&area='+arease+'&content='+contentse);
    })



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

</div>


<script>
    //分页
    $('#page_size').val(<?=$page_size?>);
    $('#butn').click(function () {
        var content=$('#content').val();
        var selecttime=$('#selecttime').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();
        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
        //判断输入页数是否大于总页数
        var totalpage=Math.ceil(<?=$pages->totalCount?>);
        if(pages>totalpage){
            pages=totalpage
        }
        var href=$(this).attr('href');
         $(this).attr('href',href+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&selecttime='+selecttime+'&per-page='+page_size+'&state='+state+'&real_search=1');
        
        var href2=$(this).attr('href');
//            alert(href2);


    $(".pagination>li>a, .pagination>li>span").click(function(){
          var href=$(this).attr('href');
        $(this).attr('href',href+'&real_search=1')
          // real_search
    })

    });
</script>