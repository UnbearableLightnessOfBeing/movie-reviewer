<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(
    [   
        'movieId',
        'isFavorite',
    ]);


const form = useForm({
    movieId: props.movieId,
});

const user = usePage().props.value.auth.user;

const formParams = {
    onSuccess: () => { form.reset() }, 
    preserveScroll: true 
};

function doAction(isFavorite) {
    if(!isFavorite) {
       form.post(route('user.storeInFavorite'), formParams); 
    }
    else {
       form.put(route('user.deleteFromFavorite', user.id), formParams); 
    }
}

// let buttonContent = ;

</script>

<template>
    <div>
        <form @submit.prevent="doAction(isFavorite)">
            <PrimaryButton class="mt-4 disabled:opacity-60"> {{ !isFavorite? 'Добавить в избранное' : 'Удалить из избранного' }} </PrimaryButton>
        </form>
    </div>
</template>

<style lang="scss" scoped>

</style>