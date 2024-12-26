<template>
  <AppLayout>
    <template #content>
      <div>
        <section style="background-color: #f4f6f9;">
          <div class="container py-5">

            <!-- Post Job Button Section -->
            <div class="row justify-content-center mb-3">
              <div class="col-md-12 col-xl-10">
                <div class="card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-2 offset-10">
                        <Link class="btn btn-success btn-sm w-100 h-100" :href="route('postjob')">
                          <i class="fas fa-comment-dots fa-lg"></i>
                          <span class="small">Post Job</span>
                        </Link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Loop over Jobs -->
            <div v-for="job in my_jobs" :key="job.job_id" class="row justify-content-center mb-4">
              <div class="col-md-12 col-xl-10">
                <div class="card shadow-sm border rounded-3">
                  <div class="card-body">
                    <div class="row">

                      <!-- Job Image Section -->
                      <div class="col-md-12 col-lg-4 col-xl-3 mb-4">
                        <div class="bg-image hover-zoom ripple rounded ripple-surface">
                          <img :src="`/categoryImages/${job.category_image}`" class="w-100 rounded" alt="Job Category" />
                        </div>
                      </div>

                      <!-- Job Details Section -->
                      <div class="col-md-6 col-lg-6 col-xl-6">
                        <h5 class="font-weight-bold">{{ job.title }}</h5>
                        <div class="d-flex flex-row align-items-center">
                          <div class="text-warning mb-1 me-2">
                            <i v-for="n in 5" :key="n" class="fa fa-star" :class="{'text-primary': n <= job.rating, 'text-muted': n > job.rating}"></i>
                          </div>
                          <span>{{ job.reviews_count }} Reviews</span>
                        </div>
                        <p class="text-muted small mt-2">
                          <span>Category: {{ job.category_name }}</span>
                          <span class="text-primary"> • </span>
                          <span>{{ job.location }}</span>
                        </p>
                        <p class="text-muted small">
                          <span>Age Range: {{ job.min_age }} - {{ job.max_age }} years</span>
                          <span class="text-primary"> • </span>
                          <span>Salary: ${{ job.salary }}</span>
                        </p>
                        <p class="text-muted small">
                          <span>Start Date: {{ job.start_date }}</span>
                          <span class="text-primary"> • </span>
                          <span>End Date: {{ job.end_date }}</span>
                        </p>
                        <p class="text-truncate mb-4">
                          {{ job.description }}
                        </p>
                      </div>

                      <!-- Job Status and Actions -->
                      <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                        <div class="d-flex flex-row align-items-center mb-1">
                          <h4 class="mb-1 me-1">Rs. {{ job.salary }}</h4>
                        </div>
                        <h6 class="text-success">Status: {{ job.job_status }}</h6>
                        <div class="d-flex flex-column mt-4">
                          <button class="btn btn-primary btn-sm mb-2" type="button">View Response</button>
                          <button class="btn btn-outline-success btn-sm " type="button">Complete Job</button>
                          <button class="btn btn-outline-danger btn-sm" type="button">Delete Job</button>
                        </div>
                      </div>

                    </div>
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

export default {
  components: {
    AppLayout,
    Link
  },
  data() {
    return {
      my_jobs: [],  // Initialize empty array to store jobs
    };
  },
  async mounted() {
    await this.fetchMyJobs();
  },
  methods: {
    async fetchMyJobs() {
      try {
        const response = await axios.get(route("fetch_my_jobs"));
        this.my_jobs = response.data;
        console.log(this.my_jobs);
      } catch (error) {
        console.error("Error fetching fetchMyJobs:", error);
      }
    },
  }
}
</script>

<style scoped>
/* Styles for job cards */
.card {
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-body {
  padding: 20px;
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

.text-warning {
  color: #ffc107;
}

.text-success {
  color: #28a745;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-outline-primary {
  border-color: #007bff;
  color: #007bff;
}

.bg-image {
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.card-shadow {
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.d-flex {
  display: flex;
}

.flex-row {
  flex-direction: row;
}

.mt-4 {
  margin-top: 20px;
}

.mb-4 {
  margin-bottom: 20px;
}

@media (max-width: 768px) {
  .card-body {
    padding: 15px;
  }

  .card img {
    height: 150px;
  }
}
</style>
