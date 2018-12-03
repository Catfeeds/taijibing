<?php
use yii\widgets\LinkPager;
error_reporting( E_ALL&~E_NOTICE );
?>
<link rel="stylesheet" href="./static/css/newTheme/newTheme.css"/>
 <link href="/static/css/style.min862f.css?v=4.1.0" rel="stylesheet">
  <link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
<link rel="stylesheet" href="./static/css/chosen.css"/>

<link rel="stylesheet" href="./static/css/Common.css"/>


<style>

*{
  font-size: 14px;
  }
 .search span{
    /*display: inline-flex;*/

}
.search span label{
    width:100px;
    margin-top: 5px
}
.search span {
    width: initial;

}
.provincecity  input, select, option {
    width:inherit;
}
 input{
  width:200px;
}
.wrapper .row label {
   padding: 0 10px;
    margin-top: 5px;
    margin-left:-5px;
        width: 100px;
}
.wrapper .row label {
    padding: 0 10px;
 
    margin-top: 5px;
}
#btn,#btnn{
    width: 50px;
    height: 30px;
    display: inline-block;
    line-height: 30px;
    text-align: center;
      background-color: #E46045;
    color: #bb442d;
    padding: 0;
    border:none;
    color: #fff
}
 input{
  width:240px;
}




.multiple-choice{
    background:#2D3136;
    border-color:#2D3136;
    margin-left: -4px;
   width: initial;;
    border-radius:4px;
}
.multiple-choice .chosen-container:first-child{
  margin-left: -10px;
}
select {
    min-width: 100px;
    background-color: #2D3136;
    color: #BABABF;
}
.table td a{
    padding: 5px;
}
.table td a:hover{
  background-color: #E46045;
  padding: 5px;
  border-radius: 2px;
  color: #fff !important;
}

    </style>
    <div class="wrapper wrapper-content">
         <div style="float: left; margin-left: 20px;"><img src="/static/images3/sidebar.png" alt="搜索"><span class="font-size-S" style='    font-size: 12px;'>&nbsp;供应商</span></div>
         <div style='clear:both'> </div>
        <div style=" margin-top: 20px;   padding: 33px 15px;" class="condition" >
            <form action="/index.php?r=supplier/list" method="post">
                    <div class="container-fluid">
                         <div class="row">
                              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                      <span style=" display: inline-flex;"><label>名称:</label>
                                        <input type="text" placeholder="请输入名称" id="username" name="Name" value=""/></span> 
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                                       <span style=" display: inline-flex;;
">
                                            <label >账号/手机号:</label>
                                           &nbsp; <input type="text" placeholder="请输入 账号/手机号" id="mobile" value="" name="LoginName"/>
                                        </span>
                                </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top: 20px;"> 
                                       
                                         <label >品牌选择</label>
                                         <div class="multiple-choice">
                                            <select class="control-label" name="logic_type"  id="logic_type">
                                                <option value>选择角色</option>
                                                <option value="1" >供应商</option>
                                                <option value="2" >设备厂家</option>
                                        </select>
                                         <select class="control-label " name="BrandName"  id="water_brands">
                                             <option value="" >选择品牌</option>
                                        </select>
                                            <select class="control-label" name="GoodsName"  id="water_names">
                                                <option value="" >选择商品型号</option>
                                        </select>
                                        
                                    </div>
                                </div>
                        
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" class="provincecity"  style="margin-top: 20px;">
                                      <label >地区:</label>
                                        <div class="multiple-choice" style="margin-left:0px">
                                            <select class="control-label" name="Provence"  id="province">
                                                            <option value="" >选择省</option>
                                                            </select>
                                            <select class="control-label" name="City" id="city">
                                               <option value="" >选择市</option>
                                            </select>
                                            <select class="control-label" name="Area" id="area">
                                                <option value="" >选择区</option>
                                            </select>
                                           
                                        </div>
                                          <input type="submit" class="btn" value="查询"/ id="btnn" style="   line-height: 0; margin-left: 10px;   margin-top: -5px;border:none">
                                  </div>
                          
                         </div>
                    </div>
            </form>
        </div>
  <table class="table table-hover"  >
             <thead>
                    <th style="width: 5%" id="sort" data="1">序号</th>
                    <th style="width: 6%">登录账号</th>
                    <th  style="width: 9%">名称</th>
                    <th style="width: 10%">角色</th>
                    <th style="width: 8%">所在区域</th>
                    <th style="width: 6%">联系人</th>
                    <th style="width: 6%">联系电话</th>
                    <th style="width: 6%">品牌</th>
                    <th style="width: 6%">商品名称</th>
                    <th style="width: 4%">商品规格</th>
                    <th style="width: 6%"><a data="LeftAmount">条码余额</a></th>
                    <th style="width: 9%"><a data ="LastUpTime">最近操作时间</a></th>
                    <th style="width: 10%">条码记录</th>
                    <th style="width: 10%">操作</th>
            </thead>
            <tbody id='tableData'>

            </tbody>
        </table>
    </div>

    <div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">

  <div id="page" class="page_div"></div>
</div>


    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script> 
    <script type="text/javascript" src="/static/js/Common2.js?v=2.9"></script> 
<script type="text/javascript" src="/static/js/dev-statistics/paging.js"></script>
    <script>
       var select_where =<?=$select_where?>;
       var form_datas =<?=$form_datas?>;
       var checked_datas =<?=json_encode($checked_datas)?>;
        for (var z in checked_datas) {
          if (checked_datas[z] == null) {
            checked_datas[z] = ''
          }
        }

        console.log(select_where)

        $("#username").val(checked_datas.Name);
        $("#mobile").val(checked_datas.LoginName);
        $("#logic_type").val(checked_datas.logic_type);
       var total =<?=$total?>;
// 地址渲染 
addressResolve(select_where.address,checked_datas.Provence,checked_datas.City,checked_datas.Area)
$("#logic_type").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
$("#water_brands").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
$("#water_names").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
// 设备品牌型号

addresEquipmente2({
     logic_type:'logic_type',
     logic_type_data:[{'name':'供应商','id':1},{'name':'设备厂家','id':2}],
     devbrand:'water_brands',
     devbrand_data:select_where.brands,
     devname:'water_names',
     devname_data:select_where.goods,
     where:{
        logic_type:$("#logic_type").val()||'',
        devbrand:checked_datas.BrandName,
        devname:checked_datas.GoodsName
     }
});




dev_listdata(form_datas) 
  paging({
    pageNo: 1,
    totalPage: Math.ceil(total / 10),
    totalLimit: 10,
    totalSize:total,
    callback: function(num, nbsp) {
      var searchParameters =checked_datas;
          searchParameters.offset=num * nbsp - nbsp;
          searchParameters.limit=nbsp;
 // console.log(searchParameters)
           Get_datas(searchParameters,num)
    }
  })
  function  Get_datas(searchParameters,num){
 // console.log(searchParameters)
    
     var ii =   layer.open({
          type: 1,
          skin: 'layui-layer-demo', //样式类名
          closeBtn: 0, //不显示关闭按钮
          anim: 2,
          shade: [0.8, '#000'],
          shadeClose: false, //开启遮罩关闭
          content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
        });

  $.post("./index.php?r=supplier/list-page", searchParameters, function(data){
       layer.close(ii); 

           if(typeof(data)=='string'){
                data=  jQuery.parseJSON(data);
           }
         var sales_detail=data.form_datas
         dev_listdata(sales_detail,num)
  })
}
       function dev_listdata(data,num) {
           var j = 0;
         $("#tableData").empty();
             for (var i = 0; i < data.length; i++) {
              var item = data[i]
                for (var z in item) {
                  if (item[z] == null) {
                    item[z] = '--'
                  }
                }
                j++;

                 var logic_type= item.logic_type;
                   if(item.logic_type==1){
                    logic_type='供应商'
                   }else{
                    logic_type="设备厂家"
                   }


                   if(item.Fid=='--'){
                    item.Fid=''
                   }
            var html = '<tr><td>'+j+'</td>';
                html += '<td>'+item.LoginName  +'</td>';
                html += '<td>'+item.Name  +'</td>';
                html += '<td>'+logic_type +'</td>';
                html += '<td>'+item.Province +"-"+item.City+"-"+item.Area+'</td>';
                html += '<td>'+item.ContractUser  +'</td>';
                html += '<td>'+item.ContractTel +'</td>';
                html += '<td>'+item.BrandName  +'</td>';
                html += '<td>'+item.GoodsName  +'</td>';
                html += '<td>'+item.Volume  +'</td>';
                html += '<td>'+item.LeftAmount  +'</td>';
                html += '<td>'+item.LastUpTime  +'</td>';
                html += '<td>';
                html += '<p style="color: #D05626;margin:0"><a href="/index.php?r=supplier/recharge-log&BrandId='+item.BrandId+'&Fid='+item.Fid+'&logic_type='+item.logic_type+'&GoodsId='+item.GoodsId+'  "   style="color:#D05626">条码充值记录</a></p>';

                html += '<p style="color:#00C38F;"><a href="/index.php?r=supplier/use-log&Fid='+item.Fid+'&logic_type='+item.logic_type+'&GoodsId='+item.GoodsId+'  "   style="color:#00C38F">条码使用记录</a></p>';
         

                html += '</td>';
                html += '<td><a href="/index.php?r=supplier/recharge&BrandId='+item.BrandId+'&GoodsId='+item.GoodsId+'&Volume='+item.Volume+'&Fid='+item.Fid+'&logic_type='+item.logic_type+'  "   style="color:#DBAF44">充值</a></td>';
                  html += '</tr>';
                $("#tableData").append(html);
             }
       }
     $(".table th a").click(function(){
            var _thisdata = $(this).attr('data');
            var _sortdata = $("#sort").attr('data');
            _sortdata++
            $("#sort").attr('data',_sortdata)
            // console.log(_thisdata)
            // console.log(_sortdata)

      // var checked_datas =checked_datas;
          checked_datas.order_column=_thisdata;
          checked_datas.sort=_sortdata;
          // console.log(checked_datas)
              // var Urlobj = encodeURIComponent(url);
            // $(this).attr('href',_thisURl+"&Url="+Urlobj)
                Get_datas(checked_datas)

                paging({
                    pageNo: 1,
                    totalPage: Math.ceil(total / 10),
                    totalLimit: 10,
                    totalSize:total,
                    callback: function(num, nbsp) {
                      var searchParameters =checked_datas;
                          searchParameters.offset=num * nbsp - nbsp;
                          searchParameters.limit=nbsp;
                      
                           // console.log(searchParameters)
                           Get_datas(searchParameters,num)
                    }
                  })         
        })





       

         $(document).on('click','.table td a',function(){

          var where_datas=checked_datas;
            var url='';
            // var result = JSON.stringify(where_datas)
            for(var i in where_datas){
              if(where_datas[i]==null){
                 where_datas[i]=''
              }
              url= url +"&"+ i+'='+where_datas[i]
            }
           var _thisURl = $(this).attr('href');
            // console.log(where_datas)
              var Urlobj = encodeURIComponent(url);
            $(this).attr('href',_thisURl+"&Url="+Urlobj)
          // console.log(_thisURl)
            // return false;
         })
      
    </script>
