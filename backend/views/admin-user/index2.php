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
        <?= $this->render('/widgets/_ibox-title') ?>
        <?= Bar::widget([
            'template' => '{refresh} {create}'
        ])?>
<!--        {delete}-->
        <table class="table table-hover" style="background:white;">
            <thead>
            <th>平台Id</th>
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
            foreach($model as $key=>$val)
            {
                $str.= "<tr>
                            <td>".$val["id"]."</td>
                            <td>".$val["username"]."</td>
                            <td>".$val["name"]."</td>
                            <td>".$val["type"]."</td>
                            <td>".$val["province"].$val["city"].$val["area"]."</td>
                            <td>".$val["contacts"]."</td>
                            <td>".$val["tel"]."</td>
                            <td>".$val["email"]."</td>
                            <td>".$val["created_at"]."</td>
                            <td>".$val["updated_at"]."</td>
                            <td>
                                <a href='./?r=admin-user/update&id=".$val['id']."'>编辑</a>
                                <a onclick='del(".$val['id'].")'>删除</a>
                            </td>
                         </tr>";
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
            function del(id){
                if(confirm("你确认要删除吗？")){
                    var ii=layer.msg("操作中……");
                    $.getJSON("/index.php?r=admin-user/delete&id="+id,function(data){

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
                    return
                }


            }
            //    function updateWaterBrand(brandno){
            //       window.location.href="/index.php?r=water-brand/update&brandno="+brandno;
            //    }
</script>




    </div>

<?= LinkPager::widget(['pagination' => $pages]); ?>


