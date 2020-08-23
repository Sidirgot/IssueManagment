<template>
    <div class="container mx-auto">
        <h2 class="mb-3 text-xl text-gray-600 mb-6 mt-2">Assigned Projects</h2>

        <loading></loading>

        <div class="bg-white rounded shadow-lg p-4" v-show="! loading">
            <table class="table-fixed w-full  text-center text-sm">
                <thead class="bg-gray-300 rounded leading-loose">
                    <th class="py-2">Title</th>
                    <th class="py-2">Opened Issues</th>
                    <th class="py-2">Actions</th>
                </thead>
                <tbody>
                    <tr class="leading-loose border-b border-l border-r" v-for="project in projects" :key="project.id">
                        <td class="py-2" v-text="project.title"></td>
                        <td class="leading-loose">
                            <span class="px-2 bg-teal-600 rounded-full text-white">{{ project.opened_issues }}</span>
                        </td>
                        <td class="py-2">
                            <router-link :to="{name: 'show-project', params: {id: project.id }}" class="px-4 py-1 rounded">
                                <svg width="20" height="20" class="inline-block" viewBox="0 0 20 20">
                                    <path fill="#319795" stroke="#319795" d="M10,6.978c-1.666,0-3.022,1.356-3.022,3.022S8.334,13.022,10,13.022s3.022-1.356,3.022-3.022S11.666,6.978,10,6.978M10,12.267c-1.25,0-2.267-1.017-2.267-2.267c0-1.25,1.016-2.267,2.267-2.267c1.251,0,2.267,1.016,2.267,2.267C12.267,11.25,11.251,12.267,10,12.267 M18.391,9.733l-1.624-1.639C14.966,6.279,12.563,5.278,10,5.278S5.034,6.279,3.234,8.094L1.609,9.733c-0.146,0.147-0.146,0.386,0,0.533l1.625,1.639c1.8,1.815,4.203,2.816,6.766,2.816s4.966-1.001,6.767-2.816l1.624-1.639C18.536,10.119,18.536,9.881,18.391,9.733 M16.229,11.373c-1.656,1.672-3.868,2.594-6.229,2.594s-4.573-0.922-6.23-2.594L2.41,10l1.36-1.374C5.427,6.955,7.639,6.033,10,6.033s4.573,0.922,6.229,2.593L17.59,10L16.229,11.373z"></path>
                                </svg>
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import loading from '../partials/loading'

export default {
    name: 'projects',

    components: { loading },

    created() {
        this.$store.dispatch('projects/fetchProjects')
    },

    computed: {
        ...mapGetters('projects', ['projects']),
        ...mapGetters(['loading', 'auth_user'])
    },
}
</script>
