<template>
    <div v-if="followups">
        <transition-group name="fade" v-if="! loading">
            <div class="bg-white rounded shadow-lg my-2 mx-8" v-for="followup in followups" :key="followup.id">
                <div class="flex justify-between items-center bg-gray-300 p-2 rounded border">
                    <h1 class="" v-text="followup.owner.name"></h1>

                    <div v-if="isFollowupOwner(followup.owner.id) && issue.status == 'opened'">
                        
                        <button @click="$modal.show('delete-followup', {id: followup.id})" class="text-red-700 text-sm mr-6">
                            <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                                <path fill="#E53E3E" d="M17.114,3.923h-4.589V2.427c0-0.252-0.207-0.459-0.46-0.459H7.935c-0.252,0-0.459,0.207-0.459,0.459v1.496h-4.59c-0.252,0-0.459,0.205-0.459,0.459c0,0.252,0.207,0.459,0.459,0.459h1.51v12.732c0,0.252,0.207,0.459,0.459,0.459h10.29c0.254,0,0.459-0.207,0.459-0.459V4.841h1.511c0.252,0,0.459-0.207,0.459-0.459C17.573,4.127,17.366,3.923,17.114,3.923M8.394,2.886h3.214v0.918H8.394V2.886z M14.686,17.114H5.314V4.841h9.372V17.114z M12.525,7.306v7.344c0,0.252-0.207,0.459-0.46,0.459s-0.458-0.207-0.458-0.459V7.306c0-0.254,0.205-0.459,0.458-0.459S12.525,7.051,12.525,7.306M8.394,7.306v7.344c0,0.252-0.207,0.459-0.459,0.459s-0.459-0.207-0.459-0.459V7.306c0-0.254,0.207-0.459,0.459-0.459S8.394,7.051,8.394,7.306"></path>
                            </svg>
                        </button>
                        
                        <button @click="$modal.show('edit-followup', {id: followup.id})" class="text-yellow-700 text-sm">
                            <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                                <path fill="#b7791f" d="M18.303,4.742l-1.454-1.455c-0.171-0.171-0.475-0.171-0.646,0l-3.061,3.064H2.019c-0.251,0-0.457,0.205-0.457,0.456v9.578c0,0.251,0.206,0.456,0.457,0.456h13.683c0.252,0,0.457-0.205,0.457-0.456V7.533l2.144-2.146C18.481,5.208,18.483,4.917,18.303,4.742 M15.258,15.929H2.476V7.263h9.754L9.695,9.792c-0.057,0.057-0.101,0.13-0.119,0.212L9.18,11.36h-3.98c-0.251,0-0.457,0.205-0.457,0.456c0,0.253,0.205,0.456,0.457,0.456h4.336c0.023,0,0.899,0.02,1.498-0.127c0.312-0.077,0.55-0.137,0.55-0.137c0.08-0.018,0.155-0.059,0.212-0.118l3.463-3.443V15.929z M11.241,11.156l-1.078,0.267l0.267-1.076l6.097-6.091l0.808,0.808L11.241,11.156z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <p class="p-2" v-text="followup.body"></p>
            </div>
        </transition-group>


        <editFollowup></editFollowup>
        <deleteFollowup></deleteFollowup>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import editFollowup from './modals/editFollowup'
import deleteFollowup from './modals/deleteFollowup'

export default {
    name: 'followups',

    components:{ editFollowup, deleteFollowup },

    created() {
        this.$store.commit('followups/clear_followups')
        var payload = {project: this.project, issue: this.issue}
        this.$store.dispatch('followups/fetchFollowups', payload)
    },

    computed: {
        ...mapGetters(['loading','auth_user']),
        ...mapGetters('followups', ['followups']),
        ...mapGetters('issues', ['issue']),
        ...mapGetters('projects', ['project']),
    },

    methods: {
        isFollowupOwner(followup_owner_id) {
            return this.auth_user.id === followup_owner_id
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>