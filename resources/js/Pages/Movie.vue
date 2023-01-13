<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Comment from '@/Components/Comment.vue';
import FavoriteIndicator from '@/Components/FavoriteIndicator.vue';
import RatingPopup from '@/Components/RatingPopup.vue';
import { Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import { ref, watch } from 'vue';

import { getPoster } from '@/Utils/utils';

import dayjs from 'dayjs';
import ru from 'dayjs/locale/ru';

dayjs.locale(ru);




const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    movie: Object,
    comments: Array || Object,
    isFavorite: Boolean || null,
});

const user = usePage().props.value.auth.user;

const form = useForm({
    text: '',
    movieId: props.movie.id,
});

let isBeingRated = ref(false);
let ratingMethod = ref('store');

function updateState(state) {
    isBeingRated.value = state;
}

let isDescriptionFull = ref(false);


</script>

<template>
    <AuthenticatedLayout>
        <div class="movie-wrapper overflow-hidden">

            <div class="movie-container text-white flex flex-col gap-6">
                <div class="title-container px-4 pt-6">
                    <div class=" text-3xl font-semibold">
                        {{ movie.title }}
                    </div>
                    <div class="movie-info text-gray-500 text-sm font-black">
                        {{ dayjs(movie.releaseDate).locale(ru).format('YYYY') }} - {{ movie.production }} - {{ movie.duration }} min
                    </div>
                </div>
                <div class="trailer-container relative w-full flex h-[250px]">
                    <div class="poster absolute bottom-0 left-4 z-10 w-[30%] h-[60%]  border border-secondary">
                        <img class="w-full h-full object-cover" :src="getPoster(movie)" alt="poster">
                    </div>
                    <video-player
                        class="w-full h-full"
                        :src="$page.props.ziggy.url + '/storage/' + movie.trailer"
                        :poster="$page.props.ziggy.url + '/storage/' + movie.trailerPoster"
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
                </div>
                <div class="genres px-4 flex gap-4">
                    <div v-for="genre in movie.genres" class="genre px-2 py-1 border border-white border-opacity-40
                                bg-black bg-opacity-30 hover:border-opacity-100 rounded-full flex-wrap">
                        {{ genre }}
                    </div>
                </div>
                <div class="desc px-4 font-semibold text-lg">
                    <div v-if="movie.description.length > 200 && !isDescriptionFull">
                        {{ movie.description.slice(0, 200) }}...  <span class="inline text-secondary" @click="isDescriptionFull = true"> Показать все</span>
                    </div>
                    <div v-else>
                        {{ movie.description }}
                        <span class="block text-secondary" @click="isDescriptionFull = false"> Свернуть</span>
                    </div>
                </div>
                <div class="ratings flex gap-4 px-4">
                    <div class="avg flex items-center gap-2">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="ipc-icon ipc-icon--star-inline" id="iconContext-star-inline" viewBox="0 0 24 24" fill="yellow" role="presentation"><path d="M12 20.1l5.82 3.682c1.066.675 2.37-.322 2.09-1.584l-1.543-6.926 5.146-4.667c.94-.85.435-2.465-.799-2.567l-6.773-.602L13.29.89a1.38 1.38 0 0 0-2.581 0l-2.65 6.53-6.774.602C.052 8.126-.453 9.74.486 10.59l5.147 4.666-1.542 6.926c-.28 1.262 1.023 2.26 2.09 1.585L12 20.099z"></path></svg>
                        <p class="text-sm text-gray-400"><span class="font-black text-white text-lg">{{ movie.rating }}</span>/10 - {{ movie.ratingCount }} оценок</p>
                    </div>
                    <div class="your-estim h-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="ipc-icon ipc-icon--star-border sc-ab12c7bd-4 bgmEkI" id="iconContext-star-border" viewBox="0 0 24 24" fill="currentColor" role="presentation"><path fill="none" d="M0 0h24v24H0V0z"></path><path d="M19.65 9.04l-4.84-.42-1.89-4.45c-.34-.81-1.5-.81-1.84 0L9.19 8.63l-4.83.41c-.88.07-1.24 1.17-.57 1.75l3.67 3.18-1.1 4.72c-.2.86.73 1.54 1.49 1.08l4.15-2.5 4.15 2.51c.76.46 1.69-.22 1.49-1.08l-1.1-4.73 3.67-3.18c.67-.58.32-1.68-.56-1.75zM12 15.4l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.1l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.4z"></path></svg>
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="ipc-icon ipc-icon--star-border" id="iconContext-star-border" viewBox="0 0 24 24" fill="none" role="presentation"><path fill="none" d="M0 0h24v24H0V0z"></path><path fill="blue" d="M19.65 9.04l-4.84-.42-1.89-4.45c-.34-.81-1.5-.81-1.84 0L9.19 8.63l-4.83.41c-.88.07-1.24 1.17-.57 1.75l3.67 3.18-1.1 4.72c-.2.86.73 1.54 1.49 1.08l4.15-2.5 4.15 2.51c.76.46 1.69-.22 1.49-1.08l-1.1-4.73 3.67-3.18c.67-.58.32-1.68-.56-1.75zM12 15.4l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.1l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.4z"></path></svg>
                        
                    </div>
                </div>
            </div>

            <img class="mt-20" :src="getPoster(movie)" alt="poster">
            <pre>
                {{ movie }}
            </pre>
            favorite: {{ isFavorite }}

            
            <div class="movie-rating m-3">
                <div class="rating-wrapper">
                    <div v-if="!$page.props.auth.user" class="border border-pink-500 w-fit text-xl text-red-800 p-2 hover:cursor-pointer"
                    >Авторизуйтесь, чтобы оценить фильм</div>
                    <div v-else class="authenticated">
                        <div v-if="movie.userRating" class="rated flex gap-6 items-end">
                            <div>
                                Ваша оценка: {{ movie.userRating.rating }}
                            </div>
                            <div class="text-sm text-green-600 hover:underline hover:cursor-pointer"
                                @click="isBeingRated = true; ratingMethod = 'update';">Изменить оценку</div>
                        </div>
                        <div v-else  class="border border-pink-500 w-fit text-xl text-red-800 p-2 hover:cursor-pointer"
                            @click="isBeingRated = true">Оценить фильм</div>
                        <RatingPopup v-if="isBeingRated" :ratingId="+movie.userRating?.id" :method="ratingMethod" :movieId="movie.id" @update:isBeingRated="updateState" />
                        <!-- <star-rating class="p-4" :border-width="6" :rounded-corners="true" :star-size="70" :glow="10" glow-color="#ffd055"></star-rating> -->
                    </div>
                </div>
                <div v-if="$page.props.auth.user && isFavorite !== null" class="favorite-wrapper">
                    <FavoriteIndicator :isFavorite="isFavorite" :movieId="movie.id" />
                </div>
            </div>

        </div>

        <div v-if="Object.keys(props.comments).length" class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <Comment
                v-for="comment in comments"
                :key="comment.id"
                :comment="comment"
                :movieId="movie.id"
            />
        </div>
        <div v-else>No comments yet</div>

        <div class="comments-wrapper text-center py-4 m-2 outline-red-300 outline ">
            <div class="comments" v-if="user">
                COMMENTS
                <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                    <form @submit.prevent="form.post(route('comments.store'), { onSuccess: () => form.reset(), preserveScroll: true })">
                        <textarea
                            v-model="form.text"
                            placeholder="Оставте комментарий"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        ></textarea>

                        <InputError :message="form.errors.text" class="mt-2" />
                        <PrimaryButton class="mt-4">Опубликовать</PrimaryButton>
                    </form>
            
                </div>
            </div>
            <div v-else class="text-2xl font-bold text-pink-500">
                YOU ARE NOT AUTHENTICATED
            </div>
        </div>



    </AuthenticatedLayout>
</template>

<style lang="scss" scoped>

</style>