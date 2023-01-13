<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm, Head } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PopupSuccess from '@/Components/PopupSuccess.vue';
import AdminEdit from '@/Components/AdminEdit.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { defineProps, ref } from 'vue';

import VueMultiselect from 'vue-multiselect';

import { getAvatarSource } from '@/Utils/utils'; 
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    movie: Object,
    actors: Array,
    genres: Array,
    countries: Array,
});

const form = useForm({
    title: props.movie.title,
    duration: props.movie.duration,
    release_date: props.movie.release_date,
    production: props.movie.production,
    restriction: props.movie.restriction,
    description: props.movie.description,
    actorValues: props.movie.actors,
    genreValues: props.movie.genres,
    countryValues: props.movie.countries,
});

const posterForm = useForm({
    poster: {},
    movieId: props.movie.id
});

const trailerForm = useForm({
    trailer: null,
    movieId: props.movie.id
});

const trailerPosterForm = useForm({
    poster: null,
    movieId: props.movie.id
});

let showTrailer = ref(false);

</script>

<template>
    <div>
    <AdminLayout>
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Фильмы
            </h1>
            <Head title="Редактировать фильм" />
        </template>

            <div class="py-0">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <section class="container mx-auto p-6 font-mono">
                        <section class="flex content-center">
                            <div  v-if="showTrailer" class="w-full md:w-1/2">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 flex flex-col gap-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-6">
                                                <div class="flex flex-col gap-4">
                                                    <video-player
                                                        :src="$page.props.ziggy.url + '/storage/' + movie.trailer"
                                                        :poster="$page.props.ziggy.url + '/storage/' + movie.trailer_poster"
                                                        width="350"
                                                        controls
                                                        :loop="true"
                                                        :volume="0.6"
                                                        @mounted=""
                                                        @ready=""
                                                        @play=""
                                                        @pause=""
                                                        @ended=""
                                                        @seeking=""
                                                    />
                                                    <form class="flex flex-col gap-2" @submit.prevent="trailerPosterForm.post(route('admin.trailer.update', { _method: 'put' }))">

                                                        <!-- <img    :src="props.movie.trailer_poster? $page.props.ziggy.url + '/storage/' + 
                                                                props.movie.trailer_poster : $page.props.ziggy.url + '/storage/images/posters/no-image.jpg'" 
                                                                width="200" class="rounded-md overflow-hedden" alt="avatar"> -->

                                                        <InputLabel for="trailerPoster" class="block w-full text-sm font-medium text-gray-700">Постер к трейлеру: </InputLabel>
                                                        <input class="block" type="file" @input="trailerPosterForm.poster = $event.target.files[0]" />
                                                        <InputError :message="trailerPosterForm.errors.poster" class="mt-2" />
                                                        <button class="bg-indigo-500 hover:bg-indigo-700 h-[40px] self-end text-white px-4 py-2 rounded-lg">Сохранить</button>
                                                    </form>
                                                    <form class="flex flex-col gap-2" @submit.prevent="trailerForm.post(route('admin.trailer.update', { _method: 'put' }))">
                                                        <InputLabel for="trailer" class="block w-full text-sm font-medium text-gray-700">Трейлер: </InputLabel>
                                                        <input class="block" type="file" @input="trailerForm.trailer = $event.target.files[0]" />
                                                        <InputError :message="trailerForm.errors.trailer" class="mt-2" />
                                                        <progress v-if="trailerForm.progress" :value="trailerForm.progress.percentage" max="100">
                                                        {{ trailerForm.progress.percentage }}%
                                                        </progress>
                                                        <button class="bg-indigo-500 hover:bg-indigo-700 h-[40px] self-end text-white px-4 py-2 rounded-lg">Сохранить</button>
                                                    </form>
                                                    <i @click="showTrailer=false" class="px-4 py-2 border-2 w-fit self-start transition-all duration-200 rounded-full text-gray-500 font-bold border-indigo-500 
                                                                bg-indigo-400 hover:cursor-pointer bg-opacity-50 hover:bg-opacity-100 hover:text-white">Свернуть</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    <i v-if="!showTrailer" @click="showTrailer=true"  class="px-4 py-2 mt-16 border-2 w-fit self-end rounded-full text-gray-500 
                                                font-bold border-indigo-500 bg-indigo-400 hover:cursor-pointer bg-opacity-50 
                                                hover:bg-opacity-100 hover:text-white transition-all duration-200">Нажмите, чтобы загрузить трейлер для фильма</i>
                        </section>
                    </section>
                </div>
            </div>

        <AdminEdit :isPost="true" routeName="poster" :form="posterForm" :item="movie">
            <template v-slot:inputs>
                <div class="flex flex-col gap-6">
                    <div>
                        <InputLabel for="avatar" class="block w-full text-sm font-medium text-gray-700">Постер: </InputLabel>
                        <img    :src="props.movie.poster? $page.props.ziggy.url + '/storage/' + 
                                props.movie.poster : $page.props.ziggy.url + '/storage/images/posters/no-image.jpg'" 
                                width="200" class="rounded-md overflow-hedden" alt="avatar">
                        <input
                            id="poster"
                            name="poster"
                            type="file"
                            @input="posterForm.poster = $event.target.files[0]"
                            accept="image/*"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            capture
                        />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                        <InputError :message="form.errors.poster" class="mt-2" />
                    </div>
                </div>
            </template>
        </AdminEdit>
        <AdminEdit routeName="movies" :form="form" :item="movie">
            <template v-slot:inputs>
                <div class="input-wrapper flex flex-col gap-2">
                    <div>
                        <InputLabel for="title" class="block text-sm font-medium text-gray-700"><strong class="text-pink-500">* </strong>Название фильма: </InputLabel>
                        <TextInput v-model="form.title" required type="text" autocomplete="title"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <InputError :message="form.errors.title" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="duration" class="block text-sm font-medium text-gray-700"><strong class="text-pink-500">* </strong>Длительность: </InputLabel>
                        <TextInput v-model="form.duration" required type="text" autocomplete="title"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <InputError :message="form.errors.duration" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="date" class="block text-sm font-medium text-gray-700"><strong class="text-pink-500">* </strong>Дата выхода: </InputLabel>
                        <input v-model="form.release_date" required type="date" id="date" name="date"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <InputError :message="form.errors.release_date" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="production" class="block text-sm font-medium text-gray-700"><strong class="text-pink-500">* </strong>Производство: </InputLabel>
                        <TextInput v-model="form.production" required type="text" id="production"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <InputError :message="form.errors.production" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="restriction" class="block text-sm font-medium text-gray-700"><strong class="text-pink-500">* </strong>Возрастное ограничение: </InputLabel>
                        <TextInput v-model="form.restriction" required type="text" id="restriction"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <InputError :message="form.errors.restriction" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="description" class="block text-sm font-medium text-gray-700">Описание: </InputLabel>
                        <textarea rows="10" v-model="form.description" type="text" id="description"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="actors" class="block text-sm font-medium text-gray-700">Добавить актерский состав: </InputLabel>
                            <VueMultiselect v-model="form.actorValues" :options="actors" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Выберете актера" label="name" track-by="name" :preselect-first="false">
                                <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="form.actorValues.length &amp;&amp; !isOpen">{{ form.actorValues.length }} options selected</span></template>
                            </VueMultiselect>
                        <InputError :message="form.errors.actorValues" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="genres" class="block text-sm font-medium text-gray-700">Добавить жанр: </InputLabel>
                            <VueMultiselect v-model="form.genreValues" :options="genres" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Выберете жанр" label="title" track-by="title" :preselect-first="false">
                                <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="form.genreValues.length &amp;&amp; !isOpen">{{ form.genreValues.length }} options selected</span></template>
                            </VueMultiselect>
                        <InputError :message="form.errors.genreValues" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="countries" class="block text-sm font-medium text-gray-700">Добавить страну: </InputLabel>
                            <VueMultiselect v-model="form.countryValues" :options="countries" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Выберете страну" label="title" track-by="title" :preselect-first="false">
                                <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="form.countryValues.length &amp;&amp; !isOpen">{{ form.countryValues.length }} options selected</span></template>
                            </VueMultiselect>
                        <InputError :message="form.errors.countryValues" class="mt-2" />
                    </div>
                </div>
            </template>
        </AdminEdit>
    </AdminLayout>
    </div>
</template>

<style lang="scss" scoped>

</style>



