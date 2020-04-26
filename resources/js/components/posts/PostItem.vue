<template>
    <div class='card post-item mb-3'>
        <div class='card-body'>
            <h4 class='card-title'>
                <router-link class='text-dark' :to="'/post/' + post.id">
                    {{ post.title }}</router-link> 
            </h4>
            <div>
                <a class='card-link' v-for='tag in post.tags' v-bind:key="tag.id">{{tag.name}}</a>
            </div>
            <p class="card-text text-secondary clearfix">
                <span><i class="el-icon-time"></i>  {{ post.published_at | momentFromNow }}</span>
                <span><i class="el-icon-view"></i>  {{ post.views }}</span>
                <router-link class='pull-right' :to="'/post/' + post.id">Read More</router-link>
            </p>
        </div> 
    </div>
</template>

<script>
export default {
    props: [
        'post'
    ],
    data() {
        return {

        }
    },
    created() {
    }
}
</script>

<style scoped>
.post-item {
    margin: 20px auto;
    border: 0;
}
</style>