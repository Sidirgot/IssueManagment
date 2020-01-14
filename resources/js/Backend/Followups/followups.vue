<template>
    <div v-if="followups">
        <transition-group name="fade" v-if="! loading">
            <div class="bg-white rounded shadow-lg my-2 mx-8" v-for="followup in followups" :key="followup.id">
                <div class="flex justify-between items-center bg-gray-200 p-2 rounded border">
                    <h1 class="" v-text="followup.owner.name"></h1>

                    <div v-if="isFollowupOwner(followup.owner.id) && issue.status == 'opened'">
                        <button @click="$modal.show('delete-followup', {id: followup.id})" class="text-red-700 text-sm mr-6"><i class="fas fa-trash"></i></button>
                        <button @click="$modal.show('edit-followup', {id: followup.id})" class="text-yellow-700 text-sm"><i class="fas fa-edit"></i></button>
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