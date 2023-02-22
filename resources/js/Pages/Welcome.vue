<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    movies: Array,
    // laravelVersion: String,
    // phpVersion: String,
});

const user = usePage().props.value.auth.user;
const url = usePage().props.value.ziggy.url;
</script>

<template>
    <Head title="Welcome" />

    <AuthenticatedLayout>

        <div 
            class="hero mt-4 border-b-4 border-t-4 border-secondary h-[500px] overflow-hidden
                z-1 relative flex justify-center items-end" >
            <img class="absolute top-0 left-0 object-cover object-top z-0 w-full h-full" :src="url + '/storage/images/Hero.jpg'" alt="hero-image">
            <div class="background absolute bg-gradient-to-t from-primary w-full h-full"></div>
            <div class="title text-secondary text-4xl font-black z-10 mb-6 xl:text-7xl">Movie reviewer</div>
        </div>
        <main class="mx-2 py-6 max-w-[1000px] lg:mx-auto">
            <h1 class="site-desc text-secondary text-2xl font-bold m-6 text-center">
                Великолепный портал для просмотра, оценки и обсуждения фильмов.
            </h1>
            <h2 class="text-secondary opacity-80 text-xl font-bold mx-6 my-4 text-center">
                Оценивай и обсуждай фильмы в комментариях вместе с пользователями со всего мира.
            </h2>
            <div class="buttons m-6 flex flex-wrap gap-4 justify-center items-center">
                <div class="register-button w-[210px] text-primary text-lg font-bold p-4 rounded-md bg-blue-800
                    hover:bg-blue-500 hover:cursor-pointer text-center"
                    @click="Inertia.get('/movies')">
                    Начать просмотр
                </div>
                <div v-if="!$page.props.auth.user" class="register-button text-primary text-lg font-bold w-[210px] p-4 rounded-md bg-teal-800
                    hover:bg-teal-500 hover:cursor-pointer text-center"
                    @click="Inertia.get(route('register'))">
                    Зарегистрироваться
                </div>
            </div>
            <h2 v-if="!$page.props.auth.user" class="text-pink-500 opacity-60 text-md font-medium mx-6 my-4 text-center">
                Зарегистрируйтесь, чтобы получить болше возможностей приложения.
            </h2>

            <!-- <pre class="text-white">
                {{ movies }}
            </pre> -->
            <div class="desc text-secondary text-md font-bold text-center max-w-xl mx-auto my-6 opacity-80">
                Не знаете с чего начать? Попробуйте оценить самые высоко оцениваемые фильмы.
            </div>
            <div class="content p-4 rounded-md bg-primarylight flex flex-wrap gap-2 justify-around mx-6 mb-2">
                <div v-for="movie in movies" class="movie flex flex-col justify-between rounded-lg bg-primary overflow-hidden h-[400px] w-[200px]">
                    <img class="h-3/6 object-cover w-full"
                        :src="movie.poster? url + '/storage/' + movie.poster : url + '/storage/images/posters/no-image.jpg'" alt="">
                    <div class="info px-2 flex gap-2">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="ipc-icon ipc-icon--star-inline" id="iconContext-star-inline" viewBox="0 0 24 24" fill="yellow" role="presentation"><path d="M12 20.1l5.82 3.682c1.066.675 2.37-.322 2.09-1.584l-1.543-6.926 5.146-4.667c.94-.85.435-2.465-.799-2.567l-6.773-.602L13.29.89a1.38 1.38 0 0 0-2.581 0l-2.65 6.53-6.774.602C.052 8.126-.453 9.74.486 10.59l5.147 4.666-1.542 6.926c-.28 1.262 1.023 2.26 2.09 1.585L12 20.099z"></path></svg>
                        <p class="text-secondary font-bold text-xl">{{ movie.rating?.toFixed(1) }}</p>
                    </div>
                    <div class="movie-title text-white text-xl text-bold text-center">
                        {{ movie.title }}
                    </div>
                    <Link @click="Inertia.get('/movies/' + movie.id)"  
                        class="button mx-auto w-fit text-primary bg-blue-800 hover:bg-blue-500 hover:cursor-pointer py-2 px-3
                            rounded-md font-semibold mb-6">
                        Просмотр
                    </Link>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>

</template>

<style>

.hero {
}
</style>
