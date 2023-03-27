<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, inject, computed } from "vue";

const tokenNameInput = ref(null);

const tokens = inject("tokens");

const computedTokens = computed(() => tokens);

const createForm = useForm({
    token_name: "",
});

const createToken = () => {
    createForm.post(route("tokens.store"), {
        preserveScroll: true,
        onSuccess: (res) => {
            createForm.reset()
            computedTokens.value.push(res.props.token.accessToken);
            alert(res.props.token.plainTextToken);
        },
        onError: () => {
            if (createForm.errors.token_name) {
                createForm.reset("token_name");
                tokenNameInput.value.focus();
            }
        },
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
