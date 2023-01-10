<script setup>
import { defineProps } from 'vue';

const props = defineProps(['message']);

</script>

<template>
    <div class="fixed top-12 right-10 border-4 bg-teal-500 border-emerald-600 rounded-xl w-fit p-4 text-xl text-white">
        {{ message }}
    </div>
</template>

<style lang="scss" scoped>

</style>