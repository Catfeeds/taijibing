/**
 * Created by pengjixiang on 15/12/9.
 */
var pageController=null;
$(function(){
  var loginmobile=loginmobile  =  localStorage.getItem('loginmobile')

    if(loginmobile){
        loginmobile=loginmobile;
    }else{
        loginmobile='';
    }
    pageController=new Vue({

            'el':'#login_c',
            data:{
                mobile:loginmobile,
                vcode:'',
                enableGetValidateBtn:true,
                amount:60,
                getValidateBtnLabel:'获取验证码',
            },
            methods:{
                getChange:function(){
                    var getChange_length =this.mobile.length;
                    var vcode_length =this.vcode.length;
                    if(getChange_length==11){
                        $('.login_input_item_right').css('background','url(/static/images/canding.png) 100% 100% no-repeat;');
                        if(vcode_length==4){
                            $('.submitBtn').css('background','url(/static/images/canding.png) 100% 100% no-repeat;');
                        }
                    }else{
                        $('.login_input_item_right').css('background','#ddd')
                        $('.submitBtn').css('background','#ddd')
                    }
                },
                getVcodeChange:function(){
                    var getChange_length =this.mobile.length;
                    var vcode_length =this.vcode.length;
                     if(vcode_length==4){
                          if(getChange_length==11){
                             $('.submitBtn').css('background','url(/static/images/canding.png) 100% 100% no-repeat;');
                         }else{
                            $('.submitBtn').css('background','#ddd')
                         }
                        
                    }else{
                        $('.submitBtn').css('background','#ddd')
                    }
                },

                getValidateCode:function(){
                    //调用请求
                    //更新状态
                    if(!validateTel(this.mobile)){
                        //手机号输入错误
                        $.toast("手机格式错误，请重新输入");
                        return;
                    }
                    $('.login_input_item_right').css('background','#ddd')
                    $('.submitBtn').css('background','#ddd')
                    sendSms(this.mobile);


                    this.enableGetValidateBtn=true;
                    this.getValidateBtnLabel=this.amount+"秒";
                    var t=setInterval(function(){
                    
                        pageController.amount--;
                        if(pageController.amount<0){
                            clearInterval(t);
                            reset();
                             $('.login_input_item_right').css('background','url(/static/images/canding.png) 100% 100% no-repeat;')
                            return;
                        }
                        pageController.getValidateBtnLabel=pageController.amount+"秒";
                    },1000);
              },


                submit:function(){
                    if(!isValid()){
                        return;
                    }
                    $.showIndicator();

                    $.getJSON("/index.php/personal-center/login?mobile="+this.mobile+"&vcode="+this.vcode,function(data){
                       
         
                        
                        $.hideIndicator();
                                localStorage.setItem("loginmobile", pageController.mobile);

                         // alert(this.mobile)
                        if(data.state!=0){
                            $.toast(data.desc);

                            if(data.desc=='手机号码未注册')
                             layer.open({
                                        title: [
                                          '<div style="width:80%;height:60px;margin:auto;background: url(/static/images/bftitle.png) 100% 100% no-repeat;     background-position: center;background-size: 100% 40px;">免费赠机</div>',


                                          'color:#fe7b00;font-weight: bold;background: -moz-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -webkit-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -webkit-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -o-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -ms-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background:linear-gradient(left, #ff8a20 0%, #ff5e20 100%);'
                                        ]
                                        ,content:   '<div style="padding:30px 35px;font-weight: bold;"><img src="/static/images/bgliwu.png" alt="" style="width:140px;">'+
                                                    '<p style="margin-top: 20px ;color:#313131">你还未登记!</p>'+
                                                    '<p style="margin-top: 10px ;color:#313131">快去免费领取一台智能茶吧机吧！</p>'+
                                                    '</div>'+
                                                    '<a href="https://e.eqxiu.com/s/IY2MCPqM"><p class="btn ativer"  >马上去</p></a>' +
                                                    '<a href="http://test.wx.taijibing.cn/index.php/water-shop/index"><p class="btn">去商城逛逛</p></a>'
                                         });

                                             $(".btn").click(function(){
                                                $(this).css({'background':'#fdf6f6','color':'#fe7200','border-top':'1px solid #f3f3f3','border-bottom':'1px solid #f3f3f3'})
                                                $(".ativer").removeClass('ativer')
                                                $(this).addClass('ativer')
                                              })
                            return;
                        }

                        window.location.replace("/index.php/personal-center/skip");
                    });
                }
            },
            computed:{

            }

    });

});
//发送短信
    function sendSms(tel){
        $.showIndicator();
        $.getJSON("/index.php/personal-center/get-sms?mobile="+tel,function(data){
            $.hideIndicator();
            if(data.state!='0'){
                pageController.amount =-1;
                $.toast('验证码发送失败,请重试!');
                return;
            }
            $.toast('验证码已发送到您的手机!');
        });

    }
    function isValid(){
        if(!validateTel(pageController.mobile)){
            //手机号输入错误
            $.toast('手机格式错误，请重新输入');
            return false;
        }
        //验证码
        if (isNaN(pageController.vcode) || pageController.vcode.length != 4) {
            $.toast('验证码输入错误');

             $('.submitBtn').css('background','#ddd')
            return false;
        }
        return true;

    }
var reset=function(){
    pageController.amount=60;
    pageController.getValidateBtnLabel="获取验证码";
    pageController.enableGetValidateBtn=false;
}