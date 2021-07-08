<template>
    <div class='container-fluid'>
        <el-table :data='posts' stripe>
            <el-table-column label='#' type='index'>
            </el-table-column>
            <el-table-column label="标题" prop='title'>
            </el-table-column>
            <el-table-column label="标签">
                <template slot-scope='scope'>
                    <div class='tag-group'>
                        <el-tag 
                            v-for='tag in scope.row.tags' 
                            :key='tag.id'
                            effect='plain' 
                            size='small' 
                            type='info'>
                            {{ tag.name }}
                        </el-tag>
                    </div>
                </template>
            </el-table-column>
            <el-table-column label='更新于' prop='updated_at'>
            </el-table-column>
            <el-table-column label='操作'>
                <template slot-scope='scope'>
                    <router-link 
                        :to="'/console/post/' + scope.row.id + '/edit'"
                        v-slot="{ href, navigate, isActive }">
                        <el-button 
                            type='text' 
                            :active='isActive' 
                            :href='href'
                            @click='navigate'>编辑
                        </el-button>
                    </router-link>
                    <el-button @click='deletePost(scope.row)'
                        type='text'>删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="block text-center">
            <el-pagination
                hide-on-single-page
                @current-change="handleCurrentChange"
                layout="prev, pager, next"
                :page-size="limit"
                :total="total">
            </el-pagination>
        </div>
    </div>
</template>

<script>
import PostAPI from '../../../api/post.js';

export default {
    data() {
        return {
            limit: 12,
            offset: 0,
            total: 0,

            posts: [],
        }
    },
    
    computed: {

    },

    methods: {
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

        /**
         * Load posts
         */
        loadPosts(params) {
            let vm = this;

            vm.$store.dispatch('user/loadPosts', params) 
                .then((response) => {
                    vm.posts = response.posts;
                    vm.offset += response.posts.length;
                    vm.total = response.total;
                }).catch((error) => {
                    console.log(error);
                });
        },

        /**
         * Delete a post
         */
        deletePost(post) {
            let vm = this;
            // Confirm delete operation
            vm.$confirm('This operation will permanently delete the post, continue?', 'warning', {
                confirmButtonText: 'continue',
                cancelButtonText: 'cancel',
                type: 'warning',
            }).then( () => {
                vm.$store.dispatch('post/deletePost', post.id)
                    .then( (response) => {
                        // Find the index of deleted post in posts
                        let index = vm.posts.findIndex( ({id}) => id === response.post.id );
                        vm.posts.splice(index, 1);
                        vm.$message( {
                            message: 'Operation success',
                            type: 'success',
                        });
                    } ).catch( (error) => {
                        let data = error.response.data;
                        vm.$message( {
                            message: data.message,
                            type: 'error',
                        } );
                    } );
            }).catch( () => {
                vm.$message({
                    type: 'info',
                    message: 'Operation canceled',
                })
            })
        },
    },

    created() {
        let vm = this;
        // Load the posts belong to current user
        let params = {
            limit: vm.limit,
            offset: vm.offset,
        };

        vm.loadPosts(params);
    },
}
</script>

<style scoped>
.tag-group .el-tag+.el-tag {
    margin-left: 10px;
}
</style>