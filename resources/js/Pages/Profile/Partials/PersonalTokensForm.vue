<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, inject, computed } from "vue";

const tokenNameInput = ref(null);
const accessToken = ref(null);

const tokens = inject("tokens");
const computedTokens = computed(() => tokens);

const createForm = useForm({
    token_name: "",
});

const createToken = () => {
    axios.post(route('tokens.store'), createForm)
    .then((res) => {
        createForm.reset()
        computedTokens.value.push(res.data.token.accessToken);
        accessToken.value = res.data.token.plainTextToken;

    })
    .catch(() => {
        if (createForm.errors.token_name) {
            createForm.reset("token_name");
            tokenNameInput.value.focus();
        }
    });
};

const deleteForm = useForm({});

const deleteToken = (id) => {
    deleteForm.delete('/tokens/' + id, {
        preserveScroll: true,
        onSuccess: () => {
            // delete from tokens the element that contains id equals to id
            const index = computedTokens.value.findIndex((token) => token.id === id);
            computedTokens.value.splice(index, 1);
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Personal Tokens
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Create bearer tokens for your application.
            </p>
        </header>

        <div v-if="accessToken !== null" class="my-3 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <p class="font-bold">Make sure to copy your token now as you will not be able to see it again.</p>
            <p class="block sm:inline">{{ accessToken }}</p>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="accessToken = null" class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>

        <form @submit.prevent="createToken" class="mt-6 space-y-6">
            <div>
                <InputLabel for="token_name" value="Token Name" />

                <TextInput
                    id="token_name"
                    ref="tokenNameInput"
                    v-model="createForm.token_name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="token-name"
                />

                <InputError
                    :message="createForm.errors.token_name"
                    class="mt-2"
                />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="createForm.processing"
                    >Create</PrimaryButton
                >

                <Transition
                    enter-from-class="opacity-0"
                    leave-to-class="opacity-0"
                    class="transition ease-in-out"
                >
                    <p
                        v-if="createForm.recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        Created.
                    </p>
                </Transition>
            </div>
        </form>

        <ul class="pt-4 pl-4 list-disc text-gray-200">
            <li class="pt-2" v-for="token in computedTokens" :key="token.id">
                <div class="flex">
                    <div class="flex-1">
                        <div class="font-medium">{{ token.name }}</div>
                    </div>

                    <div class="flex-none">
                        <DangerButton @click="deleteToken(token.id)">Delete</DangerButton>
                    </div>
                </div>
            </li>
        </ul>
    </section>
</template>
