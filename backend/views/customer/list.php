<?php
use yii\widgets\LinkPager;
?>
<div class="wrapper wrapper-content">
    <div style="margin-bottom:10px;">
        <form action="/index.php?r=customer/list" method="post">
            <span><label>名称:</label><input type="text" placeholder="请输入名称" name="username" value="<?=$username?>"/></span>
            <span style="padding-left:10px;"><label>手机号:</label><input type="text" placeholder="请输入手机号" value="<?=$mobile?>" name="mobile"/></span>
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
            <th>序号</th>
            <th>登陆账号</th>
            <th>用户姓名</th>
            <th>手机号</th>
            <th>设备编号</th>
            <th>所在地区</th>
            <th>地址</th>
            <th>所属服务中心</th>
            <th>入网属性</th>
            <th>客户类型</th>
            <!--    <th>设备编号</th>-->
            <!--    <th>硬件手机号</th>-->
            <!--    <th>代理商</th>-->
            <!--    <th>激活时间</th>-->
            <th>最近操作时间</th>
            <th>操作详情</th>
            <th>管理</th>
            </thead>
            <tbody>
            <?php
            $str='';
            $no=1;
            foreach($model as $key=>$val)
            {
                $str.= "<tr>
                            <td>".$no."</td>
                            <td>".$val["Tel"]."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["Tel"]."</td>
                            <td>".$val["DevNo"]."</td>
                            <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                            <td>".$val["Address"]."</td>
                            <td>".$val["AgentName"]."</td>
                            <td>".$UserType[$val["UserType"]]."</td>
                            <td>".$CustomerType[$val["CustomerType"]]."</td>
                            <td>".$val["RowTime"]."</td>
                            <td><a href='./?r=customer/detail&id=".$val["Id"]."&DevNo=".$val["DevNo"]."'>详情</a></td>
                            <td><a href='./?r=customer/update&id=".$val["Id"]."'>修改</a>
                                <a class='del' id='".$val["Id"]."'  href='javascript:void(0);'>删除</a></td>
                        </tr>";
                $no++;
            }
            echo $str;
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
    </script>
    <script>
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