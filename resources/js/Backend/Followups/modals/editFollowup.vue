<template>
    <modal name="edit-followup" height="auto" :adaptive="true" :clickToClose="false" @before-open="fetchFollowup">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Edit Followup</h1>

                <button @click="$modal.hide('edit-followup')" class="self-end btn btn-teal text-white mx-2"><i class="fas fa-times"></i></button>
            </div>

            <form class="mt-4">
                <textarea v-model="followup.body" id="" cols="30" rows="10" class="p-2 bg-gray-200 w-full rounded" placeholder="Followup description" required></textarea>

                <button @click.prevent="updateFollowup" class="btn btn-teal w-full my-4">Update Followup</button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'edit-followup',

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

        updateFollowup() {
            this.$store.dispatch('followups/updateFollowup', this.followup)
            this.$modal.hide('edit-followup')
        }
    }
}
</script>