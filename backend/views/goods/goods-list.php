<!DOCTYPE html>
<html>
<head>
    <title>在售商品管理</title>
        <link rel="stylesheet" href="./static/css/chosen.css"/>
            <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
        <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
        <link rel="stylesheet" type="text/css" href="./static/css/conmones2.css">
</head>

<style type="text/css" media="screen">
    #btnop{
        width:100%;
            display: inline-box;
            display: -webkit-inline-box;

    }
    #btnop p{
        margin:0;
        margin-left:10px;
        padding:5px 10px;
        background:#2D3136;
        border-radius: 5px ;
        color:#fff;
            width:50px;
    text-align: center;
         display: inline-block;
        margin-top:20px;
    }
    #btnop p:hover{
        background-color:#454a50;
    }
    .inp{
        width: 50px;
    line-height: 11px;
    margin-top: 10px;
    margin-left: 20px;
    height: 30px;
    display: inline-block;
    text-align: center;
;
    }
    input[type=submit]:hover{
            background-color: #d46d58;
    }

    td,th{
        padding:3px 5px;font-size:15px;
    }
    		select, .chosen-container {
    width: 250px !important;
    height: 30px;
    min-width: inherit !important;
    border: none;
}
label{
	width: 100px;
}
</style>
<body>

    <div id="type_manage">

           <header>
           <form action="./index.php?r=goods/goods-list" method="post" accept-charset="utf-8">
              <div style="margin-bottom:10px;    padding: 50px;" class="condition"> 
                <div class='row'>
                  <span style="padding-left:5px;display:inline-block"><label>商品分类:</label> 
                    <select  style="width:250px;" name='category1_id' id="category1_id" class="category1_id"> 
                        <option value="">请选择</option>
                    </select>
                  </span>
                 <span style="padding-left:25px;display:inline-block"><label>商品二级分类:</label> 
                    <select  style="width:250px;" name='category2_id'  id="category2_id" class="category2_id"> 
                        <option value="">请选择</option>
                    </select>

                  </span>



                  
             </div>

            <div class='row' style="margin-top:20px;">
          <span style="padding-left:5px;display:inline-block"><label>商品品牌:</label> 

                    <select  style="width:250px;" name='brand_id'  id="brand_id" class="brand_id"> 
                         <option value="">请选择</option>
                    </select>

                  </span>
                  <span style="padding-left:25px;display:inline-block"><label>商品名称:</label> 
                    <select  style="width:250px;" name='goods_id'  id="goods_id" class="goods_id"> 
                        <option value="">请选择</option>
                    </select>
                  </span>
                   
                <input class='inp' type="submit" style='width:50px; background-color: #E46045;border: none;color:#fff;position: absolute;' value="查询" >
              </div>

          <div id="btnop" class="" style="position: relative;">
                  <a href="./index.php?r=goods/add-goods" title=""><p class='Establish'>创建</p></a>
                  <p class='Refresh' style="cursor:pointer;">刷新</p>

             
             </div>
              </div>
          </form>
           </header>
           <div >
               <table style='width:100%;border-collapse:separate; border-spacing:0px 10px;'>    
                <thead>
                    <tr>
                        <th>序号</th>
                    
                        <th style="width:10%">商品名称</th>
                        <th>商品品牌</th>
                        <th>商品分类</th>
                        <th>商品规格</th>
                        <th>商品二级分类</th>
        
                        <th>添加时间</th>
                        <th>更新时间</th>
                        <th>修改</th>
                        <th>删除</th>
                        <th>预览商品</th>
                    </tr>
                </thead>
                <tbody id='tableData'  style="">
                    <tr>
            
                    </tr>
                </tbody>
               </table>
           </div>   
       
    </div>
<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
    <div id="page" class="page_div"></div>
</div>

</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script>

 <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>    
<script> 
     

      var datas= eval('(' + <?=json_encode($datas)?> + ')') ;
      var type1= eval('(' + <?=json_encode($type1)?> + ')') ;
      var type2= eval('(' + <?=json_encode($type2)?> + ')') ;

      var category1_id= <?=json_encode($category1_id)?> ;
      var category2_id= <?=json_encode($category2_id)?>;

      var brand_id_top= <?=json_encode($brand_id)?>  ;
      var goods_id_top= <?=json_encode($goods_id)?>;



      var total= eval('(' + <?=json_encode($total)?> + ')') ;




      var where_datas={
            category1_id:category1_id,
            category2_id:category2_id,
            brand_id:brand_id_top,
            goods_id:goods_id_top,
        };
 // console.log(where_datas)



var addressResolve = function (options1,options2 ) {

      var defaluts = { 
        type1: 'category1_id' ,brand_id_name: 'brand_id',goods_id: 'goods_id'
      };
      var defaluts2 = { type2: 'category2_id' };

      var optstype1 = $.extend({}, defaluts, options1);//使用jQuery.extend 覆盖插件默认参数
      var optstype2 = $.extend({}, defaluts2, options2);//使用jQuery.extend 覆盖插件默认参数

          var addressInfo = this;
          this.optstype1 = $("#" + optstype1.type1);//省份select对象
          this.optstype2 = $("#" + optstype2.type2);//城市select对象
          this.brand_id_name = $("#" + optstype1.brand_id_name);//城市select对象
          this.goods_id = $("#" + optstype1.goods_id);//城市select对象
             // /*一级初始化方法*/
             this.type1 = function () {
               
                  var proOpts = "";
                  $.each(options1, function (index, item) {
                      proOpts+='<option   value="'+item.Id+'">'+item.Name+'</option>'
                  });
                addressInfo.optstype1.append(proOpts);
                addressInfo.optstype1.chosen({no_results_text: "没有找到",disable_search: true}); //初始化chosen
                addressInfo.optstype2.chosen({no_results_text: "没有找到",disable_search: true});//初始化chosen
                addressInfo.brand_id_name.chosen({no_results_text: "没有找到",disable_search: true});//初始化chosen
                addressInfo.goods_id.chosen({no_results_text: "没有找到",disable_search: true});//初始化chosen
          }

          //     /*二级初始化方法*/
            this.type2 = function () {
                  addressInfo.optstype2.empty().append("<option value=>请选择</option>");
                  addressInfo.brand_id_name.empty().append("<option value=>请选择</option>");
                  addressInfo.goods_id.empty().append("<option value=>请选择</option>");
                  var proOpts = "";
                    var Pid = $("#category1_id").val()
                  $.each(options2, function (index, item) {
                        if(Pid==item.ParentId){
                          proOpts+='<option   value="'+item.Id+'">'+item.Name+'</option>'
                        }
                  });

                 addressInfo.optstype2.append(proOpts);
                 addressInfo.optstype2.trigger("chosen:updated");
                 addressInfo.brand_id_name.trigger("chosen:updated");
                 addressInfo.goods_id.trigger("chosen:updated");
              }
              this.brand_idfun = function (brand_id_top) {

                addressInfo.brand_id_name.empty().append("<option value=>请选择</option>");
                addressInfo.goods_id.empty().append("<option value=>请选择</option>");


                var proOpts = " ";
                var  category1_id_val =addressInfo.optstype1.val() 
                var  category2_id_val = addressInfo.optstype2.val() ;
                var objdataA = {
                  'category1_id':category1_id_val,
                  'category2_id':category2_id_val
                }
        
                  $.post('index.php?r=goods/get-brands-when-search#', objdataA,function(data) {
                         var data =JSON.parse(data); 
                  
                         // console.log(data)   
                           for(var i=0;i<data.brands.length;i++){
                              var item = data.brands[i];
                              // console.log(item)  
                                  proOpts+=('<option value="'+item.BrandNo+'">'+item.BrandName+'</option>')
                            }
                         addressInfo.brand_id_name.append(proOpts);
                    if(brand_id_top){
                       addressInfo.brand_id_name.val(brand_id_top);
        
                      
                    }

                      addressInfo.brand_id_name.trigger("chosen:updated");
                      addressInfo.goods_id.trigger("chosen:updated");
                  })
         };
        this.goods_idfun = function (goods_id_data,brand_id_top) {
            addressInfo.goods_id.empty().append("<option value=>请选择</option>");
               var proOpts = "";
                 var  category1_id_val =addressInfo.optstype1.val() 
               var  category2_id_val = addressInfo.optstype2.val() ;
               var  brand_id_val =addressInfo.brand_id_name.val()||brand_id_top;
                var objdataB = {
                'category1_id':category1_id_val,
                'category2_id':category2_id_val,
                'brand_id':brand_id_val
                }
               //  console.log(objdataB)  
                $.post('index.php?r=goods/get-goods-when-search', objdataB,function(data) {
                  var data =JSON.parse(data); 

                 for(var i=0;i<data.goods.length;i++){
                  var item = data.goods[i]; 
                  $("#goods_id").append('<option value="'+item.id+'">'+item.name+'</option>')

                 }
                  if(goods_id_data){
                       addressInfo.goods_id.val(goods_id_data);
                    }
                  addressInfo.goods_id.append(proOpts);
                  addressInfo.goods_id.trigger("chosen:updated");

                })


         }
         this.inifo=function(){
               

         }



        /*对象初始化方法*/
    this.init = function () {
              // addressInfo.optstype1.append("<option value=''>请选择</option>");
               addressInfo.type1();
               addressInfo.optstype1.bind("change", addressInfo.type2);

               addressInfo.optstype2.bind("change", addressInfo.brand_idfun);
  

              addressInfo.brand_id_name.bind("change", addressInfo.goods_idfun);




if(category1_id){
    addressInfo.optstype1.val(category1_id);
     addressInfo.optstype1.trigger("chosen:updated");
      addressInfo.type2()
}
if(category2_id){
    addressInfo.optstype2.val(category2_id);
     addressInfo.optstype2.trigger("chosen:updated");
    addressInfo.brand_idfun(brand_id_top)

}

if(goods_id_top){
      addressInfo.goods_idfun(goods_id_top,brand_id_top)

}


}
init()
}



 addressResolve(type1,type2)

dev_listdata(datas)

  $("#page").paging({
    pageNo: 1,
    totalPage: Math.ceil(total / 10),
    totalLimit: 10,
    totalSize: total ,
    callback: function(num, nbsp) {

      var searchParameters = {
        category1_id:category1_id||'',
        category2_id:category2_id||'',
        brand_id:brand_id_top||'',
        goods_id:goods_id_top||'',
        offset: num * nbsp - nbsp,
        limit: nbsp
      }
     // console.log(searchParameters)
      Get_datas(searchParameters)
    }
  })

  function Get_datas(searchParameters) {
    var ii = layer.open({
      type: 1,
      skin: 'layui-layer-demo', //样式类名
      closeBtn: 0, //不显示关闭按钮
      anim: 2,
      shadeClose: false, //开启遮罩关闭
      content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
    });
       $.post("/index.php?r=goods/goods-list-page", searchParameters, function(data) {
 //console.log(obj)
     var obj = eval('(' + data+ ')')


      var sales_detail = obj.datas
      layer.close(ii);
      $("#tableData").empty()
      dev_listdata(sales_detail)
    })
  }

function  dev_listdata(data){
    
var j = 0;
   $("#tableData").empty()
    for (var i = 0; i < data.length; i++) {

      var item = data[i]
    //  console.log(item)
      var typeName='' ;

           // console.log(item)
     if(!item.WaterBrandName){

      typeName=item.TeaBrandName;
     }else{

      typeName = item.WaterBrandName;
     }
     // item.WaterBrandName?(typeName = item.WaterBrandName):(typeName = TeaBrandName)
      for (var z in item) {
        if (item[z] == null) {
          item[z] = '--'
        }
      }
      j++
      var updatetime='无更新时间';
      var addtime='无添加时间';
      if(item.updatetime&&item.updatetime!=0){
              updatetime=fmtDate(item.updatetime*1000)
      }
      if(item.addtime&&item.addtime!=0){
              addtime=fmtDate(item.addtime*1000)
      }
      var html = '<tr>'
      html += '<td>' + j + '</td>'
      html += '<td>' + item.name + '</td>'
      html += '<td>' + item.BrandName + '</td>'
      html += '<td>' + item.Type1Name + '</td>'
      html += '<td>' + item.volume +  item.unit +'</td>'
      html += '<td>' + item.type2Name + '</td>'
      html += '<td>' + addtime + '</td>'
      html += '<td>' +updatetime+ '</td>'
      html += '<td><a href="index.php?r=goods/edit-goods&id='+item.id+'"><img src="/static/images3/edit.png" alt=""></a></td>'
      html += '<td><img style="cursor: pointer;" src="/static/images3/delete.png" alt=""  onclick="del_goods('+item.id+')"></td>'
      html += '<td><p  style="cursor: pointer;margin-top:10px" onclick= "images_img('+item.id+')">预览<p></td>'

      html += '</tr>'
      $("#tableData").append(html);   

      
    }



}

function fmtDate(obj){
    var date =  new Date(obj);
    var y = 1900+date.getYear();
    var m = "0"+(date.getMonth()+1);
    var d = "0"+date.getDate();
    return y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length);
}


 function del_goods(Id){

layer.msg('    <div style="padding:50px;    font-size: 25px;">你确认要删除吗？</div>', {
  time: 0 //不自动关闭
   ,btn: ['确定', '取消']
  ,yes: function(index){
   var ii=layer.msg("操作中……");
            $.get('index.php?r=goods/del-goods&id='+Id, function(data) {
                 var data = eval('(' + data+ ')')
             // console.log(obj)
                   layer.close(ii);
            
                       if(!data.state){
                          layer.msg('    <div style="padding:50px;    font-size: 25px;">删除'+data.mas+'</div>')
                       }else{
                         layer.msg('    <div style="padding:50px;    font-size: 25px;">删除'+data.mas+'</div>')
                    }


                    window.location.reload()
        });    

    layer.close(index);
  }
});
  
 }

function images_img(id){
  var html = '';
  for(var y=0;y<datas.length;y++){
      var item = datas[y]
    // console.log(item)
      if(id==item.id){
      
         for(var i=6;i<13;i++){
               var imgName = 'goods_image'+''+i;
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



$(".Refresh").click(function(){
           window.location.reload(); 
})


 var url='';
// var result = JSON.stringify(where_datas)
for(var i in where_datas){
  if(where_datas[i]==null){
     where_datas[i]=''
  }
  url= url +"&"+ i+'='+where_datas[i]
}

$("table a").click(function(){
    var _thisURl = $(this).attr('href');
      var Urlobj = encodeURIComponent(url);
    $(this).attr('href',_thisURl+"&Url="+Urlobj)
    // return false;
})

 // alert(4)
</script>
</html> 