<template>
    <div class="w-full bg-white rounded shadow-lg md:mx-2 my-2 md:my-0 p-3 text-sm" v-if="! loading">
        <div class="flex justify-between items-center mb-3" v-if="isManager">
            <button @click="$modal.show('edit-project-details')" class="hover:opacity-50 transition-opacity duration-700 focus:outline-none">
                <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                    <path fill="#b7791f" d="M18.303,4.742l-1.454-1.455c-0.171-0.171-0.475-0.171-0.646,0l-3.061,3.064H2.019c-0.251,0-0.457,0.205-0.457,0.456v9.578c0,0.251,0.206,0.456,0.457,0.456h13.683c0.252,0,0.457-0.205,0.457-0.456V7.533l2.144-2.146C18.481,5.208,18.483,4.917,18.303,4.742 M15.258,15.929H2.476V7.263h9.754L9.695,9.792c-0.057,0.057-0.101,0.13-0.119,0.212L9.18,11.36h-3.98c-0.251,0-0.457,0.205-0.457,0.456c0,0.253,0.205,0.456,0.457,0.456h4.336c0.023,0,0.899,0.02,1.498-0.127c0.312-0.077,0.55-0.137,0.55-0.137c0.08-0.018,0.155-0.059,0.212-0.118l3.463-3.443V15.929z M11.241,11.156l-1.078,0.267l0.267-1.076l6.097-6.091l0.808,0.808L11.241,11.156z"></path>
                </svg>
            </button>
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
            <p class="bg-gray-300 p-2 ml-3 rounded" v-text="project.title"></p>
        </div>

        <div class="my-2">
            <label class="block mb-2 font-bold underline">Description: </label>
            <p class="bg-gray-300 p-2 ml-3 rounded tracking-wide" v-text="project.description"></p>
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