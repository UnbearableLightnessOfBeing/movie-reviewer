<script setup>
import VueMultiselect from 'vue-multiselect';
import { ref, watch } from 'vue';



</script>

<template>
    <label class="text-secondary">Сортировка по жанру</label>
    <VueMultiselect v-model="searchGenre"
                    :options="genres.map(genre => genre.title)" 
                    :option-height="46"
                    :searchable="false" 
                    :close-on-select="true" 
                    :show-labels="false" 
                    placeholder="Выберете жанр"
                    class="w-full"
                    >

        <template v-slot:singleLabel="props">
                <span class="bg-primary text-white ">{{ props.option }}</span>
        </template>

        <template v-slot:option="props">
            <div class="group dropdown-option h-[46px] w-full flex items-center justify-center text-center bg-primary border 
                    border-transparent hover:outline-none hover:bg-primarylight">
                <span class="text-secondary group-hover:text-white">{{ props.option }}</span>
            </div>
        </template>
    </VueMultiselect>
</template>

<style lang="scss" scoped>

</style>