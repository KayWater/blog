
$(document).ready(function(){
	let editor;
	let isDurty = false;
    const HTTP_SERVER_LAG = 6000; //提交延迟
    let preEditorData = ""; //上次提交时的数据
    
    //ckeditor upload adapter
    class UploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return new Promise((resolve, reject) => {
	            const data = new FormData();
	            data.append("_token", $("meta[name='csrf-token']").attr('content'));
	            data.append('upload', this.loader.file);
	            data.append('allowSize', 10);//允许图片上传的大小/兆
	            $.ajax({
	                url: '/editor/upload',
	                type: 'POST',
	                data: data,
	                dataType: 'json',
	                processData: false,
	                contentType: false,
	                success: function (data) {
	                    if (data.uploaded) {
	                        resolve({
	                            default: data.url
	                        });
	                    } else {
	                        reject(data.msg);
	                    }
	
	                }
	            });
	
	        });
        }
        abort() {
        }
    }

    ClassicEditor
        .create( document.querySelector( '#editor' ), {
			autosave: {
				save(editor){
					return saveData( editor.getData() );
				}
			}
        }).then( newEditor => {
            editor = newEditor;
            editor.plugins.get('FileRepository').createUploadAdapter = (loader)=>{
                return new UploadAdapter(loader);
            };
            preEditorData = editor.getData();
            handleStatusChanges( editor );
            handleSaveButton( editor );
            handleBeforeUnload( editor );
            
        }).catch( error => {
            console.log( error );
        } );
    //auto save 
    function saveData( data ) {
    	return new Promise( resolve => {
    		(function() {
    			var _token = $("meta[name='csrf-token']").attr('content');
    			var id = $("#draftId").val();
    			var title = $("#title").val();
    			if(data != preEditorData) {
    				$.ajax({
    					url: "/admin/draft/prestore",
    					type: "POST",
    					data: {
    						_token: _token,
    						id: id,
    						title: title,
    						content: data,
    					},
    					success: function(res) {
	        				if(res.errorCode == 0) {
	        					$("#draftId").val(res.data.draftId);
	        					title = title || "无标题草稿";
	        					if(!id) {
	        						var navHtml = "<li class=\"nav-item active\">" +
	        							"<a class=\"nav-link\" " +
	        							"href=\"/admin/draft/edit/"+res.data.draftId+"\">" +
	        								"<p class=\"draft-title\">"+title+"</p>" +
	        								"<p class=\"draft-time\">更新于："+res.data.updatedAt+"</p>" +
	        							"</a></li>";
	        						$(".draft-nav").append(navHtml);
	        					} else {
	        						var $navItem = $(".draft-nav").find(".nav-item.active");
	        						$navItem.find(".draft-title").html(title);
	        						$navItem.find(".draft-time").html("更新于："+res.data.updatedAt);
	        					}
	        				}
    					}
    				});
    			}
    			resolve();
    		})();
    	})
    }

    function handleSaveButton( editor ) {
    	const saveButton = document.querySelector( "#save" );
    	const pendingActions = editor.plugins.get( "PendingActions" );
    	
    	saveButton.addEventListener( 'click', evt => {
	        const data = editor.getData();
	        // Register the action of saving the data as a "pending action".
	        // All asynchronous actions related to the editor are tracked like this,
	        // so later on you only need to check `pendingActions.hasAny` to check
	        // whether the editor is busy or not.
	        const action = pendingActions.add( 'Saving changes' );

	        evt.preventDefault();
	        
	        var _token = $("meta[name='csrf-token']").attr("content");
	        var articleId = $("#articleId").val();
	        var draftId = $("#draftId").val();
	        var title = $("#title").val();
	        var $tags = $(":checkbox[name='tags']:checked");
	        var tags = [];
	        $.each($tags, function(index, item) {
	        	tags.push($(item).val());
	        });
	        $.ajax({
	        	url: "/admin/article/store",
	        	type: "POST",
	        	data: {
	        		_token: _token,
	        		id: articleId,
	        		draftId: draftId,
	        		title: title,
	        		content: data,
	        		tags: tags
	        	},
	        	success: function(res) {
        			pendingActions.remove( action );
		            // Reset isDirty only if the data did not change in the meantime.
		            if ( data == editor.getData() ) {
		                isDirty = false;
		            }
	        		updateStatus( editor );
	        		if(res.errorCode != 0) {
	        			initErrorModal(res.errorMsg);
	        		} else if(res.errorCode == 0) {
	        			$("#articleId").val(res.data.articleId);
	        			window.location.href="/dashboard";
	        		}
	        	}
	        });
	        // Save the data to a fake HTTP server.
//	        setTimeout( () => {
//	            pendingActions.remove( action );
//	            // Reset isDirty only if the data did not change in the meantime.
//	            if ( data == editor.getData() ) {
//	                isDirty = false;
//	            }
//	
//	            updateStatus( editor );
//	        }, HTTP_SERVER_LAG );
	    } );
    }
    
    // Listen to new changes (to enable the "Save" button) and to
    // pending actions (to show the spinner animation when the editor is busy).
    function handleStatusChanges( editor ) {
    	editor.plugins.get("PendingActions").on("change:hasAny", () => updateStatus(editor));
    	
    	editor.model.document.on("change:data", () => {
    		isDurty = true;
    		updateStatus(editor);
    	}) 
    }
    // If the user tries to leave the page before the data is saved, ask
    // them whether they are sure they want to proceed.
    function handleBeforeUnload( editor ) {
    	const pendingActions = editor.plugins.get("PendingActions");
    	window.addEventListener("beforeunload", evt => {
    		evt.preventDefault();
    		if( pendingActions.hasAny ) {
    			evt.preventDefault();
    		}
    	})
    }
    
    function updateStatus( editor ) {
    	const saveButton = document.querySelector("#save");
    	const editorStatus = document.querySelector("#editor-status");
		
    	// Disables the "Save" button when the data on the server is up to date.
    	// Display the editor status when the data on the server is up to date.
    	if(isDurty) {
    		saveButton.classList.add("disabled");
    		editorStatus.innerHTML = "保存中";
    		editorStatus.classList.add("text-warning");
    		editorStatus.classList.remove("text-success");
    	} else {
    		saveButton.classList.remove("disabled");
    		editorStatus.innerHTML = "已保存";
    		editorStatus.classList.remove("text-warning");
    		editorStatus.classList.add("text-success");
    	}
    	
    	if(editor.plugins.get("PendingActions").hasAny) {
    		saveButton.classList.add("disabled");
    		editorStatus.innerHTML = "保存中";
    		editorStatus.classList.add("text-warning");
    		editorStatus.classList.remove("text-success");
    	} else {
    		saveButton.classList.remove("disabled");
    		editorStatus.innerHTML = "已保存";
    		editorStatus.classList.remove("text-warning");
    		editorStatus.classList.add("text-success");
    	}
    }
    
    //编辑文章时添加标签
    $("#tagForm").find("#store").on("click", function(evt){
    	$("#tagForm").validate({
    		focusInvalid: false,
			onfocusout: false,
			focusCleanup: true,
			submitHandler: function(form) {
				var _token = $("meta[name='csrf-token']").attr("content");
				var tagName = $("#tagname").val();
				$.ajax({
					url: "/admin/tags",
				    type: "POST",
				    data: {
				    	_token: _token,
				    	tagName: tagName,
				    },
				    success: function(res) {
				    	if(res.errorCode != 0) {
				    		initErrorModal(res.errorMsg);
				    	} else {
				    		var tagHtml = "<div class=\"check-item line-check\">" +
				    				"<input name=\"tags\" id=\"tag"+res.data.tagId+"\" " +
				    					"type=\"checkbox\" value="+res.data.tagId+">" +
				    				"<label class=\"line-check-label\" " +
				    				    "for=\"tag"+res.data.tagId+"\">"+tagName+"</label>" +
				    				"</div>";
				    		$(".tag-group").append(tagHtml);
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
    	})
    })
    
    //标签点击事件
    $(".tag-group").on("click", ".line-check-label", function(evt){
    	var that = this;
    	var $checked = $(":checkbox[name='tags']:checked");
    	var $currentItem = $(that).parent(".check-item");
    	var isActive = $currentItem.hasClass("active");
    	var maxLength = 3;
    	if(isActive || $checked.length < maxLength) {
    		$currentItem.toggleClass("active");
    	} else {
    		evt.preventDefault();
    	}   	
    })
})