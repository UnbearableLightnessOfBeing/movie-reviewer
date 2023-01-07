<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    movies: Array,
});
</script>

<template>
    <Head title="Фильмы" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Фильмы</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Movies page</div>
                    <div class="movies" v-if="movies">
                        <Link class="movie block space-y-6 mt-6 outline-red-300 outline p-3 m-3"  
                            :href="route('movie.show', { id: movie.id })" v-for="movie in movies" :key="movie.id">
                            {{ movie }}
                        </Link>
                    </div>
                    <div v-else>
                        NO MOVIES
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
