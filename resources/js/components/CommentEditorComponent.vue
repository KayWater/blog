<template>
    <form class="comment-form" id="commentForm" >
        <input id="postId" name="postId"  type="hidden" value="">
        <div class="form-group">
            <label for="comment">评论</label>
            <textarea name="comment" id="commentEditor"></textarea>
        </div>
        <div class="form-group text-right">
            <button type="submit" id="commentSubmit" class="btn btn-primary ">
            <span class="fa fa-comment-o fa-flip-horizontal"></span>&nbsp;&nbsp;评论</button>
            <button type="button" class="btn btn-primary login-required">
            <span class="fa fa-comment-o fa-flip-horizontal"></span>&nbsp;&nbsp;评论</button>
        </div>
    </form>
</template>

<script>
import { default as classicEditor } from '../ckeditor.js'

    export default {
        mounted() {
            console.log('Component mounted.')
            ClassicEditor
                .create( document.querySelector( '#commentEditor' ), {
                    toolbar: {},
                    mention: {
                        feeds: [
                            {
                                marker: '@',
                                // Define feed items callback
                                feed: this.getFeedItems,
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
        },
        methods: {
            getFeedItems(queryText) {
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
            },
        }
    }
</script>