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
                                                <input type="text" class="form-control" v-model="profile.fullName"
                                                    :disabled="!isEditing" />
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Phone:</strong>
                                                <input type="text" class="form-control" v-model="profile.phone"
                                                    :disabled="!isEditing" />
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Email:</strong>
                                                <input type="text" class="form-control" v-model="profile.email"
                                                    :disabled="!isEditing" />
                                            </li>
                                            <li class="list-group-item">
                                                <strong>LinkedIn:</strong>
                                                <input type="text" class="form-control" v-model="profile.linkedin"
                                                    :disabled="!isEditing" />
                                            </li>
                                            <li class="list-group-item">
                                                <strong>GitHub:</strong>
                                                <input type="text" class="form-control" v-model="profile.github"
                                                    :disabled="!isEditing" />
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Parents:</strong>
                                                <input type="text" class="form-control" v-model="profile.parents"
                                                    :disabled="!isEditing" />
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Education Section -->
                                    <div class="mb-4">
                                        <h5>Education</h5>
                                        <ul class="list-group">
                                            <li class="list-group-item"
                                                v-for="(certificate, index) in profile.education" :key="index">
                                                <strong>Certificate:</strong>
                                                <input type="text" class="form-control" v-model="certificate.title"
                                                    :disabled="!isEditing" />
                                                <strong>Institute:</strong>
                                                <input type="text" class="form-control" v-model="certificate.institute"
                                                    :disabled="!isEditing" />
                                                <strong>Date:</strong>
                                                <input type="date" class="form-control" v-model="certificate.date"
                                                    :disabled="!isEditing" />
                                                <strong>Grade:</strong>
                                                <input type="text" class="form-control" v-model="certificate.grade"
                                                    :disabled="!isEditing" />
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Skills Section -->
                                    <div class="mb-4">
                                        <h5>Skills</h5>
                                        <ul class="list-group">
                                            <li class="list-group-item" v-for="(skill, index) in profile.skills"
                                                :key="index">
                                                <input type="text" class="form-control" v-model="profile.skills[index]"
                                                    :disabled="!isEditing" />
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Work Experience Section -->
                                    <div class="mb-4">
                                        <h5>Work Experience</h5>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>Position:</strong>
                                                <input type="text" class="form-control"
                                                    v-model="profile.workExperience.position" :disabled="!isEditing" />
                                                <strong>Businesses:</strong>
                                                <input type="text" class="form-control"
                                                    v-model="profile.workExperience.businesses"
                                                    :disabled="!isEditing" />
                                                <strong>Responsibilities:</strong>
                                                <textarea class="form-control"
                                                    v-model="profile.workExperience.responsibilities"
                                                    :disabled="!isEditing"></textarea>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="row justify-content-center">
                                        <button v-if="!isEditing" class="btn btn-primary col-2 me-2"
                                            @click="enableEditing">
                                            Edit Profile
                                        </button>
                                        <div v-else>
                                            <button class="btn btn-success col-2 me-2" @click="saveChanges">
                                                Update
                                            </button>
                                            <button class="btn btn-secondary col-2" @click="cancelEditing">
                                                Cancel
                                            </button>
                                        </div>
                                        <Link v-if="!isEditing" class="btn btn-danger col-2 ms-2" aria-current="page"
                                            @click="logout" :href="route('logout')" method="post" as="button">Log Out
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
import AppLayout from '@/Layouts/App.vue'
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout,
        Link
    },
    data() {
        return {
            isEditing: false,
            profile: {
                fullName: 'Loku Gamage Jasitha Nilan Visuranga',
                phone: '0771360985',
                email: 'nilanviduranga26@gmail.com',
                linkedin: 'https://www.linkedin.com/in/nilanviduranga',
                github: 'https://github.com/nilanviduranga',
                parents: 'L.G Podimahaththaya & H.P Indrani Priyanka',
                education: [
                    {
                        title: 'International Marketing',
                        institute: 'Xuetang',
                        date: '2023-12-30',
                        grade: '100.0'
                    },
                    {
                        title: 'Software Engineering',
                        institute: 'ICE Institute',
                        date: '2023-12-24',
                        grade: '100.0'
                    }
                ],
                skills: ['Agile Software Development', 'International Marketing', 'Software Engineering', 'Business Management'],
                workExperience: {
                    position: 'Business Owner',
                    businesses: 'Software Designing, Music Store, Hotels, Food Supply',
                    responsibilities: 'Managing multiple business operations, client engagement, and growth strategies.'
                }
            }
        };
    },
    methods: {
        enableEditing() {
            this.isEditing = true;
        },
        saveChanges() {
            alert('Profile updated successfully!');
            this.isEditing = false;
        },
        cancelEditing() {
            alert('Changes discarded.');
            this.isEditing = false;
        },
        logout() {
            alert('Logged out.');
        }
    }
};
</script>

<style scoped>
section {
    background-color: #f8f9fa;
}

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

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
}

.btn-secondary:hover {
    background-color: #5a6268;
}
</style>
