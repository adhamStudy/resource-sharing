<template>
    <div class="py-8 sm:py-12 px-4 sm:px-0">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="p-4 sm:p-6 bg-white border-b border-gray-200 text-right"
                >
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6"
                    >
                        <h1
                            class="text-xl sm:text-2xl font-semibold text-gray-900 mb-2 sm:mb-0"
                        >
                            شاركنا في المنتدى منشور - رأي - شكوى
                        </h1>
                        <Link
                            :href="route('posts.index')"
                            class="text-indigo-600 hover:text-indigo-900 text-sm sm:text-base"
                        >
                            الرجوع إلى المنتدى
                        </Link>
                    </div>

                    <form
                        @submit.prevent="submit"
                        class="space-y-4 sm:space-y-6"
                    >
                        <div>
                            <label
                                for="title"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                العنوان
                            </label>
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
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                المحتوى
                            </label>
                            <textarea
                                id="content"
                                v-model="form.content"
                                rows="5"
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
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                الصورة (اختياري)
                            </label>
                            <input
                                id="image"
                                type="file"
                                @input="form.image = $event.target.files[0]"
                                class="mt-1 block w-full text-sm sm:text-base text-gray-700"
                                accept="image/*"
                            />
                            <div
                                v-if="form.errors.image"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.image }}
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button
                                type="submit"
                                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white text-sm sm:text-base rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :disabled="form.processing"
                            >
                                {{
                                    form.processing
                                        ? "جاري الإنشاء..."
                                        : "إنشاء المنشور"
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

<style scoped>
/* يمكنك تعديل الاتجاه من هنا أيضًا */
[dir="rtl"] {
    direction: rtl;
}
</style>
