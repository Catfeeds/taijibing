/**
 * Created by pengjixiang on 2017/9/19.
 */
var citypicker={

    provincehandledData:null,
    cityhandledData:[],
    areahandledData:[],
    province:null,
    city:null,
    area:null,
    initArea:function(){
        if(this.city==null||this.province==null){
            $(".address_list").empty();
            return;
        }
        this.areahandledData=[];
        var letter=ucfirst(ConvertPinyin(this.city.name));
        var citys=this.cityhandledData[letter][this.city.index].city;
        var letterIndexes=[];
        for(var index=0;index<citys.length;index++){
            var letter=ucfirst(ConvertPinyin(citys[index]));
            if(typeof this.areahandledData[letter] =="undefined"){
                this.areahandledData[letter]=[];
            }
            this.areahandledData[letter].push({
                name:citys[index]
            });
        }
        this.updateListPage(this.areahandledData);
        $(".address_ul li").on("click",function(){
            var area=$(this).text();
            var index=$(this).attr("index");
            citypicker.area={"name":area,"index":index};
            $("#area").text(area);
            app.listOrder();
        });

    },
    initProvince: function () {
        if(this.provincehandledData==null){
            this.provincehandledData=[];
            var letterIndexes=[];
            for(var index=0;index<addressData.length;index++){
                var letter=ucfirst(ConvertPinyin(addressData[index].name));
                if(typeof this.provincehandledData[letter] =="undefined"){
                    this.provincehandledData[letter]=[];
                }
                this.provincehandledData[letter].push({
                    city:addressData[index].city,
                    name:addressData[index].name
                });
            }
        }
        this.updateListPage(this.provincehandledData);
        $(".address_ul li").on("click",function(){
            var province=$(this).text();
            var index=$(this).attr("index");
            citypicker.province={"name":province,"index":index};
            $("#province").text(province);
            $("#city").text("请选择市");
            citypicker.city=null;
            $("#area").text("请选择区");
            citypicker.area=null;
            citypicker.switchSelect(1);
        });
    },
    initCity:function(){
        if(this.province==null){
            $(".address_list").empty();
            return;
        }
        this.cityhandledData=[];
            var letter=ucfirst(ConvertPinyin(this.province.name));
            var citys=this.provincehandledData[letter][this.province.index].city;
            var letterIndexes=[];
            for(var index=0;index<citys.length;index++){
                var letter=ucfirst(ConvertPinyin(citys[index].name));
                if(typeof this.cityhandledData[letter] =="undefined"){
                    this.cityhandledData[letter]=[];
                }
                this.cityhandledData[letter].push({
                    city:citys[index].area,
                    name:citys[index].name
                });
            }
        this.updateListPage(this.cityhandledData);
        $(".address_ul li").on("click",function(){
            var city=$(this).text();
            var index=$(this).attr("index");
            citypicker.city={"name":city,"index":index};
            $("#city").text(city);
            $("#area").text("请选择区");
            citypicker.area=null;
            citypicker.switchSelect(2);
        });
    },
    updateListPage:function(_handledData){
        var firstLetters=[];
        for(var key in _handledData){
            if(key.length!=1){
                continue;
            }
            firstLetters.push(key);
        }
        firstLetters.sort();
        $(".flags_list").empty();
        $(".flags_list").append("<li>#</li>");
        for(var index=0;index<firstLetters.length;index++){
            $(".flags_list").append("<a href='#"+firstLetters[index]+"'><li>"+firstLetters[index]+"</li></a>");
        }
        $(".address_list").empty();
        for(var index=0;index<firstLetters.length;index++){
            var wrap_c_str='<div class="wrap_c">'+
                '<a name="'+(firstLetters[index])+'"><p style="padding-left:22px;height:34px;background:#ededed;line-height:34px;">'+(firstLetters[index])+'</p></a>'+
                '<ul class="address_ul">';
            for(var itemIndex=0;itemIndex< _handledData[firstLetters[index]].length;itemIndex++){
                var provincItem=_handledData[firstLetters[index]][itemIndex];
                wrap_c_str+='<li index="'+itemIndex+'">'+ provincItem.name+'</li>';
            }
            wrap_c_str+=  '</ul></div>';
            $(".address_list").append(wrap_c_str);
        }

        $(".address_list").append('<div class="wrap_c"></div>');
    },

    init:function(){
        $(".add_item").on("click",function(){
            var type=$(this).attr("type");
            switch(type){
                case "1":citypicker.initProvince();break;
                case "2":citypicker.initCity();break;
                case "3":citypicker.initArea();break;
            }
        });
        this.initProvince();
        $(".add_item").on("click",function(){
            $(".add_item").removeClass("add_item_selected");
            $(this).addClass("add_item_selected");
        });
    },
    switchSelect:function(index){
        $(".add_item").removeClass("add_item_selected");
        $(".add_item").eq(index).addClass("add_item_selected");
        switch(index){
            case 0:citypicker.initProvince();break;
            case 1:citypicker.initCity();break;
            case 2:citypicker.initArea();break;
        }
    }
};
