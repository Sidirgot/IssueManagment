<template>
    <modal name="edit-project-details" height="auto" :adaptive="true" :clickToClose="false">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Update Project Details</h1>

                <button @click="$modal.hide('edit-project-details')" class="self-end btn btn-teal text-white mx-2"><i class="fas fa-times"></i></button>
            </div>

            <loading></loading>

            <form class="my-3 w-full" method="POST" v-if="! loading">

                <div class="p-2 my-3 md:mx-2 w-full">
                    <div class="my-2">
                        <label for="title">Title</label>
                        <input type="text" v-model="project.title" class="p-2 my-2 bg-gray-200 rounded block w-full" placeholder="Title" required>
                    </div>

                    <div class="my-2">
                        <label for="description">Description</label>
                        <textarea v-model="project.description" class="p-2 my-2 bg-gray-200 rounded block w-full" placeholder="Projects Description" cols="30" rows="10" required></textarea>
                    </div>

                </div>

                <button type="submit" class="btn btn-teal w-full" @click.prevent="updateProject">Save Changes <i class="far fa-save"></i></button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex';
import loading from '../../../partials/loading'

export default {
    name:'edit-project-details',

    components: {loading},

    computed: {
        ...mapGetters('projects', ['project']),
        ...mapGetters(['loading'])
    },

    methods: {
        updateProject() {
            this.$store.dispatch('managers/projects/updateProject', this.project)
            this.$modal.hide('edit-project-details')
        },
    }
}
</script>