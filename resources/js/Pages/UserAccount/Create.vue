<template>
    <form @submit.prevent="register">
        <div class="w-2/5 mt-0 mx-auto">
            <div>
                <label for="name" class="label">Your Name</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="input"
                />
                <div v-if="form.errors.name" class="input-error">
                    {{ form.errors.name }}
                </div>
            </div>
            <div class="mt-2">
                <label for="email" class="label">E-mail</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="input"
                />
                <div v-if="form.errors.email" class="input-error">
                    {{ form.errors.email }}
                </div>
            </div>
            <!-- phone number -->
            <div class="mt-4">
                <label for="email" class="label">Phone</label>
                <input
                    id="phone"
                    v-model="form.phone"
                    type="tel"
                    class="input"
                />
                <div v-if="form.errors.phone" class="input-error">
                    {{ form.errors.phone }}
                </div>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="input"
                />
                <div v-if="form.errors.password" class="input-error">
                    {{ form.errors.password }}
                </div>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="label"
                    >Confirm Password</label
                >
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="input"
                />
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">
                    Create Account
                </button>
                <div class="mt-4">
                    already hava an account ?
                    <span>
                        <Link
                            href="/login"
                            as="button"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-500 font-medium"
                        >
                            Sign-in
                        </Link>
                    </span>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";

const form = useForm({
    name: null,
    email: null,
    phone: null,
    password: null,
    password_confirmation: null,
});
const register = () => form.post("/user-account");
</script>
