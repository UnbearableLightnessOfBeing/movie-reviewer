<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';

defineProps({
    movies: Array,
});

 function getImgUrl(urlString) {
    return usePage().props.value.ziggy.url + '/storage/' + urlString.toString();
}

function getPoster(movie) {
    return movie.poster? getImgUrl(movie.poster) : usePage().props.value.ziggy.url + '/storage/images/posters/no-image.jpg'
}

</script>

<template>
    <Head title="Фильмы" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl bg-primary text-secondary leading-tight">Фильмы</h2>
        </template>

        <div class="bg-primary py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-primarylight overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-secondary">Search</div>
                    <!-- <div class="movies" v-if="movies">
                        <Link class="movie block space-y-6 mt-6 outline-red-300 outline p-3 m-3"  
                            :href="route('movie.show', { id: movie.id })" v-for="movie in movies" :key="movie.id">
                            {{ movie }}
                        </Link>
                    </div>
                    <div v-else>
                        NO MOVIES
                    </div> -->


                    <div>
                        <div class="wrapper-container px-1 py-6 mt-10 gap-10 justify-center max-w-6xl mx-auto flex flex-wrap">
                            <div v-for="movie in movies" :key="movie.id" class="link-wrapper">
                                <!-- <Link :href="route('movie.show', { id: movie.id })" 
                                        class="movie-card relative flex flex-col justify-end items-center bg-center bg-cover bg-no-repeat" 
                                            :style="'background-image: url(' + getPoster(movie) + ')'" > -->
                                <Link :href="route('movie.show', { id: movie.id })" 
                                        class="group movie-card relative flex flex-col justify-end items-center bg-center overflow-hidden bg-cover bg-no-repeat" 
                                        >
                                    <img :src="getPoster(movie)" class="absolute group-hover:scale-110 ease-in-out duration-300 w-full h-full object-cover -z-15">
                                    <div  class="card-foreground bg-secondary bg-opacity-80 w-full flex flex-col justify-center
                                                text-center text-white py-4 gap-4 z-10">
                                        <div class="age-badge absolute top-4 right-4 ">
                                            {{ movie.restriction }}
                                        </div>
                                        <h2 class="movie-title font-bold">
                                            {{ movie.title.toUpperCase() }}
                                        </h2>
                                        <p class="genre font-medium overflow-hidden h-0 transition ease-in-out duration-300">
                                            {{ movie.genres.join(', ') }}
                                        </p>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
