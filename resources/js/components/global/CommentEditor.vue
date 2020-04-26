<template>
    <!-- <form class="comment-form" id="commentForm" >
        <input id="postId" name="postId"  type="hidden" value="">
        <div class="form-group">
            <label for="comment">评论</label>
            <textarea name="comment" id="commentEditor"></textarea>
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-primary login-required">
            <span class="fa fa-comment-o fa-flip-horizontal"></span>&nbsp;&nbsp;评论</button>
        </div>
    </form> -->
    <div class="block">
        <div class="document-editor">
            <div class="document-editor__toolbar"></div>
            <div class="document-editor__editable-container">
                <div id="editor"></div> 
            </div>
        </div>
    </div>
</template>

<script>
import '../../ckeditor.js';
import { customUploadAdapterPlugin } from '../../utils/CustomUploadAdapter.js';
 
export default {
    data() {
        return {
            content: '',
        }
    },
    methods: {
        /**
         * Create editor instance
         */
        createEditor() {
            let vm = this;
            DecoupledDocumentEditor
                .create( document.querySelector( '#editor' ), {
                    extraPlugins: [ customUploadAdapterPlugin ],
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'fontSize',
                            'fontFamily',
                            'fontBackgroundColor',
                            'fontColor',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            'strikethrough',
                            'highlight',
                            '|',
                            'alignment',
                            '|',
                            'numberedList',
                            'bulletedList',
                            '|',
                            'indent',
                            'outdent',
                            '|',
                            'link',
                            'blockQuote',
                            'imageUpload',
                            'insertTable',
                            'mediaEmbed',
                            '|',
                            'code',
                            'codeBlock',
                            'subscript',
                            'superscript',
                            '|',
                            'undo',
                            'redo'
                        ]
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
                    document.querySelector( '.document-editor__toolbar' ).appendChild( editor.ui.view.toolbar.element );
                    // document.querySelector( '.ck-toolbar' ).classList.add( 'ck-reset_all' );

                    // console.log( Array.from( editor.ui.componentFactory.names() ) )

                    // Listen doucment change
                    editor.model.document.on('change:data', function() {
                        vm.content = editor.getData();
                    });
                } )
                .catch( error => {
                    console.error( error );
                } );
        }
    },

    mounted() {
        console.log('Component mounted.')
        let vm = this;
        this.$nextTick().then(() => {
            vm.createEditor();
        });
    },
    // methods: {
    //     getFeedItems(queryText) {
    //         return new Promise( resolve => {
    //             let url = "/api/user/search?key=" + queryText;
                
    //             const xhr = new XMLHttpRequest();
    //             xhr.open('GET', url);
    //             xhr.responseType = 'json';
    //             xhr.addEventListener('load', ()=>{
    //                 const response = xhr.response;
    //                 var data = response.data.map(function(item) {
    //                     item['id'] = '@' + item.name;
    //                     item['userId'] = item.id;
    //                     return item;
    //                 });
    //                 resolve(data);
    //             });
    //             xhr.send();
    //         });
    //     },
    // }
}
</script>

<style scoped>
.document-editor {
    border: 1px solid var(--ck-color-base-border);
    border-radius: var(--ck-border-radius);

    /* This element is a flex container for easier rendering. */
    display: flex;
    flex-flow: column nowrap;
}

.document-editor__toolbar {
    /* Make sure the toolbar container is always above the editable. */
    z-index: 1;

    /* Create the illusion of the toolbar floating over the editable. */
    box-shadow: 0 0 5px hsla( 0,0%,0%,.2 );

    /* Use the CKEditor CSS variables to keep the UI consistent. */
    border-bottom: 1px solid var(--ck-color-toolbar-border);
}

.document-editor__toolbar .ck-toolbar {
    border: 0;
    border-radius: 0;
}
/* .ck-editor__editable_inline {
    border: 1px solid var(--ck-color-toolbar-border);;
} */
</style>