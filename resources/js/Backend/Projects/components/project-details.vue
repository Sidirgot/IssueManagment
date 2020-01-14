<template>
    <div class="w-full bg-white rounded shadow-lg md:mx-2 my-2 md:my-0 p-3 text-sm" v-if="! loading">
        <div class="flex justify-between items-center mb-3" v-if="isManager">
            <button @click="$modal.show('edit-project-details')" class="btn btn-yellow">Edit <i class="fas fa-edit"></i></button>
        </div>

        <div class="flex flex-col md:flex-row justify-around items-center border-b border-gray-200 pb-4">
                <p class="mx-2 text-sm my-2 md:my-0 px-2 rounded ">
                    <label class="mb-2 block ml-4">Created At:</label>
                    <span class="bg-teal-600 p-1 rounded text-white whitespace-no-wrap">{{ project.created_at }}</span>
                </p>

                <p class="mx-2 text-sm my-2 md:my-0 px-2 rounded">
                    <label class="mb-2 block ml-4">Last Updated At:</label>
                    <span class="bg-yellow-600 p-1 rounded text-white whitespace-no-wrap">{{ project.updated_at }}</span>
                </p>
        </div>

        <div class="my-2 pt-2">
            <label class="block mb-2 font-bold underline">Title: </label>
            <p class="bg-gray-200 p-2 ml-3 rounded" v-text="project.title"></p>
        </div>

        <div class="my-2">
            <label class="block mb-2 font-bold underline">Description: </label>
            <p class="bg-gray-200 p-2 ml-3 rounded tracking-wide" v-text="project.description"></p>
        </div>

        <editProjectDetails v-if="isManager"></editProjectDetails>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import editProjectDetails from '../../Managers/Project/modals/edit-project-details'

export default {
    name: 'project-details',

    components: { editProjectDetails },

    computed: {
        ...mapGetters('projects', ['project']),
        ...mapGetters(['isManager', 'loading'])

    },
}
</script>