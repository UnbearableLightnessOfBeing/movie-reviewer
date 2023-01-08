<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Comment from '@/Components/Comment.vue';
import FavoriteIndicator from '@/Components/FavoriteIndicator.vue';
import RatingPopup from '@/Components/RatingPopup.vue';
import { Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import { ref, watch } from 'vue';



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


</script>

<template>
    <AuthenticatedLayout>
        <div class="movie-wrapper overflow-hidden">
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