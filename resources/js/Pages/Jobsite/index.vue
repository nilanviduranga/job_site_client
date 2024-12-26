<template>
    <AppLayout>
        <template #content>
            <div>
                <section style="background-color: #f4f6f9;">
                    <div class="container py-5">

                        <!-- Loop over Jobs -->
                        <div v-if="my_jobs.length > 0">
                            <div v-for="job in my_jobs" :key="job.id" class="row justify-content-center mb-4">
                                <div class="col-md-12 col-xl-10">
                                    <div class="card shadow-sm border rounded-3">
                                        <div class="card-body">
                                            <div class="row">

                                                <!-- Job Image Section -->
                                                <div class="col-md-12 col-lg-4 col-xl-3 mb-4">
                                                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                                        <img :src="job.category_image ? `/categoryImages/${job.category_image}` : '/defaultImage.jpg'"
                                                            class="w-100 rounded" alt="Job Category" />
                                                    </div>
                                                </div>

                                                <!-- Job Details Section -->
                                                <div class="col-md-6 col-lg-6 col-xl-6">
                                                    <h5 class="font-weight-bold">{{ job.title || 'Job Title Unavailable'
                                                        }}</h5>
                                                    <p class="text-muted small mt-2">
                                                        <span>Category: {{ job.category_name || 'N/A' }}</span>
                                                        <span class="text-primary"> • </span>
                                                        <span>{{ job.location || 'Location Unavailable' }}</span>
                                                    </p>
                                                    <p class="text-muted small">
                                                        <span>Age Range: {{ job.min_age }} - {{ job.max_age }}
                                                            years</span>
                                                        <span class="text-primary"> • </span>
                                                        <span>Salary: Rs. {{ job.salary }}</span>
                                                    </p>
                                                    <p class="text-muted small">
                                                        <span>Start Date: {{ job.start_date }}</span>
                                                        <span class="text-primary"> • </span>
                                                        <span>End Date: {{ job.end_date }}</span>
                                                    </p>
                                                    <p class="text-truncate mb-4">
                                                        {{ job.description || 'No description available for this job.'
                                                        }}
                                                    </p>
                                                </div>

                                                <!-- Job Status and Actions -->
                                                <div
                                                    class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                                    <div class="d-flex flex-row align-items-center mb-1">
                                                        <h4 class="mb-1 me-1">Rs. {{ job.salary }}</h4>
                                                    </div>
                                                    <h6 class="text-success">Status: {{ job.job_status }}</h6>

                                                    <!-- Action Buttons -->
                                                    <div class="d-flex flex-column mt-4">
                                                        <button class="btn btn-success btn-sm mb-2" type="button"
                                                            @click="applyJob(job.id)">Apply</button>
                                                    </div>

                                                    <!-- Poster Contact Info -->
                                                    <div class="mt-3">
                                                        <h6>Contact the Poster:</h6>
                                                        <p><strong>Phone:</strong> {{ job.poster_contact_number
                                                            || 'N/A' }}</p>
                                                        <p><strong>WhatsApp:</strong>
                                                            <a :href="job.poster_contact_number ? `https://wa.me/${job.poster_contact_number}` : '#'"
                                                                target="_blank">
                                                                {{ job.poster_whatsapp || 'N/A' }}
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p class="text-center mt-5">No jobs available at the moment.</p>
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

export default {
    components: {
        AppLayout,
        Link
    },
    data() {
        return {
            my_jobs: [], // Initialize empty array to store jobs
        };
    },
    async mounted() {
        await this.fetchAvailableJobs();
    },
    methods: {
        async fetchAvailableJobs() {
            console.log("Fetching pending jobs");
            try {
                const response = await axios.get(route("fetch_available_jobs")); // Fetching job data from API
                this.my_jobs = response.data;
                console.log(this.my_jobs);
            } catch (error) {
                console.error("Error fetching pending jobs:", error);
            }
        },
        async applyJob(jobId) {
            if (confirm("Are you sure you want to apply for this job?")) {
                try {
                    await axios.post(route("apply_to_"), { id: jobId });
                    alert("Application submitted successfully!");
                } catch (error) {
                    console.error("Error applying for the job:", error);
                }
            }
        },
    }
};
</script>

<style scoped>
/* Updated styles */
.card {
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card img {
    object-fit: cover;
    height: 200px;
}

.font-weight-bold {
    font-weight: 600;
    color: #333;
}

.text-muted {
    color: #6c757d;
}

.text-primary {
    color: #007bff;
}

.text-success {
    color: #28a745;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.bg-image {
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.mt-4 {
    margin-top: 20px;
}

.mb-4 {
    margin-bottom: 20px;
}

.text-center {
    text-align: center;
}

@media (max-width: 768px) {
    .card img {
        height: 150px;
    }
}
</style>
