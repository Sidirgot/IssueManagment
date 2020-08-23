<template>
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <h1 class="text-xl text-gray-600 mb-6 mt-2 flex items-center">

                <router-link :to="{name: 'projects-index'}" class="btn btn-teal">
                    <svg width="20" height="20" class="inline-block" viewBox="0 0 20 20">
                        <path fill="#fff" d="M3.24,7.51c-0.146,0.142-0.146,0.381,0,0.523l5.199,5.193c0.234,0.238,0.633,0.064,0.633-0.262v-2.634c0.105-0.007,0.212-0.011,0.321-0.011c2.373,0,4.302,1.91,4.302,4.258c0,0.957-0.33,1.809-1.008,2.602c-0.259,0.307,0.084,0.762,0.451,0.572c2.336-1.195,3.73-3.408,3.73-5.924c0-3.741-3.103-6.783-6.916-6.783c-0.307,0-0.615,0.028-0.881,0.063V2.575c0-0.327-0.398-0.5-0.633-0.261L3.24,7.51 M4.027,7.771l4.301-4.3v2.073c0,0.232,0.21,0.409,0.441,0.366c0.298-0.056,0.746-0.123,1.184-0.123c3.402,0,6.172,2.709,6.172,6.041c0,1.695-0.718,3.24-1.979,4.352c0.193-0.51,0.293-1.045,0.293-1.602c0-2.76-2.266-5-5.046-5c-0.256,0-0.528,0.018-0.747,0.05C8.465,9.653,8.328,9.81,8.328,9.995v2.074L4.027,7.771z"></path>
                    </svg>
                </router-link>

                <span class="self-end ml-2">Project Details</span>
            </h1>

            <div v-if="isManager">
                <button @click.prevent="updateStatus('closed')" class="btn btn-teal flex items-center" v-if="project.status === 'opened'">
                    Close Project

                    <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                        <path fill="#fff" d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
                    </svg>
                </button>

                <button @click.prevent="updateStatus('opened')" class="btn btn-blue flex items-center" v-else>
                    Open Project 
                    
                    <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                        <path fill="#fff" d="M16.198,10.896c-0.252,0-0.455,0.203-0.455,0.455v2.396c0,0.626-0.511,1.137-1.138,1.137H5.117c-0.627,0-1.138-0.511-1.138-1.137V7.852c0-0.626,0.511-1.137,1.138-1.137h5.315c0.252,0,0.456-0.203,0.456-0.455c0-0.251-0.204-0.455-0.456-0.455H5.117c-1.129,0-2.049,0.918-2.049,2.047v5.894c0,1.129,0.92,2.048,2.049,2.048h9.488c1.129,0,2.048-0.919,2.048-2.048v-2.396C16.653,11.099,16.45,10.896,16.198,10.896z"></path>
                        <path fill="#fff" d="M14.053,4.279c-0.207-0.135-0.492-0.079-0.63,0.133c-0.137,0.211-0.077,0.493,0.134,0.63l1.65,1.073c-4.115,0.62-5.705,4.891-5.774,5.082c-0.084,0.236,0.038,0.495,0.274,0.581c0.052,0.019,0.103,0.027,0.154,0.027c0.186,0,0.361-0.115,0.429-0.301c0.014-0.042,1.538-4.023,5.238-4.482l-1.172,1.799c-0.137,0.21-0.077,0.492,0.134,0.629c0.076,0.05,0.163,0.074,0.248,0.074c0.148,0,0.294-0.073,0.382-0.207l1.738-2.671c0.066-0.101,0.09-0.224,0.064-0.343c-0.025-0.118-0.096-0.221-0.197-0.287L14.053,4.279z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <loading></loading>

        <div class="w-full bg-teal-700 p-2 text-center text-white rounded my-2" v-if="! loading && project.status === 'closed'">
            <svg width="50" height="50" class="inline-block" viewBox="0 0 20 20">
                <path fill="#fff" d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
            </svg>
            <p>
                You have closed this project.
            </p>
        </div>

        <div class="flex flex-col md:flex-row md:-mx-2" v-if="! loading">

            <projectDetails></projectDetails>

            <projectTesterDevelopers></projectTesterDevelopers>

        </div>

        <projectIssues></projectIssues>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import loading from '../partials/loading'

import projectDetails from './components/project-details'
import projectTesterDevelopers from './components/project-testers-developers'
import projectIssues from '../Issues/projectIssues'

export default {
    name: 'show-project',

    components: { loading, projectDetails, projectTesterDevelopers, projectIssues },

    created() {
        this.$store.dispatch('projects/fetchProject', this.$route.params.id)
    },

    computed: {
        ...mapGetters('projects', ['project']),
        ...mapGetters(['isManager', 'loading']),
    },

    methods: {
        updateStatus(status) {
            var payload = { project: this.project, status: status }

            this.$store.dispatch('managers/projects/updateStatus', payload)
        },
    }
}
</script>
