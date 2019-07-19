$(document).ready(function(){
	var paging = [];
	// editor instances
	const editors = new Map();
	
	// if no login, then redirect to login page
	$(".login-required").on("click", function(){
		window.location = "/login";
	})

	// show confirm modal when click the delete buttun
	$('#removeConfirmModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var targetId = button.data('targetid');
		var modal = $(this)
		modal.find('.modal-message').text('删除后无法恢复，是否删除评论？')
		modal.find("#targetComment").val(targetId);
	});
	
	// send delete request when confirm delete the comment
	$("#removeConfirmModal .btn-remove").on("click", function(event) {
		var targetId = $("#removeConfirmModal #targetComment").val();
		var _token = $("meta[name='csrf-token']").attr("content");
		$.ajax({
			url: '/comment/destroy',
			type: 'POST',
			data: {
				_token: _token,
				targetId: targetId,
			},
			success: function(res) {
				$("#removeConfirmModal").modal('hide');
				$("#messageModal").find(".modal-message").html(res.errorMsg);
				$("#messageModal").modal('show');
				setTimeout(function(){
					window.location.reload();
				}, 1500);
			},
		});
	});
	
	$(".hover-dropdown .dropdown-menu").on("click", function(event){
		event.stopPropagation();
	});

    let editor;
    // create a instance of comment editor
    ClassicEditor
        .create( document.querySelector( '#commentEditor' ), {
        	mention: {
                feeds: [
                    {
                        marker: '@',
                        // Define feed items callback
                        feed: getFeedItems,
                        // Define the custom item renderer
                        //itemRenderer: customItemRenderer,
                        minimumCharacters: 1
                    }
                ]
            }
        }).then( newEditor => {
            editor = newEditor;
            console.log('test');
//            editor.plugins.get('FileRepository').createUploadAdapter = (loader)=>{
//                return new MyUploadAdapter(loader);
//            };
            // List of plugins
            // ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName );
            // toolbar items
            // Array.from( editor.ui.componentFactory.names() );
            handleCommentButton( editor );
        }).catch( error => {
            console.log( error );
        });
    
    // comment submit button hanlder
    function handleCommentButton( editor ) {
    	const saveButton = document.querySelector( "#commentSubmit" );
    	if (saveButton == null) {
    		return ;
    	}
    	
    	saveButton.addEventListener( 'click', evt => {
    		evt.preventDefault();
    		// editor content
	        const data = editor.getData();
	        if (data == '') {
	        	return ;
	        }
	        
	        
	        // Register the action of saving the data as a "pending action".
	        // All asynchronous actions related to the editor are tracked like this,
	        // so later on you only need to check `pendingActions.hasAny` to check
	        // whether the editor is busy or not.
	        
	        //const action = pendingActions.add( 'Saving changes' );

	        let submitPromise = new Promise((resolve, reject) => {
        		var formdata = new FormData();
        		var _token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
        		var postId = document.querySelector('#postId').value;
        		formdata.append('_token', _token);
        		formdata.append('postId', postId);
        		formdata.append('content', data);
        		
        		const xhr = new XMLHttpRequest();
        		xhr.open('POST', '/comment');
        		xhr.responseType = 'json';
        		xhr.addEventListener('error', () => reject());
        		xhr.addEventListener('load', () => {
        			const response = xhr.response;
        			
        			//Handle errors
        			if( ! response || response.error ) {
        				return reject(response && response.error 
        						? response.error.message : "unknown error" );
        			}
        			
        			// Handle success
        			resolve(response);	
        		});
        		
        		xhr.send(formdata);
        	})
	        
	        submitPromise.then(function(res) {
	        	var msgEle = document.createElement('p');
				msgEle.classList.add('text-info');
				msgEle.textContent = res.errorMsg;
				document.querySelector('#messageModal .modal-body').appendChild(msgEle);
				$("#messageModal").modal('show');
	        })
	    } );
    }
    
    // metion feed callback
    function getFeedItems(queryText) 
    {
    	return new Promise( resolve => {
    		let url = "/api/user/search?key=" + queryText;
    		
    		const xhr = new XMLHttpRequest();
    		xhr.open('GET', url);
    		xhr.responseType = 'json';
    		xhr.addEventListener('load', ()=>{
    			const response = xhr.response;
    			var data = response.data.map(function(item) {
    				item['id'] = '@' + item.name;
    				item['userId'] = item.id;
    				return item;
    			});
    			resolve(data);
    		});
    		xhr.send();
    	});
    }  
    
    const commentList = document.querySelector('.comment-list');
    // Delegate the click event on reply button to it parent element(.comment-list)
    commentList.addEventListener('click', handleReplyButton);
    
    // Delegate the click event on more reply button to it parent element
    commentList.addEventListener('click', handleMoreReplyButton);
    
    // Delegate the click event on praise button to it parent element
    commentList.addEventListener('click', handlePraiseButton);
    
    
    /**
     * Handle click event on reply button, 
     * the event is delegated to it's parent element
     */
    function handleReplyButton()
    {
    	var replyButton = null;
    	// Look up the replyButton
    	for (var i=0, len=event.path.length; i<len; i++) {
    		let element = event.path[i];
    		if (element == event.currentTarget) {
    			break;
    		}
    		if (element.classList.contains('reply')) {
    			replyButton = element;
    		}
    	}
    	if (replyButton == null) {
    		return ;
    	}
    	
    	// Closest parent .comment-item
    	var commentItem = replyButton.closest('.comment-item');
    	var targetID = commentItem.getAttribute('data-targetid');
    	var editorID = 'replyEditor' + targetID;
    	
    	var commentEditorContainer = commentItem.querySelector('.comment-editor');

    	if (commentEditorContainer === null) {
    		// if haven't editor container, create it; and install the editor;
    		var textNode = document.createTextNode('取消回复');
    		replyButton.removeChild(replyButton.lastChild);
    		replyButton.appendChild(textNode);
    		// Comment editor container
        	var commentEditorContainer = document.createElement('div');
        	commentEditorContainer.classList.add('comment-editor');
        	// Comment editor input container
        	var inputContainer = document.createElement('div');
        	inputContainer.classList.add('comment-input-wrap');
        	// input textarea
        	var editorEle = document.createElement('textarea');
        	editorEle.setAttribute('name', 'content');
        	editorEle.setAttribute('id', editorID);
        	inputContainer.appendChild(editorEle);
        	commentEditorContainer.appendChild(inputContainer);
        	
        	// Publish button
        	var publishBtn = document.createElement('button');
        	publishBtn.classList.add('btn');
        	publishBtn.classList.add('btn-primary');
        	publishBtn.classList.add('btn-publish');
        	publishBtn.textContent = '发布';
        	publishBtn.addEventListener('click', handlePublishButton);
        	
        	commentEditorContainer.appendChild(publishBtn);
        	commentItem.appendChild(commentEditorContainer);
        	// Create ckeditor instance
        	ClassicEditor
            .create( document.querySelector( '#'+editorID ), {
            	mention: {
                    feeds: [
                        {
                            marker: '@',
                            // Define feed items callback
                            feed: getFeedItems,
                            // Define the custom item renderer
                            //itemRenderer: customItemRenderer,
                            minimumCharacters: 1
                        }
                    ]
                }
            }).then( newEditor => {
                var editor = newEditor;
                //editors[editorID] = editor;
                editors.set(editorID, editor);
                //handleCommentButton( editor );
            }).catch( error => {
                console.log( error );
            });
    	} else {
    		// if have editor container, remove it; and destroy editor instance;
    		var textNode = document.createTextNode('回复');
    		replyButton.removeChild(replyButton.lastChild);
    		replyButton.appendChild(textNode);
        	
        	commentEditorContainer.parentElement.removeChild(commentEditorContainer);
        	editors.get(editorID).destroy()
    	}
    }
    
    
    function handlePublishButton() 
    {
    	var target = event.target;
    	// Closest parent .comment-item
    	var commentItem = target.closest('.comment-item');
    	var targetID = commentItem.getAttribute('data-targetid');
    	var postID = commentItem.getAttribute('data-postid');
    	var parentID = commentItem.getAttribute('data-parentid');
    	
    	editor = editors.get('replyEditor' + targetID);
    	var content = editor.getData();
    	if (content.length == 0) {
    		return ;
    	}
    	parentID = parentID == 0 ? targetID : parentID;
    	
    	let replyPromise = new Promise((resolve, reject) => {
    		var formdata = new FormData();
    		var _token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    		formdata.append('_token', _token);
    		formdata.append('postId', postID);
    		formdata.append('parentId', parentID);
    		formdata.append('repliedId', targetID);
    		formdata.append('content', content);
    		
    		const xhr = new XMLHttpRequest();
    		xhr.open('POST', '/comment');
    		xhr.responseType = 'json';
    		xhr.addEventListener('error', () => reject());
    		xhr.addEventListener('load', () => {
    			const response = xhr.response;
    			// Handle errors
    			if ( !response || response.error ) {
    				return reject( response && response.error ? 
    						response.error.message : "unknown error");
    			}
    			
    			resolve(response);
    		});
    		xhr.send(formdata);
    	});
    	replyPromise.then(function(res) {
			var msgEle = document.createElement('p');
			msgEle.classList.add('text-info');
			msgEle.textContent = res.errorMsg;
			document.querySelector('#messageModal .modal-body').appendChild(msgEle);
			$("#messageModal").modal('show');
		})
    }
    
    // Get the child comment, use event delegate
    function handleMoreReplyButton()
	{
    	var moreReplyButton = null;
    	// Look up the moreReplyButton 
    	for (var i=0, len=event.path.length; i<len; i++) {
    		let element = event.path[i];
    		if (element == event.currentTarget) {
    			break;
    		}
    		if (element.classList.contains('btn-more-reply')) {
    			moreReplyButton = element;
    		}
    	}
    	// If haven't found the moreReplyButton, return;
    	if (moreReplyButton === null) {
    		return ;
    	}
    	
    	var targetId = moreReplyButton.getAttribute('data-targetid');
    	var rootCommentItem = moreReplyButton.closest('.nest-comment')
    							.firstElementChild.firstElementChild.cloneNode(true);
    	
    	let moreReplyPromise = new Promise ((resolve, reject) => {
    		const xhr = new XMLHttpRequest;
    		var url = '/comment/' + targetId + "/child_comments";
    		xhr.open('GET', url);
    		xhr.responseType = 'json';
    		xhr.addEventListener('error', () => reject());
    		xhr.addEventListener('load', () => {
    			const response = xhr.response;
    			// Handle errors
    			if ( !response || response.error ) {
    				return reject( response && response.error ? 
    						response.error.message : "unknown error");
    			}
    			
    			//
    			resolve(response);
    		});
    		xhr.send();
    	});
    	
    	moreReplyPromise.then(function(res) {
	    	var data = res.data;
	    	paging = res.paging;
	    	// if #moreReplyModal has exists, remove it.
	    	var modal = document.querySelector('#moreReplyModal');
			if(modal != null) {
				modal.parentElement.removeChild(modal);
			}
			// modal container
			var modalEle = document.createElement("div");
			modalEle.classList.add('modal');
			modalEle.classList.add('fade');
			modalEle.classList.add('bd-example-modal-lg');
			modalEle.setAttribute('id', 'moreReplyModal');
			modalEle.setAttribute('tabindex', -1);
			modalEle.setAttribute('role', 'dialog');
			
			// inner dialog container
			var dialogEle = document.createElement('div');
			dialogEle.classList.add('modal-dialog');
			dialogEle.classList.add('modal-lg');
			// content box in dialog container
			var contentEle = document.createElement('div');
			contentEle.classList.add('modal-content');
			// modal header in content box
			var headerEle = document.createElement('div');
			headerEle.classList.add('modal-header');
			// dialog title in header box
			var titleEle = document.createElement('h6');
			titleEle.classList.add('modal-title');
			titleEle.innerHTML = "查看对话";
			// close button in header
			var closeBtnEle = document.createElement('button');
			closeBtnEle.classList.add('close');
			closeBtnEle.setAttribute('type', 'button');
			closeBtnEle.setAttribute('data-dismiss', 'modal');
			var spanEle = document.createElement('span');
			spanEle.innerHTML = "&times;";
			// modal body in content box
			var bodyEle = document.createElement('div');
			bodyEle.classList.add('modal-body');
			bodyEle.classList.add('comment-list');
			bodyEle.addEventListener('scroll', () => { scrollLoadMore() } )
			bodyEle.addEventListener('click', handleReplyButton);
			bodyEle.addEventListener('click', handlePraiseButton);
			
			bodyEle.appendChild(rootCommentItem);
			
			var dividerEle = document.createElement('div');
			dividerEle.classList.add('comment-item-divider');
			bodyEle.appendChild(dividerEle);
			
			for(var i=0, len=data.length; i<len; i++) {
				bodyEle.appendChild(createCommentItemElement(data[i]));
			}
			
			closeBtnEle.appendChild(spanEle);
			headerEle.appendChild(titleEle);
			headerEle.appendChild(closeBtnEle);
			contentEle.appendChild(headerEle);
			contentEle.appendChild(bodyEle);
			dialogEle.appendChild(contentEle);
			modalEle.appendChild(dialogEle);
			
			document.body.appendChild(modalEle);
			$(modalEle).modal('show');
			
		});
    	
    	
	}
	
	// Handle more reply modal scroll event
	function scrollLoadMore() {
		if (paging.is_end) {
			return ;
		}
		
		var scrollHeight = event.target.scrollHeight;
		var scrollTop = event.target.scrollTop;
		var clientHeight = event.target.clientHeight;
		
		if (scrollHeight - scrollTop - clientHeight != 0) {
			return ;
		}
		
		let promise = new Promise((resolve, reject) => {
			const xhr = new XMLHttpRequest();
			var url = paging.next;
			xhr.open('GET', url);
			xhr.responseType = 'json';
			xhr.addEventListener('error', () => reject());
			xhr.addEventListener('load', () => {
				const response = xhr.response;
				// Handle errors
    			if ( !response || response.error ) {
    				return reject( response && response.error ? 
    						response.error.message : "unknown error");
    			}
    			
    			//
    			resolve(response);
			});
			
			xhr.send();
		});
		
		promise.then((res)=>{
			paging = res.paging;
			var data = res.data;
			var modal = document.querySelector('#moreReplyModal');
			var bodyEle = modal.querySelector('.comment-list');
			for(var i=0, len=data.length; i<len; i++) {
				bodyEle.appendChild(createCommentItemElement(data[i]));
			}
			//appendMoreReply(res.data);
		});
	}
	
	/**
	 * Create comment item element
	 */
	function createCommentItemElement(item) {
		var commentItemEle = document.createElement('div');
		commentItemEle.classList.add('comment-item');
		commentItemEle.setAttribute('data-postid', item.post_id);
		commentItemEle.setAttribute('data-parentid', item.parent_id);
		commentItemEle.setAttribute('data-targetid', item.id);
		
		var itemMetaEle = document.createElement('div');
		itemMetaEle.classList.add('comment-item-meta');
		var pEle = document.createElement('p');
		pEle.classList.add('d-inline');
		var commentUserLinkEle = document.createElement('a');
		commentUserLinkEle.setAttribute('href', 'user/'+item.user_id);
		commentUserLinkEle.innerHTML = item.user.name;
		var textEle = document.createElement('small');
		textEle.innerHTML = '回复';
		var replyToUserLinkEle = document.createElement('a');
		replyToUserLinkEle.setAttribute('href', 'user/'+item.replied.user_id);
		replyToUserLinkEle.innerHTML = item.replied.user.name;
		
		var timeEle = document.createElement('p');
		timeEle.classList.add('d-inline');
		timeEle.classList.add('ml-3');
		timeEle.classList.add('small');
		var timeSpanEle = document.createElement('span');
		timeSpanEle.classList.add('fa');
		timeSpanEle.classList.add('fa-clock-o');
		timeSpanEle.classList.add('mr-1');
		var timeTextNode = document.createTextNode(item.created_at);
		
		timeEle.appendChild(timeSpanEle);
		timeEle.appendChild(timeTextNode);
		pEle.appendChild(commentUserLinkEle);
		pEle.appendChild(textEle);
		pEle.appendChild(replyToUserLinkEle);
		itemMetaEle.appendChild(pEle);
		itemMetaEle.appendChild(timeEle);
		
		var commentContentEle = document.createElement('div');
		commentContentEle.classList.add('comment-item-content');
		commentContentEle.innerHTML = item.content;
		
		var commentFooterEle = document.createElement('div');
		commentFooterEle.classList.add('comment-item-footer');
		var replyBtnEle = document.createElement('button');
		replyBtnEle.classList.add('btn-plain');
		replyBtnEle.classList.add('reply');
		var replyBtnSpanEle = document.createElement('span');
		replyBtnSpanEle.classList.add('fa');
		replyBtnSpanEle.classList.add('fa-comment-o');
		replyBtnSpanEle.classList.add('fa-flip-horizontal');
		replyBtnSpanEle.classList.add('mr-1');
		var textNode = document.createTextNode("回复");
		replyBtnEle.appendChild(replyBtnSpanEle);
		replyBtnEle.appendChild(textNode);
		
		var praiseBtnEle = document.createElement('button');
		praiseBtnEle.classList.add('btn-plain');
		praiseBtnEle.classList.add('praise');
		if (item.voting) {
			praiseBtnEle.classList.add('active');
		}
		
		var praiseBtnSpanEle = document.createElement('span');
		praiseBtnSpanEle.classList.add('fa');
		praiseBtnSpanEle.classList.add('fa-thumbs-o-up');
		praiseBtnSpanEle.classList.add('fa-flip-horizontal');
		praiseBtnSpanEle.classList.add('mr-1');
		
		var text = item.votes_count == 0 ? "赞" : item.votes_count;
		var textNode = document.createTextNode(text);
		praiseBtnEle.appendChild(praiseBtnSpanEle);
		praiseBtnEle.appendChild(textNode);
		
		commentFooterEle.appendChild(praiseBtnEle);
		commentFooterEle.appendChild(replyBtnEle);
		
		commentItemEle.appendChild(itemMetaEle);
		commentItemEle.appendChild(commentContentEle);
		commentItemEle.appendChild(commentFooterEle);
		return commentItemEle;
	}
	
	/**
	 * Handle praise button
	 */
	function handlePraiseButton() 
	{
		var praiseButton = null;
    	// Look up the praiseButton
    	for (var i=0, len=event.path.length; i<len; i++) {
    		let element = event.path[i];
    		if (element == event.currentTarget) {
    			break;
    		}
    		if (element.classList.contains('praise')) {
    			praiseButton = element;
    		}
    	}
    	if (praiseButton == null) {
    		return ;
    	}
    	// Closest parent .comment-item
    	var commentItem = praiseButton.closest('.comment-item');
    	
    	var targetId = commentItem.getAttribute('data-targetid');
    	var _token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    	let promise = new Promise((resolve, reject) => {
    		const formdata = new FormData();
    		formdata.append('_token', _token);
    		const xhr  = new XMLHttpRequest();
    		let url = "/comment/" + targetId + "/like";
    		xhr.open('POST', url);
    		xhr.responseType = 'json';
    		xhr.addEventListener('error', () => reject());
    		xhr.addEventListener('load', () => {
    			const response = xhr.response;
    			// Handle errors
    			if ( !response || response.error ) {
    				return reject( response && response.error ? 
    						response.error.message : "unknown error");
    			}
    			
    			//
    			resolve(response);
    		});
    		xhr.send(formdata);
    	});
    	promise.then((res) => {
    		if (res.vote_count != 0) {
    			praiseButton.lastChild.textContent = res.vote_count;
    		} else {
    			praiseButton.lastChild.textContent = '赞';
    		}
    		if (res.voting) {
    			praiseButton.classList.add('active');
    		} else {
    			praiseButton.classList.remove('active');
    		}
    		
    	})
    }
    
    
});