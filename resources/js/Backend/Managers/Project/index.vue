<template>
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h1 class="self-start text-xl text-gray-600 my-3 md:my-0">Project Management</h1>

            <router-link :to="{name: 'projects-create'}" class="self-end btn btn-teal text-white">Create New Project <i class="fas fa-plus"></i> </router-link>
        </div>

        <loading></loading>

        <div class="bg-white rounded shadow-lg p-3 mt-4 mx-2" v-show="! loading">
            <table class="table-fixed w-full  text-center text-sm">
                <thead class="bg-gray-200 rounded">
                    <th class="py-2">Title</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Opened Issues</th>
                </thead>
                <tbody class="break-words">
                    <tr v-if="projects.length == 0">
                        <td colspan="3" class="p-2 text-teal-600 rounded font-bold">You haven't created a projects.</td>
                    </tr>
                    <tr class="border-b border-gray-200" v-for="project in projects" :key="project.id">
                        <td class="leading-loose">
                            <router-link :to="{name: 'show-project', params:{ id: project.id }}" class="text-teal-500 font-bold hover:text-teal-700" v-text="project.title"></router-link>
                        </td>
                        <td class="leading-loose">
                            <span class="bg-green-500 text-white rounded px-2 py-1" v-if="project.status === 'opened'">Open</span>
                            <span class="bg-teal-700 text-white rounded px-2 py-1" v-else>Closed</span>
                        </td>
                        <td class="leading-loose">
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