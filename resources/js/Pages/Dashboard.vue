<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import VueMultiselect from 'vue-multiselect';

import { getImgUrl, getPoster } from '@/Utils/utils';

const props = defineProps({
    movies: Array,
    filters: Object,
    genres: Array,
    actors: Array,
});

let search = ref(props.filters.search ?? '');
let searchGenre = ref(props.filters.searchGenre ?? '');
let searchActor = ref(props.filters.searchActor ?? '');

let queryFilters = ref({
    search: search.value, 
    searchGenre: searchGenre.value, 
    searchActor: searchActor.value, 
});

watch(search, (value) => {
    queryFilters.value.search = value;
    Inertia.get(route('dashboard'), queryFilters.value, { preserveState: true, replace: true });
});

watch(searchGenre, (value) => {
    queryFilters.value.searchGenre = value;
    Inertia.get(route('dashboard'), queryFilters.value, { preserveState: true, replace: true });
});

watch(searchActor, (value) => {
    queryFilters.value.searchActor = value;
    Inertia.get(route('dashboard'), queryFilters.value, { preserveState: true, replace: true });
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
                    <div class="search-pnel p-6 flex flex-wrap gap-4 mx-auto w-fit">
                        <div class="search-by-name space-y-2">
                            <label class="text-secondary ">Сортировка по названию</label>
                            <div class="search-by-name relative">
                                <div class="absolute flex items-center ml-2 h-full">
                                    <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z">
                                        </path>
                                    </svg>
                                </div>

                                <input v-model="search" type="text" placeholder="Найти по названию"
                                    class="px-8 py-3 w-full rounded-md text-white bg-primary border-transparent 
                                        focus:border-gray-500 focus:bg-primary focus:ring-0 text-sm" />
                            </div>
                        </div>
                        <div class="seach-by-genre space-y-2">
                            <label class="text-secondary">Сортировка по жанру</label>
                            <VueMultiselect v-model="searchGenre"
                                            :options="genres.map(genre => genre.title)" 
                                            :option-height="46"
                                            :searchable="false" 
                                            :close-on-select="true" 
                                            :show-labels="false" 
                                            placeholder="Выберете жанр"
                                            class="w-[250px]"
                                            >

                                <template v-slot:singleLabel="props">
                                        <span class="bg-primary text-white ">{{ props.option }}</span>
                                </template>

                                <template v-slot:option="props">
                                    <div class="group dropdown-option h-[46px] w-full flex items-center justify-center text-center bg-primary border 
                                            border-transparent hover:outline-none hover:bg-primarylight">
                                        <span class="text-secondary group-hover:text-white">{{ props.option }}</span>
                                    </div>
                                </template>
                            </VueMultiselect>
                        </div>
                        <div class="seach-by-genre space-y-2">
                            <label class="text-secondary">Сортировка по актеру</label>
                            <VueMultiselect v-model="searchActor"
                                            :options="actors.map(actor => actor.name)" 
                                            :option-height="46"
                                            :searchable="false" 
                                            :close-on-select="true" 
                                            :show-labels="false" 
                                            placeholder="Выберете актёра"
                                            class="w-[250px]"
                                            >

                                <template v-slot:singleLabel="props">
                                        <span class="bg-primary text-white ">{{ props.option }}</span>
                                </template>

                                <template v-slot:option="props">
                                    <div class="group dropdown-option h-[46px] w-full flex items-center justify-center text-center bg-primary border 
                                            border-transparent hover:outline-none hover:bg-primarylight">
                                        <span class="text-secondary group-hover:text-white">{{ props.option }}</span>
                                    </div>
                                </template>
                            </VueMultiselect>
                            <!-- <pre>
                                {{ filters }}
                                {{ searchGenre }}
                            </pre> -->
                        </div>
                    </div>




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

<style >
.dropdown-option::after {
        content: '';
        background-color: transparent !important; 
}

.multiselect__option--highlight {
    background: none;
}

.multiselect__option--selected > div {
    background: #232533;
}

.multiselect__option {
    display: flex;
    padding: 0px;
    width: 100%;
    height: 100%;
}

.multiselect {
    height: 46px;
}

.multiselect__tags {
    background: #131522;
    border-color: #131522;
    height: 46px;
}

.multiselect__single {
    background: #131522;
}

.multiselect__content-wrapper {
    border-color: #131522;
}
</style>
