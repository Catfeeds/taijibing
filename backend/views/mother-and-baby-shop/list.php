<!DOCTYPE html>
<html style="overflow-x:hidden;overflow-y:hidden">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="X-UA-Compatible"content="IE=9; IE=8; IE=7; IE=EDGE">
    <link rel="stylesheet" href="./static/js/zui/css/zui.css"/>
    <link rel="stylesheet" href="./static/js/zui/css/style.css"/>
    <link rel="stylesheet" href="./static/css/addgood.css"/>
    <link rel="stylesheet" href="./static/js/jedate/skin/jedate.css"/>

    <link rel="stylesheet" href="./static/js/datepicker/dateRange.css"/>
  <link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="./static/js/page/jquery.pagination.css"/>
        <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
     <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
    <style>
        .operateBtn{
            font-size:12px;
            padding:0px 5px;
            color:blue;
        }
        .operateBtn:hover{
            cursor:pointer;
        }
        .du_area_item{
            padding-left:5px;
        }

        .input{
            font-size: 14px;
        }
        .rect{
            width:110px;
            height:100px;
            padding-top: 10px;
            border: 1px solid #DDDDDD;
            background-color: #EBF2F9;
        }
        .rect div{
            float: left;
            width:100%;
            margin:0px 0px;
            cursor: pointer;
        }
        .rect :hover{
            background-color: #FF9900;
        }
        .rect div a{
            margin:1px 8px;
            text-decoration: none;
        }
.table-hover > tbody > tr:hover > td, .table-hover > tbody > tr:hover > th{
    background-color: #363643
}
        .table-striped>tbody>tr:nth-of-type(odd){
            background-color: #32323E;
        }
        td{
            text-align: center;
        }
        #page a{
             padding: 4px 10px;
        }
    </style>
</head>
<body>
<div class="main-title">
    <h2>母婴管理&nbsp;&nbsp;&nbsp;</h2>
</div>
<div id="sample_2_wrapper" class="dataTables_wrapper form-inline" role="grid" style="padding-left:10px;">
    <form action="./?r=mother-and-baby-shop/list" method="post">
        <div style="margin-bottom:10px;" class="condition"> 
            商户名称：<input id="search" placeholder="请输入商户名"  value="<?=$shop_name?>" type="text" name="shop_name">
            <input type="submit" value="搜索" style='line-height: 15px; padding: 0 20px;background-color: #E46045; border: none;color: #fff;'>
      </div>

    </form>
    <table style="margin: 5px 0 10px 0;width: 100%" cellpadding="5px">

        <tr>
      <td colspan="6" style="text-align: left"><input type="button" style="background: #1d1f23; line-height: 15px;" id="create_btn" class="btn  select_btn" value="+添加商户"/></td>
        </tr>
    </table>
    <table class="table table-striped table-bordered table-hover dataTable" id="sample_2" aria-describedby="sample_2_info">
        <thead>
        <tr role="row">
            <th style="text-align:center;min-width:100px;">序号</th>
            <th style="text-align:center;min-width:140px;">商户店铺名称</th>
            <th style="text-align:center;min-width:120px;">账户名称</th>
            <th style="text-align:center;min-width:120px;">订水电话</th>
            <th style="text-align:center;min-width:100px;">营业时间（早）</th>
            <th style="text-align:center;min-width:100px;">营业时间（晚）</th>
            <!-- <th style="text-align:center;min-width:140px;">预览店铺</th> -->
            <th style="text-align:center;min-width:140px;">修改</th>
            <th style="text-align:center;min-width:140px;">删除</th>
        </tr>
        </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all" id="tbody">
        </tbody>
    </table>
    <div id="page" class="m-pagination"></div>
</div>
<div id="selectUserContainer" style="display:none;">
    <div  class="selectUserContainer">
        <div  class="UserContainer">
        </div>
        <div class="form-actions" style="padding-left:0px;text-align:center;background:white;border:0px;">
            <button class="dialogBtn" type="submit" class="btn blue"><i class="icon-ok"></i> 确定</button>
        </div>
    </div>
</div>


<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
  <div id="page" class="page_div"></div>
</div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script src="./static/js/datepicker/dateRange.js"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script>  
<script>
    var shops=stringArr(<?=json_encode($shops)?>);
    var shop_name=<?=json_encode($shop_name)?>;
    var total=<?=json_encode($total)?>;
tbodyRendering(shops)
// tabe渲染
function tbodyRendering(data){
       var no=0,str='';
      console.log(data);
       $("#tbody").html('');
   for(var i=0;i<data.length;i++){
      var item =nullUndefined(data[i]) ;
      var html = '<tr>';
          html += '<td>'+(i+1)+'</td>';
          html += '<td>'+item.shop_name+'</td>';
          html += '<td>'+item.Name+'</td>';
          if(item.shop_tel1&&item.shop_tel1!=''&&item.shop_tel2&&item.shop_tel2!=''){
             html += '<td>'+item.shop_tel1+' <br/> '+item.shop_tel2+'</td>';
           }else{
            html += '<td>'+item.shop_tel1+item.shop_tel2+'</td>';
           }
         
          html += '<td>'+item.morning+'</td>';
          html += '<td>'+item.night+'</td>';
          // html += '<td ><p  style="cursor: pointer;margin-top:10px" onclick= "images_img('+item.id+')">预览<p></td>';
          html += '<td><a href="/index.php?r=mother-and-baby-shop/edit&agent_id='+item.agent_id+'"><img src="/static/images3/edit.png"></a></td>';
          html += '<td onclick="saveedit(this,'+item.agent_id+')"  ><img src="/static/images3/delete.png"></td>';
          // html += '<td>'+item.night+'</td>';
          html += '</tr>';
 $("#tbody").append(html);
    }
}

$("#create_btn").click(function(){
      var Urlobj = encodeURIComponent("&shop_name="+shop_name);
      window.location='/index.php?r=mother-and-baby-shop/create-shop&Url='+Urlobj;
});
$(".table  td a").click(function(){
    var _thisURl = $(this).attr('href');
      var Urlobj = encodeURIComponent("&shop_name="+search);
     $(this).attr('href',_thisURl+"&Url="+Urlobj)
    console.log(_thisURl+"&Url=&"+Urlobj)
    // return false;
});

function saveedit(_this,agent_id){

  console.log(_this)
//信息框-例2
layer.msg('    <div style="padding:50px;    font-size: 25px;">你确认要删除吗？</div>', {
  time: 0 //不自动关闭
   ,btn: ['确定', '取消']
  ,yes: function(index){

 
    var ii=layer.msg('删除中...', {time: 0 });
      $.get("./index.php?r=mother-and-baby-shop/del-shop&agent_id="+agent_id , function(data){
         var data =stringArr(data) ;
         console.log(data)
         layer.close(ii); 
         if(data.state==-1){
              layer.msg(data.msg);
              return;
          }
        layer.msg('删除成功');
        $(_this).parent().remove();
          
    })

    layer.close(index);
  }
});




}

function images_img(id){
  var html = '';
  for(var y=0;y<shops.length;y++){
      var item = shops[y]
    // console.log(item)

        if(id==item.id){
          for(var i=1;i<7;i++){
               var imgName = 'image'+''+i;
                console.log(imgName)
                if(item[imgName]!=""){
                     html += '<img src="'+item[imgName]+'" alt="" width="100%">'
                }
           }
      }

  }
     // console.log(html)
        html += '';
        if(!html){
          html= '<p style="color:#000;padding:20px;line-height20px;">没有详情页</p>'
        }

 
        //页面层-自定义
        layer.open({
          type: 1,
          title: false,
          closeBtn: 0,
          area: ['820px', '800px'],
          shadeClose: true,
          skin: 'yourclass',
          content: html
        });
//       

// console.log(id)


}
  $("#page").paging({
    pageNo: 1,
    totalPage: Math.ceil(total / 10),
    totalLimit: 10,
    totalSize:total,
    callback: function(num, nbsp) {
      var searchParameters ={
        shop_name:shop_name,
         offset: num * nbsp - nbsp,
        limit: nbsp
      }
      Get_datas(searchParameters,num)
       console.log(searchParameters)
    }
  })


  function  Get_datas(searchParameters,num){
     var ii =   layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shade: [0.8, '#000'],
    shadeClose: false, //开启遮罩关闭
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });

  $.post("./index.php?r=mother-and-baby-shop/page-list", searchParameters, function(data){
       var data =stringArr(data) ;
       console.log(data)
       layer.close(ii); 
       if(data.state==-1){
                  layer.msg(data.msg);
                  return;
                }
         tbodyRendering(data.shops,num)
  })
}

// 未定义显示为空
function nullUndefined(data){
    // var dataArr= data;
    for(var i in data){
        if(data[i]==null||data[i]==undefined||data[i]==NaN){
          data[i]= ''
       }
    }
     return data; 
}


// josn序列化
function stringArr(data){
    var dataNo='';
     if(typeof(data)=='string'){
            dataNo=  jQuery.parseJSON(data);
      }else{
            dataNo = data;
      }
      return dataNo;
}

</script>





</body>
</html>

