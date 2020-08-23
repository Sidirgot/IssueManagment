<template>
    <div class="container mx-auto">
        <h2 class="mb-3 text-xl text-gray-600 mb-6 mt-2">Assigned Projects</h2>

        <loading></loading>

        <div class="bg-white rounded shadow-lg p-4" v-show="! loading">
            <table class="table-fixed w-full  text-center text-sm">
                <thead class="bg-gray-300 rounded leading-10">
                    <th class="py-2">Title</th>
                    <th class="py-2">Opened Issues</th>
                </thead>
                <tbody>
                    <tr class="leading-loose border-b border-l border-r" v-for="project in projects" :key="project.id">
                        <td class="py-2">
                            <router-link :to="{name: 'show-project', params: {id: project.id }}" class="text-teal-700 font-bold tracking-wider hover:opacity-50 transition-opacity duration-700">
                                {{ project.title }}
                            </router-link>
                        </td>
                        <td class="leading-loose">
                            <span class="px-2 bg-teal-600 rounded-full text-white">{{ project.opened_issues }}</span>
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
