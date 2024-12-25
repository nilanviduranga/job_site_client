<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5 mb-4">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                            class="img-fluid" alt="Sample image" />
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form @submit.prevent="submit">
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example3">Email address</label>
                                <input type="email" id="form3Example3" class="form-control form-control-lg"
                                    placeholder="Enter a valid email address" v-model="form.email" autofocus required />
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <label class="form-label" for="form3Example4">Password</label>
                                <input type="password" id="form3Example4" class="form-control form-control-lg"
                                    placeholder="Enter password" v-model="form.password" required />
                                <InputError :message="form.errors.password" class="mt-2" />
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <!-- Checkbox -->
                                <div class="form-check">
                                    <input class="form-check-input me-2" type="checkbox" id="form2Example3"
                                        v-model="form.remember" />
                                    <label class="form-check-label" for="form2Example3">
                                        Remember me
                                    </label>
                                </div>
                                <Link v-if="canResetPassword" :href="route('password.request')" class="text-body">Forgot
                                password?</Link>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" :class="{ 'opacity-50': form.processing }"
                                    :disabled="form.processing" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                                <p class="small fw-bold mt-3 mb-0">Don't have an account?
                                    <Link :href="route('register')" class="link-danger">Register</Link>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <footer
                class="d-flex flex-column flex-md-row text-center text-md-start justify-content-center py-4 px-4 px-xl-5 bg-primary">
                <div class="text-white mb-3 mb-md-0">
                    &copy; 2024. All rights reserved.
                </div>
            </footer>
        </section>
    </GuestLayout>
</template>

<style>
.h-custom {
    height: calc(100% - 73px);
}

@media (max-width: 450px) {
    .h-custom {
        height: 100%;
    }
}
</style>
