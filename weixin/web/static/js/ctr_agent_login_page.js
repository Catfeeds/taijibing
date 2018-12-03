/**
 * Created by pengjixiang on 15/12/9.
 */
var pageController=null;
$(function(){

  var login  =  localStorage.getItem('login')
  var objlogin=JSON.parse(login)
console.log(objlogin)
 var username='';
 var password='';
 if(objlogin){
    password= objlogin.password;
    username= objlogin.username;
 }
  
    pageController=new Vue({
            'el':'#login_c',
            data:{
                username:username,
                password:password
            },

            methods:{

                submit:function(){
                    if(!isValid()){
                        return;
                    }
                    $.showIndicator();
                   
                    $.getJSON("/index.php/agent/login?username="+this.username+"&password="+this.password,function(data){
                        var login = {'username':this.username.value,'password':this.password.value}
                        console.log(login)
                        console.log(data)
                        localStorage.setItem("login", JSON.stringify(login));
                        
                        $.hideIndicator();
                      
                        if(data.state!=0){
                            $.toast(data.msg);
                            return;
                        }
                    window.location.replace("/index.php/agent/index");
                    });
                }
            },
            computed:{
            }
    });
});
    function isValid(){
        if($.trim(pageController.username)==""){
            //手机号输入错误
            $.toast('请填入登录账号');
            return false;
        }
        if($.trim(pageController.password)==""){
            //手机号输入错误
            $.toast('请填入登录密码');
            return false;
        }
        return true;
    }


