<script setup>
defineProps(['message']);
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-pink-500">
            * {{ message }}
        </p>
    </div>
</template>
