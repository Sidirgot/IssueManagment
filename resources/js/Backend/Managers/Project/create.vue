<template>
 <div class="container mx-auto">

        <div class="flex items-center">

            <router-link :to="{name: 'projects-index'}" class="self-end btn btn-teal text-white mr-2">
                <svg width="20" height="20" class="inline-block" viewBox="0 0 20 20">
                    <path fill="#fff" d="M3.24,7.51c-0.146,0.142-0.146,0.381,0,0.523l5.199,5.193c0.234,0.238,0.633,0.064,0.633-0.262v-2.634c0.105-0.007,0.212-0.011,0.321-0.011c2.373,0,4.302,1.91,4.302,4.258c0,0.957-0.33,1.809-1.008,2.602c-0.259,0.307,0.084,0.762,0.451,0.572c2.336-1.195,3.73-3.408,3.73-5.924c0-3.741-3.103-6.783-6.916-6.783c-0.307,0-0.615,0.028-0.881,0.063V2.575c0-0.327-0.398-0.5-0.633-0.261L3.24,7.51 M4.027,7.771l4.301-4.3v2.073c0,0.232,0.21,0.409,0.441,0.366c0.298-0.056,0.746-0.123,1.184-0.123c3.402,0,6.172,2.709,6.172,6.041c0,1.695-0.718,3.24-1.979,4.352c0.193-0.51,0.293-1.045,0.293-1.602c0-2.76-2.266-5-5.046-5c-0.256,0-0.528,0.018-0.747,0.05C8.465,9.653,8.328,9.81,8.328,9.995v2.074L4.027,7.771z"></path>
                </svg>
            </router-link>

            <h1 class="text-xl text-gray-600">Create New Project</h1>
        </div>

        <loading></loading>

        <form class="my-3 w-full" method="POST" v-if="! loading">

            <div class="flex flex-col md:flex-row ">
                <div class="bg-white rounded shadow-lg p-2 my-3 md:mx-2 w-full">
                    <div class="my-2">
                        <label for="title">Title</label>
                        <input type="text" v-model="project.title" class="p-2 my-2 bg-gray-300 rounded block w-full" placeholder="Title" required>
                    </div>

                    <div class="my-2">
                        <label for="description">Description</label>
                        <textarea v-model="project.description" id="description" class="p-2 my-2 bg-gray-300 rounded block w-full" placeholder="Projects Description" cols="30" rows="10" required></textarea>
                    </div>

                    <div class="md:text-right md:mr-3">
                        <button @click.prevent="createProject" class="btn btn-indigo my-2 w-full md:w-1/4">Create Project</button>
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