<template>
    <div class='container mt-3'>
        <template v-if='post'>
            <h1 class='text-center'>{{ post.title }}</h1>
            <p class='text-center'>{{ post.user.name }} 发布于 {{ post.published_at | momentFromNow }}</p>
            <div class='ck-content' v-html="post.content"></div>

            <!-- <el-divider>{{ post.comments_count }} 条评论</el-divider>
            <div class='mt-4'>
                <nest-comment-list v-bind:comments='comments' ></nest-comment-list>
                <div class="block text-center mt-2">
                    <el-pagination
                        hide-on-single-page
                        @current-change="handleCurrentChange"
                        :page-size="limit"
                        layout="total, prev, pager, next, jumper"
                        :total="total">
                    </el-pagination>
                </div>
            </div> -->
            <div class='block clearfix mt-4'>
                <p>评论</p>
                <comment-editor ref='comment' v-bind:id="'commentEditor'"></comment-editor>
                <div class='mt-2 float-right'>
                    <el-button @click='addComment' >提交评论</el-button>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import PostAPI from '../../api/post.js';

import CommentEditor from '../global/CommentEditor.vue';
// import NestCommentList from './Comments/NestCommentList.vue';



export default {
    props: [
        'id',
    ],

    components: {
        CommentEditor,
        // NestCommentList,
    },

    data() {
        return {
            limit: 10,
            offset: 0,
            total: 0,

            post: null,
        }
    },

    computed: {


        /**
         * Comments
         */
        // comments() {
        //     return this.$store.state.post.comments;
        // },

        /**
         * Comment
         */
        // comment() {
        //     return this.$store.state.post.comment;
        // },
    },

    methods: {
        /**
         * Load post
         */
        loadPost(id) {
            let vm = this;
            PostAPI.getPost(id)
                .then((response) => {
                    vm.post = response.data.post;
                }).catch((error) => {
                    console.log(error);
                })
        },

        /**
         * Comment
         */
        addComment() {
            let vm = this;
            let content = this.$refs.comment.content;
            if (content === '') {
                return 
            }
            vm.$store.dispatch('post/addComment', {
                postID: vm.postID,
                content: content,
            }).then((response) => {
                vm.$message({
                    message: '评论成功',
                    type: 'success',
                });
                console.log(response);
                let comments = vm.comments;
                vm.$store.commit('post/setComments',  comments.push(response.comment));
            }).catch((error) => {
                console.log(error);
            });
        },

        /**
         * Handle currentPage change
         */
        handleCurrentChange(currentPage) {
            let vm = this;
            // Load next comments
            this.$store.dispatch('post/getComments', {
                postID: vm.postID,
                params: {
                    limit: this.limit,
                    offset: (currentPage - 1) * this.limit,
                }
            });
        },
    },

    created() {
        let vm = this;
        // Load post
        vm.loadPost(vm.id);

        // vm.$store.dispatch('post/getPost', vm.postID)
        //     .then((response) => {
        //         // Load comments of post
        //         return vm.$store.dispatch('post/getComments', {
        //             postID: vm.postID,
        //             params: {
        //                 limit: vm.limit,
        //                 offset: vm.offset,
        //             }
        //         });
        //     }).then((response) => {
        //         vm.offset += response.comments.length;
        //         vm.total += response.total;
        //     }).catch((error) => {
        //         console.log(error);
        //     });
    },

    /**
     * Listen route change
     */
    beforeRouteUpdate(to, from , next) {
        let vm = this;

        // Load post
        vm.loadPost(to.params.id);
        
        next();
    }
}
</script>

<style scoped>

</style>