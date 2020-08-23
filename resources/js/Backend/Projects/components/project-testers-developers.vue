<template>
    <div class="w-full md:w-2/3 md:mx-2 my-2 md:my-0" v-if="! loading">

        <div class=" bg-white rounded shadow-lg p-3">
            <div class="flex justify-between items-center border-b border-gray-200 pb-1">
                <h1 class="text-lg">Testers</h1>
                <button v-if="isManager" @click="$modal.show('edit-testers')" class=" hover:opacity-50 transition-opacity duration-700 focus:outline-none">
                    <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                        <path fill="#b7791f" d="M18.303,4.742l-1.454-1.455c-0.171-0.171-0.475-0.171-0.646,0l-3.061,3.064H2.019c-0.251,0-0.457,0.205-0.457,0.456v9.578c0,0.251,0.206,0.456,0.457,0.456h13.683c0.252,0,0.457-0.205,0.457-0.456V7.533l2.144-2.146C18.481,5.208,18.483,4.917,18.303,4.742 M15.258,15.929H2.476V7.263h9.754L9.695,9.792c-0.057,0.057-0.101,0.13-0.119,0.212L9.18,11.36h-3.98c-0.251,0-0.457,0.205-0.457,0.456c0,0.253,0.205,0.456,0.457,0.456h4.336c0.023,0,0.899,0.02,1.498-0.127c0.312-0.077,0.55-0.137,0.55-0.137c0.08-0.018,0.155-0.059,0.212-0.118l3.463-3.443V15.929z M11.241,11.156l-1.078,0.267l0.267-1.076l6.097-6.091l0.808,0.808L11.241,11.156z"></path>
                    </svg>
                </button>
            </div>

            <div class="flex flex-wrap my-2">
                <span v-for="tester in project.project_testers" :key="tester.name" class="bg-teal-600 text-white rounded px-1 mx-2 my-1">
                    {{ tester.name }}
                </span>

                <p v-if="project.project_testers == 0" class="text-sm text-center bg-teal-600 text-white rounded my-3 p-1">No Testers Assigned To This Project</p>
            </div>
        </div>

        <div class="my-2 bg-white rounded shadow-lg p-3">
            <div class="flex justify-between items-center border-b border-gray-200 pb-1">
                <h1 class="text-lg">Developers</h1>
                <button v-if="isManager" @click="$modal.show('edit-developers')" class="hover:opacity-50 transition-opacity duration-700 focus:outline-none">
                    <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                        <path fill="#b7791f" d="M18.303,4.742l-1.454-1.455c-0.171-0.171-0.475-0.171-0.646,0l-3.061,3.064H2.019c-0.251,0-0.457,0.205-0.457,0.456v9.578c0,0.251,0.206,0.456,0.457,0.456h13.683c0.252,0,0.457-0.205,0.457-0.456V7.533l2.144-2.146C18.481,5.208,18.483,4.917,18.303,4.742 M15.258,15.929H2.476V7.263h9.754L9.695,9.792c-0.057,0.057-0.101,0.13-0.119,0.212L9.18,11.36h-3.98c-0.251,0-0.457,0.205-0.457,0.456c0,0.253,0.205,0.456,0.457,0.456h4.336c0.023,0,0.899,0.02,1.498-0.127c0.312-0.077,0.55-0.137,0.55-0.137c0.08-0.018,0.155-0.059,0.212-0.118l3.463-3.443V15.929z M11.241,11.156l-1.078,0.267l0.267-1.076l6.097-6.091l0.808,0.808L11.241,11.156z"></path>
                    </svg>
                </button>
            </div>
            <div class="flex flex-wrap my-2">
                <span v-for="developer in project.project_developers" :key="developer.id" class="bg-teal-600 text-white rounded px-1 mx-2 my-1">
                    {{ developer.name }}
                </span>

                <p v-if="project.project_developers == 0" class="text-sm text-center bg-teal-600 text-white rounded my-3 p-1">No Developers Assigned To This Project</p>
            </div>
        </div>

        <editTesters v-if="isManager"></editTesters>
        <editDevelopers v-if="isManager"></editDevelopers>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import editTesters from '../../Managers/Project/modals/editTesters'
import editDevelopers from '../../Managers/Project/modals/editDevelopers'

export default {
    name: 'project-testers-developers',

    components: { editTesters, editDevelopers },

    computed: {
        ...mapGetters('projects', ['project']),
        ...mapGetters(['isManager', 'loading'])
    }
}
</script>