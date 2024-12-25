<template>
    <AppLayout>
        <template #content>
            <div>
                <section style="background-color: #eee;">
                    <div class="container py-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8">
                                <div class="card shadow-0 border rounded-3 p-4">
                                    <h3 class="text-center mb-4">Create Job Post</h3>
                                    <form @submit.prevent="handleSubmit">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="jobTitle" class="form-label">Job Title</label>
                                                <input type="text" v-model="job.title" class="form-control"
                                                    id="jobTitle" placeholder="Enter job title" required />
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="jobLocation" class="form-label">Location</label>
                                                <input type="text" v-model="job.location" class="form-control"
                                                    id="jobLocation" placeholder="Enter job location" required />
                                            </div>

                                            <!-- Dynamic Categories -->
                                            <div class="col-md-6 mb-3">
                                                <label for="jobCategory" class="form-label">Job Category</label>
                                                <select v-model="job.category_id" class="form-select" id="jobCategory"
                                                    required>
                                                    <option value="" disabled>Select job category</option>
                                                    <option v-for="category in categories" :key="category.id"
                                                        :value="category.id">
                                                        {{ category.category_name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="minAge" class="form-label">Min Age</label>
                                                <input type="number" v-model="job.minAge" class="form-control"
                                                    id="minAge" placeholder="e.g., 18" required />
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="maxAge" class="form-label">Max Age</label>
                                                <input type="number" v-model="job.maxAge" class="form-control"
                                                    id="maxAge" placeholder="e.g., 30" required />
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Gender Preference</label>
                                                <div class="row">
                                                    <div class="col-12 col-md-4 mb-3 d-flex align-items-center">
                                                        <input type="checkbox" id="maleCheckbox"
                                                            v-model="genderSelections.male"
                                                            @change="handleGenderChange('male')"
                                                            class="form-check-input" />
                                                        <label for="maleCheckbox"
                                                            class="form-check-label ms-2">Male</label>
                                                        <input type="number" v-model="genderCounts.male"
                                                            class="form-control ms-2" :disabled="!genderSelections.male"
                                                            placeholder="Count" min="0" />
                                                    </div>
                                                    <div class="col-12 col-md-4 mb-3 d-flex align-items-center">
                                                        <input type="checkbox" id="femaleCheckbox"
                                                            v-model="genderSelections.female"
                                                            @change="handleGenderChange('female')"
                                                            class="form-check-input" />
                                                        <label for="femaleCheckbox"
                                                            class="form-check-label ms-2">Female</label>
                                                        <input type="number" v-model="genderCounts.female"
                                                            class="form-control ms-2"
                                                            :disabled="!genderSelections.female" placeholder="Count"
                                                            min="0" />
                                                    </div>
                                                    <div class="col-12 col-md-4 mb-3 d-flex align-items-center">
                                                        <input type="checkbox" id="bothCheckbox"
                                                            v-model="genderSelections.both"
                                                            @change="handleGenderChange('both')"
                                                            class="form-check-input" />
                                                        <label for="bothCheckbox"
                                                            class="form-check-label ms-2">Both</label>
                                                        <input type="number" v-model="genderCounts.both"
                                                            class="form-control ms-2" :disabled="!genderSelections.both"
                                                            placeholder="Count" min="0" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="salaryRange" class="form-label">Salary</label>
                                                <input type="text" v-model="job.salary" class="form-control"
                                                    id="salaryRange" placeholder="e.g., $50,000 - $70,000" />
                                            </div>

                                            <!-- New fields for Start and End Date -->
                                            <div class="col-md-6 mb-3">
                                                <label for="jobStartDate" class="form-label">Job Start Date</label>
                                                <input type="datetime-local" v-model="job.start_date"
                                                    class="form-control" id="jobStartDate" required />
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="jobEndDate" class="form-label">Job End Date</label>
                                                <input type="datetime-local" v-model="job.end_date" class="form-control"
                                                    id="jobEndDate" required />
                                            </div>


                                            <div class="col-md-12 mb-3">
                                                <label for="jobDescription" class="form-label">Job Description</label>
                                                <textarea v-model="job.description" class="form-control"
                                                    id="jobDescription" rows="4" placeholder="Enter job description"
                                                    required></textarea>
                                            </div>

                                            <div class="col-md-12 d-grid">
                                                <button type="submit" class="btn btn-primary">Post Job</button>
                                            </div>
                                        </div>
                                    </form>
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
import axios from 'axios';

export default {
    components: {
        AppLayout
    },
    data() {
        return {
            job: {
                title: '',
                description: '',
                category_id: '',
                location: '',
                minAge: '',
                maxAge: '',
                salary: '',
                experience: '',
                start_date: '',
                end_date: '',
            },
            genderSelections: {
                male: false,
                female: false,
                both: false
            },
            genderCounts: {
                male: 0,
                female: 0,
                both: 0
            },
            categories: [] // This will store job categories fetched from the backend
        };
    },
    mounted() {
        this.fetchCategories();
    },
    methods: {
        // Fetch job categories from the backend
        async fetchCategories() {
            try {
                const response = await axios.get(route('categories.get'));
                this.categories = response.data;
            } catch (error) {
                console.error('Failed to fetch categories', error);
            }
        },
        handleGenderChange(gender) {
            if (gender === 'both') {
                if (this.genderSelections.both) {
                    this.genderSelections.male = false;
                    this.genderSelections.female = false;
                    this.genderCounts.male = 0;
                    this.genderCounts.female = 0;
                }
            } else {
                if (this.genderSelections[gender]) {
                    this.genderSelections.both = false;
                    this.genderCounts.both = 0;
                }
            }
        },

        async handleSubmit() {
            // Create a new FormData instance
            const formData = new FormData();

            // Append all job-related data to the FormData instance
            formData.append("title", this.job.title);
            formData.append("description", this.job.description);
            formData.append("category_id", this.job.category_id);
            formData.append("location", this.job.location);
            formData.append("minAge", this.job.minAge);
            formData.append("maxAge", this.job.maxAge);
            formData.append("salary", this.job.salary);
            formData.append("start_date", this.job.start_date);
            formData.append("end_date", this.job.end_date);

            // Append gender selections and counts
            formData.append("genderSelections", JSON.stringify(this.genderSelections));
            formData.append("genderCounts", JSON.stringify(this.genderCounts));

            // If you have any files to upload, you can append them as well
            // formData.append("image", this.category.image);

            try {
                // Send a POST request to store the job data
                const response = await axios.post(route('store_jobs'), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                if (response.status === 200) {
                    alert('Job post created successfully!');
                    this.resetForm(); // Optionally reset the form after submission
                } else {
                    alert('Failed to create job post. Please try again.');
                }
            } catch (error) {
                console.error('Error posting job:', error);
                alert('An error occurred while posting the job. Please try again later.');
            }
        },


    }
};
</script>

<style scoped>
section {
    background-color: #eee;
}

.card {
    background-color: #fff;
}

.form-label {
    font-weight: 600;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    transition: background-color 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .card {
        padding: 1.5rem;
    }
}
</style>
