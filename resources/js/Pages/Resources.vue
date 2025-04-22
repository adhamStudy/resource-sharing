<template>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Neighborhood Resources
            </h1>

            <!-- ✅ Replaced <a> with Inertia <Link> -->
            <Link
                href="/create"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
                Create
            </Link>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <ResourceCard :resources="resources" />
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import ResourceCard from "../Components/Resources/ResourceCard.vue";

export default {
    components: {
        Link,
        ResourceCard,
    },
    props: {
        resources: Array,
    },
};
</script>
