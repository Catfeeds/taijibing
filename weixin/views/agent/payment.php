<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>太极兵智能饮水机</title>

	<link rel="stylesheet" href="">
	<style type="text/css" media="screen">
	  .capacity{
float: left;
    width: 50px;
    height: 30px;
    margin-left: 20px;
    text-align: center;
    border:1px solid #000;
    line-height: 30px;    
    color: #ff0707;    
    position: relative;
	  }
	.dvCBs  input{
	opacity: 0;position: absolute;
	width: 45px;
	height: 30px;
	left: 0;    top: 0;
	}
.state + label{
    /*background-color: #2d3136;*/
    border-radius: 5px;
 
    width:15px;
    height:15px;
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    line-height: 15px;
    border-radius:2px;
    position: absolute;    
        right: 0;
        bottom: 0;
}
.state:checked + label{
    background-color: #e46045;
    border-radius:2px;
        position: absolute;    
        right: 0;
        bottom: 0;
}
.state:checked + label:after{
    content:"\2714";
    font-weight:400;
        color: #fff;
}
p{
	font-size: 14px;	
}
.remarks p{
	font-size: 12px;
	color: #999
}
.remarks .ativer{
	color: #ff0707;	
}
.remarks p span{
	font-size: 14px;
	color: #ff0707;	
}
.substr{
	    clear: both;
    padding: 10px;
    border-radius: 10px;
    color: #fff;
	background: -webkit-linear-gradient(right,#FF5E20,#ff8a20);
    background: -o-linear-gradient(right,#FF5E20,#ff8a20);
    background: -moz-linear-gradient(right,#FF5E20,#ff8a20);
    background: -mos-linear-gradient(right,#FF5E20,#ff8a20);
    background: linear-gradient(right,#FF5E20,#ff8a20);
    text-align: center;
}

</style>
</head>
<body>
	<div class="text">
		<p>欢迎选择太极兵智能饮水机，喝多少买多少，拒绝千滚水，节约用水从我做起！</p>
	    <p>选择容量：</p>
	    <div  class="choice">
	    	<div class="capacity">1L
              <div class="dvCBs"  >
                 <input type="radio" name="state" value="1"  id="state1" class='state' / >
    			 <label for="state1"></label>
    		 </div> 

	    	</div>
	    	<div class="capacity">2L
	    	  <div class="dvCBs"  >
                 <input type="radio" checked  name="state" value="1"  id="state2" class='state' / >
    			 <label for="state2"></label>
    		 </div> 
    		 </div>
	    	<div class="capacity">5L
	    	  <div class="dvCBs"  >
                 <input type="radio" name="state" value="1"  id="state3" class='state' / >
    			 <label for="state3"></label>
    		 </div> 
    		 </div>
	    	<div class="capacity">7.5L
	    	  <div class="dvCBs"  >
                 <input type="radio" name="state" value="1"  id="state4" class='state' / >
    			 <label for="state4"></label>
    		 </div> 
    		 </div>
    		 <div style='clear:both' class='remarks'>
    		 	备注“
    		 	 <p> <span>1L：</span>价格2元，容量约等于两瓶普通矿泉水，适合1-2人饮用。</p>
    		 	 <p class="ativer"> <span>2L：</span>价格3元，容量约等于四瓶普通矿泉水，适合2-3人饮用。</p>
    		 	 <p> <span>5L：</span>价格6元，容量约等于十瓶普通矿泉水，适合3-4人饮用。</p>
    		 	 <p> <span>7.5：</span>价格10元，换整袋新的一次性袋装水。</p>
    		 </div>
             <div >
             	
				<p style="float: left">合计：</p>
				<p style="float: right" id="rmb"> <span style="color: #ff0707;">3.00 </span>元</p>
             </div>


    		 <p class='substr' style='clear:both'>立即支付</p>
	    </div>
        
	</div>	
</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script>
     $('.choice input').click(function(){
     	var Index = $(this).attr('id')
     	var stateIndex = Index.split("state");
     	$(".ativer").removeClass('ativer')
     	$(".remarks p").eq(stateIndex[1]*1-1).addClass('ativer');
     	var rmb = '<span style="color: #ff0707;">2.00 </span>元';
     		// alert(stateIndex[1])
     	if(stateIndex[1]==1){
            rmb = '<span style="color: #ff0707;">2.00 </span>元';
     	}
     	else if(stateIndex[1]==2){
            rmb = '<span style="color: #ff0707;">3.00 </span>元';
     	}
     	else if(stateIndex[1]==3){
            rmb = '<span style="color: #ff0707;">6.00 </span>元';
     	}
     	else if(stateIndex[1]==4){
            rmb = '<span style="color: #ff0707;">7.50 </span>元';
     	}
     	$("#rmb").html(rmb)
     })
</script>

</html>