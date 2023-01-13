<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';

import { getImgUrl, getPoster } from '@/Utils/utils';

defineProps({
    movies: Array,
});

//  function getImgUrl(urlString) {
//     return usePage().props.value.ziggy.url + '/storage/' + urlString.toString();
// }

// function getPoster(movie) {
//     return movie.poster? getImgUrl(movie.poster) : usePage().props.value.ziggy.url + '/storage/images/posters/no-image.jpg'
// }

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
                                        <div v-if="movie.rating" class="flex gap-2 rating absolute top-0 left-0 p-2 m-1 rounded-xl bg-black bg-opacity-30 ">
                                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="ipc-icon ipc-icon--star-inline" id="iconContext-star-inline" viewBox="0 0 24 24" fill="yellow" role="presentation"><path d="M12 20.1l5.82 3.682c1.066.675 2.37-.322 2.09-1.584l-1.543-6.926 5.146-4.667c.94-.85.435-2.465-.799-2.567l-6.773-.602L13.29.89a1.38 1.38 0 0 0-2.581 0l-2.65 6.53-6.774.602C.052 8.126-.453 9.74.486 10.59l5.147 4.666-1.542 6.926c-.28 1.262 1.023 2.26 2.09 1.585L12 20.099z"></path></svg>
                                            <p class="text-lg font-bold text-gray-200">
                                                {{ movie.rating }}
                                            </p>
                                        </div>
                                        <h2 class="movie-title text-xl font-black text-primary">
                                            {{ movie.title.toUpperCase() }}
                                        </h2>
                                        <p class="genre font-semibold overflow-hidden h-0 transition text-primarylight ease-in-out duration-300">
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
