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
                :page-size='limit'
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
            
            limit: 12,  // Limit when load posts. 
            offset: 0,   // Offset when load posts.
            total: 0,  
        }
    },

    created() {
        let vm = this;

        // Load posts
        let params = {
            limit: vm.limit,
            offset: vm.offset,
        };
        vm.loadPosts(params);

    },

    methods: {
        /**
         * Load posts
         */
        loadPosts(params) {
            let vm = this;
            PostAPI.getPosts({
                params: params,
            }).then((response) => {
                let data = response.data;
                vm.posts = data.posts;
                vm.offset += data.posts.length;
                vm.total = data.total;
            }).catch((error) => {
                console.log(error);
            })
        },

        /**
         * Handle current page change
         */
        handleCurrentChange(current) {
            let params = {
                limit: this.limit,
                offset: (current - 1) * this.limit,
            };

            this.loadPosts(params);
        },
    }

}
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: center;
}
</style>