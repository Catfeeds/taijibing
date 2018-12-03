
(function($, window, document, undefined) {
	//定义分页类
	function Paging(element, options) {
		this.element = element;
		//传入形参
		this.options = {
			pageNo: options.pageNo || 1,
			totalPage: options.totalPage,
			totalLimit: options.totalLimit,
			totalSize: options.totalSize,
			callback: options.callback
		};
		//根据形参初始化分页html和css代码
		this.init();
	}
	//对Paging的实例对象添加公共的属性和方法
	Paging.prototype = {
		constructor: Paging,
		init: function() {
			this.creatHtml();
			this.bindEvent();
		},
		creatHtml: function() {
			var me = this;
			var content = "";
			var current = me.options.pageNo;
			var total = me.options.totalPage;
			var totalLimit = me.options.totalLimit;
			var totalNum = me.options.totalSize;
			content +='<span class="shoPpage">'
			content +='<span class="Jumpdisplay"> 本页显示<span>&nbsp;'

			content +='<select class="control-label" name="usetype"  id="Jumpdisplay" style="min-width: 60px;">';
			content +='<option value="10" selected>10</option>';
			content +='<option value="20" selected>20</option>';
			content +='<option value="50" selected>50</option>';
			content +='</select>';
			// content +='<span class="dropdown" style="height: 20px;border-radius: 4px;float:none">'
			// content +='<button class="btn btn-default dropdown-toggle"  style=" background-color: #2D3136;color:#f0f0f0;"  type="button" id="Jumpdisplay" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'
			// content +=''+totalLimit+'&nbsp;<span class="caret"></span>'
			// content +='</button>'
			// content +='<input  class="toggle-input"  style="display:none" type="text" name="Jumpdisplay" value="'+totalLimit+'">'
			// content +='<ul class="dropdown-menu" aria-labelledby="Jumpdisplay">'
			// content +='<li class="Jump" value="10">10</li>'
			// content +='<li  class="Jump" value="20">20</li>'
			// content +='<li  class="Jump" value="50">50</li>'
			// content +='</ul> '
			// content +='</span>'
			content +='</span> 条 </span>'
			content +='</span>'
			content +=''
			content += "<span class='totalSize'> 共<span>" + totalNum + "</span>条记录 </span>";
			content += "<a id='prePage'><</a>";
			//总页数大于6时候
			if (total > 6) {
				//当前页数小于5时显示省略号
				if (current < 5) {
					for (var i = 1; i < 6; i++) {
						if (current == i) {
							content += "<a class='current'>" + i + "</a>";
						} else {
							content += "<a>" + i + "</a>";
						}
					}
					content += ". . .";
					content += "<a>" + total + "</a>";
				} else {
					//判断页码在末尾的时候
					if (current < total - 3) {
						for (var i = current - 2; i < current + 3; i++) {
							if (current == i) {
								content += "<a class='current'>" + i + "</a>";
							} else {
								content += "<a>" + i + "</a>";
							}
						}
						content += ". . .";
						content += "<a>" + total + "</a>";
						//页码在中间部分时候	
					} else {
						content += "<a>1</a>";
						content += ". . .";
						for (var i = total - 4; i < total + 1; i++) {
							if (current == i) {
								content += "<a class='current'>" + i + "</a>";
							} else {
								content += "<a>" + i + "</a>";
							}
						}
					}
				}
				//页面总数小于6的时候
			} else {
				for (var i = 1; i < total + 1; i++) {
					if (current == i) {
						content += "<a class='current'>" + i + "</a>";
					} else {
						content += "<a>" + i + "</a>";
					}
				}
			}
					content += "<a id='nextPage'>></a>";
		 

 
			content += "<span class='JumpPages'> 跳转到<span>&nbsp;<input type='number'  style='width:50px;text-align: center;line-height: 14px;' id='Jumpnump' value=" + me.options.pageNo + " >&nbsp;</span>页 </span>";
			content += "<a id='JumpPagesA'><span class='JumpPagesbtn'> <button type='text' id='JumpPagesbtn'>确认</button> </span></a>";
			me.element.html(content);
		},
		//添加页面操作事件
		bindEvent: function() {
			 // $("#Jumpdisplay").chosen()
			var me = this;
			     this.Jumpdisplay= $("#Jumpdisplay");
			me.element.off('click', 'a');
			me.Jumpdisplay.trigger("chosen:updated");

			me.element.on('click', 'a', function() {
				// alert(4)
				var num = $(this).html();
				var id = $(this).attr("id");
 
				// var _class = $(this).attr("class");

				// var Jumpnump= Math.floor( $("#Jumpnump").val()*1)||1;
    
				// if(_class == "Jump"){
				//    var _thisval = $(this).attr('value');
				//     	$(this).css('backgroundColor','#E46045')
    //           		    me.options.totalLimit = _thisval;
   	// 				    me.options.totalPage = Math.ceil(me.options.totalSize/_thisval)
    //                    if(me.options.pageNo>me.options.totalPage){
    //                    	me.options.pageNo=Math.ceil(me.options.totalPage)
    //                    }
				// }else 

				if (id == "prePage") {
					if (me.options.pageNo <= 1) {
						me.options.pageNo = 1;
						return;
					} else {
						me.options.pageNo = +me.options.pageNo - 1;
					}
				} else if (id == "nextPage") {
					if (me.options.pageNo >= me.options.totalPage) {
					    	me.options.pageNo = Math.ceil(me.options.totalPage)||1;

					    	return;
					} else {
						me.options.pageNo = +me.options.pageNo + 1;
					}

				} else if (id == "firstPage") {
					me.options.pageNo = 1;
				} else if (id == "lastPage") {
					me.options.pageNo = Math.ceil(me.options.totalPage);
				}else if(id == "JumpPagesA"){
                   
					if (Jumpnump < 1) {
						me.options.pageNo = 1;

					}else if(Jumpnump > me.options.totalPage){

						me.options.pageNo =Math.ceil(me.options.totalPage) ;

					}else if(Jumpnump == me.options.pageNo){
							return;
                     

					}

					else{
						me.options.pageNo = Jumpnump;
					}


                    
				} else {
					 // me.options.pageNo = +num;

				}

				

				me.creatHtml();
				if (me.options.callback) {
					me.options.callback(me.options.pageNo,me.options.totalLimit);
				}


			})
		}
	};
	//通过jQuery对象初始化分页对象
	$.fn.paging = function(options) {
		return new Paging($(this), options);
	}
})(jQuery, window, document);


