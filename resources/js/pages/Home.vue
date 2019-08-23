<template>
    <div id='home'>
        <span v-show="cafesLoadStatus == 1">加载中...</span>
        <span v-show="cafesLoadStatus == 2">数据加载成功！</span>
        <span v-show="cafesLoadStatus == 3">数据加载失败！</span>
    </div>
</template>

<script>
    export default {
        created() {
            this.$store.dispatch('loadCafes');
        },
        computed: {
            cafesLoadStatus() {
                return this.$store.getters.getCafesloadStatus;
            },

            cafes() {
                return this.$store.getters.getCafes;
           }
         }
    }
</script>

<style>

</style>