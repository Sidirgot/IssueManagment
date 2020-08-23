<template>
    <modal name="create-followup" height="auto" :adaptive="true" :clickToClose="false">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Open Followup</h1>

                <button @click="$modal.hide('create-followup')" class="self-end btn btn-teal text-white mx-2">X</button>
            </div>

            <form class="mt-4">
                <textarea v-model="followup.body" id="" cols="30" rows="10" class="p-2 bg-gray-300 w-full rounded" placeholder="Followup description" required></textarea>

                <button @click.prevent="openFollowup" class="btn btn-teal w-full my-4">Open Followup</button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'create-followup',

    data() {
        return {
            followup: {
                body: ''
            }
        }
    },

    computed: {
        ...mapGetters('projects', ['project']),
        ...mapGetters('issues', ['issue'])
    },

    methods: {
        openFollowup() {
            if (this.followup.body) {
                var payload = {project: this.project, issue: this.issue, followup: this.followup}
                this.$store.dispatch('followups/openFollowup', payload)
                this.$modal.hide('create-followup')
            }
        }
    }
}
</script>