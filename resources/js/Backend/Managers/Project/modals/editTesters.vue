<template>
    <modal name="edit-testers" height="auto" :adaptive="true" :clickToClose="false" @before-open="fetchTesters">
        <div class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-2">
                <h1 class="self-start text-xl text-gray-600">Update Project Testers</h1>

                <button @click="$modal.hide('edit-testers')" class="self-end btn btn-teal text-white mx-2">X</button>
            </div>

            <loading></loading>

            <div class="mt-2" v-show="! loading">
                <label for="role">Testers</label>
                <select v-model="selected" class="appearance-none block bg-gray-300 p-2 mt-2 mb-8 rounded w-full" required>
                    <option v-if="testers.length === 0">No Testers Availiable</option>
                    <option v-for="tester in testers" :key="tester.name" :value="tester" class="text-blue" v-text="tester.name"></option>
                </select>

                <div>
                    <label>Assigned Developers: </label>
                    <div class="flex flex-wrap w-full p-3 bg-gray-300 rounded my-2">
                        <span v-for="tester in project.project_testers" :key="tester.id" class="bg-teal-600 text-white rounded px-1 mx-2 my-1">
                            {{ tester.name }}
                            <button @click.prevent="removeTester(tester)" class="bg-teal-700 text-sm hover:opacity-50 px-2 my-1 rounded" >x</button>
                        </span>
                    </div>

                    <p v-if="project.project_testers == 0" class="text-sm text-center bg-teal-600 text-white rounded my-3">No Testers Assigned To This Project</p>

                </div>

                <button @click="addTester" class="btn btn-teal w-full my-4">Assign Tester</button>
            </div>
        </div>

    </modal>
</template>

<script>
import { mapGetters } from 'vuex'
import loading  from '../../../partials/loading'

export default {
    name: 'edit-testers',

    components: {loading},

    data() {
        return {
            selected: '',
        }
    },

    computed: {
        ...mapGetters('projects', ['project']),
        ...mapGetters(['loading']),
        ...mapGetters('managers/projects', ['testers'])
    },

    methods: {
        fetchTesters(){
            this.$store.dispatch('managers/projects/fetchTesters', this.project)
        },

        addTester() {
            if(this.selected) {
                var payload = {project: this.project, tester: this.selected}
                this.$store.dispatch('managers/projects/assignTester', payload)
                this.selected = ''
            }
        },

        removeTester(tester) {
            var payload = {project: this.project, tester: tester}
            this.$store.dispatch('managers/projects/removeTester', payload)
        },
    }
}
</script>