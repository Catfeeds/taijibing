    <?php
use yii\widgets\LinkPager;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/23
 * Time: 17:51
 */
use feehi\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\AdminRoles;
use feehi\widgets\Bar;

$assignment = function($url, $model){
    return Html::a('<i class="fa fa-tablet"></i> '.yii::t('app', 'Assign Roles'), Url::to(['assign','uid'=>$model['id']]), [
        'title' => 'assignment',
        'class' => 'btn btn-white btn-sm'
    ]);
};

$this->title = "Admin";

?>
 <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="/static/css/Common.css?v=1.1"/>

<style>
    td,th{
            text-align: center;
    }
    .layui-layer-title {
        display: none
    }
 .layui-layer-hui,.layui-layer-dialog .layui-layer-content,.layui-layer-btn{
        background-color: #000;color: #fff
 }

 	.btn-white{
		    display: initial;
	}
    .reset_password{
        margin-top: 10px;
    }

</style>

    <div class="wrapper wrapper-content">

        <form action="./?r=admin-user/index" method="post" style='padding-bottom: 20px'>
           <div style="margin-bottom:10px;    padding: 40px 15px;" class="condition">
            搜索内容：<input id="search" placeholder="请输入账号、名称或类型" value="<?=$content?>" type="text" name="content">

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

                <input type="submit" value="搜索"  style="	border:none !important;   background-color: #E46045;color:#fff;line-height: 0px;">
           </div>

            <?= Bar::widget([
            'template' => '{refresh} {create}'
             ])?>
        </form>


       
<!--        {delete}-->


           <div style="clear:both">
               
           </div>


        <table class="table table-hover" >
            <thead>
            <th  style="width: 4%">序号</th>
            <th  style="width: 8%">编号</th>
            <th>登陆账号</th>
            <th>账户名称</th>
            <th style="width: 9%">账户类型</th>
            <th  style="width: 9%">所在地区</th>
            <th>联系人</th>
            <th>联系电话</th>
            <th>邮箱</th>
            <th style="width: 5%">角色</th>
            <th><a id="sort" href="">创建时间</a></th>
            <th><a id="sort2" href="">最后更新</a></th>
            <th style="width: 4%">编辑</th>
            <th style="width: 6%">删除</th>
            <th style="width: 6%">重置密码</th>
            <?php
            if($role_id==1){
                echo '<th style="width: 6%">角色分配</th>';
            }
            ?>
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
                            <td>".$val["Number"]."</td>
                            <td>".$val["LoginName"]."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["type"]."</td>
                            <td>".$val["Province"].'-'.$val["City"].'-'.$val["Area"]."</td>
                            <td>".$val["ContractUser"]."</td>
                            <td>".$val["ContractTel"]."</td>
                            <td>".$val["email"]."</td>
                            <td>".$val["role_name"]."</td>
                            <td>".date('Y-m-d H:i:s',$val["created_at"])."</td>
                            <td>".date('Y-m-d H:i:s',$val["updated_at"])."</td>
                            <td><a href='./?r=admin-user/update&LoginName=".$val['LoginName']."'>
                               
                                    <img src='/static/images3/edit.png'>

                            </a></td>
                            <td> <a class='del' >
                               <img src='/static/images3/delete.png'>
                               <input type='hidden' value='".$val['LoginName']."'></a><br /></td>
                            <td><p class='reset_password' >
                                     <img src='/static/images3/Reset.png'>
                            <input type='hidden' value='".$val['LoginName']."'></p></td>
                                
                               
                                
                            <td>

                                <a href='./?r=auth-user/assign&uid=".$val['admin_id']."'>
                                    <img src='/static/images3/fenpei.png'>
                                </a>
                            </td>
                         </tr>";
                    $no++;
                }
                echo $str;
            }else{
                foreach($model as $key=>$val)
                {
                    $str.= "<tr>
                            <td>".$no."</td>
                            <td>".$val["Number"]."</td>
                            <td>".$val["LoginName"]."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["type"]."</td>
                            <td>".$val["Province"].'-'.$val["City"].'-'.$val["Area"]."</td>
                            <td>".$val["ContractUser"]."</td>
                            <td>".$val["ContractTel"]."</td>
                            <td>".$val["email"]."</td>
                            <td>".$val["role_name"]."</td>
                            <td>".date('Y-m-d H:i:s',$val["created_at"])."</td>
                            <td>".date('Y-m-d H:i:s',$val["updated_at"])."</td>
                            <td><a href='./?r=admin-user/update&LoginName=".$val['LoginName']."'>
                               
                                    <img src='/static/images3/edit.png'>

                            </a></td>
                            <td> <a class='del' >
                               <img src='/static/images3/delete.png'>
                               <input type='hidden' value='".$val['LoginName']."'></a><br /></td>
                            <td><p class='reset_password' >
                                     <img src='/static/images3/Reset.png'>
                            <input type='hidden' value='".$val['LoginName']."'></p></td>
                                
                               
                                
                          
                         </tr>";
                    $no++;
                }
                echo $str;
            }

            ?>
            </tbody>
        </table>
        <table>

        </table>

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js"></script>
<script>
    var data =<?=json_encode($address)?>;
    var province='<?=$province?>';
    var city='<?=$city?>';
    var area='<?=$area?>';
    var sort=<?=$sort?>;
    var sort2=<?=$sort2?>;
        var content ='<?=$content?>';

        var where_datas={
            province:province,
            city:city,
            area:area,
            content:content,
            sort2:sort2,
            sort:sort
        };


var url='';
// var result = JSON.stringify(where_datas)
for(var i in where_datas){
  if(where_datas[i]==null){
     where_datas[i]=''
  }
  url= url +"&"+ i+'='+where_datas[i]
}

$("a").click(function(){
    var _thisURl = $(this).attr('href');
      var Urlobj = encodeURIComponent(url);
    $(this).attr('href',_thisURl+"&Url="+Urlobj)
})

// 地址渲染 
addressResolve(data,province,city,area);

    //排序(创建时间)
    $('#sort').click(function(){
        sort++;

        var content=$('#search').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        $(this).attr('href','./?r=admin-user/index&sort='+sort+'&content='+content+'&province='+province+'&city='+city+'&area='+area);

    });
    //排序（最后更新）
    $('#sort2').click(function(){
        sort2++;

        var content=$('#search').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        $(this).attr('href','./?r=admin-user/index&sort2='+sort2+'&content='+content+'&province='+province+'&city='+city+'&area='+area);

    });


    $(function(){
        $('.pagination a').click(function(){

            var content=$('#search').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();
            var page_size=$('#page_size option:selected').val();

            var href=$(this).attr('href');

            $(this).attr('href',href+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&sort2='+sort2+'&per-page='+page_size);
//                var href2=$(this).attr('href');
//                alert(href2)
        });
    });






    $(function(){
        // initProvince();
        // initListener();
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







    //重置密码
    $('.reset_password').click(function(){
        var Name=$(this).find('input').val();


                //信息框
                layer.msg('你确定要重置密码吗？重置后密码将变为123456', {
                  time: 0 //不自动关闭
                   ,btn: ['确定', '取消']
                  ,yes: function(index){
                    var ii=layer.msg("操作中……");
                            $.getJSON("/index.php?r=admin-user/reset-password&LoginName="+Name,function(data){

                                layer.close(ii);
                                if(data.state!=0){
                                    layer.msg(data.desc);
                                  
                //                    alert(data.desc);
                                    return;
                                }

                                layer.alert(data.desc,function(){

                                    window.location.reload(true);
                                });


                            });

                    layer.close(index);
                  }
                });
});






    $('.del').click(function(){
        var LoginName=$(this).find('input').val();
//信息框-例2
layer.msg('    <div style="padding:50px;    font-size: 25px;">你确认要删除吗？</div>', {
  time: 0 //不自动关闭
   ,btn: ['确定', '取消']
  ,yes: function(index){
   var ii=layer.msg("操作中……");
            $.getJSON("/index.php?r=admin-user/delete&LoginName="+LoginName,function(data) {

                layer.close(ii);
                if (data.state != 0) {
                    layer.alert(data.desc);
                    return;
                }
                layer.alert("操作成功", function () {
                    window.location.reload(true);

                });
            });

    layer.close(index);
  }
});

    })

</script>




    </div>

<?php
echo "";
echo "<dev style='float:left;margin-bottom: 152px;margin-left: 50px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=admin-user/index' id='butn'>确定</a></span>
</dev>"

?>
<script>

    $('#page_size').val(<?=$page_size?>);
        $('#page_size').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#butn').click(function (){
        var content=$('#search').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&sort2='+sort2);
        var href2=$(this).attr('href');
//            alert(href2);

    });

</script>


