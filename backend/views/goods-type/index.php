<!DOCTYPE html>
<html>
<head>
	<title>商品分类管理</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
	    <link rel="stylesheet" href="./static/css/chosen.css"/>
          <!-- <link rel="stylesheet" href="./static/css/bootstrap.min.css">  -->
	        <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
	    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
</head>

<style type="text/css" media="screen">
	#btnop{
		width:100%;
		    display: inline-box;
		    display: -webkit-inline-box;

	}
	#btnop p{
		margin:0;
    width:50px;
    text-align: center;
		margin-left:10px;
		padding:5px 10px;
		background:#2D3136;
		border-radius: 5px ;
		color:#fff;
		margin-top:20px;
        display: inline-block;
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


</style>
<body>

	<div id="type_manage">

           <header>
           <form action="./index.php?r=goods-type/index" method="post" accept-charset="utf-8">
           		
        
	          <div style="margin-bottom:10px;" class="condition"> 
	          	  <span style="padding-left:5px;display:inline-block"><label>商品分类:</label> 
                    <select  style="width:250px;" name='parent_id' id="type1" class="type1"> 
			
					</select>
	          	  </span>
	          	  <span style="padding-left:5px;display:inline-block"><label>商品二级分类:</label> 
                    <select  style="width:250px;" name='id'  id="type2" class="type2"> 
					    <option value="">请选择</option>
					</select>

	          	  </span>
				<input class='inp' type="submit" style='width:50px; background-color: #E46045;border: none;color:#fff;' value="查询" >

<div id="btnop" class="">
           	     <a href="./index.php?r=goods-type/add-goods-type" title=""><p class='Establish'>创建</p></a>
                <p class='Refresh' >刷新</p>
           </div>
	          </div>
           	</form>
           </header>
           <div	>
           	   <table style='width:100%;border-collapse:separate; border-spacing:0px 10px;'>	
           	   	<thead>
           	   		<tr>
           	   			<th>序号</th>
           	   			<th>商品分类</th>
           	   			<th>二级分类</th>
           	   			<th>添加时间</th>
           	   			<th>更新时间</th>
           	   			<th>修改</th>
           	   			<th>删除</th>
           	   		</tr>
           	   	</thead>
           	   	<tbody   style="">
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
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
 <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>	
<script type="text/javascript" src="/static/js/paging3.js"></script>
<script> 
  var type1=<?=json_encode($type1)?>||'';
  var type2=<?=json_encode($type2)?>||'';
  var data=<?=json_encode($datas)?>||'';
  var parent_id=<?=json_encode($parent_id)?>||'';
  var id=<?=json_encode($id)?>||'';
  var total =0
console.log(parent_id)
// console.log(id)
var addressResolve = function (options1,options2,obj){
      var defaluts = { type1: 'type1' };
      var defaluts2 = { type2: 'type2' };
      var optstype1 = $.extend({}, defaluts, options1);//使用jQuery.extend 覆盖插件默认参数
      var optstype2 = $.extend({}, defaluts2, options2);//使用jQuery.extend 覆盖插件默认参数
          var addressInfo = this;
          this.optstype1 = $("#" + optstype1.type1);//省份select对象
          this.optstype2 = $("#" + optstype2.type2);//城市select对象
          //     /*一级初始化方法*/
            this.type1 = function () {
                  var proOpts = "";
                  $.each(options1, function (index, item) {
                      if(obj.parent_id==item.Id){
                          proOpts+='<option selected  value="'+item.Id+'">'+item.Name+'</option>'
                      }else{
                       proOpts+='<option   value="'+item.Id+'">'+item.Name+'</option>' 
                      }
                  });
                addressInfo.optstype1.append(proOpts);
                addressInfo.optstype1.chosen({no_results_text: "没有找到",disable_search: true}); //初始化chosen
                addressInfo.optstype2.chosen({no_results_text: "没有找到",disable_search: true});//初始化chosen
          }
          //     /*二级初始化方法*/
            this.type2 = function () {
             addressInfo.optstype2.empty();
                addressInfo.optstype2.append("<option value=>请选择</option>");
                  var proOpts = "";
                    var Pid = $("#type1").val()
                  $.each(options2, function (index, item) {
                        if(Pid==item.ParentId){
                             if(obj.id==item.Id){
                              proOpts+='<option selected  value="'+item.Id+'">'+item.Name+'</option>'
                            }else{
                             proOpts+='<option   value="'+item.Id+'">'+item.Name+'</option>'
                            }
                        }
                  });
                addressInfo.optstype2.append(proOpts);
                addressInfo.optstype2.trigger("chosen:updated");
          }
        /*对象初始化方法*/
    this.init = function () {
               addressInfo.optstype1.append("<option value=''>请选择</option>");
               addressInfo.type1();
               addressInfo.optstype1.bind("change", addressInfo.type2);
              var Pid = $("#type1").val()
              if(Pid){
                addressInfo.type2();
              }
}
init()
}


    var search_where = {
      parent_id:parent_id,
      id :id ,
      sort:1,
      limit:0,
      offset:10
    };
// console.log(data.length)
addressResolve(type1,type2,{'id':id,'parent_id':parent_id})


   function Get_datas(searchParameters) {

      var ii = layer.open({
        type: 1,
        skin: 'layui-layer-demo', //样式类名
        closeBtn: 0, //不显示关闭按钮
        anim: 2,
        shadeClose: false, //开启遮罩关闭
        content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
      });
      // $.post('./index.php?r=goods-type/get-page', searchParameters, function(data) {
      //   layer.close(ii);

      //   var data = eval('(' + data + ')');
      //   console.log(data)
      //      total=data.total;

      //   // dev_listdata(data.data)
      // })


       $.ajax({cache: false,
               async: false,
               type: 'get',
               data:searchParameters,
               url: "./index.php?r=goods-type/get-page",
               success: function (data) {
                  layer.close(ii);
                    var data = eval('(' + data + ')');
                    console.log(data)
                  total=data.total;

                  dev_listdata(data.datas)
               }
           });

   }

   function dev_listdata(dev_list) {
            if(dev_list.length){
              $("#type_manage tbody").empty();
              for(var i=0;i<dev_list.length;i++){
                   var item = dev_list[i];
                //   console.log(item)
                   var IsShow='是';


                   if(item.IsShow<0){

                        IsShow = '否';
                   }else{

                      IsShow='是';
                   }

                   var type2_id_obj=''

                   if(item.type2_id){
                    type2_id_obj = item.type2_id
                   }
                 for (var z in item) {
                      if (item[z] == null) {
                      item[z] = '--'
                      }
                  }
                   var html = '<tr>';
                       html+='<td>'+(i+1)+'</td>';
             
                       html+='<td>'+item.ParentName+'</td>';
                 

                              html+='<td class="idname" data1="'+item.type1_id+'" data2="'+type2_id_obj+'">'+item.Name+'</td>';
                       html+='<td>'+item.RowTime+'</td>';
                       html+='<td>'+item.UpdateTime+'</td>';
                     html+='<td><a href="./index.php?r=goods-type/edit&type1_id='+item.type1_id+'&type2_id='+type2_id_obj+'"><img src="/static/images3/edit.png" alt=""></a></td>';
                       html+='<td class="del"><img src="/static/images3/delete.png" style="cursor: pointer;" alt=""></td>';
                       html+='</tr>';
                       $("#type_manage tbody").append(html)

              }
          }
}
// Get_datas(search_where)
// 取总条数
$.ajax({cache: false,
     async: false,
     type: 'get',
     data:search_where,
     url: "./index.php?r=goods-type/get-page",
     success: function (data) {
          var data = eval('(' + data + ')');
          console.log(data)
          total=data.total;
     }
 });

 dev_listdata(data) 
console.log(total)
  //分页
   $("#page").paging({
    pageNo: 1,
    totalPage: Math.ceil(total/ 10),//
    totalLimit: 10,
    totalSize: total,//
    callback: function(num, nbsp) {
       search_where.limit= nbsp;
       search_where.offset= num * nbsp - nbsp;
  console.log(search_where)
        Get_datas(search_where)
    }
   }) 



     $(function(){


          $(document).on('click','.del',function(){
            var type1_id = 	  $(this).parent().find('.idname').attr('data1');
            var type2_id = 	  $(this).parent().find('.idname').attr('data2');
         //   console.log(type1_id)
        //  console.log(type2_id)






layer.msg('    <div style="padding:50px;    font-size: 25px;">你确认要删除吗？</div>', {
  time: 0 //不自动关闭
   ,btn: ['确定', '取消']
  ,yes: function(index){
   var ii=layer.msg("操作中……");
           $.get('./index.php?r=goods-type/del&type1_id='+type1_id+'&type2_id='+type2_id, function(data) {
                
           //        layer.msg('删除成功'）

            }); 

            layer.close(ii);

    layer.close(index);
  }
});
          }).on('click','.Refresh',function(){
          	window.location.reload();
          })

       



  $("table a").click(function(){
      var _thisURl = $(this).attr('href');

        var Urlobj = encodeURIComponent("&parent_id="+parent_id+"&id="+id);
       $(this).attr('href',_thisURl+"&Url="+Urlobj);


  })
 
     })
</script>
</html>