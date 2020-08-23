<template>
    <div class="container mx-auto">
        <h1 class="text-xl my-3 opacity-75"> Dashboard</h1>

        <div class="flex items-center justify-around flex-wrap">
            <div class="bg-white shadow-xl rounded text-teal-700 w-full md:w-1/3 my-1 mx-1">
                <h1 class="px-2  py-1 border-b pb-1 shadow">Assigned Projects</h1>
                <div class="flex items-center justify-around py-6">
                    <svg width="50" height="50" viewBox="0 0 20 20">
                        <path fill="#319795" d="M8.627,7.885C8.499,8.388,7.873,8.101,8.13,8.177L4.12,7.143c-0.218-0.057-0.351-0.28-0.293-0.498c0.057-0.218,0.279-0.351,0.497-0.294l4.011,1.037C8.552,7.444,8.685,7.667,8.627,7.885 M8.334,10.123L4.323,9.086C4.105,9.031,3.883,9.162,3.826,9.38C3.769,9.598,3.901,9.82,4.12,9.877l4.01,1.037c-0.262-0.062,0.373,0.192,0.497-0.294C8.685,10.401,8.552,10.18,8.334,10.123 M7.131,12.507L4.323,11.78c-0.218-0.057-0.44,0.076-0.497,0.295c-0.057,0.218,0.075,0.439,0.293,0.495l2.809,0.726c-0.265-0.062,0.37,0.193,0.495-0.293C7.48,12.784,7.35,12.562,7.131,12.507M18.159,3.677v10.701c0,0.186-0.126,0.348-0.306,0.393l-7.755,1.948c-0.07,0.016-0.134,0.016-0.204,0l-7.748-1.948c-0.179-0.045-0.306-0.207-0.306-0.393V3.677c0-0.267,0.249-0.461,0.509-0.396l7.646,1.921l7.654-1.921C17.91,3.216,18.159,3.41,18.159,3.677 M9.589,5.939L2.656,4.203v9.857l6.933,1.737V5.939z M17.344,4.203l-6.939,1.736v9.859l6.939-1.737V4.203z M16.168,6.645c-0.058-0.218-0.279-0.351-0.498-0.294l-4.011,1.037c-0.218,0.057-0.351,0.28-0.293,0.498c0.128,0.503,0.755,0.216,0.498,0.292l4.009-1.034C16.092,7.085,16.225,6.863,16.168,6.645 M16.168,9.38c-0.058-0.218-0.279-0.349-0.498-0.294l-4.011,1.036c-0.218,0.057-0.351,0.279-0.293,0.498c0.124,0.486,0.759,0.232,0.498,0.294l4.009-1.037C16.092,9.82,16.225,9.598,16.168,9.38 M14.963,12.385c-0.055-0.219-0.276-0.35-0.495-0.294l-2.809,0.726c-0.218,0.056-0.351,0.279-0.293,0.496c0.127,0.506,0.755,0.218,0.498,0.293l2.807-0.723C14.89,12.825,15.021,12.603,14.963,12.385"></path>
                    </svg>

                    <span class="text-xl font-bold traking-wider">{{ total_projects }}</span>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded text-teal-700 w-full md:w-1/3 my-1 mx-1">
                <h1 class="px-2  py-1 border-b pb-1 shadow">Opened Issues</h1>
                <div class="flex items-center justify-around py-6">
                    <svg width="50" height="50" viewBox="0 0 20 20">
                        <path fill="#319795" d="M18.344,16.174l-7.98-12.856c-0.172-0.288-0.586-0.288-0.758,0L1.627,16.217c0.339-0.543-0.603,0.668,0.384,0.682h15.991C18.893,16.891,18.167,15.961,18.344,16.174 M2.789,16.008l7.196-11.6l7.224,11.6H2.789z M10.455,7.552v3.561c0,0.244-0.199,0.445-0.443,0.445s-0.443-0.201-0.443-0.445V7.552c0-0.245,0.199-0.445,0.443-0.445S10.455,7.307,10.455,7.552M10.012,12.439c-0.733,0-1.33,0.6-1.33,1.336s0.597,1.336,1.33,1.336c0.734,0,1.33-0.6,1.33-1.336S10.746,12.439,10.012,12.439M10.012,14.221c-0.244,0-0.443-0.199-0.443-0.445c0-0.244,0.199-0.445,0.443-0.445s0.443,0.201,0.443,0.445C10.455,14.021,10.256,14.221,10.012,14.221"></path>
                    </svg>

                    <span class="text-xl font-bold traking-wider">{{ total_issues }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 mb-2">
            <div class="bg-white shadow-xl rounded text-teal-700 w-full md:w-2/3">
                <h1 class="p-2 border-b pb-1 shadow-xl">Latest Assigned Projects</h1>

                <table class="table-fixed w-full  text-center text-sm">
                    <thead class="bg-gray-300 rounded leading-10">
                        <th class="py-2">Title</th>
                        <th class="py-2">Actions</th>
                    </thead>
                    <tbody>
                        <tr class="leading-loose border-b border-l border-r" v-for="project in projects" :key="project.id">
                            <td class="py-2">
                                <router-link :to="{name: 'show-project', params: {id: project.id }}" class="text-teal-700 text-xs font-bold tracking-wider hover:opacity-50 transition-opacity duration-700">
                                    {{ project.title }}
                                </router-link>
                            </td>
                            <td>
                                <router-link :to="{name: 'show-project', params: {id: project.id }}" class="text-teal-700 font-bold tracking-wider hover:opacity-50 transition-opacity duration-700">
                                    <svg width="20" height="20" class="inline-block" viewBox="0 0 20 20">
                                        <path fill="#319795" d="M10,6.978c-1.666,0-3.022,1.356-3.022,3.022S8.334,13.022,10,13.022s3.022-1.356,3.022-3.022S11.666,6.978,10,6.978M10,12.267c-1.25,0-2.267-1.017-2.267-2.267c0-1.25,1.016-2.267,2.267-2.267c1.251,0,2.267,1.016,2.267,2.267C12.267,11.25,11.251,12.267,10,12.267 M18.391,9.733l-1.624-1.639C14.966,6.279,12.563,5.278,10,5.278S5.034,6.279,3.234,8.094L1.609,9.733c-0.146,0.147-0.146,0.386,0,0.533l1.625,1.639c1.8,1.815,4.203,2.816,6.766,2.816s4.966-1.001,6.767-2.816l1.624-1.639C18.536,10.119,18.536,9.881,18.391,9.733 M16.229,11.373c-1.656,1.672-3.868,2.594-6.229,2.594s-4.573-0.922-6.23-2.594L2.41,10l1.36-1.374C5.427,6.955,7.639,6.033,10,6.033s4.573,0.922,6.229,2.593L17.59,10L16.229,11.373z"></path>
                                    </svg>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'team-dashboard',

    data() {
        return {
            total_projects: 0,
            total_issues: 0,
            projects: []
        }
    },

    created() {
        this.fetchData();
    },

    methods: {
        fetchData() {
            axios.get('/api/dashboard_information')
                 .then((response) => {
                     this.total_projects = response.data.total_projects
                     this.total_issues = response.data.total_opened_issues
                     this.projects = response.data.latest_projects
                 })
                 .catch(error => {
                     console.log(error)
                 })
        }
    }
}
</script>