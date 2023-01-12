<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Link
        class="block w-full px-4 py-2 text-left text-sm leading-5 text-secondary hover:bg-primary focus:outline-none focus:bg-primarylight transition duration-150 ease-in-out"
    >
        <slot />
    </Link>
</template>
