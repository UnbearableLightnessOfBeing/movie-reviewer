<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-secondary">Удалить аккаунт</h2>

            <p class="mt-1 text-sm text-secondary">
                Когда Ваш аккаунт будет удалён, все ресурсы и данные будут безвозвартно удалены.
                Перед удалением аккаунта, пожалуйста, сохраните важные для Вас данные и информацию.
            </p>
        </header>

        <DangerButton class="bg-pink-800 hover:bg-pink-500" @click="confirmUserDeletion">Удалить аккаунт</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-secondary">
                    Вы уверены, что хотите удалить аккаунт?
                </h2>

                <p class="mt-1 text-sm text-secondary">
                    Когда Ваш аккаунт будет удалён, все ресурсы и данные будут безвозвартно удалены.
                    Перед удалением аккаунта, пожалуйста, сохраните важные для Вас данные и информацию.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only text-secondary" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4 text-white bg-primary"
                        placeholder="Пароль"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton class="bg-primary text-secondary border-primary hover:bg-black hover:text-white" 
                        @click="closeModal"> Отмена </SecondaryButton>

                    <DangerButton
                        class="ml-3 bg-pink-800 hover:bg-pink-500"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Удалить аккаунт
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
