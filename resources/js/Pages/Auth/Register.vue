<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    address: '',
    phone: '',
    whatsapp: '',
    gender: '',
    dob: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <section class="vh-100" style="background-color: #f7f7f7;">
            <div class="container h-100">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col-lg-10 col-xl-9">
                        <div class="card shadow-sm" style="border-radius: 15px;">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <!-- Form Section -->
                                    <div class="col-md-8 col-lg-6">
                                        <h2 class="text-center fw-bold mb-4">Sign Up</h2>
                                        <form @submit.prevent="submit" class="mx-1 mx-md-4">
                                            <!-- Name Input -->
                                            <div class="form-group mb-4">
                                                <label for="name" class="form-label">Your Full Name</label>
                                                <input type="text" v-model="form.name" id="name" required autofocus
                                                    class="form-control" placeholder="Enter your name" />
                                                <InputError :message="form.errors.name" class="mt-1 text-danger" />
                                            </div>

                                            <!-- Email Input -->
                                            <div class="form-group mb-4">
                                                <label for="email" class="form-label">Your Email</label>
                                                <input type="email" v-model="form.email" id="email" required
                                                    class="form-control" placeholder="Enter your email" />
                                                <InputError :message="form.errors.email" class="mt-1 text-danger" />
                                            </div>

                                            <!-- Address Input -->
                                            <div class="form-group mb-4">
                                                <label for="address" class="form-label">Your Address</label>
                                                <input type="text" v-model="form.address" id="address" required
                                                    class="form-control" placeholder="Enter your address" />
                                                <InputError :message="form.errors.address" class="mt-1 text-danger" />
                                            </div>

                                            <!-- Phone Input -->
                                            <div class="form-group mb-4">
                                                <label for="phone" class="form-label">Your Phone</label>
                                                <input type="text" v-model="form.phone" id="phone" required
                                                    class="form-control" placeholder="Enter your phone" />
                                                <InputError :message="form.errors.phone" class="mt-1 text-danger" />
                                            </div>

                                            <!-- Whatsapp Input -->
                                            <div class="form-group mb-4">
                                                <label for="whatsapp" class="form-label">Your Whatsapp</label>
                                                <input type="text" v-model="form.whatsapp" id="whatsapp" required
                                                    class="form-control" placeholder="Enter your whatsapp" />
                                                <InputError :message="form.errors.whatsapp" class="mt-1 text-danger" />
                                            </div>

                                            <!-- Gender Input -->
                                            <div class="form-group mb-4">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select v-model="form.gender" id="gender" required class="form-control">
                                                    <option value="" disabled selected>Select your gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <InputError :message="form.errors.gender" class="mt-1 text-danger" />
                                            </div>

                                            <!-- DOB Input -->
                                            <div class="form-group mb-4">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="date" v-model="form.dob" id="dob" required
                                                    class="form-control" />
                                                <InputError :message="form.errors.dob" class="mt-1 text-danger" />
                                            </div>

                                            <!-- Password Input -->
                                            <div class="form-group mb-4">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" v-model="form.password" id="password" required
                                                    class="form-control" placeholder="Enter a password" />
                                                <InputError :message="form.errors.password" class="mt-1 text-danger" />
                                            </div>

                                            <!-- Password Confirmation -->
                                            <div class="form-group mb-4">
                                                <label for="password_confirmation" class="form-label">Confirm
                                                    Password</label>
                                                <input type="password" v-model="form.password_confirmation"
                                                    id="password_confirmation" required class="form-control"
                                                    placeholder="Repeat your password" />
                                                <InputError :message="form.errors.password_confirmation"
                                                    class="mt-1 text-danger" />
                                            </div>

                                            <!-- Terms and Conditions Checkbox -->
                                            <div class="form-check d-flex justify-content-center mb-3">
                                                <input class="form-check-input" type="checkbox" id="terms" required />
                                                <label class="form-check-label ms-2" for="terms">
                                                    I agree to the <a href="#" class="text-primary">Terms of Service</a>
                                                </label>
                                            </div>

                                            <!-- Already Registered Link -->
                                            <div class="text-center mb-3">
                                                <Link :href="route('login')" class="text-secondary">Already registered?
                                                Log in</Link>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" :class="{ 'opacity-50': form.processing }"
                                                    :disabled="form.processing" class="btn btn-primary btn-lg px-5">
                                                    Register
                                                </button>
                                            </div>

                                        </form>
                                    </div>

                                    <!-- Image Section -->
                                    <div
                                        class="col-md-8 col-lg-6 d-flex align-items-center justify-content-center mt-4 mt-lg-0">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                            class="img-fluid" alt="Registration illustration" style="max-width: 80%;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
