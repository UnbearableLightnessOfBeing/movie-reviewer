<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { defineEmits, defineProps } from 'vue';

// import vue3starRatings from "vue3-star-ratings";

import { Link, usePage, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    movieId: Number,
    movieTitle: String,
    method: String,
    ratingId: Number,
});

const form = useForm({
    rating: 0,
    movieId: props.movieId,
});

function setRating(rating) {
    form.rating = +rating;
}

const formParams = {
    onSuccess: () => { form.reset(); emit('update:isBeingRated', false) }, 
    preserveScroll: true 
};

function doAction(method) {
    if(method == 'store') {
       form.post(route('ratings.store'), formParams); 
    }
    else {
       form.put(route('ratings.update', props.ratingId), formParams); 
    }
}

const emit = defineEmits(['update:isBeingRated']);


const desc = [{
          text: 'Poor',
          class: 'star-poor'
        },
        {
          text: 'Below Average',
          class: 'star-belowAverage'
        },
        {
          text: 'Average',
          class: 'star-average'
        },
        {
          text: 'Good',
          class: 'star-good'
        },
        {
          text: 'Excellent',
          class: 'star-excellent'
        }];

</script>

<template>
    <div class="fixed z-[100] top-0 left-0 w-screen h-screen bg-black bg-opacity-80 flex justify-center items-center"
            @click="emit('update:isBeingRated', false);">
            <div class="wrapper">
                <div @click.stop="" class="rating-window relative  rounded-xl bg-transparent">
                    <div class="top-elements flex justify-between px-2 py-2">
                        <div class="ex  flex justify-senter items-center p-4 rounded-full bg-transparent">
                            <svg width="24" height="24" fill="transparent" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg>
                        </div>
                        <div class="star relative flex justify-center items-center">
                            <svg fill="dodgerblue" class="absolute transition-all" :height="55 + form.rating * 10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
                            <div class="number absolute mt-3 text-white text-4xl font-bold transition-all" 
                                :style="'font-size: calc(25px + '+form.rating*4+'px);'">{{ form.rating }}</div>
                        </div>
                        <div @click="emit('update:isBeingRated', false);" 
                            class="ex group flex justify-senter items-center h-fit p-4 rounded-full 
                                hover:bg-gray-500 hover:cursor-pointer
                                transition-all duration-200 hover:bg-opacity-30">
                            <svg width="24" height="24" fill="white" class="opacity-50 group-hover:opacity-100 transition-all duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg>
                        </div>
                    </div>
                    <form @submit.prevent="doAction(method)" class="z-10">
                        <star-rating v-model="form.rating" class="px-8 z-10 pb-8 pt-10 mx-4" :max-rating="10" text-class="hidden" 
                                    :star-size="35" @update:rating ="setRating" ></star-rating>
                        <InputError :message="form.errors.rating" class="mt-2" />

                        <h1 class="text-secondary mx-auto w-fit text-2xl font-bold">
                            {{ movieTitle }}
                        </h1>
                        <div class="background absolute left-0 bottom-0 bg-primarylight rounded-xl w-full h-5/6 z-[-1]"></div>
                        <div class="button w-fit mx-auto mt-3" >
                            <PrimaryButton :disabled="+form.rating === 0? true : false" class="my-6 border border-secondary disabled:opacity-60">Оценить</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</template>

<style lang="scss" scoped>

</style>