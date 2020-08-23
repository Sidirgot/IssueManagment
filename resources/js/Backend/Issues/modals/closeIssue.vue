<template>
    <modal name="close_issue" height="auto" :adaptive="true" :clickToClose="false" @before-open="beforeOpen">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Close Issue</h1>

                <button @click="$modal.hide('close_issue')" class="self-end btn btn-teal text-white mx-2">X</button>
            </div>

            <form @submit.prevent="openIssue" class="my-3 mx-3" method="post">

                 <p class="bg-gray-300 text-red-600 p-4 rounded my-6">
                    <span class="text-red-600">Are you certain you want to close this issue ?</span>
                </p>

                 <button type="submit" class="btn btn-red my-2 w-full">Close Issue</button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'close_issue',

    data() {
        return {
            issue: {}
        }
    },

    computed: {
        ...mapGetters('projects', ['project']),
    },

    methods: {

        beforeOpen(event) {
            this.issue = event.params.issue
        },
    }
}
</script>
