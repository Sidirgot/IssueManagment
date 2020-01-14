<template>
    <div class="w-full md:w-2/3 md:mx-2 my-2 md:my-0" v-if="! loading">

        <div class=" bg-white rounded shadow-lg p-3">
            <div class="flex justify-between items-center border-b border-gray-200 pb-1">
                <h1 class="text-lg">Testers</h1>
                <button v-if="isManager" @click="$modal.show('edit-testers')" class="btn btn btn-yellow">Edit <i class="fas fa-edit"></i></button>
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
                <button v-if="isManager" @click="$modal.show('edit-developers')" class="btn btn btn-yellow">Edit <i class="fas fa-edit"></i></button>
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