<template>

    <div class="mb-5">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <!-- Container wrapper -->
            <div class="container">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="#"><i class="fab fa-linkedin fa-2x"></i></a>
                <!-- Search form -->
                <form class="input-group" style="width: 400px">
                    <input type="search" class="form-control" placeholder="Type query" aria-label="Search" />
                    <button class="btn btn-outline-primary" type="button" data-mdb-ripple-color="dark"
                        style="padding: .45rem 1.5rem .35rem;">
                        Search
                    </button>
                </form>

                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left links -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <Link class="nav-link active d-flex flex-column text-center" aria-current="page"
                                :href="route('dashboard')"><i class="fas fa-home fa-lg"></i><span
                                class="small">Home</span>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-column text-center" aria-current="page" :href="route('myNetwork')"><i
                                    class="fas fa-user-friends fa-lg"></i><span class="small">My Network</span></a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link d-flex flex-column text-center" aria-current="page" href="#"><i
                                    class="fas fa-briefcase fa-lg"></i><span class="small"></span></a>
                        </li> -->
                        <li class="nav-item">
                            <Link class="nav-link d-flex flex-column text-center" aria-current="page"
                                :href="route('aboutme')"><i class="fas fa-comment-dots fa-lg"></i><span
                                class="small">My Profile</span>
                            </Link>
                        </li>
                        <li>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->

    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Link
    },
}

</script>

<style>
/* Color of the links BEFORE scroll */
.navbar-scroll .nav-link,
.navbar-scroll .navbar-toggler-icon,
.navbar-scroll .navbar-brand {
    color: #262626;
}

/* Color of the navbar BEFORE scroll */
.navbar-scroll {
    background-color: #FFC017;
}

/* Color of the links AFTER scroll */
.navbar-scrolled .nav-link,
.navbar-scrolled .navbar-toggler-icon,
.navbar-scroll .navbar-brand {
    color: #262626;
}

/* Color of the navbar AFTER scroll */
.navbar-scrolled {
    background-color: #fff;
}

/* An optional height of the navbar AFTER scroll */
.navbar.navbar-scroll.navbar-scrolled {
    padding-top: auto;
    padding-bottom: auto;
}

.navbar-brand {
    font-size: unset;
    height: 3.5rem;
}
</style>
