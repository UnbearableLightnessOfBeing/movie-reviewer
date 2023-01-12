<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdminInterractor from '@/Components/AdminInterractor.vue';
import PopupWatched from '@/Components/PopupWatched.vue';
import { defineProps, ref } from 'vue';
import dayjs from 'dayjs';
import ru from 'dayjs/locale/ru';

import { getAvatarSource } from '@/Utils/utils'; 

dayjs.locale(ru);

let watchedMovie = ref(1);
let isMovieWatched = ref(false);

function updateWatchedMovie(value) {
    watchedMovie.value = value;
    isMovieWatched.value = true;
}

const props = defineProps(['movies', 'movieRatings', 'filters', 'notifs']);

</script>
<template>
    <AdminLayout >
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Фильмы
            </h1>
            <PopupWatched v-if="isMovieWatched" @closeWindow="isMovieWatched = false" :item = "movies.data.find(movie => +movie.id === +watchedMovie)">
                <template v-slot:modelProps="slotProps" >
                    <div>
                        <strong class="text-xl">Постер</strong>
                        <img    :src="slotProps.item.poster? $page.props.ziggy.url + '/storage/' + 
                                slotProps.item.poster : $page.props.ziggy.url + '/storage/images/posters/no-image.jpg'" 
                                width="200" class="rounded-md overflow-hedden" alt="poster">
                    </div>
                    <div>
                        <strong class="text-xl">Название</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.title }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Длительность</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.duration }}мин</p>
                    </div>
                    <div>
                        <strong class="text-xl">Дата выхода</strong>
                        <p class="text-md text-gray-300">{{ dayjs( slotProps.item.release_date).locale(ru).format('d/MMM/YYYY') }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Производство</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.production }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Ограничение</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.restriction }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Жанр</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.genres.map(genre => genre.title).join(', ') }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Страны</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.countries.map(country => country.title).join(', ') }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Актерский состав</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.actors.map(actor => actor.name).join(', ') }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Трейлер</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.trailer? 'Присутствует' : 'Отсутствует' }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Постер к трейлеру</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.posterTrailer? 'Присутствует' : 'Отсутствует' }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Описание</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.description }}</p>
                    </div>
                </template>
            </PopupWatched>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <AdminInterractor @update:watched-item="updateWatchedMovie" :items="movies" :filters="filters" 
                                :notifs="notifs" :watchable="true" routeName='movies' :creatable="true" :deletable="true" >
                    <template v-slot:table-headings>
                        <th class="px-4 py-3">Название</th>
                        <th class="px-4 py-3">Рейтинг</th>
                        <th class="px-4 py-3">Оценок</th>
                        <th class="px-4 py-3">Постер</th>
                        <th class="px-4 py-3">Даата выхода</th>
                    </template>
                    <template v-slot:table="tableProps" >
                        <td class="px-4 py-3 border">
                            {{ tableProps.item.title }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ movieRatings.find(rating => +rating.movieId === +tableProps.item.id).avg }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ movieRatings.find(rating => +rating.movieId === +tableProps.item.id).count }}
                        </td>
                        <td class="py-1 border max-w-[100px]">
                            <img    :src="tableProps.item.avatar? $page.props.ziggy.url + '/storage/' + 
                                    tableProps.item.poster : $page.props.ziggy.url + '/storage/images/posters/no-image.jpg'" 
                                    width="100" class="mx-auto rounded-md overflow-hedden" alt="poster">
                        </td>
                        <td class="px-4 py-3 border">
                            {{ dayjs(tableProps.item.release_date).locale(ru).format('d/MMM/YYYY') }}
                        </td>
                    </template>
                </AdminInterractor>
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="scss" scoped>

</style>


