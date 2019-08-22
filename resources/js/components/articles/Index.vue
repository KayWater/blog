<template>

    <section class='container mb-4'>
        <post-item v-for='post in posts' v-bind:key='post.id' v-bind:post='post'></post-item>
        <div class='pagination'>
            <el-pagination layout='prev, pager, next' :total='total' :page-size='pageSize'
            :hide-on-single-page='true' @current-change='handleCurrentChange'></el-pagination>
        </div>
    </section>
</template>

<script>
import PostItem from './PostItem'

export default {
    components: {
        PostItem,
    },
    data() {
        return {
            loading: false,
            posts: null,
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
        '$route': 'getPosts'
    },
    methods: {
        getPosts() {
            this.error = this.posts = null;
            this.loading = true;
            var offset = (this.currentPage - 1) * this.pageSize;
            var url = '/api/articles';
            axios.get(url, {
                params: {
                    pageSize: this.pageSize,
                    offset: offset,
                }
            }).then(response => {
                //console.log(response);
                this.loading = false;
                this.posts = response.data.articles;
                this.total = response.data.total;
                this.pageSize = response.data.pageSize;
            }).catch(function (error) {
                console.log(error)
                //this.error = error.toString();
            })
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