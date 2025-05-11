<template>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Profile</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Update your account information and password.
                </p>
            </div>

            <!-- Flash Message -->

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form @submit.prevent="updateProfile" class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                                >Name</label
                            >
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{ 'border-red-500': form.errors.name }"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                                >Email</label
                            >
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{ 'border-red-500': form.errors.email }"
                            />
                            <div
                                v-if="form.errors.email"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label
                                for="phone"
                                class="block text-sm font-medium text-gray-700"
                                >Phone (optional)</label
                            >
                            <input
                                id="phone"
                                v-model="form.phone"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{ 'border-red-500': form.errors.phone }"
                            />
                            <div
                                v-if="form.errors.phone"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.phone }}
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 pt-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Update Password
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Leave blank to keep your current password.
                            </p>
                        </div>

                        <!-- Current Password -->
                        <div>
                            <label
                                for="current_password"
                                class="block text-sm font-medium text-gray-700"
                                >Current Password</label
                            >
                            <input
                                id="current_password"
                                v-model="form.current_password"
                                type="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500':
                                        form.errors.current_password,
                                }"
                            />
                            <div
                                v-if="form.errors.current_password"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.current_password }}
                            </div>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700"
                                >New Password</label
                            >
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500': form.errors.password,
                                }"
                            />
                            <div
                                v-if="form.errors.password"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label
                                for="password_confirmation"
                                class="block text-sm font-medium text-gray-700"
                                >Confirm Password</label
                            >
                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :disabled="form.processing"
                            >
                                {{
                                    form.processing
                                        ? "Saving..."
                                        : "Save Changes"
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
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone || "",
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updateProfile = () => {
    form.put(route("profile.update"), {
        preserveScroll: true,
        onSuccess: () => {
            form.current_password = "";
            form.password = "";
            form.password_confirmation = "";
        },
    });
};
</script>
