<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div
                            class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-4 hidden"
                            role="alert"
                        >
                            <div class="flex">
                                <div class="flex-1">
                                    <p class="text-sm">
                                        Your token has been created
                                        successfully:
                                    </p>
                                </div>

                                <div class="flex-none">
                                    <button class="text-black">X</button>
                                </div>
                            </div>
                        </div>

                        <h2 class="mb-2 text-lg">Personal Tokens</h2>
                        <form @submit.prevent="createToken" action="/tokens" method="POST">
                            <div class="flex">
                                <div class="flex-1">
                                    <input
                                        type="text"
                                        name="token-name"
                                        placeholder="Token Name"
                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                                    />
                                </div>

                                <div class="flex-none">
                                    <button
                                        type="submit"
                                        class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                                    >
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>

                        <ul class="pt-4 pl-4 list-disc">
                            <li class="pt-2">
                                <div class="flex">
                                    <div class="flex-1">
                                        <div class="font-medium">
                                            Token Name
                                        </div>
                                    </div>

                                    <div class="flex-none">
                                        <button class="text-red-500">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
