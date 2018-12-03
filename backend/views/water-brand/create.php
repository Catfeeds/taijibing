<?php
///**
// * Created by PhpStorm.
// * User: Administrator
// * Date: 2016/3/23
// * Time: 15:47
// */
//
//=$this->render('_form', [
//    'model' => $model,
//]);?>
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */
use feehi\widgets\ActiveForm;

$this->title = '商品';
?>

            <!DOCTYPE html>
            <html style="overflow-x:hidden;overflow-y:hidden;">
            <head lang="en">
                <meta charset="UTF-8">

                <meta http-equiv="X-UA-Compatible"content="IE=9; IE=8; IE=7; IE=EDGE">
                <link rel="stylesheet" href="./static/js/zui/css/zui.css"/>
                <link rel="stylesheet" href="./static/js/zui/css/style.css"/>
                <link rel="stylesheet" href="./static/css/addgood.css"/>
                <link rel="stylesheet" href="./static/js/jedate/skin/jedate.css"/>

                <link rel="stylesheet" href="./static/js/datepicker/dateRange.css"/>

                <link rel="stylesheet" href="./static/js/page/jquery.pagination.css"/>
                   <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
                <style>
                    body{
                        height:100%;
                        width:100%;
                        overflow:auto;
                    }
                </style>
            </head>
            <body>
            <div class="col-sm-12">
                <div class="ibox">

                    <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['water-brand/list'],['class'=>'btn btn-info'])?></div>
                    <div class="ibox-content">

                        <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>

                        <?= $form->field($goods, 'name',['options'=>['class'=>'col-md-7']])->textInput(['maxlength' => 64]) ?>

                        <?= $form->field($goods, 'brand_id',['options'=>['class'=>'col-md-7']])->dropDownList(\yii\helpers\ArrayHelper::map($waterbrand,'BrandNo','BrandName'),['prompt' => '请选择']) ?>
<!--                        <input type="button" value="添加品牌" style="margin-top: 45px">-->
                        <div style="padding-top: 45px"><a href="./?r=water-brand/add">添加品牌</a></div>
        
                        <div style="margin-top: 20px;margin-left: 35px;float: left;">
                            <span style="font-size: 13px;font-weight:bold">商品容量</span>
                            <label style="margin-left: 50px"><input type="radio" name="Goods[volume]" <?= $volume==7.5? 'checked':''?> value="7.5" />7.5L</label>
                            <label style="margin-left: 50px"><input type="radio" name="Goods[volume]" <?= $volume==10? 'checked':''?> value="10" />10L</label>
                            <label style="margin-left: 50px"><input type="radio" name="Goods[volume]" <?= $volume==15? 'checked':''?> value="15" />15L</label>
                            <label style="margin-left: 50px"><input type="radio" name="Goods[volume]" <?= $volume!=7.5&&$volume!=10&&$volume!=15&&$volume!=''? "checked value=$volume":''?> id="other"  />其他</label><input style="width: 40px;margin-left: 10px;" type="text" <?= $volume!=7.5&&$volume!=10&&$volume!=15&&$volume!=''? "value=$volume":''?> id="volume"><span style="margin-left:10px">L</span>

                        </div>

            <div class="content_middle" style="margin-bottom: 80px">
                <div class="detail1">
                    <div class="split"></div>
                    <div class="item" style="height: 240px;line-height: 240px">
                        <div class="ftitle"><span class="tip">*</span><span class="title"> 商品图片：</span></div>
                        <div class="fcontent">
                            <div class="goodpic" style="float: left;background: none;border: none;width:400px;height: 240px">

                                <div style="display: none">
                                    <div class="form-group field-image1">
                                        <label class="col-sm-2 control-label" for="image1">Goods Image1</label>
                                        <div class="col-sm-10"><input type="text" id="image1" class="form-control" name="Goods[goods_image1]"  value="<?=$goods->goods_image1?$goods->goods_image1:''?>">
                                            <div class="help-block m-b-none"></div></div>

                                    </div>

                                    <div class="form-group field-image2">
                                        <label class="col-sm-2 control-label" for="image2">Goods Image2</label>
                                        <div class="col-sm-10"><input type="text" id="image2" class="form-control" name="Goods[goods_image2]" value="<?=$goods->goods_image2?$goods->goods_image2:''?>">
                                            <div class="help-block m-b-none"></div></div>

                                    </div>

                                    <div class="form-group field-image3">
                                        <label class="col-sm-2 control-label" for="image3">Goods Image3</label>
                                        <div class="col-sm-10"><input type="text" id="image3" class="form-control" name="Goods[goods_image3]" value="<?=$goods->goods_image3?$goods->goods_image3:''?>">
                                            <div class="help-block m-b-none"></div></div>

                                    </div>

                                    <div class="form-group field-image4">
                                        <label class="col-sm-2 control-label" for="image4">Goods Image4</label>
                                        <div class="col-sm-10"><input type="text" id="image4" class="form-control" name="Goods[goods_image4]" value="<?=$goods->goods_image4?$goods->goods_image4:''?>">
                                            <div class="help-block m-b-none"></div></div>

                                    </div>

                                    <div class="form-group field-image5">
                                        <label class="col-sm-2 control-label" for="image5">Goods Image5</label>
                                        <div class="col-sm-10"><input type="text" id="image5" class="form-control" name="Goods[goods_image5]" value="<?=$goods->goods_image5?$goods->goods_image5:''?>">
                                            <div class="help-block m-b-none"></div></div>

                                    </div>

                                    <div class="form-group field-image6">
                                        <label class="col-sm-2 control-label" for="image6">Goods Image6</label>
                                        <div class="col-sm-10"><input type="text" id="image6" class="form-control" name="Goods[goods_image6]" value="<?=$goods->goods_image6?$goods->goods_image6:''?>">
                                            <div class="help-block m-b-none"></div></div>

                                    </div>



                                </div>


                                <div class="item" style="height: 100px;line-height: 100px">
                                    <div class="c3" style="height: 100px">
                                        <div class="img_add_c">
                                            <span id="image1span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+图1</span>
                                            <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image1btn"/>
                                            <img class="image1" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="<?=$goods->goods_image1?$goods->goods_image1:''?>" alt="+添加">
                                        </div>
                                    </div>
                                    <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image1')"/>
                                    <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image1')"/>

                                </div>
                                <div class="item" style="height: 100px;margin-top: 10px;line-height: 100px">
                                    <div class="c3" style="height: 100px">
                                        <div class="img_add_c">
                                            <span id="image2span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+图2</span>
                                            <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image2btn"/>
                                            <img class="image2" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="<?=$goods->goods_image2?$goods->goods_image2:''?>" alt="+添加">
                                        </div>
                                    </div>
                                    <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image2')"/>
                                    <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image2')"/>

                                </div>
                                <div class="item" style="height: 100px;margin-top: 10px;line-height: 100px">
                                    <div class="c3" style="height: 100px">
                                        <div class="img_add_c">
                                            <span id="image3span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+图3</span>
                                            <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image3btn"/>
                                            <img class="image3" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="<?=$goods->goods_image3?$goods->goods_image3:''?>" alt="+添加">
                                        </div>
                                    </div>
                                    <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image3')"/>
                                    <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image3')"/>

                                </div>
                                <div class="item" style="height: 100px;margin-top: 10px;line-height: 100px">
                                    <div class="c3" style="height: 100px">
                                        <div class="img_add_c">
                                            <span id="image4span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+图4</span>
                                            <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image4btn"/>
                                            <img class="image4" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="<?=$goods->goods_image4?$goods->goods_image4:''?>" alt="+添加">
                                        </div>
                                    </div>
                                    <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image4')"/>
                                    <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image4')"/>

                                </div>
                                <div class="item" style="height: 100px;margin-top: 10px;line-height: 100px">
                                    <div class="c3" style="height: 100px">
                                        <div class="img_add_c">
                                            <span id="image5span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+图5</span>
                                            <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image5btn"/>
                                            <img class="image5" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="<?=$goods->goods_image5?$goods->goods_image5:''?>" alt="+添加">
                                        </div>
                                    </div>
                                    <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image5')"/>
                                    <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image5')"/>

                                </div>
                                <div class="item" style="height: 100px;margin-top: 10px;line-height: 100px">
                                    <div class="c3" style="height: 100px">
                                        <div class="img_add_c">
                                            <span id="image6span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+图6</span>
                                            <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image6btn"/>
                                            <img class="image6" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="<?=$goods->goods_image6?$goods->goods_image6:''?>" alt="+添加">
                                        </div>
                                    </div>
                                    <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image6')"/>
                                    <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image6')"/>

                                </div>
                            </div>
                            <div class="goodpic" style="float: left;height: 240px">
                                <div class="item">提示：</div>
                                <div class="item">1. 最多上传6张相关图片。</div>
                                <div class="item">2. 显示尺寸大小：缩略图(220*220)，详情图（720×1080）</div>
                                <div  class="item" style="float: left;width: 18px;">3. </div>
                                <div class="item" style="float: left;width: 260px;word-wrap: break-word; ">手机详情总体大小：图片+文字+音频应小于等于1.5M，图片仅支持JPG、GIF、PNG格式；</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="split" style="margin-top: 260px" ></div>
                <div>
                    选择销售地区：
                    <select style="width: 100px">
                        <option value="国内">国内</option>
                        <option value="国际">国际</option>
                    </select>
                    <select style="width: 100px">
                        <option value="">请选择省市</option>
                    </select>
                    <select style="width: 100px">
                        <option value="">全部</option>
                    </select>
                </div>

            </div>

<style>
    .btn-white{
        display: none;
    }
</style>


                        <?= $form->defaultButtons() ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

<div id="fade" class="black_overlay">  </div>  

 <div id="MyDiv" class="white_content">  
  <div style="text-align: right; cursor: default; height: 40px;    position: fixed;
    background: #2d2d35;
    padding: 5px 15px;
    right: 11%;">  
   <span style="font-size: 16px;" onclick="CloseDiv('MyDiv','fade')">关闭</span>  
  </div>  
  <img src="" alt="" width=100%>
 </div> 

 <script type="text/javascript">  
//弹出隐藏层  
function ShowDiv(show_div,bg_div){  
 document.getElementById(show_div).style.display='block';  
 document.getElementById(bg_div).style.display='block' ;  
 var bgdiv = document.getElementById(bg_div);  
 bgdiv.style.width = document.body.scrollWidth;   
 // bgdiv.style.height = $(document).height();  
 $("#"+bg_div).height($(document).height());  
};  
//关闭弹出层  
function CloseDiv(show_div,bg_div)  
{  
 document.getElementById(show_div).style.display='none';  
 document.getElementById(bg_div).style.display='none';  
};  
</script> 

            <script type="text/javascript" src="./static/js/jquery.min.js"></script>
            <script type="text/javascript" src="./static/js/zui/js/zui.js"></script>
            <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
            <script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
            <script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
            <script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>
            <script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
            <script type="text/javascript" src="./static/js/layer/layer.js"></script>
            <script type="text/javascript" src="./static/js/pinyin.js"></script>
            <script type="text/javascript" src="./static/js/lib.js"></script>
            <script type="text/javascript" src="./static/js/good/addgood3.js"></script>

            <script>

                $('.btn-primary').click(function(){
                    var image1=$('#image1').val();

                    if(!image1){
                        alert('第一张图片必须添加');
                        return false;
                    }
                });




                $('#volume').blur(function(){
                    var volume= $.trim($(this).val());
                    if(volume!=''){
                        if(isNaN(volume)){
                            alert('容量只能是整数或小数');
                            $('#volume').val('');
                            $('#other').attr('checked',false);
                            return false;
                        }

                        if(volume<=0){
                            alert('容量必须大于0');
                            $('#volume').val('');
                            $('#other').attr('checked',false);
                            return false;
                        }

                        if(volume>=100){
                            alert('容量不能大于100');
                            $('#volume').val('');
                            $('#other').attr('checked',false);
                            return false;
                        }
                        if(volume<100 && !Number.isInteger(volume)){
                            var volume2=parseInt(volume*10)/10;//保留一位小数

                            $('#other').attr('value',volume2);
                            $('#volume').val(volume2);
                            $('#other').attr('checked',true);

                        }else{
                            $('#other').attr('value',volume);
                            alert(volume);
                            $('#other').attr('checked',true);
                        }

                    }else{
                        $('#other').attr('checked',false);

                    }
//                    alert(volume);
                })

            </script>

            </body>
            </html>











