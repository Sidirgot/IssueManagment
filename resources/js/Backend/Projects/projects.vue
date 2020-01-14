<template>
    <div class="container mx-auto">
        <h2 class="mb-3 text-xl text-gray-600 mb-6 mt-2">Assigned Projects</h2>

        <loading></loading>

        <div class="bg-white rounded shadow-lg p-4" v-show="! loading">
            <table class="table-fixed w-full  text-center text-sm">
                <thead class="bg-gray-200 rounded leading-loose">
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
                            <router-link :to="{name: 'show-project', params: {id: project.id }}" class="bg-teal-600 text-white px-4 py-1 rounded"><i class="fas fa-eye"></i></router-link>
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
