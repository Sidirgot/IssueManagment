<template>
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <h1 class="self-start text-xl text-gray-600 mb-6 mt-2">Project Details</h1>

            <div v-if="isManager">
                <button @click.prevent="updateStatus('closed')" class="btn btn-teal" v-if="project.status === 'opened'">Close Project <i class="fas fa-lock"></i></button>
                <button @click.prevent="updateStatus('opened')" class="btn btn-blue" v-else>Open Project <i class="fas fa-lock-open"></i></button>
            </div>
        </div>

        <loading></loading>

        <div class="w-full bg-teal-700 p-2 text-center text-white rounded my-2" v-if="! loading && project.status === 'closed'">
            <i class="fas fa-lock text-3xl"></i>
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
