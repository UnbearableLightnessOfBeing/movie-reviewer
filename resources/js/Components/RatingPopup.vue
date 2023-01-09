<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { defineEmits, defineProps } from 'vue';

// import vue3starRatings from "vue3-star-ratings";

import { Link, usePage, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    movieId: Number,
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
    <div class="fixed top-0 left-0 w-screen h-screen bg-black bg-opacity-80 flex justify-center items-center"
            @click="emit('update:isBeingRated', false);">
        <div @click.stop="" class="rating-window border border-red-500 bg-zinc-800">
            <!-- <form @submit.prevent="form.post(route('ratings.store'), 
                { onSuccess: () => { form.reset(); emit('update:isBeingRated', false) }, preserveScroll: true }) "> -->
            <form @submit.prevent="doAction(method)">
                <star-rating v-model="form.rating" class="p-4 m-4" :max-rating="10" text-class="text-4xl text-red-500" 
                            :star-size="35" @update:rating ="setRating" ></star-rating>
                <!-- <vue3-star-ratings v-model="form.rating" /> -->
                <InputError :message="form.errors.rating" class="mt-2" />

                <h1 class="text-white">
                    Rating method:  {{ method }}
                </h1>
                <h1 class="text-white">
                    {{ form.rating }}
                </h1>
                <h1 class="text-white">
                    movieid: {{ form.movieId }}
                </h1>
                <PrimaryButton :disabled="+form.rating === 0? true : false" class="mt-4 disabled:opacity-60">Оценить</PrimaryButton>
            </form>
        </div>
    </div>
</template>

<style lang="scss" scoped>

</style>