

    // console.log(datas)
// console.log(where_datas)

// 地址渲染 

addressResolve(where_datas.areas,datas.where.province,datas.where.city,datas.where.area);
// if(datas.where.state){
//   $("#state").val(datas.where.state)
// }
// $("#state").chosen({no_results_text: "没有找到",disable_search_threshold: 10})

// 设备品牌型号
addresEquipmente({
     devbrand:'devbrand_id',
     devbrand_data:where_datas.devbrand,
     devname:'devname_id',
     devname_data:where_datas.devname,
     where:{
        devbrand:datas.where.devbrand_id,
        devname:datas.where.devname_id
     }
})
// 版本号
addressSelect({
     type_Id:'select_type',
     select_type:where_datas.select_type,
     version_Id:'select_version',
     select_version:where_datas.select_version,
     where:{
        _type:datas.where.select_type,
        version:datas.where.select_version
     }
})
// 设备厂家
devlistFu({
	name:'devfactory_id',
	data:where_datas.devfactory,
	where:datas.where.devfactory_id
})

// 设备投资商
devlistFu2({
	name:'investor_id',
	data:where_datas.investor,
	where:datas.where.investor_id
})
// 服务中心 、运营中心
  addressOperateService({
     agenty:'agenty_id',
     agenty_data:where_datas.agenty,
     agentf:'agentf_id',
     agentf_data:where_datas.agentf,
     where_agenty:datas.where.agenty_id,
     where_agentf:datas.where.agentf_id
  })

  //用户类型
customertypea({
  name:'customertype',
  where:datas.where.customertype
})

//用户类型
dev_state({
  name:'dev_state',
  where:datas.where.dev_state
})


//用户类型
dev_state2({
  name:'state',
  where:datas.where.state
})

// 状态记录
if(datas.where.search){
	$("#searchp").val(datas.where.search)
}
if(datas.where.start){
	$(".startIccid").val(datas.where.start)
}
if(datas.where.end){
	$(".endIccid").val(datas.where.end)
}





console.log( datas.where)
 //分页
 $("#page").paging({
  pageNo: 1,
  totalPage: Math.ceil(datasNum / 10),
  totalLimit: 10,
  totalSize: datasNum,
  callback: function(num, nbsp) {
    for(var i in datas.where){
       console.log(datas.where[i])
       if(datas.where[i]==null){
          datas.where[i]=''
       }
    }
  // console.log(datas.where)
  var searchParameters =datas.where;
    searchParameters.limit=nbsp;
    searchParameters.offset=num * nbsp - nbsp;
    // var searchParameters = {
    //   selecttime: datas.where.selecttime,
    //   province: datas.where.province,
    //   city: datas.where.city,
    //   area: datas.where.area,

    //   state: datas.where.state,
    //   devbrand_id: datas.where.devbrand_id,
    //   devname_id: datas.where.devname_id,

    //   devfactory_id: datas.where.devfactory_id,
    //   investor_id: datas.where.investor_id,
    //   customertype: datas.where.customertype,
    //   search: datas.where.search,
    //   agentf_id:datas.where.agentf_id,
    //   agenty_id:datas.where.agenty_id,
    //   select_type:datas.where.select_type,
    //   select_version:datas.where.select_version,
    //   start:datas.where.start,
    //   end:datas.where.end,
    //   offset: num * nbsp - nbsp,
    //   limit: nbsp
    // }
    console.log(searchParameters)
    if(datasNum*1>0){
        Get_datas(searchParameters,num)
    }
  }
 })

 function Get_datas(searchParameters,num) {
  var ii = layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shadeClose: false, //开启遮罩关闭
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });
  $.post('./index.php?r=version-manage/dev-list', searchParameters, function(data) {
    var data = eval('(' + data + ')');
     layer.close(ii);
     dev_listdata(data,num)
  })
 };



// 表格

 function dev_listdata(datas,num) {
  if (datas.length) {
    // alert(num)
console.log(datas)
    $("#dev_list_body").empty();
    for (var i = 0; i < datas.length; i++) {
      var item = datas[i];

      for (var z in item) {
        if (item[z] == null) {
          item[z] = '-'
        }
      }
      var CustomerType;
      if (item.CustomerType == 1) {
        CustomerType = '家庭'
      } else if (item.CustomerType == 2) {
        CustomerType = '公司'
      } else if (item.CustomerType == 3) {
        CustomerType = '集团'
      } else if (item.CustomerType == 4) {
        CustomerType = '酒店'
      } else {
        CustomerType = '其他'
      };
      var IsUpgrade;
      if (IsUpgrade) {
        IsUpgrade = '允许'
      } else {
        IsUpgrade = '不允许'
      }
      var State;
      if (State) {
        State = '完成'
      } else {
        State = '未完成'
      };
      var html = '<tr>'
      html += '<td > <input type="checkbox"  name="state" value="1"  id="state_' + i + '" class="state" / ><label for="state_' + i + '"></label></td>'
 // ((num-1)*10 + i+1)*1 
      html += '<td><span>&nbsp;' + (i+1)+ '</span></td>'
      html += '<td class="DevNo"><div>' + item.DevNo + '</div></td>'
      html += '<td>' + item.HwNo + '</td>'
      html += '<td   class="DevType">' + item.DevType + '</td>'
      html += '<td>' + item.username + '</td>'
      html += '<td>' + item.Tel + '</td>'
      html += '<td class="oiuy">' + CustomerType + '</td>'
      html += '<td>' + item.agentname + '</td>'
      html += '<td>' + item.agentpname + '</td>'
      html += '<td class="devname" dataId="' + item.goods_id + '">' + item.devname + '</td>'
      html += '<td class="devbrand"  dataId="' + item.brand_id + '">' + item.devbrand + '</td>'
      html += '<td class="devfactory">' + item.devfactory + '</td>'
      html += '<td>' + item.investor + '</td>'
      html += '<td>' + item.Province + '-' + item.City + '-' + item.Area + '</td>'
      html += '<td>' + item.Address + '</td>'


      html += '<td>' + item.StartTime + '</td>'
      html += '<td>' + item.EndTime + '</td>'
      html += '<td>' + item.UpgradeTime + '</td>'
      html += '<td>' + item.LastConnectTime + '</td>'


      // html += '<td>' + item.UpgradeTime + '</td>'
      html += '<td>' + item.Version + '</td>'
      html += '<td class="IsUpgrade" >' + StateInit(item.IsUpgrade, item.State, item.StartTime, item.EndTime) + '</td>'
      html += '<td><div class="promote" style="padding:5px;"><img src="/static/images3/Edition.png" alt=""></div></td>'
      html += '</tr>';

      $("#dev_list_body").append(html)
    }
  }



 function StateInit(IsUpgrade, State,StartTime,EndTime) {

if(IsUpgrade=='-'){
  IsUpgrade=''
}

if(State=='-'){
  State=''
}
// console.log(IsUpgrade)
// console.log(State)
// console.log(StartTime)
// console.log(EndTime)
// console.log(GetDatr)
var atu;
var time1dataA = Date.parse(new Date());

var time1dataEndTime ;
var time1dataStartTime ;
if(StartTime){
  time1dataStartTime= Date.parse(new Date(StartTime));
}

if(EndTime){
  time1dataEndTime= Date.parse(new Date(EndTime));
}
  var res='<span style="color:#E34F32">未在升级</span>';
  if (!StartTime&& !EndTime) {
    res = '<span style="color:#E34F32">未在升级</span>';
  }else if(IsUpgrade == 0 && time1dataA>time1dataEndTime){
     res = '<span style="color:#E34F32">未在升级</span>';
  }else if(IsUpgrade == 1 && time1dataA<time1dataStartTime){
     res = '<span style="color:#E34F32">未在升级</span>';
  }
// console.log(time1dataStartTime)

  else if(IsUpgrade == 1&& State==0 &&time1dataA>time1dataStartTime  && time1dataA<time1dataEndTime){
     res = '<span style="color:#E34F32">等待升级</span>';
  }
// 
else if(IsUpgrade == 1 &&  State==1){
     res = '<span style="color:#E34F32">升级中</span>'
  }
else if(State=2&&time1dataA>time1dataStartTime&&time1dataA<time1dataEndTime){
     res = '<span style="color:#E34F32">升级完成</span>'
  }


  // if (IsUpgrade == 0 && State == 0) {
  //   res = '<span style="color:#E34F32">未在升级</span>'
  // }
  // if (IsUpgrade == 1 && State == 0) {
  //   res = '<span style="color:#3DCCCD">等待升级</span>'
  // }
  // if (IsUpgrade == 1 && State == 1) {
  //   res = '<span style="color:#AB47BD">升级完成</span>'
  // } else {
  // }
  return res;
  }
 }
 //弹窗
 function layerdatefun(html) {
  var ppp = layer.open({
    type: 1,
    title: false,
    area: ['730px', '500px'],
    closeBtn: 0,
    shadeClose: true,
    skin: 'yourclass',
    content: html
  });

var start = {
elem: '#start_time',
format: 'YYYY-MM-DD hh:mm:ss',
min: laydate.now(), //设定最小日期为当前日期
// max: '2099-06-16 23:59:59', //最大日期
istime: true,
istoday: false,
choose: function(datas){
    // console.log(datas)
end.min = datas; //开始日选好后，重置结束日的最小日期
end.start = datas //将结束日的初始值设定为开始日
}
};

var end = {
elem: '#end_time',
format: 'YYYY-MM-DD hh:mm:ss',
min: laydate.now(+1),
// max: '2099-06-16 23:59:59',
istime: true,
istoday: false,
choose: function(datas){

start.max = datas; //结束日选好后，重置开始日的最大日期
}
};
laydate(start);
laydate(end);

  $('.Close').click(function() {
    layer.close(ppp);
  })

   $('.dropdown-menu li').on('click', function() {
      var _thisval = $(this).attr('value');
      var _thisvalt;

      if (_thisval == ' ' || !_thisval || _thisval == 0) {
        _thisvalt = '请选择版本号';
      } else{
        _thisvalt=_thisval
      }

      var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
           
      if (_thisval != _toggleval) {
        $(this).parent().siblings(".dropdown-toggle").val(_thisval).html(_thisvalt + '&nbsp;<span class="caret"></span>');
        $("#target_val").val(_thisvalt)

      }
    })



  $('.submit').click(function() {
    var target_version  =   $("#target_val").val()
    var start_time  =  $("#start_time").val();
    var end_time  =  $("#end_time").val();
    if(!target_version){
         layer.msg('请选择版本号')
         return false;
    }
    if(!start_time){
         layer.msg('请选择开始时间');
         return false;
    }
    if(!end_time){
         layer.msg('请选择结束时间');
         return false;
    }



  })


 }


