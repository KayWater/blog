<template>
    <div class='card article-card mb-3'>
        <div class='card-body'>
            <h4 class='card-title'>
                <router-link class='text-dark' :to="{ name: 'post', params: { id: post.id }}">
                    {{ post.title }}</router-link>
            </h4>
            <div>
                <a class='card-link' v-for='tag in post.tags' v-bind:key="tag.id">{{tag.name}}</a>
            </div>
            <p class="card-text text-secondary clearfix">
                <span class="fa fa-clock-o ">  {{ post.published_at }}</span>
                <span class="fa fa-eye pl-2">  {{ post.views }}</span>
                <router-link class='pull-right' :to="{ name: 'post', params: { id: post.id }}">Read More</router-link>
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
    }
}
</script>

<style scoped>

</style>