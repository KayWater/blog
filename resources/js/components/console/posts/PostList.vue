<template>
    <div class='container-fluid'>
        <el-table 
            :data='posts' 
            stripe
        >
            <el-table-column 
                label='#' 
                type='index'
            >
            </el-table-column>
            <el-table-column 
                label="标题" 
                prop='title'
            >
            </el-table-column>
            <el-table-column label="标签">
                <template slot-scope='scope'>
                    <div class='tag-group'>
                        <el-tag 
                            v-for='tag in scope.row.tags' 
                            :key='tag.id'
                            effect='plain' 
                            size='small' 
                            type='info' 
                        >
                            {{ tag.name }}
                        </el-tag>
                    </div>
                </template>
            </el-table-column>
            <el-table-column 
                label='更新于'
                prop='updated_at'
            >
            </el-table-column>
            <el-table-column label='操作'>
                <template slot-scope='scope'>
                    <router-link 
                        :to="'/console/post/' + scope.row.id + '/edit'"
                        v-slot="{ href, route, navigate, isActive }"
                    >
                        <el-button 
                            type='text' 
                            :active='isActive' 
                            :href='href'
                            @click='navigate'
                        >编辑</el-button>
                    </router-link>
                    <el-button @click='deletePost(scope.row)'
                    size='small' type='text'>删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
import UserAPI from '../../../api/user.js';
import PostAPI from '../../../api/post.js';

export default {
    data() {
        return {
            limit: 10,
            offset: 0,

            posts: [],
        }
    },
    
    computed: {

    },

    methods: {
        /**
         * Delete a post
         */
        deletePost(post) {
            let vm = this;
            // Confirm delete operation
            vm.$confirm('此操作将永久删除该文章,是否继续', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning',
            }).then( () => {
                PostAPI.deletePost(post.id)
                    .then( (response) => {
                        let data = response.data;
                        // Find the index of deleted post in posts
                        let index = vm.posts.findIndex( ({id}) => id === data.post.id );
                        vm.posts.splice(index, 1);
                        vm.$message( {
                            message: 'The operation was successful',
                            type: 'success',
                        } );
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
        UserAPI.getPosts( {
            params: {
                limit: vm.limit,
                offset: vm.offset,
            }
        } ).then( (response) => {
            let data = response.data;
            vm.posts = data.posts;
            vm.offset += data.posts.length;
        } ).catch( (error) => {
            console.log(error.response);
        } );

    },
}
</script>

<style scoped>
.tag-group .el-tag+.el-tag {
    margin-left: 10px;
}
</style>