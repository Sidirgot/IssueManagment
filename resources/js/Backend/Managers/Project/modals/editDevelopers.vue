<template>
    <modal name="edit-developers" height="auto" :adaptive="true" :clickToClose="false" @before-open="fetchDevelopers">
        <div class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-2">
                <h1 class="self-start text-xl text-gray-600">Update Project Testers</h1>

                <button @click="$modal.hide('edit-developers')" class="self-end btn btn-teal text-white mx-2"><i class="fas fa-times"></i></button>
            </div>

            <loading></loading>

            <div class="mt-2" v-show="! loading">
                <label>Select a Developer: </label>
                <select v-model="selected" class="appearance-none block bg-gray-200 p-2 mt-2 mb-8 rounded w-full" required>
                    <option v-if="developers.length === 0">No Developers Availiable</option>
                    <option v-for="developer in developers" :key="developer.name" :value="developer" class="text-blue" v-text="developer.name"></option>
                </select>

                <div>
                    <label>Assigned Developers: </label>
                    <div class="flex flex-wrap w-full p-3 bg-gray-200 rounded my-2">
                        <span v-for="developer in project.project_developers" :key="developer.id" class="bg-teal-600 text-white rounded px-1 mx-2 my-1">
                            {{ developer.name }}
                            <button @click.prevent="removeDeveloper(developer)" class="bg-teal-700 text-sm hover:opacity-50 px-1 my-1 rounded" ><i class="fas fa-times"></i></button>
                        </span>
                    </div>

                    <p v-if="project.project_developers == 0" class="text-sm text-center bg-teal-600 text-white rounded my-3">No Developers Assigned To This Project</p>

                </div>

                <button @click="addDeveloper" class="btn btn-teal w-full my-4">Assign Developer</button>
            </div>
        </div>

    </modal>
</template>

<script>
import { mapGetters } from 'vuex'
import loading  from '../../../partials/loading'

export default {
    name: 'editDevelopers',

    components: {loading},

    data() {
        return {
            selected: '',
        }
    },

    computed: {
        ...mapGetters('managers/projects', ['developers']),
        ...mapGetters('projects', ['project']),
        ...mapGetters(['loading'])
    },

    methods: {
        fetchDevelopers() {
            this.$store.dispatch('managers/projects/fetchDevelopers', this.project)
        },

        addDeveloper() {
            if(this.selected) {
                var payload = { project: this.project, developer: this.selected }
                this.$store.dispatch('managers/projects/assignDeveloper', payload)
                this.selected = ''
            }
        },

        removeDeveloper(developer) {
            var payload = { project: this.project, developer: developer }
            this.$store.dispatch('managers/projects/removeDeveloper', payload)
        }
    }
}
</script>