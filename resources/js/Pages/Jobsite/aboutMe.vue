<template>
    <AppLayout>
        <template #content>
            <div>
                <section style="background-color: #f8f9fa;">
                    <div class="container py-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8">
                                <div class="card shadow-0 border rounded-3 p-4">
                                    <h3 class="text-center mb-4">My Profile</h3>

                                    <!-- Personal Details Section -->
                                    <div class="mb-4">
                                        <h5>Personal Details</h5>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>Full Name:</strong>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="profile.fullName"
                                                    :disabled="!isEditing"
                                                />
                                                <span v-if="errors.fullName" class="text-danger">{{ errors.fullName }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Address:</strong>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="profile.address"
                                                    :disabled="!isEditing"
                                                />
                                                <span v-if="errors.address" class="text-danger">{{ errors.address }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Phone:</strong>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="profile.phone"
                                                    :disabled="!isEditing"
                                                />
                                                <span v-if="errors.phone" class="text-danger">{{ errors.phone }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Whatsapp:</strong>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="profile.whatsapp"
                                                    :disabled="!isEditing"
                                                />
                                                <span v-if="errors.whatsapp" class="text-danger">{{ errors.whatsapp }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Email:</strong>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="profile.email"
                                                    :disabled="!isEditing"
                                                />
                                                <span v-if="errors.email" class="text-danger">{{ errors.email }}</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="row justify-content-center">
                                        <button
                                            v-if="!isEditing"
                                            class="btn btn-primary col-2 me-2"
                                            @click="enableEditing"
                                        >
                                            Edit Profile
                                        </button>
                                        <div v-else>
                                            <button
                                                class="btn btn-success col-2 me-2"
                                                @click="saveChanges"
                                            >
                                                Update
                                            </button>
                                            <button
                                                class="btn btn-secondary col-2"
                                                @click="cancelEditing"
                                            >
                                                Cancel
                                            </button>
                                        </div>
                                        <Link
                                            v-if="!isEditing"
                                            class="btn btn-danger col-2 ms-2"
                                            aria-current="page"
                                            @click="logout"
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/App.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

export default {
    components: {
        AppLayout,
        Link
    },
    data() {
        return {
            isEditing: false,
            profile: {
                fullName: '',
                address: '',
                phone: '',
                whatsapp: '',
                email: '',
            },
            errors: {}, // Store validation errors here
        };
    },
    async mounted() {
        await this.fetchProfile();
    },
    methods: {
        enableEditing() {
            this.isEditing = true;
        },
        async saveChanges() {
            try {
                await axios.put(route('profile.update'), this.profile);
                alert('Profile updated successfully!');
                this.isEditing = false;
                this.errors = {}; // Clear errors on success
                await this.fetchProfile(); // Reload profile
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors; // Set validation errors
                } else {
                    console.error(error);
                    alert('Failed to update profile.');
                }
            }
        },
        cancelEditing() {
            this.isEditing = false;
            this.fetchProfile(); // Reset to original data
        },
        async fetchProfile() {
            try {
                const response = await axios.get(route('profile.get'));
                const user = response.data;
                this.profile = {
                    fullName: user.name,
                    address: user.address,
                    phone: user.phone,
                    whatsapp: user.whatsapp,
                    email: user.email,
                };
            } catch (error) {
                console.error('Error fetching profile:', error);
                alert('Failed to load profile data.');
            }
        },
        logout() {
            alert('Logged out.');
        }
    }
};
</script>

<style scoped>
.card {
    background-color: #fff;
}

h5 {
    font-weight: bold;
    color: #333;
}

.list-group-item {
    background-color: #fff;
    border: 1px solid #ddd;
}

.text-danger {
    font-size: 0.9rem;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-secondary:hover {
    background-color: #5a6268;
}
</style>
