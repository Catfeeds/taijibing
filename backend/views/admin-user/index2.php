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
    <div class="wrapper wrapper-content">

        <?= Bar::widget([
            'template' => '{refresh} {create}'
        ])?>
<!--        {delete}-->
        <table class="table table-hover" style="background:white;">
            <thead>
            <th>序号</th>
            <th>登陆账号</th>
            <th>账户名称</th>
            <th>账户类型</th>
            <th>所在地区</th>
            <th>联系人</th>
            <th>联系电话</th>
            <th>邮箱</th>
            <th>创建时间</th>
            <th>最后更新</th>
            <th>操作</th>
            </thead>
            <tbody>
            <?php
            $str='';
            $no=1;
            foreach($model as $key=>$val)
            {
                $str.= "<tr>
                            <td>".$no."</td>
                            <td>".$val["LoginName"]."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["type"]."</td>
                            <td>".$val["Province"].'-'.$val["City"].'-'.$val["Area"]."</td>
                            <td>".$val["ContractUser"]."</td>
                            <td>".$val["ContractTel"]."</td>
                            <td>".$val["email"]."</td>
                            <td>".date('Y-m-d H:i:s',$val["created_at"])."</td>
                            <td>".date('Y-m-d H:i:s',$val["updated_at"])."</td>
                            <td>
                                <a href='./?r=admin-user/update&LoginName=".$val['LoginName']."'>编辑</a>
                                <a class='del' >删除<input type='hidden' value='".$val['LoginName']."'></a>
                            </td>
                         </tr>";
                $no++;
            }
            echo $str;
            ?>
            </tbody>
        </table>
        <table>

        </table>

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script>

    $('.del').click(function(){
        var LoginName=$(this).find('input').val();
        if(confirm("你确认要删除吗？")){
            var ii=layer.msg("操作中……");
            $.getJSON("/index.php?r=admin-user/delete&LoginName="+LoginName,function(data){

                layer.close(ii);
                if(data.state!=0){
                    layer.alert(data.desc);
                    return;
                }
                layer.alert("操作成功",function(){
                    window.location.reload(true);
                });
            });
        }else{
            return;
        }

    });

//            function del(LoginName){
//                alert(LoginName)
//                if(confirm("你确认要删除吗？")){
//                    var ii=layer.msg("操作中……");
//                    $.getJSON("/index.php?r=admin-user/delete&LoginName="+LoginName,function(data){
//
//                        layer.close(ii);
//                        if(data.state!=0){
//                            layer.alert(data.desc);
//                            return;
//                        }
//                        layer.alert("操作成功",function(){
//                            window.location.reload(true);
//                        });
//                    });
//                }else{
//                    return
//                }
//
//
//            }
            //    function updateWaterBrand(brandno){
            //       window.location.href="/index.php?r=water-brand/update&brandno="+brandno;
            //    }
</script>




    </div>

<?= LinkPager::widget(['pagination' => $pages]); ?>


