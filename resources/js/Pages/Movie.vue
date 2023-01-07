<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Comment from '@/Components/Comment.vue';
import { Link, usePage, useForm } from '@inertiajs/inertia-vue3';

import { VueStars } from 'vue-stars';
// Vue.component("vue-stars", VueStars)

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    movie: Object,
    comments: Array || Object,
});

const user = usePage().props.value.auth.user;

const form = useForm({
    text: '',
    movieId: props.movie.id,
});

</script>

<template>
    <AuthenticatedLayout>
        <div class="movie-wrapper overflow-hidden">
            <pre>
                {{ movie }}
            </pre>

            <vue-stars
                name="demo"
                :active-color="'#ffdd00'"
                :inactive-color="'#999999'"
                :shadow-color="'#ffff00'"
                :hover-color="'#dddd00'"
                :max="10"
                :value="4"
                :readonly="false"
                char="★"
                inactive-char="☆"
                :class="''" 
            />

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