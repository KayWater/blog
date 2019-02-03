//错误信息模态框生成
var initErrorModal = function(errors){
	errorMsgHtml = "";
	for(var key in errors) {
		var type = typeof errors[key];
		if(type == 'array' || type == 'object') {
			for(var index in errors[key]) {
				errorMsgHtml += "<p>"+errors[key][index]+"</p>";
			}
		} else if(type  == 'string') {
			errorMsgHtml += "<p>"+errors[key]+"</p>";
		}
	}
	$modalHtml = 
		  "<div class=\"modal\" id=\"errModal\" role=\"dialog\" >" +
	        "<div class=\"modal-dialog\" role=\"document\">" +
	          "<div class=\"modal-content\" >" +
	            "<div class=\"modal-header\">" +
	              "<h5 class=\"modal-title\">错误信息</h5>" +
	              "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" +
	                " <span aria-hidden=\"true\">&times;</span></button>" +
	            "</div>" +
	            "<div class=\"modal-body\">" +
	               errorMsgHtml +
	            "</div>" +
	          "</div>" +
	        "</div>" +
	      "</div>";
	
	$("body").append($modalHtml);
	$("#errModal").modal("show");
}
$(document).ready(function(){
	
	//提交标签
	$("#tagForm").find("#save").click(function(evt) {
		$("#tagForm").validate({
			focusInvalid: false,
			onfocusout: false,
			focusCleanup: true,
			submitHandler: function( ) {
				var tagid = $("#tagid").val();
				var tagName = $("#tagname").val();
				var status = Number($(":checkbox[name='tagInitialStatus']").bootstrapSwitch('state'));
				var _token = $("meta[name='csrf-token']").attr('content');
				$.ajax({
					url: "/admin/tags",
					type: 'POST',
					data: {
						id: tagid,
						tagName: tagName,
						status: status,
						_token: _token
				    },
					success: function (res) {
						if(res.errorCode) {
							initErrorModal(res.errorMsg);
						}
					}
				});
			},
			rules: {
				tagname: {
					required: true,
					rangelength: [2,18],
				},
			},
			messages: {
				tagname: {
					required: "标签名称不能为空",
					rangelength: "标签名为2~18位字符",
				},
			},
			showErrors: function(errorMap, errorList) {
				if(Object.keys(errorMap).length) {
					initErrorModal(errorMap);
				}	
			}
		});
	});
	
	//bootstrap-switch initial
	$(".bootstrap-switch").bootstrapSwitch();
	//标签列表状态栏切换事件 
	$(".tag-status-switch").on("switchChange.bootstrapSwitch", function(event, state){
		var that = this;
		var id = $(that).attr("data-tag-id");
		var _token = $("meta[name='csrf-token']").attr("content");
		state = Number(state);
		$.ajax({
			url: "/admin/tags/update",
			type: "POST",
			data: {
				_token: _token,
				status: state, 
				id: id
			},
			dataType: "json",
			success: function(res){
				if(res.errorCode) {
					initErrorModal(res.errorMsg);
				}
			}
		});
	});
	
	//标签编辑按钮点击事件
	$(".tag-edit-btn").bind("click", function(){
		var $that = $(this);
		var $tagForm = $("#"+$that.attr("data-control"));
		// get the table cell value
		var id = $that.attr("data-tag-id");
		var $parentTr = $that.parents("tr");
		var name = $parentTr.find(".tag-name").text();
		var status = $parentTr.find(".tag-status-switch").bootstrapSwitch("state");
		// fill the tag form
		$tagForm.find("#tagname").val(name).focus();
		$tagForm.find("#tagStatus").bootstrapSwitch("state", status);
		$tagForm.find("#tagid").val(id);
	});
	
});