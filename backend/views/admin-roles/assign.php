<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 16/4/11
 * Time: 22:34
 */
use feehi\widgets\ActiveForm;
use feehi\widgets\JsBlock;
use feehi\assets\JstreeAsset;

JstreeAsset::register($this);

$this->title = "Assign Permission";
?>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<style>.hide{display: none}</style>
<div class="col-sm-12">
    <div class="ibox">
        <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['admin-roles/index'],['class'=>'btn btn-primary'])?></div>
        <div class="ibox-content">
            <div class="row text-center"><span style="font-weight: bold;"><?=$role_name?></span></div>
            <div id="permission-tree"></div>
            <div class="hr-line-dashed"></div>
            <?php $form = ActiveForm::begin()?>
            <?= $form->defaultButtons()?>
            <?php ActiveForm::end()?>
        </div>
    </div>
</div>
<?php JsBlock::begin() ?>

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script>
        $(function() {

            $('#permission-tree').jstree({
                'core' : {
                    'data' : <?=$treeJson?>
                },
                "plugins" : ["checkbox"]
            });
            $("form").on('submit', function (e) {
                e.preventDefault();
                var idArr = $('#permission-tree').jstree().get_checked();
                var ids = idArr.join(',');
                $("form").append("<input type='hidden' name='ids' value='"+ids+"'>");
                $.ajax({
                    url : $('form').attr('action'),
                    method : "post",
                    data : $('form').serialize(),
                }).always(function(){
                    location.reload();
                });
            });
        });     
    </script>
