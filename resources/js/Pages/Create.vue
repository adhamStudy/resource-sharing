<template>
    <div class="create-resource-page">
        <h1 class="text-2xl font-bold mb-4">Create Resource</h1>
        <form @submit.prevent="create" enctype="multipart/form-data">
            <label for="">Title</label>
            <input
                v-model="form.title"
                type="text"
                class="border p-2 mb-4 w-full"
            />
            <div class="input-error text-red-500" v-if="form.errors.title">
                {{ form.errors.title }}
            </div>

            <label for="">Description</label>
            <input
                v-model="form.description"
                type="text"
                class="border p-2 mb-4 w-full"
            />
            <div
                class="input-error text-red-500"
                v-if="form.errors.description"
            >
                {{ form.errors.description }}
            </div>

            <label for="">Image</label>
            <input
                type="file"
                @input="form.image = $event.target.files[0]"
                class="border p-2 mb-4 w-full"
            />
            <div class="input-error text-red-500" v-if="form.errors.image">
                {{ form.errors.image }}
            </div>

            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
            >
                Create
            </button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    title: "",
    description: "",
    image: null,
});

const create = () => {
    form.post("/store", {
        forceFormData: true, // this is required for file uploads
    });
};
</script>

<style scoped>
.create-resource-page {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}
</style>
