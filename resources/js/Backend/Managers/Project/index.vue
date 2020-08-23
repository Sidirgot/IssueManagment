<template>
    <div class="container mx-auto">
        

        <loading></loading>

        <div class="bg-white rounded shadow-lg p-3 mt-4 mx-2" v-show="! loading">

            <div class="flex flex-col md:flex-row justify-between items-center my-2">
                <h1 class="self-start text-xl text-gray-600 my-3 md:my-0">Projects Table</h1>

                <router-link :to="{name: 'projects-create'}" class="self-end btn btn-teal text-white flex items-center">
                    New Project

                    <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                        <path fill="#fff" d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10"></path>
                    </svg>
                </router-link>
            </div>

            <table class="table-fixed w-full  text-center text-sm">
                <thead class="bg-gray-300 leading-10 rounded">
                    <th class="py-2">Title</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Opened Issues</th>
                </thead>
                <tbody class="break-words">

                    <tr v-if="projects.length == 0">
                        <td colspan="3" class="p-2 text-teal-600 rounded font-bold">You haven't created a projects.</td>
                    </tr>

                    <tr class="border-b border-gray-300 leading-8 odd:bg-white even:bg-gray-300" v-for="project in projects" :key="project.id">
                        <td class="leading-loose py-2">
                            <router-link :to="{name: 'show-project', params:{ id: project.id }}" class="text-teal-500 font-bold hover:text-teal-700 transition duration-700" v-text="project.title"></router-link>
                        </td>
                        <td class="leading-loose py-2">
                            <span class="bg-green-500 text-white rounded px-2 py-1" v-if="project.status === 'opened'">Open</span>
                            <span class="bg-teal-700 text-white rounded px-2 py-1" v-else>Closed</span>
                        </td>
                        <td class="leading-loose py-2">
                            <span class="px-2 bg-teal-600 rounded-full text-white">{{ project.opened_issues }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-right border-t border-gray-200 pt-2" v-show="! loading">
            <pagination @fetchData="fetchProjects"></pagination>
        </div>
    </div>
</template>

<script>
import loading from '../../partials/loading'
import { mapGetters } from 'vuex'
import pagination from '../../partials/pagination'

export default {
    name: 'projects-index',

    components: {loading, pagination},

    created() {
        this.fetchProjects()
    },

    computed: {
        ...mapGetters('managers/projects', ['projects']),
        ...mapGetters(['loading'])
    },

    methods: {
        fetchProjects(page_url) {
            this.$store.dispatch('managers/projects/fetchProjects', page_url)
        },
    }
}
</script>