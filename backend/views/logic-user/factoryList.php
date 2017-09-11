<?php
use yii\widgets\LinkPager;
error_reporting( E_ALL&~E_NOTICE );
?>
    <div class="wrapper wrapper-content">
        <div style="margin-bottom:10px;">
            <form action="/index.php?r=logic-user/factory-list" method="post">
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
            <th>登录名称</th>
            <th>名称</th>
            <th>地址</th>
            <th>所在地区</th>
            <th>联系人</th>
            <th>手机号</th>
            <th>条码余数</th>
            <th>厂家代码(数字代号)</th>
            <th>最近操作时间</th>
            <th>明细</th>
            <th>操作</th>
            </thead>
            <tbody>
            <?php
            $str='';
            $no=1;
//            var_dump($BrandName);
            foreach($model as $key=>$val)
            {

                $str.= "<tr>
                        <td>".$no."</td>
                        <td>".$val["LoginName"]."</td>
                        <td>".$val["Name"]."</td>
                        <td>".$val["Address"]."</td>
                        <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                        <td>".$val["ContractUser"]."</td>
                        <td>".$val["ContractTel"]."</td>
                        <td>".$BrandName[$val["Id"]].'&nbsp;'.$LeftAmount[$val["Id"]]."</td>
                         <td>".$val["PreCode"]."</td>
                        <td>".$val["RowTime"]."</td>
                        <td><a href='/index.php?r=recharge/list&pid=".$val["Id"]."'>条码充值记录</a>&nbsp;&nbsp;<a href='/index.php?r=saoma/flist&waterfname=".$val["Name"]."'>条码使用记录</a></td>
                        <td><a href='./?r=factory/update&id=".$val["Id"]."'>修改</a>&nbsp;&nbsp;<a href='./?r=recharge/create&fid=".$val["Id"]."'>充值</a></td>
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