<?php
use yii\widgets\LinkPager;
?>
    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
   <style type="text/css" media="screen">
   	  td, td:hover{
     color: inherit;
   	  }
   	  #dvCBs  input{
	display:none;
}
.state + label{
    background-color: #2d3136;
    border-radius: 5px;
 
    width:20px;
    height:20px;
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    line-height: 20px;
    border-radius:2px;
}
.state:checked + label{
    background-color: #e46045;
    border-radius:2px;
}
.state:checked + label:after{
    content:"\2714";
    font-weight:400;
}
.boootn{
   width:10px;
   display: inline-block;
   height:10px;
   border-radius:50px;
   background-color:#fff;
}
.table > thead > tr > th, .table > tbody > tr > td {
    border: none;
    text-align: center;
    color: inherit;
    vertical-align: middle;
}
   </style>
<div class="wrapper wrapper-content">
    <div style="margin-bottom:10px;" class='condition'>
        <form action="/index.php?r=customer/list" method="post">
<!--            <span><label>名称:</label><input type="text" placeholder="请输入名称" name="username" value="--><?//=$username?><!--"/></span>-->
<!--            <span style="padding-left:10px;"><label>手机号:</label><input type="text" placeholder="请输入手机号" value="--><?//=$mobile?><!--" name="mobile"/></span>-->
            <span style="padding-left:10px;"><label>搜索内容:</label><input type="text" id="content" placeholder="请输入关键字" value="<?=$content?>" name="content"/></span>
            <div style="display:none">
             <label style="padding-left:10px;">入网属性:</label>
            <select class="control-label" name="usetype"  id="usetype">
                <option value="" selected>请选择</option>
                <option value="1" >自购</option>
                <option value="2" >押金</option>
                <option value="3" >买水送机</option>
                <option value="4" >买机送水</option>
                <option value="5" >免费</option>
                <option value="99" >其他</option>
            </select>
            <label style="padding-left:10px;">客户类型:</label>
            <select class="control-label" name="customertype"  id="customertype">
                <option value="" selected>请选择</option>
                <option value="1" >家庭</option>
                <option value="2" >公司</option>
                <option value="3" >集团</option>
                <option value="99" >其他</option>
            </select>	
            </div>
            <label style="padding-left:10px;">地区:</label>
            <select class="control-label" name="province"  id="province">
                <option value="" selected>请选择</option>
            </select>
            <select class="control-label" name="city" id="city">
                <option value="">请选择</option>
            </select>
            <select class="control-label" name="area" id="area">
                <option value="">请选择</option>
            </select>
              <input type="submit" class="btn" value="查询"  style="background: #e46045; color: white;height: 26px;line-height: 14px;padding-left: 10px;margin-top: -5px;    border: none;"/>
              <br/>
       
          <!--  <div style='margin-left: 5px;margin-top:15px; margin-right: 5%;'>
                  <label>设备状态:</label>
                   <select class="control-label" name="state" id="state">
                        <option value="1" selected>正常设备</option>
                        <option value="2">初始化设备</option>
                        <option value="3">未登记设备</option>
                        <option value="">全部用户</option>
                    </select>               
            </div> -->
             <div id="dvCBs"  style="padding-left:5px;  margin-top: 25px;">
                
                 <input type="checkbox" name="state1" value="1"  id="state1" class='state' / >
    			 <label for="state1"></label>
    			 <span>	正常用户</span>
				 <input type="checkbox" name="state2" value="1"  id="state2" class='state'/>
                 <label  for="state2"></label>
                  已登记用户
                 <input type="checkbox" name="state3" value="1"  id="state3" class='state'/>
                 <label  for="state3"></label>
                  初始化用户
           &nbsp;
           &nbsp;
           &nbsp;
           &nbsp;
                  <span style="font-weight: bold;">（此选项为复选项 ,  同时满足多个条件筛选  注释：
                    	<span class='boootn'></span>正常用户 &nbsp; 
                    	<span class='boootn' style='background-color: red;'></span>已登记用户 &nbsp; 
                  	 <span style="width: 50px;height:1px;text-decoration:line-through;">&nbsp;&nbsp;&nbsp;</span>
                  	&nbsp;初始化用户 ）
                  </span>
            </div>

          
        </form>
    </div>
        <table class="table table-hover" >
            <thead>
            <th style="width: 5%">序号</th>
            <!--            <th>登陆账号</th>-->
            <th  style="width: 8%">用户姓名</th>
            <th style="width: 8%">手机号</th>
            <th style="width: 8%">设备编号</th>
            <th style="width: 8%">设备商品型号</th>
            <th style="width: 8%">设备品牌</th>
            <th  style="width: 9%">所在地区</th>
            <th s style="width: 11%">地址</th>
            <th  style="width: 10%">所属服务中心</th>
            <th style="width: 8%">入网属性</th>
            <th style="width: 8%">客户类型</th>
            <!--    <th>设备编号</th>-->
            <!--    <th>硬件手机号</th>-->
            <!--    <th>代理商</th>-->
            <!--    <th>激活时间</th>-->

            <?= $role_id==1?"<th  style='width: 10%'><a id='sort' hreg=''>登记时间</a></th>":''?>
            <?= $role_id==1?'<th style="width: 8%">操作详情</th>':''?>
            <?= $role_id==1?'<th style="width: 7%">管理</th>':''?>
            </thead>
            <tbody>
            <tbody>
            <?php

            $str='';
            $no=1;
            if($role_id==1){
                foreach($model as $key=>$val)
                {
                    $str.= "<tr ".(in_array($val['DevNo'],$users_of_init)?"date = '1'":'')."".(($val['IsActive']==0&&!in_array($val['DevNo'],$users_of_init))?"style='color: red;'":'').">
                            <td>".$no."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["Tel"]."</td>
                            <td>".$val["DevNo"]."</td>
                            <td>".$val["goodsname"]."</td>
                            <td>".$val["BrandName"]."</td>
                            <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                            <td>".$val["Address"]."</td>
                            <td>".$val["AgentName"]."</td>
                            <td>".$UserType[$val["UseType"]]."</td>
                            <td>".$CustomerType[$val["CustomerType"]]."</td>
                            <td>".$val["RowTime"]."</td>
                            <td><a href='./?r=customer/detail&id=".$val["Id"]."&DevNo=".$val["DevNo"]."'>详情</a></td>
                            <td>".(in_array($val['DevNo'],$users_of_init)?"修改":"<a href='./?r=customer/update&id={$val['Id']}&devno={$val['DevNo']}'>修改</a>")."</td>
                        </tr>";//<a class='del' id='".$val["Id"]."'  href='javascript:void(0);'>删除</a></td>
                    $no++;
                }
                echo $str;
            }else{
                foreach($model as $key=>$val)
                {
                    $str.= "<tr ".(in_array($val['DevNo'],$users_of_init)?"date = '1'":'')." ".($val['IsActive']==0?"style='color: red;'":'').">
                            <td>".$no."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["Tel"]."</td>
                            <td>".$val["DevNo"]."</td>
                            <td>".$val["goodsname"]."</td>
                            <td>".$val["BrandName"]."</td>
                            <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                            <td>".$val["Address"]."</td>
                            <td>".$val["AgentName"]."</td>
                            <td>".$UserType[$val["UseType"]]."</td>
                            <td>".$CustomerType[$val["CustomerType"]]."</td>

                        </tr>";
                    $no++;
                }
                echo $str;
            }

            ?>
            </tbody>
        </table>



</div>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/Common2.js?v=4"></script>
    <script>
        var data =<?=json_encode($address)?>;
        var province='<?=$province?>';
        var city='<?=$city?>';
        var area='<?=$area?>';
        var usetype ='<?=$usetype?>';
        var customertype ='<?=$customertype?>';
        var sort=<?=$sort?>;

         var state1='<?=$state1?>';
         var state2='<?=$state2?>';
         var state3='<?=$state3?>';

         console.log(state1)
         console.log(state2)
         console.log(state3)
         console.log(sort)
    </script>
    <script>
$(function(){
    $(".table tbody").children("tr").each(function(index){
        if( $(this).attr("date")==1){
            // $(this).parent().parent().line();
             $(this).children().attr("disabled", "disabled").children().attr("disabled", "disabled");
                    var t = $(this).offset().top + $(this).height()/2;//1、获得对应行，第一列相对于浏览器顶部的位移
                    var l = $(this).offset().left;//2、获得对应行，第一列相对于浏览器左侧的位移
                    var w = $(this).width();//3、获得对应行的宽度 
                   
                     $(this).after("<div style='outline:#BABABF solid 1px; position:absolute; left:" + l + "px;top:" + t + "px;width:" + w + "px;'></div>");//4
        }
    })
})

// 地址渲染 
addressResolve(data,province,city,area);
        //排序
        $('#sort').click(function(){
            sort++;
            var content=$('#content').val();
            var usetype=$('#usetype option:selected').val();
            var customertype=$('#customertype option:selected').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();

            $(this).attr('href','./?r=customer/list&sort='+sort+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&state1='+state1+'&state2='+state2+'&state3='+state3);
//            alert($(this).attr('href'));

        });



        $(function(){
            $('.pagination a').click(function(){

                var content=$('#content').val();
                var usetype=$('#usetype option:selected').val();
                var customertype=$('#customertype option:selected').val();
                var province=$('#province option:selected').val();
                var city=$('#city option:selected').val();
                var area=$('#area option:selected').val();

                var page_size=$('#page_size option:selected').val();
                var href=$(this).attr('href');


                $(this).attr('href',href+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&per-page='+page_size+'&state1='+state1+'&state2='+state2+'&state3='+state3);
//                var href2=$(this).attr('href');
//                alert(href2)
            });
        });





        $('#usetype').val(usetype);
        $('#customertype').val(customertype);
        //删除时弹框提示
        var id='';
        $('.del').click(function(){
            var r = confirm("确定删除吗？");
            if (r == true) {
                id=$(this).attr('id');

                $.get('./?r=customer/delete&id='+id,function(data){

                })

            } else {

            }
        }) ;





            $(function(){
            initProvince();
            initListener();
            initAddress();
        });
        function initAddress() {
            $("#province").val(province);
            initCityOnProvinceChange();
            $("#city").val(city);
            initThree();
            $("#area").val(area);
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
            $("#queryBtn").on("click",function(){
                query();
            });
    if(state1){
        $("#state1").attr("checked",state1)
    }else{
        $("#state1").attr("checked",false)
    }
    if(state2){
         $("#state2").attr("checked",state2);
    }else{
        $("#state2").attr("checked",false)
    }
    if(state3){
         $("#state3").attr("checked",state3);
    }else{
        $("#state3").attr("checked",false)
    }   


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
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px;height:100px; padding-bottom: 150px;'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=customer/list' id='butn'>确定</a></span>
</dev>"

?>
<script>

    $('#page_size').val(<?=$page_size?>);
        $('#page_size').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#butn').click(function () {
        var content=$('#content').val();
        var usetype=$('#usetype option:selected').val();
        var customertype=$('#customertype option:selected').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&state1='+state1+'&state2='+state2+'&state3='+state3);
        var href2=$(this).attr('href');
//            alert(href2);

    });

</script>