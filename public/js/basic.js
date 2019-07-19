$(document).ready(function(){
	//搜索
	$("#searchForm").find("#save").click(function(evt) {
		$("#searchForm").validate({
			focusInvalid: false,
			onfocusout: false,
			focusCleanup: true,
			submitHandler: function(form) {
				form.submit();
//				var search = $("#search").val();
//				var _token = $("meta[name='csrf-token']").attr('content');
//				$.ajax({
//					url: "/article/search",
//					type: 'GET',
//					data: {
//						search: search,
//						_token: _token
//				    },
//					success: function (res) {
//						console.log("test")
//					}
//				});
			},
			rules: {
				search: {
					required: true,
				},
			},
			messages: {
				search: {
					required: "",
				},
			},
//			showErrors: function(errorMap, errorList) {
//				if(Object.keys(errorMap).length) {
//					initErrorModal(errorMap);
//				}	
//			}
		});
	});
});