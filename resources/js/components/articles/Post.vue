<template>
    <div class='post'>
        <div v-if='loading' class='container'>
            <div> loading </div>
        </div>
        <div v-if='post' class='container '>
            <section class='mt-4'>
                <h3 class='text-center'>{{ post.title }}</h3>
                <div class='text-center'>
                    <a class='card-link' v-for='tag in post.tags' v-bind:key="tag.id">{{tag.name}}</a>
                </div>
                <p class='text-center'>{{ post.published_at }}</p>
                    <div id='editor' class='ck-content' v-html="post.content">
                </div>
            </section>
            <commentEditor></commentEditor>
        </div>
    </div>
</template>

<script>

//import { default as ClassicEditor } from '../../ckeditor'
import CommentEditor from '../CommentEditor'

export default {
    props: ['id'],
    components: {
        commentEditor: CommentEditor,
    },
    data() {
        return {
            loading: false,
            error: null,
            post: null,
        }
    },
    created() {
        this.getPost();
    },
    watch: {
        "$router": 'getPost',
    },
    methods: {
        getPost() {
            this.error = this.post = null
            this.loading = true
            axios.get('/api/article/' + this.id)
            .then(response => {
                this.loading = false
                console.log(response)
                this.post = response.data.post
                console.log(this.post)
            }).catch(function(error){
                console.log(error);
                //this.error = error.toString()
            })
        }
    }
}
</script>

<style scoped>

</style>