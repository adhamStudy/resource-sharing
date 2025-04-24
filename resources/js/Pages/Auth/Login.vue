<template>
    <form @submit.prevent="login">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="email" class="label">E-mail</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="input"
                />
                <div class="input-error" v-if="form.errors.email">
                    {{ form.errors.email }}
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
                <div class="input-error" v-if="form.errors.password">
                    {{ form.errors.password }}
                </div>
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">Login</button>
                <div class="mt-4">
                    dont have an account ?
                    <span>
                        <Link
                            href="/user-account/create"
                            as="button"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-500 font-medium"
                        >
                            Register
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
    email: "",
    password: "",
});

const login = () => form.post("/login");
</script>
