<template>
    <section class='container mb-4'>
        <post-item 
            v-for='post in posts' 
            :key='post.id' 
            :post='post'
        >
        </post-item>
        <div class='pagination'>
            <el-pagination 
                layout='prev, pager, next' 
                :total='total' 
                :page-size='pageSize'
                :hide-on-single-page='true' 
                @current-change='handleCurrentChange'
            >
            </el-pagination>
        </div>
    </section>
</template>

<script>
import PostAPI from '../../api/post.js';
import PostItem from './PostItem.vue'

export default {
    components: {
        PostItem,
    },
    data() {
        return {
            posts: [],

            loading: false,
            error: null,
            
            pageSize: 10, 
            total: 0,
            currentPage: 1,
        }
    },

    created() {
        this.getPosts()
    },

    watch: {
        // Execute getPosts method once route changed.
        '$route': 'getPosts'
    },

    methods: {
        /**
         * Load the posts
         */
        getPosts() {
            let vm = this;
            let offset = (this.currentPage - 1) * this.pageSize;

            PostAPI.getPosts( {
                params: {
                    limit: vm.pageSize,
                    offset: offset,
                }
            } ).then( (response) => {
                let data = response.data;
                vm.posts = data.posts;
                vm.offset = data.posts.length;
            } ).catch( (error) => {
                vm.posts = [];
                console.log(error);
            } );
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.getPosts();
        }
    }

}
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: center;
}
</style>