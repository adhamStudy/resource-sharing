<template>
    <div
        v-for="resource in resources"
        :key="resource.id"
        class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition"
    >
        <!-- Static Image -->

        <img
            v-if="!resource.image"
            src="/public/images/resource.png"
            alt="Resource"
            class="w-12 h-12 object-cover rounded-md mb-4"
        />
        <img
            v-else
            :src="resource.image"
            alt="Resource"
            class="w-20 h-20 object-cover rounded-md mb-4"
        />

        <div class="mb-4">
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold text-gray-900 mb-1">
                    {{ resource.title }}
                </h2>
                <Link :href="`/show/${resource.id}`">
                    <div
                        class="rounded-sm px-2 py-1 text-white bg-green-700 hover:bg-green-600"
                    >
                        Reserve
                        <span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 inline-block ml-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width=""
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M14.752 11.168l-4.197 2.1a.75.75 0 01-1.09-.659V9.39a.75.75 0 011.09-.659l4.197 2.1a.75.75 0 010 1.336z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </span></div
                ></Link>
            </div>
            <p class="text-gray-600 text-sm">
                {{ resource.description }}
            </p>
        </div>

        <div class="flex items-center justify-between mt-4">
            <span
                class="text-xs font-medium px-3 py-1 rounded-full"
                :class="
                    resource.is_available
                        ? 'bg-green-100 text-green-700'
                        : 'bg-red-100 text-red-700'
                "
            >
                {{ resource.is_available ? "Available" : "Unavailable" }}
            </span>
            <span class="text-xs text-gray-400"> #{{ resource.id }} </span>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    resources: {
        type: Array,
        required: true,
    },
});
</script>
