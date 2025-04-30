<template>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            Create Post
                        </h1>
                        <Link
                            :href="route('posts.index')"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            Back to Posts
                        </Link>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label
                                for="title"
                                class="block text-sm font-medium text-gray-700"
                                >Title</label
                            >
                            <input
                                id="title"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{ 'border-red-500': form.errors.title }"
                            />
                            <div
                                v-if="form.errors.title"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.title }}
                            </div>
                        </div>

                        <div>
                            <label
                                for="content"
                                class="block text-sm font-medium text-gray-700"
                                >Content</label
                            >
                            <textarea
                                id="content"
                                v-model="form.content"
                                rows="6"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500': form.errors.content,
                                }"
                            ></textarea>
                            <div
                                v-if="form.errors.content"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.content }}
                            </div>
                        </div>

                        <div>
                            <label
                                for="image"
                                class="block text-sm font-medium text-gray-700"
                                >Image (Optional)</label
                            >
                            <input
                                id="image"
                                type="file"
                                @input="form.image = $event.target.files[0]"
                                class="mt-1 block w-full text-gray-700"
                                accept="image/*"
                            />
                            <div
                                v-if="form.errors.image"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.image }}
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :disabled="form.processing"
                            >
                                {{
                                    form.processing
                                        ? "Creating..."
                                        : "Create Post"
                                }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    title: "",
    content: "",
    image: null,
});

const submit = () => {
    form.post(route("posts.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
