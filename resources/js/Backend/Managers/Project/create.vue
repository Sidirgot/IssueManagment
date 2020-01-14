<template>
 <div class="container mx-auto">

        <div class="flex justify-between items-center">
            <h1 class="text-xl text-gray-600">Create New Project</h1>

            <router-link :to="{name: 'projects-index'}" class="self-end btn btn-teal text-white">Back <i class="fas fa-undo"></i> </router-link>
        </div>

        <loading></loading>

        <form class="my-3 w-full" method="POST" v-if="! loading">

            <div class="flex flex-col md:flex-row ">
                <div class="bg-white rounded shadow-lg p-2 my-3 md:mx-2 w-full">
                    <div class="my-2">
                        <label for="title">Title</label>
                        <input type="text" v-model="project.title" class="p-2 my-2 bg-gray-200 rounded block w-full" placeholder="Title" required>
                    </div>

                    <div class="my-2">
                        <label for="description">Description</label>
                        <textarea v-model="project.description" id="description" class="p-2 my-2 bg-gray-200 rounded block w-full" placeholder="Projects Description" cols="30" rows="10" required></textarea>
                    </div>

                    <div class="md:text-right md:mr-3">
                        <button @click.prevent="createProject" class="btn btn-indigo my-2 w-full md:w-1/4">Create Project <i class="fas fa-check"></i></button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</template>

<script>
import loading from  '../../partials/loading'
import { mapGetters } from 'vuex'

export default {
    name: 'projects-create',

    components: { loading },

    data() {
        return {
            project: {
                title: '',
                description: '',
            }
        }
    },

    computed: {
        ...mapGetters(['loading'])
    },

    methods: {
        createProject() {
            if (this.project.title && this.project.description) {
                this.$store.dispatch('managers/projects/createProject', this.project)
                           .then(response => {
                               this.$router.push({name: 'show-project', params: {id: response.data.id}})
                           })
            }
        }
    }
}
</script>