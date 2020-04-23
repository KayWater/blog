<template>
    <div class='container-fluid'>
        <el-table :data='drafts' stripe>
            <el-table-column label='#' type='index'>
            </el-table-column>
            <el-table-column label="标题">
                <template slot-scope="scope">
                    <router-link :to="'/console/draft/' + scope.row.id + '/edit'">
                        {{ scope.row.title ? scope.row.title : '无标题' }}
                    </router-link>
                </template>
            </el-table-column>

            <el-table-column label='更新于'>
                <template slot-scope="scope">
                    <span>{{ scope.row.updated_at | momentFromNow }}</span>
                </template>
            </el-table-column>
            <el-table-column label='操作'>
                <template slot-scope='scope'>
                    <el-button @click='deleteDraft(scope.row)'
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
import UserAPI from '../../../api/user.js';
import PostAPI from '../../../api/post.js';

export default {
    data() {
        return {
            limit: 10,
            offset: 0,
            total: 0,

            drafts: [],
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

            this.loadDrafts(params);
        },

        /**
         * Delete a draft
         */
        deleteDraft(draft) {
            let vm = this;
            // Confirm delete operation
            vm.$confirm('This operation will permanently delete the draft, continue?', 'warning', {
                confirmButtonText: 'continue',
                cancelButtonText: 'cancel',
                type: 'warning',
            }).then( () => {
                PostAPI.deleteDraft(draft.id)
                    .then( (response) => {
                        let data = response.data;
                        // Find the index of deleted post in posts
                        let index = vm.drafts.findIndex( ({id}) => id === data.draft.id );
                        vm.drafts.splice(index, 1);
                        vm.$message( {
                            message: 'Operation success',
                            type: 'success',
                        } );
                    } ).catch( (error) => {
                        console.log(error);
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

        /**
         * Load drafts belongs to current user
         */
        loadDrafts(params) {
            let vm = this;
            UserAPI.getDrafts( {
                params: params,
            } ).then( (response) => {
                let data = response.data;
                vm.drafts = data.drafts;
                vm.offset += data.drafts.length;
                vm.total = data.total;
            } ).catch( (error) => {
                console.log(error.response);
            } );

        },
    },

    created() {
        let vm = this;
        let params = {
            limit: vm.limit,
            offset: vm.offset,
        };
        // Load the posts belong to current user
        vm.loadDrafts(params);

    },
}
</script>

<style scoped>
.tag-group .el-tag+.el-tag {
    margin-left: 10px;
}
</style>