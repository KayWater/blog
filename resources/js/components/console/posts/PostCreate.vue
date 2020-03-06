<template>
    <div class='container-fluid'>
        <nav class='navbar navbar-light justify-content-between '>
            <div>
                <a class='navbar-brand d-flex' href='/'>首页</a>
            </div>
            <div class='navbar-title'>
                <p class='d-inline'>写文章</p>
                <p class='d-inline editor-status'>{{ editorStatus }}</p>
            </div>
            <div>
                <el-button @click='publish'>发布文章</el-button>
            </div>
        </nav>
        <div class='container-fluid'>
            <el-form :model='postForm' :rules='postFormRules' ref='postForm'>
                <el-form-item prop='title'>
                    <el-input v-model='postForm.title' placeholder='请输入标题'></el-input>
                </el-form-item>
                <el-form-item prop='tags'>
                    <div class='tag-group'>
                        <el-tag v-for='tag in postForm.tags' :key='tag.id'
                            effect='plain' closable @close='removeTag(tag)'>
                            {{ tag.name }}
                        </el-tag>
                        <el-button size='small' @click="handleTagChoiceDialog"
                            v-show='(tagsLimit - postForm.tags.length) != 0 '>添加标签</el-button>
                    </div>
                </el-form-item>
                <el-form-item prop='content'>
                    <!-- <el-input type='textarea' id="editor" v-model="postForm.content"
                        placeholder="请输入内容"></el-input> -->
                    <div class="document-editor">
                        <div class="toolbar-container"></div>
                        <div class="content-container">
                            <div id="editor" :v-html="postForm.content">
                            </div>
                        </div>
                    </div>
                </el-form-item>
            </el-form>
        </div>
        
        <!-- tag selector dialog -->
        <el-dialog title='选择标签' :visible.sync="dialogTagChoiceVisible">
            <div>
                <div class='tag-group'>
                    <el-tag v-for='tag in postForm.tags' :key='tag.id'
                        effect='plain' closable @close='removeTag(tag)'>
                        {{ tag.name }}
                    </el-tag>
                </div>
                <div class='d-flex justify-content-between'>
                    <p>还可添加{{ tagsLimit - postForm.tags.length }}个标签</p>
                    <p>找不到标签? <a class='text-primary' href='#'
                        @click.prevent='dialogTagCreateVisible = true'>创建</a></p>
                </div>
                <el-input v-model='tagSearch' placeholder="搜索标签"></el-input>
                <div class='tag-group'>
                    <el-tag class='clickable' v-for='tag in tags' :key='tag.id' 
                        effect="plain" type='info' @click='selectTag(tag)'>
                        {{ tag.name }}
                    </el-tag>
                </div>
            </div>
            <!-- inner tag create dialog -->
            <el-dialog title='创建标签' :visible.sync='dialogTagCreateVisible' 
                append-to-body @close="closeDialogTagChoice">
                <el-form ref='tagForm' :model='tagForm' :rules='tagRules' hide-required-asterisk>
                    <el-form-item label="标签名称" prop='name' 
                        :error='tagFormErrorMessage.name'>
                        <el-input v-model='tagForm.name' placeholder='请输入标签名称'>
                        </el-input>
                    </el-form-item>
                    <p><i class='el-icon-info'></i> 空格请用符合"-"代替</p>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogTagCreateVisible = false">取 消</el-button>
                    <el-button type="primary" @click="addTag">提交</el-button>
                </div>
            </el-dialog>
            <div slot="footer" class="dialog-footer">
            </div>
        </el-dialog>

    </div>
</template>

<script>
import TagAPI from '../../../api/tag.js';
import PostAPI from '../../../api/post.js';
import '../../../ckeditor.js';
import { customUploadAdapterPlugin } from '../../../utils/CustomUploadAdapter.js';

export default {
    data() {
        return {
            editor: null,
            editorStatus: '',
            dialogTagChoiceVisible: false,
            dialogTagCreateVisible: false,
            tagsLimit: 5,

            limit: 10,
            offset: 0,

            tagSearch: '',
            newTag: '',

            tags: [],

            postForm: {
                postID: 0,
                title: '',
                tags: [],
                content: '',
            },

            postFormRules: {
                title: [
                    { required: true, message: '请输入标题', trigger: 'blur' },
                ],
                tags: [
                    { type: 'array', required: true, message: '请至少选择一个标签', trigger: 'change' },
                ],
                content: [
                    { required: true, message: '请输入内容', trigger: 'blur' },
                ]
            },

            tagForm: {
                name: '',
            },

            tagRules: {
                name: [
                    { required: true, message: '请输入标签名', trigger: 'blur' },
                ],
            },

            tagFormErrorMessage: {
                name: '',
            }
        }
    },

    computed: {
    },

    methods: {
        /**
         * handle tag choice dialog
         */
        handleTagChoiceDialog() {
            let vm = this;
            vm.dialogTagChoiceVisible = true;
            // If the popular tags is not empty, return.
            if (vm.tags.length !== 0) {
                return;
            }
            // Load tags
            TagAPI.getTags( { 
                params: {
                    limit: vm.limit,
                    offset: vm.offset,
                }
            } ).then( (response) => {
                let data = response.data;

                vm.tags = data.tags;
                vm.offset += data.tags.length;

            }).catch( (error) => {
                console.log(error);
            } );
        },

        /**
         * Close dialog TagChoice
         */
        closeDialogTagChoice() {
            this.$refs['tagForm'].resetFields();
        },

        /**
         * Add a new Tag
         */
        addTag() {
            let vm = this;
            vm.$refs['tagForm'].validate((valid) => {
                if (!valid) {
                    return false;
                }
                // Post to servers
                TagAPI.addTag(vm.tagForm.name)
                    .then( (response) => {
                        let data = response.data;
                        vm.postForm.tags.push(data.tag);
                        vm.dialogTagCreateVisible = false;
                    } ).catch( (error) => {
                        let errors = error.response.data;
                        for(let [key, value] of Object.entries(errors)) {
                            vm.tagFormErrorMessage[key] = value[0];
                        }
                    } );
            });
        },

        /**
         * Select a tag
         */
        selectTag(tag) {
            let vm = this;
            // if exceed the limit, return
            if (vm.postForm.tags.length >= vm.tagsLimit) {
                return ;
            }
            // if tag has been selected, return
            if (vm.postForm.tags.find( ({id}) => id === tag.id )) {
                return ;
            }
            vm.postForm.tags.push(tag);
        },

        /**
         * Remove the selected tag
         */
        removeTag(tag) {
            let index = this.postForm.tags.findIndex( ({id}) => id === tag.id );
            this.postForm.tags.splice(index, 1);
        },

        /**
         * Publish a post
         */
        publish() {
            let vm = this;
            vm.$refs['postForm'].validate((valid) => {
                if (!valid) {
                    return false;
                }
                // if postID equal to 0, add a new post;
                // otherwise, update the post
                if (vm.postForm.postID === 0) {
                    PostAPI.addPost( {
                        title: vm.postForm.title,
                        tags: vm.postForm.tags,
                        content: vm.postForm.content,
                    } ).then( (response) => {
                        let data = response.data;
                        vm.postForm.postID = data.post.id;
                        vm.$message( {
                            message: '文章发布成功',
                            type: 'success',
                        } );
                    } ).catch( (error) => {
                        let errors = error.response.data;
                        for (let [key, value] of Object.entries(errors)) {
                            if (typeof value == 'string') {
                                vm.postFormErrorMessage[key] = value;
                            } else {
                                vm.postFormErrorMessage[key] = value[0];
                            }
                        }
                        vm.$message( {
                            message: '文章发布失败',
                            type: 'error',
                        } );
                    } );
                }
            });
        },

        /**
         * Auto save editor content
         */
        saveData( content ) {
            return new Promise( resolve => {
                (function() {
                    console.log('test');
                    // var _token = $("meta[name='csrf-token']").attr('content');
                    // var id = $("#draftId").val();
                    // var title = $("#title").val();
                    // if(data != preEditorData) {
                    //     $.ajax({
                    //         url: "/admin/draft/prestore",
                    //         type: "POST",
                    //         data: {
                    //             _token: _token,
                    //             id: id,
                    //             title: title,
                    //             content: data,
                    //         },
                    //         success: function(res) {
                    //             if(res.errorCode == 0) {
                    //                 $("#draftId").val(res.data.draftId);
                    //                 title = title || "无标题草稿";
                    //                 if(!id) {
                    //                     var navHtml = "<li class=\"nav-item active\">" +
                    //                         "<a class=\"nav-link\" " +
                    //                         "href=\"/admin/draft/edit/"+res.data.draftId+"\">" +
                    //                             "<p class=\"draft-title\">"+title+"</p>" +
                    //                             "<p class=\"draft-time\">更新于："+res.data.updatedAt+"</p>" +
                    //                         "</a></li>";
                    //                     $(".draft-nav").append(navHtml);
                    //                 } else {
                    //                     var $navItem = $(".draft-nav").find(".nav-item.active");
                    //                     $navItem.find(".draft-title").html(title);
                    //                     $navItem.find(".draft-time").html("更新于："+res.data.updatedAt);
                    //                 }
                    //             }
                    //         }
                    //     });
                    // }
                    resolve();
                })();
            })
        }
    },

    mounted() {
        let vm = this;

        // Create ckeditor instance
        DecoupledEditor.create(document.querySelector('#editor'), {
            extraPlugins: [ customUploadAdapterPlugin ],
            autosave: {
                save( editor ) {
                    return vm.saveData( editor.getData() );
                }
            }
        }).then(editor => {
            // Create toolbar element
            const toolbarContainer = document.querySelector( '.toolbar-container' );
			toolbarContainer.prepend( editor.ui.view.toolbar.element );

            vm.preEditorData = editor.getData();
            console.log( Array.from( editor.ui.componentFactory.names() ) )
            // vm.handleStatusChanges( editor );
            // vm.handleSaveButton( editor );
            // vm.handleBeforeUnload( editor );

            vm.editor = editor;
            vm.postForm.content = editor.getData();

            // Listen doucment change
            editor.model.document.on('change:data', function(){
                vm.postForm.content = editor.getData();
            });
        }).catch(error => {
            console.log(error);
        });
    },
//     ClassicEditor
//         .create( document.querySelector( '#editor' ), {
// 			autosave: {
// 				save(editor){
// 					return saveData( editor.getData() );
// 				}
// 			}
//         }).then( newEditor => {
//             editor = newEditor;
//             editor.plugins.get('FileRepository').createUploadAdapter = (loader)=>{
//                 return new UploadAdapter(loader);
//             };
//             preEditorData = editor.getData();
//             handleStatusChanges( editor );
//             handleSaveButton( editor );
//             handleBeforeUnload( editor );
            
//         }).catch( error => {
//             console.log( error );
//         } );
//     //auto save 
//     function saveData( data ) {
//     	return new Promise( resolve => {
//     		(function() {
//     			var _token = $("meta[name='csrf-token']").attr('content');
//     			var id = $("#draftId").val();
//     			var title = $("#title").val();
//     			if(data != preEditorData) {
//     				$.ajax({
//     					url: "/admin/draft/prestore",
//     					type: "POST",
//     					data: {
//     						_token: _token,
//     						id: id,
//     						title: title,
//     						content: data,
//     					},
//     					success: function(res) {
// 	        				if(res.errorCode == 0) {
// 	        					$("#draftId").val(res.data.draftId);
// 	        					title = title || "无标题草稿";
// 	        					if(!id) {
// 	        						var navHtml = "<li class=\"nav-item active\">" +
// 	        							"<a class=\"nav-link\" " +
// 	        							"href=\"/admin/draft/edit/"+res.data.draftId+"\">" +
// 	        								"<p class=\"draft-title\">"+title+"</p>" +
// 	        								"<p class=\"draft-time\">更新于："+res.data.updatedAt+"</p>" +
// 	        							"</a></li>";
// 	        						$(".draft-nav").append(navHtml);
// 	        					} else {
// 	        						var $navItem = $(".draft-nav").find(".nav-item.active");
// 	        						$navItem.find(".draft-title").html(title);
// 	        						$navItem.find(".draft-time").html("更新于："+res.data.updatedAt);
// 	        					}
// 	        				}
//     					}
//     				});
//     			}
//     			resolve();
//     		})();
//     	})
//     }

//     function handleSaveButton( editor ) {
//     	const saveButton = document.querySelector( "#save" );
//     	const pendingActions = editor.plugins.get( "PendingActions" );
    	
//     	saveButton.addEventListener( 'click', evt => {
// 	        const data = editor.getData();
// 	        // Register the action of saving the data as a "pending action".
// 	        // All asynchronous actions related to the editor are tracked like this,
// 	        // so later on you only need to check `pendingActions.hasAny` to check
// 	        // whether the editor is busy or not.
// 	        const action = pendingActions.add( 'Saving changes' );

// 	        evt.preventDefault();
	        
// 	        var _token = $("meta[name='csrf-token']").attr("content");
// 	        var articleId = $("#articleId").val();
// 	        var draftId = $("#draftId").val();
// 	        var title = $("#title").val();
// 	        var $tags = $(":checkbox[name='tags']:checked");
// 	        var tags = [];
// 	        $.each($tags, function(index, item) {
// 	        	tags.push($(item).val());
// 	        });
// 	        $.ajax({
// 	        	url: "/admin/article/store",
// 	        	type: "POST",
// 	        	data: {
// 	        		_token: _token,
// 	        		id: articleId,
// 	        		draftId: draftId,
// 	        		title: title,
// 	        		content: data,
// 	        		tags: tags
// 	        	},
// 	        	success: function(res) {
//         			pendingActions.remove( action );
// 		            // Reset isDirty only if the data did not change in the meantime.
// 		            if ( data == editor.getData() ) {
// 		                isDirty = false;
// 		            }
// 	        		updateStatus( editor );
// 	        		if(res.errorCode != 0) {
// 	        			initErrorModal(res.errorMsg);
// 	        		} else if(res.errorCode == 0) {
// 	        			$("#articleId").val(res.data.articleId);
// 	        			window.location.href="/dashboard";
// 	        		}
// 	        	}
// 	        });
// 	        // Save the data to a fake HTTP server.
// //	        setTimeout( () => {
// //	            pendingActions.remove( action );
// //	            // Reset isDirty only if the data did not change in the meantime.
// //	            if ( data == editor.getData() ) {
// //	                isDirty = false;
// //	            }
// //	
// //	            updateStatus( editor );
// //	        }, HTTP_SERVER_LAG );
// 	    } );
//     }
    
//     // Listen to new changes (to enable the "Save" button) and to
//     // pending actions (to show the spinner animation when the editor is busy).
//     function handleStatusChanges( editor ) {
//     	editor.plugins.get("PendingActions").on("change:hasAny", () => updateStatus(editor));
    	
//     	editor.model.document.on("change:data", () => {
//     		isDurty = true;
//     		updateStatus(editor);
//     	}) 
//     }
//     // If the user tries to leave the page before the data is saved, ask
//     // them whether they are sure they want to proceed.
//     function handleBeforeUnload( editor ) {
//     	const pendingActions = editor.plugins.get("PendingActions");
//     	window.addEventListener("beforeunload", evt => {
//     		evt.preventDefault();
//     		if( pendingActions.hasAny ) {
//     			evt.preventDefault();
//     		}
//     	})
//     }
    
//     function updateStatus( editor ) {
//     	const saveButton = document.querySelector("#save");
//     	const editorStatus = document.querySelector("#editor-status");
		
//     	// Disables the "Save" button when the data on the server is up to date.
//     	// Display the editor status when the data on the server is up to date.
//     	if(isDurty) {
//     		saveButton.classList.add("disabled");
//     		editorStatus.innerHTML = "保存中";
//     		editorStatus.classList.add("text-warning");
//     		editorStatus.classList.remove("text-success");
//     	} else {
//     		saveButton.classList.remove("disabled");
//     		editorStatus.innerHTML = "已保存";
//     		editorStatus.classList.remove("text-warning");
//     		editorStatus.classList.add("text-success");
//     	}
    	
//     	if(editor.plugins.get("PendingActions").hasAny) {
//     		saveButton.classList.add("disabled");
//     		editorStatus.innerHTML = "保存中";
//     		editorStatus.classList.add("text-warning");
//     		editorStatus.classList.remove("text-success");
//     	} else {
//     		saveButton.classList.remove("disabled");
//     		editorStatus.innerHTML = "已保存";
//     		editorStatus.classList.remove("text-warning");
//     		editorStatus.classList.add("text-success");
//     	}
//     }
}
</script>

<style scoped>
.tag-group {
    margin-top: 10px;
    margin-bottom: 10px;
}

.tag-group .el-tag+.el-tag {
    margin-left: 10px;
}

.clickable {
    cursor: pointer;
}

.ck-content {
    min-height: 300px;
}

.document-editor {
	border: 1px solid #DFE4E6;
	border-bottom-color: #cdd0d2;
	border-right-color: #cdd0d2;
	border-radius: 2px;
	display: flex;
	flex-flow: column nowrap;
	box-shadow: 2px 2px 2px rgba(0,0,0,.1);
}

.toolbar-container {
	z-index: 1;
	position: relative;
	box-shadow: 2px 2px 1px rgba(0,0,0,.05);
}

.toolbar-container .ck.ck-toolbar {
	border-top-width: 0;
	border-left-width: 0;
	border-right-width: 0;
	border-radius: 0;
}

.content-container {
	padding: var(--ck-sample-base-spacing);
	background: #eee;
}
</style>