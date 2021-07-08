<template>
    <div class='container-fluid'>
        <nav class='navbar navbar-light justify-content-between '>
            <div class='navbar-title'>
                <p class='d-inline'>写文章</p>
                <p class='d-inline editor-status' v-bind:class="[editorInBusyStatus ? 'editor-status-busy' : '']">{{ editorStatusMessage }}</p>
            </div>
            <div>
                <el-button @click='publish' :disabled="publishButtonAvailable">发布文章</el-button>
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
                    <div class="document-editor">
                        <div class="toolbar-container"></div>
                        <div class="content-container">
                            <div id="editor" :v-html="postForm.content"></div>
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
            editor: null, // editor instance
            editorInBusyStatus: false, // whether editor in editing status.
            editorStatusMessage: '', // message about current status
            initialEditorStatus: true, // means whether the editor is in initial status.
            
            dialogTagChoiceVisible: false,
            dialogTagCreateVisible: false,
            tagsLimit: 5,

            limit: 10,
            offset: 0,

            tagSearch: '',
            newTag: '',

            tags: [],

            postForm: {
                draftID: 0,
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
        publishButtonAvailable() {
            return this.postForm.title == '' || this.postForm.content == '';
        }
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
                console.log('publish');
                PostAPI.addPost( vm.postForm )
                    .then( (response) => {
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
            });
        },

        /**
         * Auto save editor content
         */
        saveData( content ) {
            let vm = this;
            if (vm.initialEditorStatus && (content == '' && vm.postForm.title == '')) {
                return ;
            }
            return new Promise((resolve, reject) => {
                PostAPI.autosave(vm.postForm)
                    .then((response) => {
                        let draft = response.data.draft;
                        vm.postForm.draftID = draft.id;
                        resolve()
                    })
            });
        },

        /**
         * Create editor instance
         */
        createEditor() {
            let vm = this;
            let toolbarItems = [
                'heading', '|', 
                'fontSize', 'fontFamily','fontBackgroundColor', 'fontColor', '|', 
                'bold', 'italic', 'underline', 'strikethrough', 'highlight', '|',
                'alignment', 'indent', 'outdent', '|',
                'numberedList', 'bulletedList', '|',
                'link', 'blockQuote', 'imageUpload', 'insertTable', 'mediaEmbed', '|',
                'code', 'codeBlock', 'subscript', 'superscript', '|',
                'undo', 'redo'
            ];

            DecoupledDocumentEditor
                .create( document.querySelector( '#editor' ), {
                    extraPlugins: [ customUploadAdapterPlugin ],
                    toolbar: {
                        items: toolbarItems
                    },
                    autosave: {
                        waitingTime: 6000,
                        save( editor ) {
                            return vm.saveData( editor.getData() );
                        }
                    },
                    image: {
                        toolbar: [
                            'imageTextAlternative',
                            'imageStyle:full',
                            'imageStyle:side'
                        ]
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells',
                            'tableCellProperties',
                            'tableProperties'
                        ]
                    },
                } )
                .then( editor => {
                    vm.editor = editor;
                    // Set a custom container for the toolbar.
                    document.querySelector( '.toolbar-container' ).appendChild( editor.ui.view.toolbar.element );
                    document.querySelector( '.ck-toolbar' ).classList.add( 'ck-reset_all' );

                    // console.log( Array.from( editor.ui.componentFactory.names() ) )
                    vm.displayStatus( editor );

                    // Listen doucment change
                    editor.model.document.on('change:data', function() {
                        vm.initialEditorStatus = false;
                        vm.postForm.content = editor.getData();
                    });
                } )
                .catch( error => {
                    console.error( error );
                } );
        },

        // Display the status of editor
        displayStatus( editor ) {
            let vm = this;
            const pendingActions = editor.plugins.get( 'PendingActions' );

            pendingActions.on( 'change:hasAny', ( evt, propertyName, newValue ) => {
                if (vm.initialEditorStatus && !newValue) {
                    vm.editorInBusyStatus = false;
                    vm.editorStatusMessage = '';
                } else if (!vm.initialEditorStatus && !newValue){
                    vm.editorInBusyStatus = false;
                    vm.editorStatusMessage = '已保存';
                } else {
                    vm.editorInBusyStatus = true;
                    vm.editorStatusMessage = '保存中';
                }
            } );
        }
    },

    mounted() {
        let vm = this;

        // create editor instance after DOM rendered
        vm.$nextTick()
            .then(()=> {
                vm.createEditor();
            });
    },
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
.editor-status {
    font-size: 0.6rem;
    color: #67C23A
}
.editor-status-busy {
    color: #E6A23C
}
</style>