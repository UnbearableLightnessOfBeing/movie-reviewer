<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Comment from '@/Components/Comment.vue';
import FavoriteIndicator from '@/Components/FavoriteIndicator.vue';
import RatingPopup from '@/Components/RatingPopup.vue';
import { Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
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
let isPosterSeen = ref(true);


</script>

<template>
    <AuthenticatedLayout>
        <div class="movie-wrapper overflow-hidden">

            <div class="movie-container text-white flex flex-col gap-6 pb-6 border-b 
                border-primarylight sm:mx-4 lg:flex-row lg:flex-wrap lg:justify-between
                max-w-6xl lg:mx-auto">
                <div class="title-container px-4 pt-6 lg:order-1 lg:w-2/5">
                    <div class=" text-3xl font-semibold">
                        {{ movie.title }}
                    </div>
                    <div class="movie-info text-gray-500 text-sm font-black">
                        {{ dayjs(movie.releaseDate).locale(ru).format('YYYY') }} - {{ movie.production }} - {{ movie.duration }} min
                    </div>
                </div>
                <div class="trailer-container relative w-full sm:w-auto flex sm:gap-1 sm:mx-4 lg:order-3 lg:w-full">
                    <div :class="{'-z-10 sm:z-10': !isPosterSeen}" class="z-20 sm:w-1/4 poster absolute sm:static bottom-0 left-4 z-10 
                        w-[25%] sm:w-auto h-[60%] sm:h-auto  border border-secondary sm:border-transparent">
                        <img class="w-full h-full object-cover" :src="getPoster(movie)" alt="poster">
                    </div>
                    <div class="video z-0 w-full w-auto sm:w-3/4 h-auto">
                        <video-player
                            class="object-cover  vjs-big-play-centered"
                            :src="$page.props.ziggy.url + '/storage/' + movie.trailer"
                            :poster="$page.props.ziggy.url + '/storage/' + movie.trailerPoster"
                            controls
                            :aspectRatio="'16:9'"
                            :loop="true"
                            :volume="0.6"
                            @mounted=""
                            @ready=""
                            @play="isPosterSeen = false"
                            @pause=""
                            @ended=""
                            @seeking=""
                        />
                    </div>
                </div>
                <div class="movie-info flex flex-col gap-4 lg:order-4 lg:w-1/2">
                    <div class="genres px-4 flex gap-4 ">
                        <div v-for="genre in movie.genres" class="genre px-2 py-1 border border-white border-opacity-40
                                    bg-black bg-opacity-30 hover:border-opacity-100 rounded-full flex-wrap">
                            {{ genre }}
                        </div>
                    </div>
                    <div class="desc px-4 font-semibold text-lg">
                        <div v-if="movie.description && movie.description.length > 200 && !isDescriptionFull">
                            {{ movie.description.slice(0, 200) }}...  
                            <span class="inline text-secondary text-sm text-opacity-60 
                                hover:cursor-pointer hover:text-opacity-100" 
                            @click="isDescriptionFull = true"> Показать все</span>
                        </div>
                        <div v-else>
                            {{ movie.description }}
                            <span v-if="movie.description && movie.description.length > 200" class="block text-secondary text-sm text-opacity-60 
                                hover:cursor-pointer hover:text-opacity-100" @click="isDescriptionFull = false"> Свернуть</span>
                        </div>
                    </div>
                    <div class="restriction px-4 text-secondary font-black text-lg">
                        Возрастное ограничение: <span class="text-white font-medium text-base">{{ movie.restriction }}</span>
                    </div>
                    <div class="restriction px-4 text-secondary font-black text-lg">
                        Страны: <span class="text-white font-medium text-base">{{ movie.countries.join(', ') }}</span>
                    </div>
                    <div class="restriction px-4 text-secondary font-black text-lg">
                        Актёры: <span class="text-white font-medium text-base">{{ movie.actors.join(', ') }}</span>
                    </div>
                </div>
                <div class="ratings flex gap-4 px-4 sm:justify-center lg:order-2 lg:w-2/5 lg:items-center">
                    <div class="avg flex lg:flex-wrap items-center lg:justify-center lg:h-fit gap-2">
                        <div class="hidden lg:block lg:w-full font-bold text-secondary text-center text-lg">Рейтинг</div>
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="ipc-icon ipc-icon--star-inline" id="iconContext-star-inline" viewBox="0 0 24 24" fill="yellow" role="presentation"><path d="M12 20.1l5.82 3.682c1.066.675 2.37-.322 2.09-1.584l-1.543-6.926 5.146-4.667c.94-.85.435-2.465-.799-2.567l-6.773-.602L13.29.89a1.38 1.38 0 0 0-2.581 0l-2.65 6.53-6.774.602C.052 8.126-.453 9.74.486 10.59l5.147 4.666-1.542 6.926c-.28 1.262 1.023 2.26 2.09 1.585L12 20.099z"></path></svg>
                        <p class="text-sm text-gray-400"><span class="font-black text-white text-lg">{{ movie.rating? movie.rating : 0 }}</span>/10 - {{ movie.ratingCount }} оценок</p>
                    </div>
                    <!-- <div v-if="!movie.userRating" @click="isBeingRated = true;" 
                                class="your-estim flex itmes-end lg:items-center justify-end gap-2 p-2 rounded-md hover:bg-black border
                                border-transparent hover:border-secondary transition-all duration-200 hover:cursor-pointer
                                lg:flex-wrap justify-center">
                        <div class="hidden lg:block lg:w-full font-bold text-secondary text-center text-lg">Ваша оценка</div>
                        <p class="text-sm order-2 self-end  text-gray-400">Оцените</p>
                        <svg witdh="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="blue" d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                    </div> -->
                    <div v-if="movie.userRating" class="your-estim flex itmes-end lg:items-center justify-end gap-2 p-2 rounded-md 
                        hover:bg-black border border-transparent hover:border-secondary transition-all duration-200
                        lg:flex-wrap lg:justify-center">
                        <div class="hidden lg:block lg:w-full font-bold text-secondary text-center text-lg">Ваша оценка</div>
                        <p class="text-sm order-2 self-end  text-gray-400">
                            <span v-if="movie.userRating" class="font-black text-white text-lg">{{ movie.userRating.rating }}</span>
                            <p class="inline lg:hidden">
                                Ваша оценка 
                            </p>
                        </p>
                        <svg witdh="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path :fill="!isFavorite? 'blue' : 'yellow'" d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                    </div>
                </div>

                <div class="movie-completion flex flex-col gap-4 lg:order-6 lg:w-[430px]">
                    <div class="add-to-favorite px-4 sm:mx-auto">
                        <div v-if="user" class="add rounded-lg bg-primarylight border border-transparent
                                    hover:cursor-pointer hover:border-secondary p-2 flex 
                                    justify-center gap-2 transition-all duration-200 hover:bg-black
                                    w-fit">
                            <svg v-if="!isFavorite" class="self-center" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="white" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                            <svg v-else fill="yellow" class="self-center" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"/></svg>
                
                            <div class="h-fit">
                                <Link @click="Inertia.post('/user', { movieId: movie.id }, { preserveScroll: true })" v-if="!isFavorite" 
                                    class="text-white font-bold h-fit">
                                    Добавить в избранное
                                </Link>
                                <div v-else class="text-white font-bold">
                                    У Вас в избранном
                                </div>
                                <div class="text-sm opacity-60">
                                    у {{ movie.favoriteCount }} пользователей в избранном
                                </div>
                            </div>
                        </div>
                        <div v-else class="comment-count text-secondary px-4 flex flex gap-2 justify-center items-center lg:order-7">
                            <div class="text-lg font-black self-center">
                                {{ movie.favoriteCount }}
                            </div>
                            <div class="text-sm">добавили в избранное</div>
                        </div>
                    </div>
                    <div class="comment-count text-secondary px-4 flex flex gap-2 items-center justify-center lg:order-7">
                        <div class="text-lg font-black self-center">
                            {{ movie.commentCount }}
                        </div>
                        <div class="text-sm">прокомментировали</div>
                    </div>


                    <div class="movie-rating flex justify-around gap-2 px-4 lg:order-8">
                        <div class="rating-wrapper">
                            <div v-if="!$page.props.auth.user" @click="Inertia.get('/register')"
                                class="authenticated  hover:cursor-pointer hover:bg-teal-500 hover:bg-opacity-10 border-transparnt 
                                        bg-primarylight px-3 py-2 rounded-md w-fit border border-transparent hover:border-secondary
                                        transiton-all duration-200 hover:text-teal-400 text-secondary text-center"
                            >Зарегистрируйтесь, чтобы оценить фильм</div>
                            <div v-else class="authenticated  hover:cursor-pointer hover:bg-black border-transparnt bg-primarylight 
                                        px-3 py-2 rounded-md w-fit border border-transparent hover:border-blue-500">
                                <div v-if="movie.userRating" class="rated  flex gap-2 items-end">
                                    <div class="text-sm tracking-widest text-center text-blue-500 font-bold "
                                        @click="isBeingRated = true; ratingMethod = 'update';">Изменить оценку</div>
                                </div>
                                <div v-else  class="text-sm tracking-widest text-center text-blue-500 font-bold "
                                    @click="isBeingRated = true">Оценить</div>
                                <RatingPopup v-if="isBeingRated" :ratingId="+movie.userRating?.id" :method="ratingMethod" :movieId="movie.id" @update:isBeingRated="updateState" />
                                <!-- <star-rating class="p-4" :border-width="6" :rounded-corners="true" :star-size="70" :glow="10" glow-color="#ffd055"></star-rating> -->
                            </div>
                        </div>
                        <div v-if="$page.props.auth.user && isFavorite !== null" class="text-medium favorite-wrapper border border-transparent 
                                rounded-md h-fit" :class="isFavorite? 'hover:border-pink-400' : 'hover:border-teal-400'">
                            <FavoriteIndicator :isFavorite="isFavorite" :movieId="movie.id" />
                        </div>
                    </div>
                </div>

            </div>

            <!-- <img class="mt-20" :src="getPoster(movie)" alt="poster">
            <pre class="text-white">
                {{ movie }}
            </pre>
            favorite: {{ isFavorite }} -->

            

        </div>


        <div class="comment-section pb-10 sm:mx-4 max-w-6xl lg:mx-auto">
            <div class="comments-wrapper text-center py-4 m-2 border-b border-primarylight">
                <div class="comments" v-if="user">
                    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                        <form class="flex flex-col"
                            @submit.prevent="form.post(route('comments.store'), { onSuccess: () => form.reset(), preserveScroll: true })">
                            <textarea
                                v-model="form.text"
                                placeholder="Оставте комментарий"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 
                                        focus:ring-opacity-50 rounded-md shadow-sm bg-primarylight text-white placeholder:text-gray-400"
                            ></textarea>
                            <InputError :message="form.errors.text" class="mt-2 self-start" />
                            <PrimaryButton class="mt-4 w-fit self-end">Опубликовать</PrimaryButton>
                        </form>
            
                    </div>
                </div>
                <div v-else @click="Inertia.get('/register')"
                    class="hover:cursor-pointer hover:bg-teal-500 hover:bg-opacity-10 border-transparnt 
                            bg-primarylight px-3 py-2 rounded-md w-fit border border-transparent hover:border-secondary
                            transiton-all duration-200 hover:text-teal-400 text-secondary mx-auto"
                >Зарегистрируйтесь или войдите в аккаунт, чтобы оставить комментарий</div>
            </div>
            <div class="comments">
                <div class="title text-secondary text-2xl font-bold text-center">Комментарии</div>
                <div v-if="Object.keys(props.comments).length" class="mt-6 mx-4 bg-primarylight shadow-sm rounded-lg divide-y-4 divide-primary">
                    <Comment
                        v-for="comment in comments"
                        :key="comment.id"
                        :comment="comment"
                        :movieId="movie.id"
                    />
                </div>
                <div v-else class="text-lg text-secondary font-semibold text-center">Комментариев пока нет</div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style lang="scss" scoped>

</style>