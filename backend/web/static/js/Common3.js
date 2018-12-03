
function  linkage(obj){
  var addlinkageInfo = this;

  console.log(obj)
    this.name1Info = $("#" + obj.name1);//select对象
    this.name2Info = $("#" + obj.name2);//select对象
    this.name3Info = $("#" + obj.name3);//select对象
   // console.log(addlinkageInfo.name1Info)
    addlinkageInfo.name1Info.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    addlinkageInfo.name2Info.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    addlinkageInfo.name3Info.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    this.data1Fun = function () {
             addlinkageInfo.name1Info.find("option").not(":first").remove();
             addlinkageInfo.name2Info.find("option").not(":first").remove();
             addlinkageInfo.name3Info.find("option").not(":first").remove();
             console.log(obj.where1)
            var proOpts = "";
              $.each(obj.data1, function (index, item) {
                     if(obj.where1==item.Id){
                           proOpts+="<option  selected value='" +item.Id + "'>" + item.Name + "</option>";
                     }else{
                       proOpts+="<option value='" +item.Id + "'>" + item.Name + "</option>";
                     }

              });

               addlinkageInfo.name1Info.append(proOpts);
               addlinkageInfo.name1Info.trigger("chosen:updated");
               addlinkageInfo.name2Info.trigger("chosen:updated");
               addlinkageInfo.name3Info.trigger("chosen:updated");

    }

  this.data2Fun = function () {
            addlinkageInfo.name2Info.find("option").not(":first").remove();
             addlinkageInfo.name3Info.find("option").not(":first").remove();
             console.log(obj.where2)
            var proOpts = "";
              $.each(obj.data2, function (index, item) {
                     if(obj.where2==item.Id){
                           proOpts+="<option  selected value='" +item.Id + "'>" + item.Name + "</option>";
                     }else{
                       proOpts+="<option value='" +item.Id + "'>" + item.Name + "</option>";
                     }
              });

               addlinkageInfo.name2Info.append(proOpts);
               addlinkageInfo.name2Info.trigger("chosen:updated");
               addlinkageInfo.name3Info.trigger("chosen:updated");
                addlinkageInfo.data3Fun();
    }

  this.data3Fun = function () {
            addlinkageInfo.name3Info.find("option").not(":first").remove();
            var proOpts = "";
             var num=0;
            var name1InfoWhin = addlinkageInfo.name1Info.val();
            var name2InfoWhin = addlinkageInfo.name2Info.val();
        console.log(name1InfoWhin)
              $.each(obj.data3, function (index, item) {
                   // if (name1InfoWhin == item.area_center_id&&name2InfoWhin==ParentId) {


                     if(!name1InfoWhin&&!name2InfoWhin){
                      num++
                       if(obj.where2==item.Id){
                             proOpts+="<option  selected value='" +item.Id + "'>" + item.Name + "</option>";
                       }else{
                         proOpts+="<option value='" +item.Id + "'>" + item.Name + "</option>";
                       }
                     }else if(name1InfoWhin&&name2InfoWhin){
                          
                        if(name1InfoWhin==item.ParentId&&name2InfoWhin==item.area_center_id){
                           num++
                           console.log(item)
                            if(obj.where2==item.Id){
                                 proOpts+="<option  selected value='" +item.Id + "'>" + item.Name + "</option>";
                             }else{
                               proOpts+="<option value='" +item.Id + "'>" + item.Name + "</option>";
                             }
                        }
                     }else if(name1InfoWhin&&!name2InfoWhin){
                         
                          if(name1InfoWhin==item.ParentId){
                              num++
                            if(obj.where2==item.Id){
                                 proOpts+="<option  selected value='" +item.Id + "'>" + item.Name + "</option>";
                             }else{
                               proOpts+="<option value='" +item.Id + "'>" + item.Name + "</option>";
                             }
                          }
                     }else if(!name1InfoWhin&&name2InfoWhin){
                          
                          if(name2InfoWhin==item.area_center_id){
                              num++
                            if(obj.where2==item.Id){
                                 proOpts+="<option  selected value='" +item.Id + "'>" + item.Name + "</option>";
                             }else{
                               proOpts+="<option value='" +item.Id + "'>" + item.Name + "</option>";
                             }
                          }
                     }




                      
                    // }
                     
              });

              console.log(num)

               addlinkageInfo.name3Info.append(proOpts);
               addlinkageInfo.name3Info.trigger("chosen:updated");

    }

    this.init=function(){
        addlinkageInfo.data1Fun();
         addlinkageInfo.data2Fun();
        addlinkageInfo.name1Info.bind("change", addlinkageInfo.data2Fun);
        addlinkageInfo.name2Info.bind("change", addlinkageInfo.data3Fun);


        if(obj.where1){
              addlinkageInfo.name1Info.val(obj.where1).trigger("chosen:updated");
        }
        
         if(obj.where2){
              addlinkageInfo.name2Info.val(obj.where2).trigger("chosen:updated");
        }
        
         if(obj.where3){
              addlinkageInfo.name3Info.val(obj.where3).trigger("chosen:updated");
        }
        
       

        $("#removerSub").bind('click',function(){
  
            addlinkageInfo.name1Info.val('').trigger("chosen:updated");;
            addlinkageInfo.name2Info.val('').trigger("chosen:updated");;
            addlinkageInfo.name3Info.val('').trigger("chosen:updated");;
          
        })
    }
      this.init()
// data2Fun ()
}


// 地址方法
var addressResolve = function (options,province,city,area) {
    //检测用户传进来的参数是否合法
    if (!isValid(options))
        return this;
    //默认参数
    var defaluts = {
        proId: 'province',
        cityId: 'city',
        areaId: 'area'
    };
    var opts = $.extend({}, defaluts, options);//使用jQuery.extend 覆盖插件默认参数
    var addressInfo = this;
    this.provInfo = $("#" + opts.proId);//省份select对象
    this.cityInfo = $("#" + opts.cityId);//城市select对象
    this.areaInfo = $("#" + opts.areaId);//区县select对象
    /*省份初始化方法*/
    this.provInfoInit = function () {
        var proOpts = "";

        // console.log(province)

        $.each(options, function (index, item) {
            // console.log(item.PId)
           // proOpts += "<option value='" + item.ProID + "'>" + item.name + "</option>";
        if (item.PId == 0) {
            //$("#province").append();
            if(province==item.Name){
               proOpts+="<option  selected='selected' value='" + item.Name + "'>" + item.Name + "</option>";
             }else{
              proOpts+="<option value='" + item.Name + "'>" + item.Name + "</option>";
             }
           
        }
    });

        
    addressInfo.provInfo.append(proOpts);
    addressInfo.provInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    addressInfo.cityInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10});//初始化chosen
    addressInfo.areaInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10});//初始化chosen
    };
    /*城市选择绑定方法*/
    this.selectCity = function () {
        addressInfo.cityInfo.empty();
        addressInfo.cityInfo.append("<option value=>选择城市</option>");
        addressInfo.areaInfo.empty();
        addressInfo.areaInfo.append("<option value=>选择区县</option>");
 
        if (addressInfo.provInfo.val() == "") { //选择无效时直接返回

           addressInfo.cityInfo.empty().append("<option value= >选择市</option>");
           addressInfo.areaInfo.empty().append("<option value= >选择区</option>");
            addressInfo.cityInfo.trigger("chosen:updated");
            addressInfo.areaInfo.trigger("chosen:updated");
            return;
        }
        var poiuy = addressInfo.provInfo.val();//获取选择的省份值
        var provId = getAddressIdByName(poiuy)
        var cityOpts = "";
        $.each(options, function (index, item) {
            if (item.PId == provId) {

              if(city==item.Name ){

                cityOpts += "<option selected='selected' value='" + item.Name + "'>" + item.Name + "</option>";
              }else{
                cityOpts += "<option value='" + item.Name + "'>" + item.Name + "</option>";
              }
            }
        });
        addressInfo.cityInfo.append(cityOpts);

        if(city){
              addressInfo.selectArea()
        }
        addressInfo.cityInfo.trigger("chosen:updated");
        addressInfo.areaInfo.trigger("chosen:updated");
    };
    /*区县选择绑定方法*/
    this.selectArea = function () {
        if (addressInfo.cityInfo.val() == ""){
        addressInfo.areaInfo.empty().append("<option value= >选择区</option>");
        addressInfo.areaInfo.trigger("chosen:updated");

           return; 
        } 
        addressInfo.areaInfo.empty();
        addressInfo.areaInfo.append("<option value=>选择区县</option>");

        var cityuy = addressInfo.cityInfo.val();//获取选择的城市值
          var cityId = getAddressIdByName(cityuy)
        var areaOpts = "";

        $.each(options, function (index, item) {
            if (item.PId == cityId) {
              if(area== item.Name){
                areaOpts += "<option selected='selected' value='" + item.Name + "'>" + item.Name + "</option>";
              }else{
                areaOpts += "<option value='" + item.Name + "'>" + item.Name + "</option>";
              }
            }
        });
        addressInfo.areaInfo.append(areaOpts);
        addressInfo.areaInfo.trigger("chosen:updated");
    };
    /*对象初始化方法*/
    this.init = function () {
        addressInfo.provInfoInit();
        addressInfo.provInfo.bind("change", addressInfo.selectCity);
        addressInfo.cityInfo.bind("change", addressInfo.selectArea);
        if(province){
        	    addressInfo.selectCity()
        }
        if(city){
        	    addressInfo.selectArea()
        }
  $("#removerSub").bind('click',function(){

      addressInfo.provInfo.empty().append("<option value= >请选择省</option>");
      addressInfo.cityInfo.empty().append("<option value= >请选择市</option>");
      addressInfo.areaInfo.empty().append("<option value= >请选择区</option>");
      province='';
      addressInfo.provInfoInit()
      addressInfo.provInfo.trigger("chosen:updated");
      addressInfo.cityInfo.trigger("chosen:updated");
      addressInfo.areaInfo.trigger("chosen:updated");
    return false;
  })
 }
      init()
      function getAddressIdByName(_name) {
          _name = $.trim(_name);
          if (_name == "") {
              return 0;
          }
          for (var index = 0; index < options.length; index++) {
              var item = options[index];
              var name = $.trim(item.Name);
              if (name != "" && name == _name) {
                  return item.Id;
              }
          }
          return 0;
      }
    
}

// 服务中心 、运营中心

var addressOperateService= function (obj) {
     //检测用户传进来的参数是否合法
    if (!isValid(obj))
        return this;
         //默认参数
    // console.log(obj)
    var addressInfo = this;

        this.agentyInfo = $("#" + obj.agenty);//服务中心 select对象
        this.agentfInfo = $("#" + obj.agentf);//运营中心select对象

        this.agenty=function(){
              if (obj.agenty_data.length) {
                   addressInfo.agentyInfo.empty();
                   addressInfo.agentyInfo.append("<option value=>请选择运营中心</option>");

                  var agentyOpts = "";
                    $.each(obj.agenty_data, function (index, item) {
                        if (item) {
                            // console.log(item)
                            agentyOpts += "<option value='" + item.Id + "'>" + item.Name + "</option>";
                        }
                    });

                    addressInfo.agentyInfo.append(agentyOpts)
                    addressInfo.agentyInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
                    addressInfo.agentfInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
                }
        }
        this.agentf=function(){
           var _thisVal = addressInfo.agentyInfo.val();
           if (obj.agentf_data.length) {
               addressInfo.agentfInfo.empty();
                 addressInfo.agentfInfo.append("<option value=>请选择服务中心</option>");
                var agentfOpts = "";
                  $.each(obj.agentf_data, function (index, item) {
                    if (item) {
                        if(_thisVal==item.ParentId){
                         // console.log(item)  
                        agentfOpts += "<option value='" + item.Id + "'>" + item.Name + "</option>";
                        }
                    }
                });
               addressInfo.agentfInfo.append(agentfOpts);
               addressInfo.agentfInfo.trigger("chosen:updated");
           }
        }

    /*对象初始化方法*/
    this.init = function () {
        addressInfo.agenty();
        addressInfo.agentyInfo.bind("change", addressInfo.agentf);
        if(obj.where_agenty){
              addressInfo.agentyInfo.val(obj.where_agenty);
              addressInfo.agentyInfo.trigger("chosen:updated");
              addressInfo.agentf();
        }
        if(obj.where_agentf){
              addressInfo.agentfInfo.val(obj.where_agentf);
              addressInfo.agentfInfo.trigger("chosen:updated");
        }
    $("#removerSub").bind('click',function(){
        addressInfo.agentyInfo.empty().append("<option value= >请选择运营中心</option>");
        addressInfo.agentfInfo.empty().append("<option value= >请选择服务中心</option>");
        addressInfo.agenty()
        addressInfo.agentyInfo.trigger("chosen:updated");
        addressInfo.agentfInfo.trigger("chosen:updated");
      return false;
    })
    }

    this.init()

}


//设备投资商无关联函数
function devlistFu(obj){
       if(obj.data.length){
        var nameTitle = $('#'+obj.name).text();
           var addressInfo = this;
             this.nameInfo = $("#" + obj.name);//select对象
             this.addFun=function(){
                   addressInfo.nameInfo.empty().append("<option value=>"+nameTitle+"</option>");
                        var devOpts = "";
                         $.each(obj.data, function (index, item) {
                            if (item) {
                                if(item){
                                 // console.log(item)  
                                devOpts += "<option value='" + item.Id + "'>" + item.Name + "</option>";
                                }
                            }
                        });
                        addressInfo.nameInfo.append(devOpts);
                        addressInfo.nameInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             }
             this.init = function () {
              addressInfo.addFun();

                  if(obj.where){
                  $('#'+obj.name)
                    addressInfo.nameInfo.val(obj.where);
                    addressInfo.nameInfo.trigger("chosen:updated");
                  }


             }
        this.init()
      }
}
//无关联函数
function devlistFu2(obj){
       if(obj.data.length){
           var nameTitle = $('#'+obj.name).text();

           var addressInfo = this;
             this.pqdatasInfo = $("#" + obj.name);//select对象
              addressInfo.pqdatasInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen

             this.pqdatasFun2=function(){

                      console.log(nameTitle)
                   addressInfo.pqdatasInfo.empty().append("<option value=>"+nameTitle+"</option>");
                        var devOpts = "";
                         $.each(obj.data, function (index, item) {
                            if (item) {
                                if(item){
                                 // console.log(item)  
                                devOpts += "<option value='" + item.Id + "'>" + item.Name + "</option>";
                                }
                            }
                        });
                        addressInfo.pqdatasInfo.append(devOpts);
                          addressInfo.pqdatasInfo.trigger("chosen:updated");
          
             }
             this.init = function () {
              addressInfo.pqdatasFun2();

                  if(obj.where){
                  $('#'+obj.name)
                    addressInfo.pqdatasInfo.val(obj.where);
                    addressInfo.pqdatasInfo.trigger("chosen:updated");
                  }

                  $("#removerSub").bind('click',function(){
                    addressInfo.pqdatasInfo.empty().append("<option value=>"+nameTitle+"</option>");


                    console.log(1)
                    addressInfo.pqdatasFun2();
                    addressInfo.pqdatasInfo.trigger("chosen:updated");
            
                })
             }
             this.init()
       }
}
//无关联函数
function devlistFu3(obj){
       if(obj.data.length){
           var nameTitle = $('#'+obj.name).text();
           var addressInfo = this;
             this.agentfehtbInfo = $("#" + obj.name);//select对象
             this.agentfehtbFun2=function(){
                   addressInfo.agentfehtbInfo.empty().append("<option value=>"+nameTitle+"</option>");
                        var devOpts = "";
                         $.each(obj.data, function (index, item) {
                            if (item) {
                                if(item){
                                 // console.log(item)  
                                devOpts += "<option value='" + item.Id + "'>" + item.Name + "</option>";
                                }
                            }
                        });
                        addressInfo.agentfehtbInfo.append(devOpts);
                        addressInfo.agentfehtbInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             }
             this.init = function () {
              addressInfo.agentfehtbFun2();

                  if(obj.where){
                  $('#'+obj.name)
                    addressInfo.agentfehtbInfo.val(obj.where);
                    addressInfo.agentfehtbInfo.trigger("chosen:updated");
                  }

                $("#removerSub").bind('click',function(){
                    addressInfo.agentfehtbInfo.empty().append("<option value=>"+nameTitle+"</option>");
                    addressInfo.agentfehtbFun2();
                    addressInfo.agentfehtbInfo.trigger("chosen:updated");
            
                })
             }
             this.init()
       }
}

//无关联函数
function devlistFu4(obj){
       if(obj.data.length){
           var nameTitle = $('#'+obj.name).text();
           var addressInfo = this;
             this.devfactoryInfo = $("#" + obj.name);//select对象
             this.devfactoryFun2=function(){
                   addressInfo.devfactoryInfo.empty().append("<option value=>"+nameTitle+"</option>");
                        var devOpts = "";
                         $.each(obj.data, function (index, item) {
                            if (item) {
                                if(item){
                                 // console.log(item)  
                                devOpts += "<option value='" + item.Id + "'>" + item.Name + "</option>";
                                }
                            }
                        });
                        addressInfo.devfactoryInfo.append(devOpts);
                        addressInfo.devfactoryInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             }
             this.init = function () {
              addressInfo.devfactoryFun2();

                  if(obj.where){
                  $('#'+obj.name)
                    addressInfo.devfactoryInfo.val(obj.where);
                    addressInfo.devfactoryInfo.trigger("chosen:updated");
                  }

                $("#removerSub").bind('click',function(){
                    addressInfo.devfactoryInfo.empty().append("<option value=>"+nameTitle+"</option>");
                    addressInfo.devfactoryFun2();
                    addressInfo.devfactoryInfo.trigger("chosen:updated");
            
                })
             }
             this.init()
       }
}

//无关联函数
function devlistFu5(obj){
       if(obj.data.length){
           var nameTitle = $('#'+obj.name).text();
           var addressInfo = this;
             this.investorInfo = $("#" + obj.name);//select对象
             this.investorFun2=function(){
                   addressInfo.investorInfo.empty().append("<option value=>"+nameTitle+"</option>");
                        var devOpts = "";
                         $.each(obj.data, function (index, item) {
                            if (item) {
                                if(item){
                                 // console.log(item)  
                                devOpts += "<option value='" + item.Id + "'>" + item.Name + "</option>";
                                }
                            }
                        });
                        addressInfo.investorInfo.append(devOpts);
                        addressInfo.investorInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             }
             this.init = function () {
              addressInfo.investorFun2();

                  if(obj.where){
                  $('#'+obj.name)
                    addressInfo.investorInfo.val(obj.where);
                    addressInfo.investorInfo.trigger("chosen:updated");
                  }

                $("#removerSub").bind('click',function(){
                    addressInfo.investorInfo.empty().append("<option value=>"+nameTitle+"</option>");
                    addressInfo.investorFun2();
                    addressInfo.investorInfo.trigger("chosen:updated");
            
                })
             }
             this.init()
       }
}




function isValid(options) {
       return !options || (options && typeof options === "object") ? true : false;
    }


    //水厂 商品 关联渲染

 var water_ommodity = function(obj){
    var addressInfo = this;
  // console.log(obj)  
    this.waterfactoryInfo = $("#" + obj.waterfactoryName);//水厂select对象
    this.waterbrandInfo = $("#" + obj.waterbrandName);//品牌select对象
    this.waternameInfo = $("#" + obj.waternameName);//商品select对象
    this.water_volumeInfo = $("#" + obj.water_volumeName);//容量select对象
    this.waterfactory=function(){
       addressInfo.waterfactoryInfo.empty().append("<option value=>请选择水厂</option>");
       addressInfo.waterbrandInfo.empty().append("<option value=>请选择水品牌 </option>");
       addressInfo.waternameInfo.empty().append("<option value=>请选择水商品</option>");
       addressInfo.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");
       
       var waterOpts = "";
         // console.log(obj.where.factory) 

        $.each(obj.waterfactoryData, function (index, item) {
            if (item) {
                // console.log(item) factory
             if(obj.where.factory==item.PreCode){

                waterOpts += "<option selected='selected'  value='" + item.PreCode + "'>" + item.Name + "</option>";
             }else{
              waterOpts += "<option value='" + item.PreCode + "'>" + item.Name + "</option>";
             }
            }
        });
        addressInfo.waterfactoryInfo.val()
        addressInfo.waterfactoryInfo.append(waterOpts)
        addressInfo.waterfactoryInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        addressInfo.waterbrandInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        addressInfo.waternameInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        addressInfo.water_volumeInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        }
 this.waterfactoryID=function(Id){
       var waterfactoryID = "";
         $.each(obj.waterfactoryData, function (index, item) {
            if (item) {
                // console.log(item) 
                if(item.PreCode ==Id){
                  waterfactoryID=item.Id
                }
                // waterOpts += "<option value='" + item.PreCode + "'>" + item.Name + "</option>";
            }
        });

         return waterfactoryID;
  }   

    this.waterbrand=function(){
                   addressInfo.waterbrandInfo.empty().append("<option value=>请选择水品牌 </option>");
                   addressInfo.waternameInfo.empty().append("<option value=>请选择水商品</option>");
                   addressInfo.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");
                   var waterfactory = addressInfo.waterfactoryInfo.val();//获取选择的水厂值
                   var waterfactoryId = addressInfo.waterfactoryID(waterfactory)
                   var Opts = "";
                    $.each(obj.waterbrandData, function (index, item) {

                   
                        if (item.Fid == waterfactoryId) {
 // console.log(item)          obj.where.devbrand_id
                            if(obj.where.devbrand_id==item.BrandNo ){
                              Opts += "<option  selected='selected'   value='" + item.BrandNo + "'>" + item.BrandName + "</option>";
                            }else{
                              Opts += "<option value='" + item.BrandNo + "'>" + item.BrandName + "</option>";
                            }
                            
                        }
                    });
                   addressInfo.waterbrandInfo.append(Opts)
                   addressInfo.waterbrandInfo.trigger("chosen:updated");
                   addressInfo.waternameInfo.trigger("chosen:updated");
                   addressInfo.water_volumeInfo.trigger("chosen:updated");
    }

  
  this.watername=function(){
        addressInfo.waternameInfo.empty().append("<option value=>请选择水商品</option>");
        addressInfo.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");
         var waterbrandeVal = addressInfo.waterbrandInfo.val();//获取选择的水品牌值
          var Opts = "";
            $.each(obj.waternameData, function (index, item) {
// obj.where.devname_id
                if (item.brand_id == waterbrandeVal) {

                  if(obj.where.devname_id== item.id ){

                    Opts += "<option   selected='selected' value='" + item.id + "'>" + item.name + "</option>";
                  }else{
                     Opts += "<option value='" + item.id + "'>" + item.name + "</option>";    
                  }
                }
            });
            addressInfo.waternameInfo.append(Opts)
            addressInfo.waternameInfo.trigger("chosen:updated");
            addressInfo.water_volumeInfo.trigger("chosen:updated");

  }
  this.water_volume=function(){
        addressInfo.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");
         var waterbrandeVal = addressInfo.waterbrandInfo.val();//获取选择的水品牌值
         var waternameVal = addressInfo.waternameInfo.find("option:selected").text();;//获取选择的水商品值
          var Opts = "";
            $.each(obj.water_volumeData, function (index, item) {
               // console.log(item)
                if (item.brand_id == waterbrandeVal&&item.name == waternameVal) {
                     if(obj.where.water_volume== item.volume ){
                      Opts += "<option  selected='selected'  value='" + item.volume + "'>" + item.volume + " L </option>";
                    }else{
                      Opts += "<option value='" + item.volume + "'>" + item.volume + " L </option>";
                    }
                }
            });
            addressInfo.water_volumeInfo.append(Opts)
            addressInfo.water_volumeInfo.trigger("chosen:updated");
  }
    /*对象初始化方法*/
    this.init = function () {
        addressInfo.waterfactory();
        addressInfo.waterfactoryInfo.bind("change", addressInfo.waterbrand);
        addressInfo.waterbrandInfo.bind("change", addressInfo.watername);
        addressInfo.waternameInfo.bind("change", addressInfo.water_volume);

        if(obj.where.factory&&obj.where.factory!=null){
            addressInfo.waterbrand();
        }
        if(obj.role==2){
          var _ID = 0;
            $.each(obj.waterfactoryData, function (index, item) {
                if (item) {
                    if(obj.factory_precode==item.PreCode){
                        addressInfo.waterfactoryInfo.html("<option  selected='selected'  value='" + item.PreCode + "'>" + item.Name + "</option>");
                        _ID=item.PreCode ;
                     }
                }
            });

           addressInfo.waterfactoryInfo.val(_ID);   
           addressInfo.waterfactoryInfo.trigger("chosen:updated");
           addressInfo.waterbrand();
        }else{

        }
  if(obj.where.devbrand_id&&obj.where.factory!=null){
                  addressInfo.watername();

              }
        if(obj.where.devname_id&&obj.where.factory!=null){

          
          addressInfo.water_volume();



        }

        
         $("#removerSub").bind('click',function(){
             addressInfo.waterfactoryInfo.empty().append("<option value=>请选择水厂</option>");
             addressInfo.waterbrandInfo.empty().append("<option value=>请选择水品牌 </option>");
             addressInfo.waternameInfo.empty().append("<option value=>请选择水商品</option>");
             addressInfo.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");
            addressInfo.waterfactory();
            addressInfo.waterfactoryInfo.trigger("chosen:updated");
            addressInfo.waterbrandInfo.trigger("chosen:updated");
            addressInfo.waternameInfo.trigger("chosen:updated");
            addressInfo.water_volumeInfo.trigger("chosen:updated");
          })


    }
    this.init()
}


//水商品。容量 品牌
var addresWater= function (obj) {
    var addressInfoWater = this;
    this.waterbrandInfo = $("#" + obj.waterbrandName);//品牌select对象
    this.waternameInfo = $("#" + obj.waternameName);//商品select对象
    this.water_volumeInfo = $("#" + obj.water_volumeName);//容量select对象
// 
    this.waterbrand=function(){
     
                   addressInfoWater.waterbrandInfo.empty().append("<option value=>请选择水品牌 </option>");
                   addressInfoWater.waternameInfo.empty().append("<option value=>请选择水商品</option>");
                   addressInfoWater.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");

                   var Opts = "";
                    $.each(obj.waterbrandData, function (index, item) {

                        if (item) {
                           // console.log(item)
                            Opts += "<option value='" + item.BrandNo + "'>" + item.BrandName + "</option>";
                        }
                    });
                   addressInfoWater.waterbrandInfo.append(Opts)
                   addressInfoWater.waterbrandInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
                   addressInfoWater.waternameInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
                   addressInfoWater.water_volumeInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    };

  this.watername=function(){
        addressInfoWater.waternameInfo.empty().append("<option value=>请选择水商品</option>");
        addressInfoWater.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");
         var waterbrandeVal = addressInfoWater.waterbrandInfo.val();//获取选择的水品牌值
          var Opts = "";
            $.each(obj.waternameData, function (index, item) {

                if (item.brand_id == waterbrandeVal) {
                    Opts += "<option value='" + item.name + "'>" + item.name + "</option>";
                }
            });
            addressInfoWater.waternameInfo.append(Opts)
            addressInfoWater.waternameInfo.trigger("chosen:updated");
            addressInfoWater.water_volumeInfo.trigger("chosen:updated");

  }

  this.water_volume=function(){
        addressInfoWater.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");
         var waterbrandeVal = addressInfoWater.waterbrandInfo.val();//获取选择的水品牌值
         var waternameVal = addressInfoWater.waternameInfo.find("option:selected").text();;//获取选择的水商品值
          var Opts = "";
            $.each(obj.water_volumeData, function (index, item) {
               // console.log(item)
                if (item.brand_id == waterbrandeVal&&item.name == waternameVal) {
                     
                    Opts += "<option value='" + item.volume + "'>" + item.volume + " L </option>";
                }
            });
            addressInfoWater.water_volumeInfo.append(Opts)
            addressInfoWater.water_volumeInfo.trigger("chosen:updated");

  }



        /*对象初始化方法*/
    this.init = function () {
        addressInfoWater.waterbrand();


        addressInfoWater.waterbrandInfo.bind("change", addressInfoWater.watername);
        addressInfoWater.waternameInfo.bind("change", addressInfoWater.water_volume);

       if(obj.where.water_brand_where){
        // alert(obj.where.water_brand_where)
          addressInfoWater.waterbrandInfo.val(obj.where.water_brand_where)   
          addressInfoWater.waterbrandInfo.trigger("chosen:updated");
          addressInfoWater.watername();
        }
        if(obj.where.water_goods_where){
        // alert(obj.where.water_brand_where)
          addressInfoWater.waternameInfo.val(obj.where.water_goods_where)   
          addressInfoWater.waternameInfo.trigger("chosen:updated");
          addressInfoWater.water_volume();
        }
        if(obj.where.water_volume_where){
        // alert(obj.where.water_brand_where)
          addressInfoWater.water_volumeInfo.val(obj.where.water_volume_where)   
          addressInfoWater.water_volumeInfo.trigger("chosen:updated");
        }
        $("#removerSub").bind('click',function(){
            addressInfoWater.waterbrandInfo.empty().append("<option value=>请选择水品牌 </option>");
            addressInfoWater.waternameInfo.empty().append("<option value=>请选择水商品</option>");
            addressInfoWater.water_volumeInfo.empty().append("<option value=>请选择水商品容量</option>");
            addressInfoWater.waterbrand();
            addressInfoWater.waterbrandInfo.trigger("chosen:updated");
            addressInfoWater.waternameInfo.trigger("chosen:updated");
            addressInfoWater.water_volumeInfo.trigger("chosen:updated");
          })
      }
    this.init()

}
// 设备品牌型号
var addresEquipmente= function (obj) {
     //检测用户传进来的参数是否合法
    if (!isValid(obj))
        return this;
         //默认参数
    var addressInfo = this;
        this.devbrandInfo = $("#" + obj.devbrand);//服务中心 select对象
        this.devnameInfo = $("#" + obj.devname);//运营中心select对象
        addressInfo.devbrandInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        addressInfo.devnameInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        this.devbrand=function(){
                  var _thisVal = addressInfo.devnameInfo.find("option:selected").attr("date");
               // console.log(_thisVal)
                   if(_thisVal){
                    addressInfo.devbrandInfo.find("option").not(":first").remove();
                       var Opts = "";
                       $.each(obj.devbrand_data, function (index, item) {
                          if (item) {
                            if(item.BrandNo==_thisVal){
                             // console.log(item)
                               Opts += "<option selected value='" + item.BrandNo + "'>" + item.BrandName + "</option>";
                             }
                          }
                      });
                   }else{
                   

                    addressInfo.devbrandInfo.find("option").not(":first").remove();

                    var html = addressInfo.devbrandInfo.html()
                       // console.log(html);
                    var Opts = "";
                     $.each(obj.devbrand_data, function (index, item) {
                        if (item) {
                            // console.log(item)
                            Opts += "<option value='" + item.BrandNo + "'>" + item.BrandName + "</option>";
                        }
                    });
                   }
                 addressInfo.devbrandInfo.append(Opts).trigger("chosen:updated");

        }

        this.devname=function(){
            var _thisVal = addressInfo.devbrandInfo.val();
              if(_thisVal!=' '&&_thisVal){
                  
                  addressInfo.devnameInfo.find("option").not(":first").remove();

                      var Opts = "";
                      $.each(obj.devname_data, function (index, item) {
                          if (item) {
                              // console.log(item)
                              if(item.brand_id==_thisVal){
                                  Opts += "<option value='" + item.id + "'  date='"+item.brand_id+"'>" + item.name + "</option>";
                              }
                            
                          }
                      });
              }else{
                 addressInfo.devnameInfo.find("option").not(":first").remove();
                 var Opts = "";
                      $.each(obj.devname_data, function (index, item) {
                          if (item) {
                              // console.log(item)
                              // if(item.brand_id==_thisVal){
                                  Opts += "<option value='" + item.id + "'  date='"+item.brand_id+"'>" + item.name + "</option>";
                              // }
                            
                          }
                      });
                  }
                  addressInfo.devnameInfo.append(Opts);
                  addressInfo.devnameInfo.trigger("chosen:updated");

        }


    /*对象初始化方法*/
        this.init = function () {
        addressInfo.devbrand();
        addressInfo.devname();
        addressInfo.devbrandInfo.bind("change", addressInfo.devname);
        // addressInfo.devnameInfo.bind("change", addressInfo.devbrand);


        if(obj.where.devbrand){
          addressInfo.devbrandInfo.val(obj.where.devbrand);    
           addressInfo.devbrandInfo.trigger("chosen:updated");
          addressInfo.devname();
        }

         if(obj.where.devname){
          addressInfo.devnameInfo.val(obj.where.devname);    
          addressInfo.devnameInfo.trigger("chosen:updated");
        }

        $("#removerSub").bind('click',function(){
             addressInfo.devbrandInfo.empty().append("<option value=>请选择设备品牌</option>");
             addressInfo.devnameInfo.empty().append("<option value=>请选择设备型号 </option>");
            addressInfo.devbrand();
            addressInfo.devbrandInfo.trigger("chosen:updated");
            addressInfo.devnameInfo.trigger("chosen:updated");
          })

    }
    this.init()
}

// 版本号
   var addressSelect = function(obj){
       // console.log(obj)
          var addressInfo = this;
             this.type_Info = $("#" + obj.type_Id);//select对象
             this.version_Info = $("#" + obj.version_Id);//select对象
             this.addtypeFun=function(){
                   addressInfo.type_Info.empty().append("<option value=>请选择设备类型</option>");
                   addressInfo.version_Info.empty().append("<option value=>请选择版本号</option>");
                        var devOpts = "";
                         $.each(obj.select_type, function (index, item) {
                            if (item) {
                                if(item){
                                 // console.log(item)  
                                devOpts += "<option value='" + item.Type + "'>" + item.Type + "</option>";
                                }
                            }
                        });
                        addressInfo.type_Info.append(devOpts);
                        addressInfo.type_Info.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
                        addressInfo.version_Info.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
             }
             this.addversionFun=function(){
                addressInfo.version_Info.empty().append("<option value=>请选择版本号</option>");
                var version_val = addressInfo.type_Info.val();
                var devOpts = "";
                $.each(obj.select_version, function (index, item) {
                    if (item) {
                       // console.log(item)  
                        if(item.Type==version_val){
                        
                        devOpts += "<option value='" + item.Version + "'>" + item.Version + "</option>";
                        }
                    }
                  });
                   addressInfo.version_Info.append(devOpts);
                   addressInfo.version_Info.trigger("chosen:updated");
             }

            this.init = function () {
                 addressInfo.addtypeFun();
                 addressInfo.type_Info.bind("change", addressInfo.addversionFun);

              if(obj.where._type){
                addressInfo.type_Info.val(obj.where._type);
                addressInfo.type_Info.trigger("chosen:updated");
                addressInfo.addversionFun();
               }
             if(obj.where.version){
               addressInfo.version_Info.val(obj.where.version);
               addressInfo.version_Info.trigger("chosen:updated");
             }



                $("#removerSub").bind('click',function(){
                   addressInfo.type_Info.empty().append("<option value=>请选择设备类型</option>");
                   addressInfo.version_Info.empty().append("<option value=>请选择版本号 </option>");
                  addressInfo.addtypeFun();
                  addressInfo.type_Info.trigger("chosen:updated");
                  addressInfo.version_Info.trigger("chosen:updated");
                  })
            }
      this.init()
   }





//入网属性

function usetypeFun(obj){
   if(obj.data.length){
    var nameTitle = $('#'+obj.name).text();

       var addressInfo = this;
        this.usetypeInfo = $("#" + obj.name);//select对象
          // console.log(addressInfo.usetypeInfo)
         this.usetypeb=function () {
          addressInfo.usetypeInfo.empty().append("<option value=>"+nameTitle+"</option>");;
            var devOpts = "";
             $.each(obj.data, function (index, item) {
                if (item) {
                    if(item){
                     // console.log(item)  
                    devOpts += "<option value='" + item.use_type + "'>" + item.use_type + "</option>";
                    }
                }
            });
          addressInfo.usetypeInfo.append(devOpts);
          addressInfo.usetypeInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
         }
      
         this.init = function () {
            addressInfo.usetypeb();
            // console.log(obj.where)
            if(obj.where){
              addressInfo.usetypeInfo.val(obj.where);    
              addressInfo.usetypeInfo.trigger("chosen:updated");
            }

         $("#removerSub").bind('click',function(){
             addressInfo.usetypeInfo.empty().append("<option value=>入网属性</option>");
            addressInfo.usetypeb();
            addressInfo.usetypeInfo.trigger("chosen:updated");
          })
         }
 this.init()
   }
}


//用户类型
function customertypea(obj){

  console.log(obj)
       var addressInfo = this;
        this.customertypeInfo = $("#" + obj.name);//select对象

          // console.log(addressInfo.customertypeInfo)
         this.customertype=function () {
           addressInfo.customertypeInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
         }
      
         this.init = function () {
          addressInfo.customertype();
            if(obj.where){
              addressInfo.customertypeInfo.val(obj.where);    

              addressInfo.customertypeInfo.trigger("chosen:updated");
            }

         $("#removerSub").bind('click',function(){
            addressInfo.customertypeInfo.val('');
            // if(obj.name=='order_state'){
              
            // }
            addressInfo.customertypeInfo.trigger("chosen:updated");
          })
         }
 this.init()
   
}

//用户类型
function dev_state(obj){
       var addressInfo = this;
        this.customerInfo = $("#" + obj.name);//select对象

          // console.log(addressInfo.customertypeInfo)
         this.customertype=function () {
            addressInfo.customerInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
         }
      
         this.init = function () {
          addressInfo.customertype();
            if(obj.where){

              addressInfo.customerInfo.val(obj.where);    

              addressInfo.customerInfo.trigger("chosen:updated");
            }

         $("#removerSub").bind('click',function(){
            addressInfo.customerInfo.val('');
            
            addressInfo.customerInfo.trigger("chosen:updated");
          })
         }
 this.init()
   
}


//用户类型
function dev_state2(obj){
  // console.log(obj)
       var addressInfo = this;
        this.stateInfo = $("#" + obj.name);//select对象

 //          // console.log(addressInfo.customertypeInfo)
         this.customertype=function () {
            addressInfo.stateInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
         }
      
         this.init = function () {
          addressInfo.customertype();
            if(obj.where){

              addressInfo.stateInfo.val(obj.where);    

              addressInfo.stateInfo.trigger("chosen:updated");
            }

         $("#removerSub").bind('click',function(){
            addressInfo.stateInfo.val('');
            
            addressInfo.stateInfo.trigger("chosen:updated");
          })
         }
 this.init()
   
}


//用户类型1
function dev_state3(obj){
       var addressInfo = this;
        this.dev_stateInfo = $("#" + obj.name);//select对象
          // console.log(addressInfo.customertypeInfo)
         this.dev_statetype=function () {
            addressInfo.dev_stateInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
         }
      
         this.init = function () {
          addressInfo.dev_statetype();
            if(obj.where){
              addressInfo.dev_stateInfo.val(obj.where);    
              addressInfo.dev_stateInfo.trigger("chosen:updated");
            }
         $("#removerSub").bind('click',function(){
            addressInfo.dev_stateInfo.val(1);
            addressInfo.dev_stateInfo.trigger("chosen:updated");
          })
         }
 this.init()
   
}






// 当前时间获取
  function GetDateStr(AddDayCount, AddMonthCount) {
    var dd = new Date();
    dd.setDate(dd.getDate() + AddDayCount); //获取AddDayCount天后的日期
    var y = dd.getFullYear();
    var m = dd.getMonth() + AddMonthCount; //获取当前月份的日期
    var d = dd.getDate();
    if (String(d).length < 2) {
      d = "0" + d;
    }
    if (String(m).length < 2) {
    m = "0" + m;
    }
    return y + "-" + m + "-" + d;
  };
 // 百分比数
function Percentage(number1, number2) {
  if (number2 == 0) {
      number2 = 1;
  }
  return (Math.round(((number1 / number2) - 1) * 10000) / 100.00); // 小数点后两位百分比
}



// 计算时间天数
function diy_time(time1num, time2num) {
  time1data = Date.parse(new Date(time1num));
  time2data = Date.parse(new Date(time2num));
  return time3 = Math.abs(parseInt((time2data - time1data) / 1000 / 3600 / 24));
}





function NumberDays(xin, _date, _datenume) {
  // console.log(xin)
// console.log(_datenume)
  var xin = xin+_datenume-1;
  // console.log(xin)
  var _datenume = _datenume || 0;
  for (var i = -_datenume; i >= -xin; i--) {
    // console.log(i)
    _date.push(GetDateStr(i, 1))
  }
  _date.reverse();
  return _date;
}
//去重
function unique($data) {
  var res = [];
  var json = {};

  for (var p = 0; p < $data.length; p++) {
    if (!json[$data[p]]) {
      res.push($data[p]);
      json[$data[p]] = 1;
    } else {}
  }
  return res;
}