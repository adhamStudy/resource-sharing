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
            class="w-12 h-12 object-cover rounded-md mb-4"
        />

        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-1">
                {{ resource.title }}
            </h2>
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
const props = defineProps({
    resources: {
        type: Array,
        required: true,
    },
});
</script>
