<template>
    <modal name="delete-followup" height="auto" :adaptive="true" :clickToClose="false" @before-open="fetchFollowup">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Delete Followup</h1>

                <button @click="$modal.hide('delete-followup')" class="self-end btn btn-teal text-white mx-2"><i class="fas fa-times"></i></button>
            </div>

            <form class="mt-4">
                <p class="bg-gray-200 text-red-600 p-4 rounded my-6">
                    <span class="text-red-600">Are you certain you want to delete this followup message?</span>
                </p>
                <button @click.prevent="deleteFollowup" class="btn btn-red w-full my-4">Delete Followup</button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'delete-followup',

    data() {
        return {
            followup: []
        }
    },

    computed: {
        ...mapGetters('followups', ['followups'])
    },

    methods: {
        fetchFollowup(event) {
            this.followup = this.followups.find(followup => followup.id === event.params.id)
        },

        deleteFollowup() {
            this.$store.dispatch('followups/deleteFollowup', this.followup)
            this.$modal.hide('delete-followup')
        }
    }
}
</script>