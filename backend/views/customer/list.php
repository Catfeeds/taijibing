<?php
use yii\widgets\LinkPager;
?>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css"> 

    <link rel="stylesheet" href="./static/css/index52.css"/>
        <link href="/static/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
   <style type="text/css" media="screen">
.gray-bg{
  position: relative;
}
td, td:hover{
     color: inherit;
      }
.state{
  display:none;
}
a {
    color: #337ab7;
    text-decoration: none;
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
.table>tbody>tr{
  position: relative;
}
.table > thead > tr > th, .table > tbody > tr > td {
    border: none;
    text-align: center;
    color: inherit;
    vertical-align: middle;
    font-size: 12px;
}
.layui-layer .layer-btn{
    text-align: center;
    position: absolute;
    width: 100%;
    bottom: 10px;
}
.layui-layer .layer-btn a {

    height: 28px;
    line-height: 28px;
    margin: 0 6px;
    padding: 5px 15px;
    border: 1px solid #dedede;
    background-color: #f1f1f1;
    color: #333;
    border-radius: 2px;
    font-weight: 400;
    cursor: pointer;
    text-decoration: none;
}
.layui-layer .layer-btn .layer-btn0{
        border-color: #1AA5F1;
    background-color: #1AA5F1;
    color: #fff;
}
.layui-layer-content .content-text{
    width:50%;height:100%;display: inline-block;
}
.layui-layer-content .content-text img{
    width:100%;height:80%;    border: 5px solid #fff;
}
/*.layui-layer-content p{
   color: #000
}*/
.layui-layer-content .content-text p{
 text-align: center;  color: #000
}
.picView-magnify-list li{
        /*width: 45%;*/
}
.picView-magnify-list li a img {
   width: 100%;;
        height: 250px;

}
.picView-magnify-list p{
    text-align: center;
    color:#000;padding:5px;
}
#version{
    position: absolute;
    height: 30px;
    padding: 5px;
    background: #393e45;
    z-index: 100;
    border-radius: 5px;
    margin-left: 15px;color: #fff;
}  </style>
<div class="wrapper wrapper-content">
 
    <div style="margin-bottom:10px;" class='condition'>
        <form action="/index.php?r=customer/list" method="post">
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
         <label style="padding-left:10px;">照片状态:</label>
        <select class="control-label" name="picture_state" id="picture_state">
            <option value="">照片状态</option>
            <option value="0">未上传</option>
            <option value="1">待确认</option>
            <option value="2">已通过</option>
            <option value="3">未通过</option>
        </select>

              <input type="submit" class="btn" value="查询"  style="background: #e46045; color: white;height: 26px;line-height: 14px;padding-left: 10px;margin-top: -5px;    border: none;"/>
              <br/>
       
             <div id="dvCBs"  style="padding-left:5px;  margin-top: 25px;">
                 <input type="checkbox" name="state1" value="1"  id="state1" class='state' / >
           <label for="state1"></label>
           <span> 正常用户</span>
         <input type="checkbox" name="state2" value="1"  id="state2" class='state'/>
                 <label  for="state2"></label>
                  已登记用户
                 <input type="checkbox" name="state3" value="1"  id="state3" class='state'/>
                 <label  for="state3"></label>
                  初始化用户

                  <input type="checkbox" name="state4" value="1"  id="state4" class='state'/>
                 <label  for="state4"></label>
                  重复电话
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
        <table class="table table-hover" style="margin-top: 15px;">
            <thead>
              <div  id="version">新功能体验</div>
            <th style="width: 15%">
              <input type="checkbox" name="state5" value="1"  id="state5" class='state'/>
             <label  for="state5"></label>
            序号</th>
            <!--            <th>登陆账号</th>-->
            <th  style="width: 8%">用户姓名</th>
            <th style="width: 8%">手机号</th>
            <th style="width: 8%">二维码编号</th>
            <th style="width: 8%">设备编号</th>
            <th style="width: 8%">设备商品型号</th>
            <th style="width: 8%">设备品牌</th>
            <th  style="width: 9%">所在地区</th>
            <th  style="width: 11%">地址</th>
            <th  style="width: 10%">所属服务中心</th>
            <th style="width: 8%">入网属性</th>
            <th style="width: 8%">客户类型</th>
            <th style="width: 8%">备注</th>
            <?= $role_id==1?"<th  style='width: 10%'><a id='sort' hreg=''>登记时间</a></th>":''?>
            <?= $role_id==1?'<th style="width: 8%">操作详情</th>':''?>
            <?= $role_id==1?'<th style="width: 7%">管理</th>':''?>
             <?= $role_id==1?"<th  style='width: 10%'><a id='sort2' hreg=''>照片</a></th>":''?>
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
                            <td>
                          <input type='checkbox' name='onten".$no."' value='".$val["Id"]."' ".(($val["IsUse"]==1)?'checked=true':'')."       id='onten".$no."' class='state'/>
                          <label  for='onten".$no."'></label>
                            ".$no."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["Tel"]."</td>
                            <td>".$val["CodeNumber"]."</td>
                            <td>".$val["DevNo"]."</td>
                            <td>".$val["goodsname"]."</td>
                            <td>".$val["BrandName"]."</td>
                            <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                            <td>".$val["Address"].$val["RoomNo"]."</td>
                            <td>".$val["AgentName"]."</td>
                            <td>".$UserType[$val["UseType"]]."</td>
                            <td>".$CustomerType[$val["CustomerType"]]."</td>
                            <td>".$val["Remark"]."</td>
                            <td>".$val["RowTime"]."</td>
                            <td><a href='./?r=customer/detail&id=".$val["Id"]."&DevNo=".$val["DevNo"]."'>详情</a></td>
                            
                            <td>".(in_array($val['DevNo'],$users_of_init)?"修改":"<a href='./?r=customer/update&id={$val['Id']}&devno={$val['DevNo']}'>修改</a>")."  "
                            .(empty($val["CodeNumber"])?"解绑":"<p onclick='customer(\"{$val['CodeNumber']}, {$val['DevNo']}\")'><a>解绑</a><p>")."
                            </td>
                            <td>";
                            $ImageState =   $val["ImageState"];
                           if($ImageState==1){
                                 $str.=" <a class='picture'  onclick='picture(\"{$val['Image']},{$val['TempImage']},{$val['DevNo']},{$val['ImageState']},{$val['Name']}\")'>待确认</a> ";
                            }else if($ImageState==2){
                                  $str.=" <a   class='picture'  style='color:#00ff08'  onclick='picture(\"{$val['Image']},{$val['TempImage']},{$val['DevNo']},{$val['ImageState']},{$val['Name']}\")'>已通过</a> ";
                            }else if($ImageState==3){
                                  $str.=" <a   class='picture'  style='color:red'   onclick='picture(\"{$val['Image']},{$val['TempImage']},{$val['DevNo']},{$val['ImageState']},{$val['Name']},{$val['ImageErrorReason']}\")'>未通过</a> ";
                            }else{
                               $str.=" 未上传 ";
                            }
                            $str.= " </td> </tr>"; 
                    $no++;
                }
                echo $str;
            }else{
                foreach($model as $key=>$val)
                {
                    $str.= "<tr ".(in_array($val['DevNo'],$users_of_init)?"date = '1'":'')." ".($val['IsActive']==0?"style='color: red;'":'').">
                                 <td>
                          <input type='checkbox' name='onten".$no."' value='1'  id='onten".$no."' class='state'/>
                          <label  for='onten".$no."'></label>
                            ".$no."</td>
                            <td>".$val["Name"]."</td>
                            <td>".$val["Tel"]."</td>
                             <td>".$val["CodeNumber"]."</td>
                            <td>".$val["DevNo"]."</td>
                            <td>".$val["goodsname"]."</td>
                            <td>".$val["BrandName"]."</td>
                            <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                            <td>".$val["Address"].$val["RoomNo"]."</td>
                            <td>".$val["AgentName"]."</td>
                            <td>".$UserType[$val["UseType"]]."</td>
                            <td>".$CustomerType[$val["CustomerType"]]."</td>
                            <td>".$val["Remark"]."</td>
                            </tr>";
                    $no++;
                }
                echo $str;
            }
            ?>
            </tbody>
        </table>
</div>
    <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
    <script type="text/javascript" src="/static/js/Common2.js?v=4"></script>
    <script type="text/javascript" src="/static/js/index.js?v=1.2"></script>
    <script type="text/javascript" src="/static/js/jquery.rotate.min.js"></script>
    <script>
        layer.msg("加载中...");
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
        var state4='<?=$state4?>';
        var sort2='<?=$sort2?>';
        var picture_state='<?=$picture_state?>';
        // console.log(data)
        var page_size='<?=$page_size?>';
       // alert(picture_state)
    </script>
    <script>
 $("#version").click(function(){
              var number = '';

            $.each($('tbody input:checkbox:checked'),function(k){
               if(k == 0){
                      number = "'"+$(this).val()+"'";
                  }else{
                      number += ",'"+$(this).val()+"'";
                  }
            });
            if(!number){
                  layer.msg("请至少选取一个用户");
            }else{

              // console.log(number)
               $.get('./?r=customer/save-user-test',{'ids':number}, function(data) {
                 /*optional stuff to do after success */
        
                   if(typeof(data)=='string'){
                      data=  jQuery.parseJSON(data);
                    }
         // console.log(data)
                   if(data.state==-1){
                           layer.msg(data.msg);
                              return;
                      }else{
                          layer.msg('本次设置了'+data.num+'个用户');
                          location.reload()
                      }
               });
            }
     });
        
 $('tbody  input[type="checkbox"]').click(function(event) {
   /* Act on the event */
         var number = '';

            $.each($('tbody input:checkbox:checked'),function(k){
               if(k == 0){
                      number = $(this).val();
                  }else{
                      number += ','+$(this).val();
                  }
            });

            if(!number){
              $("#version").css('background',"#393e45")
                       
            }else{
               $("#version").css('background',"#e46045")
               $('#state5').prop('checked',false);
            }
 });
    $('thead .state').click(function(){
       if($(this).is(":checked")){
        $('tbody  input[type="checkbox"]').prop('checked','true');
        $("#version").css('background',"#e46045")
      }else{
         $('tbody  input[type="checkbox"]').prop('checked',false);
         $("#version").css('background',"#393e45")
      } ; 
    });
$('#picture_state').val(picture_state)
$('#picture_state').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
function  picture(obj){
       // console.log(obj);
    var dataArr = obj.split(",")
    // console.log(dataArr);
  var pictureObj={
       DevNo:dataArr[2],
       Image:dataArr[1],
       IsOk:1,
    };
    var html ='<p style="padding: 10px;">用户姓名：<span>'+dataArr[4]+'</span>  &nbsp;&nbsp;&nbsp;&nbsp;设备编号：<span>'+dataArr[2]+'</span></p>';
    if(dataArr[3]*1==1){
          html +='<div class="wrapper wrapper-content">'+
                     '<ul class="picView-magnify-list" style="padding:0 30px">'+
                         '<li  style="position:relative"><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+dataArr[1]+'"  data-caption="临时补拍">'+
                             ' <img src="'+dataArr[1]+'"> <p>临时补拍</p></a>'+
                         ' </li>'+
                         '<li><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+dataArr[0]+'"  data-caption="已存档">'+
                             ' <img src="'+dataArr[0]+'"> <p>已存档</p></a>'+
                         ' </li>'+
                     '</ul>'+
                '</div>';
            html+='<div class="layer-btn"><a class="layer-btn0" >确定通过</a><a class="layer-btn1">不通过</a></div>'
          //自定页
            var  pictureYii =  layer.open({
                  type: 1,
                  // skin: 'layui-layer-demo', //样式类名
                  closeBtn: 0, //不显示关闭按钮
                  anim: 2,
                  area: ['500px', '400px'], //宽高
                  shadeClose: true, //开启遮罩关闭
                  // btn: ['确定','取消'], //按钮
                  title: false,
                  skin: 'yourclass',
                  content: html
                });
                  // magnify()
                $(".layer-btn .layer-btn0").click(function(event) {
                    $.get('./?r=customer/check-picture',pictureObj,function(data){
                        // console.log(pictureObj)
                          var data=data;
                           if(typeof(data)=='string'){
                            data=  jQuery.parseJSON(data);
                          }
                        // console.log(data)
                         if(data.state==-1){
                                 layer.msg(data.msg);
                                    return;
                            }else{
                                layer.msg(data.msg);
                                location.reload()
                            }
                    });
                    layer.close(pictureYii);
                });
                $(".layer-btn .layer-btn1").click(function(event) {
                   var html = '<p>请输入原因：</p><input type="texe" class="ImageErrorReason" style="    width: 100%;background-color: #ffffff;    border: 1px solid #b3b3b3;">'
                    layer.confirm(html, {
                      btn: ['确定','取消'] //按钮
                    }, function(){
                   var ImageErrorReasonTxt = $(".ImageErrorReason").val()
                       if(!ImageErrorReasonTxt){
                           layer.msg('原因不能为空');
                           return;
                      }
                    pictureObj.IsOk=-1;
                    pictureObj.ImageErrorReason=ImageErrorReasonTxt;   
                    $.get('./?r=customer/check-picture',pictureObj,function(data){
                              // console.log(pictureObj)
                              var data=data;
                               if(typeof(data)=='string'){
                                data=  jQuery.parseJSON(data);
                              }
                            // console.log(data)
                             if(data.state==-1){
                                     layer.msg(data.msg);
                                        return;
                                }else{
                                    layer.msg(data.msg);
                                    location.reload()
                                       // layer.close(index);
                                }
                        })


                    }, function(index){
                        layer.close(index);
                    });
                });
    }else if(dataArr[3]*1==2){
       // html +='<img src="'+dataArr[0]+'" alt="图片"  style="width:100%;height:80%;border: 5px solid #fff;"> ';

          html += '<div class="wrapper wrapper-content">'+
                     '<ul class="picView-magnify-list" style="padding:0 30px">'+
                         '<li><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+dataArr[0]+'"  data-caption="已存档">'+
                             ' <img src="'+dataArr[0]+'"> </a><p>已存档</p>'+
                         ' </li>'+
                     '</ul>'+
                 '</div>';

         html+='<div class="layer-btn"><a class="layer-btn0" >确定</a><a class="layer-btn1">取消</a></div>'
          //自定页
           var  pictureYii =  layer.open({
                  type: 1,
                // skin: 'layui-layer-demo', //样式类名
                  closeBtn: 0, //不显示关闭按钮
                  anim: 2,
                  area: ['500px', '400px'], //宽高
                  shadeClose: true, //开启遮罩关闭
                  title: false,
                  skin: 'yourclass',
                  content: html
                });
                 $(".layer-btn .layer-btn0").click(function(event) {
                    layer.close(pictureYii);
                });
                $(".layer-btn .layer-btn1").click(function(event) {
                       layer.close(pictureYii);
                });
                  // magnify()
    }else if(dataArr[3]*1==3){
           var html ='<p style="padding: 10px;">用户姓名：<span>'+dataArr[4]+'</span>  &nbsp;&nbsp;&nbsp;&nbsp;设备编号：<span>'+dataArr[2]+'</span> &nbsp;&nbsp;&nbsp;&nbsp;未通过原因：<span>'+dataArr[5]+'</span></p>';
              html += '<div class="wrapper wrapper-content">'+
                        '<ul class="picView-magnify-list" style="padding:0 30px">'+
                         '<li style="position:relative"><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+dataArr[1]+'"  data-caption="临时补拍">'+
                             ' <img src="'+dataArr[1]+'"> </a><p>临时补拍</p>'+
                         ' </li>'+
                         '<li><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+dataArr[0]+'"  data-caption="已存档">'+
                             ' <img src="'+dataArr[0]+'"> </a><p>已存档</p>'+
                         ' </li>'+
                     '</ul>'+
                 '</div>'; 
        html+='<div class="layer-btn"><a class="layer-btn0" >通过</a><a class="layer-btn1">未通过</a></div>'
          //自定页
       var  pictureYii =  layer.open({
                  type: 1,
                  // skin: 'layui-layer-demo', //样式类名
                  closeBtn: 0, //不显示关闭按钮
                  anim: 2,
                  area: ['500px', '400px'], //宽高
                  shadeClose: true, //开启遮罩关闭
                  // btn: ['确定','取消'], //按钮
                  title: false,
                  skin: 'yourclass',
                  content: html
          });
                $(".layer-btn .layer-btn0").click(function(event) {
                    $.get('./?r=customer/check-picture',pictureObj,function(data){
                          var data=data;
                           if(typeof(data)=='string'){
                            data=  jQuery.parseJSON(data);
                          }
                        // console.log(data)
                         if(data.state==-1){
                                 layer.msg(data.msg);
                                    return;
                            }else{
                                layer.msg(data.msg);
                                location.reload()
                                   // layer.close(index);
                            }
                    })
                    window.location.reload()
                    layer.close(pictureYii);
             });
                $(".layer-btn .layer-btn1").click(function(event) {
                      var html = '<p>请输入原因：</p><input type="texe" class="ImageErrorReason" style="    width: 100%;background-color: #ffffff;    border: 1px solid #b3b3b3;">'
                 
                    layer.confirm(html, {
                      btn: ['确定','取消'] //按钮
                    }, function(){
                   var ImageErrorReasonTxt = $(".ImageErrorReason").val()
                       if(!ImageErrorReasonTxt){
                           layer.msg('原因不能为空');
                           return;
                      }
                    pictureObj.IsOk=-1;
                    pictureObj.ImageErrorReason=ImageErrorReasonTxt;   
                    $.get('./?r=customer/check-picture',pictureObj,function(data){
                              console.log(pictureObj)
                              var data=data;
                               if(typeof(data)=='string'){
                                data=  jQuery.parseJSON(data);
                              }
                            console.log(data)
                             if(data.state==-1){
                                     layer.msg(data.msg);
                                        return;
                                }else{
                                    layer.msg(data.msg);
                                    location.reload()
                                       // layer.close(index);
                                }
                        })

                        // layer.close(pictureYii);
                    }, function(index){
                        layer.close(index);
                           // layer.close(pictureYii);
                    });
  layer.close(pictureYii);
                });     
    };
}
 magnify();
 function magnify(){
     // $('[data-magnify]').Magnify({
           $.Magnify({
            Toolbar: [
                'prev',
                'next',
                'rotateLeft',
                'rotateRight',
                'zoomIn',
                'actualSize',
                'zoomOut'
            ],
            keyboard:true,
            draggable:false,
            movable:true,
            modalSize:[800,400],
            beforeOpen:function (obj,data) {
                console.log('beforeOpen')
                console.log('11111')
                // console.log('beforeOpen')
                         layer.closeAll()
            },
            opened:function (obj,data) {
                console.log('opened')
            },
            beforeClose:function (obj,data) {
                console.log('beforeClose')
            },
            closed:function (obj,data) {
                console.log('closed')
            },
            beforeChange:function (obj,data) {
                console.log('beforeChange')
            },
            changed:function (obj,data) {
                console.log('changed')
            }
        });
}   













function customer(stringData){
    var dataArr = stringData.split(",")
        layer.msg('你确定要解绑么？解绑时会将设备进行初始化，解除绑定之后，此二维码将能继续登记用户', {
          time: 0 //不自动关闭
          ,btn: ['确定', '取消']
          ,shadeClose :false
         , shade: [0.1, '#393D49']
          ,yes: function(index){
            layer.close(index);
               layer.msg('解绑中。。。。')
                // ./?r=customer/update&id=0d176364522444daaf8a3da3d5fbd086&devno=2079111290
               location.href='./?r=customer/untie&CodeNumber='+dataArr[0]+'&devno='+dataArr[1];
          }
        });
}
$(function(){
    $(".table tbody").children("tr").each(function(index){
        if( $(this).attr("date")==1){
            // $(this).parent().parent().line();
             $(this).children().attr("disabled", "disabled").children().attr("disabled", "disabled").attr("position", "relative");
             console.log($(this).offset().top)


                    var t =$(this).offset().top + $(this).height()/2;//1、获得对应行，第一列相对于浏览器顶部的位移
                    var l = $(this).offset().left;//2、获得对应行，第一列相对于浏览器左侧的位移
                    var w = $(this).width();//3、获得对应行的宽度 
                     $(this).append("<div style='outline:#BABABF solid 1px; position:absolute; left:" + l + "px;top:" + t + "px;width:" + w + "px;'></div>");//4
        }
    })
})
// 地址渲染 
addressResolve(data,province,city,area);
        //排序
        $('#sort').click(function(){
            sort++;
              // console.log(sort)

              sort2=='';
            var content=$('#content').val();
            var usetype=$('#usetype option:selected').val();
            var customertype=$('#customertype option:selected').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();
            // var picture_state=$('#picture_state option:selected').val();


            $(this).attr('href','./?r=customer/list&sort='+sort+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&state1='+state1+'&state2='+state2+'&state3='+state3+'&state4='+state4+'&per-page='+page_size+'&picture_state='+picture_state);
//            alert($(this).attr('href'));

        });
                //排序
   
        $('#sort2').click(function(){
          // console.log(sort2)
            sort2++;
            if(sort2>=4){
              sort2=0
            }
               sort==1;
            var content=$('#content').val();
            var usetype=$('#usetype option:selected').val();
            var customertype=$('#customertype option:selected').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();
        // var picture_state=$('#picture_state option:selected').val();
             $(this).attr('href','./?r=customer/list&sort2='+sort2+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&state1='+state1+'&state2='+state2+'&state3='+state3+'&state4='+state4+'&per-page='+page_size+'&picture_state='+picture_state);
           // alert($(this).attr('href'));

        });
        $(function(){
            $('.pagination a').click(function(){

                var content=$('#content').val();
                var usetype=$('#usetype option:selected').val();
                var customertype=$('#customertype option:selected').val();
                var province=$('#province option:selected').val();
                var city=$('#city option:selected').val();
                var area=$('#area option:selected').val();
                // var picture_state=$('#picture_state option:selected').val();
                var page_size=$('#page_size option:selected').val();
                var href=$(this).attr('href');
             // alert(picture_state);
                  if(sort2){
                    $(this).attr('href',href+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&sort2='+sort2+'&per-page='+page_size+'&state1='+state1+'&state2='+state2+'&state3='+state3+'&state4='+state4+'&picture_state='+picture_state);
                  }else{
                      $(this).attr('href',href+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&per-page='+page_size+'&state1='+state1+'&state2='+state2+'&state3='+state3+'&state4='+state4+'&picture_state='+picture_state);
                  }
               var href2=$(this).attr('href');
               // alert(href2)
 // return false;
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
    if(state4){
         $("#state4").attr("checked",state4);
    }else{
        $("#state4").attr("checked",false)
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
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 5 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=customer/list' id='butn'>确定</a></span>
</dev>"

?>
<script>

    $('#page_size').val(<?=$page_size?>);

    // console.log('<?=$page_size?>')

    // alert(<?=$page_size?>)
        $('#page_size').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#butn').click(function () {
        var content=$('#content').val();
        var usetype=$('#usetype option:selected').val();
        var customertype=$('#customertype option:selected').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        var page_size=$('#page_size option:selected').val();
        // var picture_state=$('#picture_state option:selected').val();
        var pages=$('#pages').val();
           // alert(pages);
           // alert(picture_state);
        var href=$(this).attr('href');
               if(sort2){
                 $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&sort2='+sort2+'&state1='+state1+'&state2='+state2+'&state3='+state3+'&state4='+state4+'&picture_state='+picture_state);
                   }else{
                   $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&state1='+state1+'&state2='+state2+'&state3='+state3+'&state4='+state4+'&picture_state='+picture_state);
                    }





        // $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&usetype='+usetype+'&customertype='+customertype+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&state1='+state1+'&state2='+state2+'&state3='+state3+'&state4='+state4);
        var href2=$(this).attr('href');

        // console.log(href2);
           // alert(href2);
           // return false;

    });

</script>