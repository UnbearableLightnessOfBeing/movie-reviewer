<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    movies: Array,
    // laravelVersion: String,
    // phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <AuthenticatedLayout>
        <!-- <div
        >
            <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="text-sm text-gray-700 dark:text-gray-500 underline"
                    >Dashboard</Link
                >

                <template v-else>
                    <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                        >Register</Link
                    >
                </template>
            </div>
        </div> -->

        <h1 class="mx-auto w-fit mt-4 text-2xl font-bold">Main page</h1>
        {{ $page.props.auth }}
        <br />
        <br />
        {{ $page.props.ziggy.url }}
        <br />
        <br />
    </AuthenticatedLayout>

</template>
