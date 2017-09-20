<?php
use yii\widgets\LinkPager;
?>
<div class="wrapper wrapper-content">
    <div style="margin-bottom:10px;">
        <form action="/index.php?r=customer/list" method="post">
<!--            <span><label>名称:</label><input type="text" placeholder="请输入名称" name="username" value="--><?//=$username?><!--"/></span>-->
<!--            <span style="padding-left:10px;"><label>手机号:</label><input type="text" placeholder="请输入手机号" value="--><?//=$mobile?><!--" name="mobile"/></span>-->
            <span style="padding-left:10px;"><label>搜索内容:</label><input type="text" id="content" placeholder="请输入关键字" value="<?=$content?>" name="content"/></span>
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
            <input type="submit" class="btn" value="查询"  style="background:#5f97ff;color:white;height:26px;line-height:14px;padding-left:10px;"/>
        </form>
    </div>
        <table class="table table-hover" style="background:white;">
            <thead>
            <th style="width: 5%">序号</th>
<!--            <th>登陆账号</th>-->
            <th  style="width: 8%">用户姓名</th>
            <th style="width: 8%">手机号</th>
            <th style="width: 8%">设备编号</th>
            <th  style="width: 9%">所在地区</th>
            <th s style="width: 11%">地址</th>
            <th  style="width: 10%">所属服务中心</th>
            <th style="width: 8%">入网属性</th>
            <th style="width: 8%">客户类型</th>
            <!--    <th>设备编号</th>-->
            <!--    <th>硬件手机号</th>-->
            <!--    <th>代理商</th>-->
            <!--    <th>激活时间</th>-->

            <?= $role_id==1?'<th  style="width: 10%">最近操作时间</th>':''?>
            <?= $role_id==1?'<th style="width: 8%">操作详情</th>':''?>
            <?= $role_id==1?'<th style="width: 7%">管理</th>':''?>
            </thead>
            <tbody>
            <?php

            $str='';
            $no=1;
            if($role_id==1){
                foreach($model as $key=>$val)
                {
                    $str.= "<tr>
                            <td>".$no."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["Tel"]."</td>
                            <td>".$val["DevNo"]."</td>
                            <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                            <td>".$val["Address"]."</td>
                            <td>".$val["AgentName"]."</td>
                            <td>".$UserType[$val["UseType"]]."</td>
                            <td>".$CustomerType[$val["CustomerType"]]."</td>
                            <td>".$val["RowTime"]."</td>
                            <td><a href='./?r=customer/detail&id=".$val["Id"]."&DevNo=".$val["DevNo"]."'>详情</a></td>
                            <td><a href='./?r=customer/update&id=".$val["Id"]."&devno=".$val["DevNo"]."'>修改</a>
                        </tr>";//<a class='del' id='".$val["Id"]."'  href='javascript:void(0);'>删除</a></td>
                    $no++;
                }
                echo $str;
            }else{
                foreach($model as $key=>$val)
                {
                    $str.= "<tr>
                            <td>".$no."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["Tel"]."</td>
                            <td>".$val["DevNo"]."</td>
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
    <script>
        var data =<?=json_encode($address)?>;
        var province='<?=$province?>';
        var city='<?=$city?>';
        var area='<?=$area?>';
        var usetype ='<?=$usetype?>';
        var customertype ='<?=$customertype?>';

    </script>
    <script>



        $(function(){
            $('.pagination a').click(function(){

                var content=$('#content').val();
                var usetype=$('#usetype option:selected').val();
                var customertype=$('#customertype option:selected').val();
                var province=$('#province option:selected').val();
                var city=$('#city option:selected').val();
                var area=$('#area option:selected').val();

                var href=$(this).attr('href');

                $(this).attr('href',href+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area);
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
        }
        function initCityOnProvinceChange() {
            var pid = getAddressIdByName($("#province").val());
            $("#city").empty();
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

<?= LinkPager::widget(['pagination' => $pages]); ?>