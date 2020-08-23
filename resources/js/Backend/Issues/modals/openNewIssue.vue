<template>
    <modal name="open-new-issue" height="auto" :adaptive="true" :clickToClose="false">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Open New Issue</h1>

                <button @click="$modal.hide('open-new-issue')" class="self-end btn btn-teal text-white mx-2">X</button>
            </div>

            <form @submit.prevent="openIssue" class="my-3 mx-3" method="post">
                <div class="my-2">
                    <label for="title">Title</label>
                    <input type="text" v-model="issue.title" class="p-2 my-2 bg-gray-300 rounded block ml-3 w-full" placeholder="Issue Title" required>
                </div>

                <div class="my-2">
                    <label for="description">Description</label>
                    <textarea v-model="issue.description" class="p-2 my-2 bg-gray-300 rounded block ml-3 w-full" placeholder="Issue Description" required rows="12"></textarea>
                </div>

                <div class="my-2">
                    <label for="priority">Priority</label>
                    <select v-model="issue.priority" class="appearance-none block bg-gray-300 p-2 my-2 ml-3 rounded w-full" required>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>

                 <button type="submit" class="btn btn-teal my-2 w-full">Open Issue</button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'open-new-issue',

    data() {
        return {
            issue: {
                title: '',
                description: '',
                priority: ''
            }
        }
    },

    computed: {
        ...mapGetters('projects', ['project']),
    },

    methods: {
        openIssue() {
            if (this.issue.title && this.issue.description && this.issue.priority) {

                var payload = {issue: this.issue, project: this.project}

                this.$store.dispatch('issues/OpenIssue', payload ).then( response => {
                    this.$modal.hide('open-new-issue')
                    this.$router.push({name: 'show-issue', params: {projectId: this.project.id, issueId: response.data.id}})
                })
            }
        }
    }
}
</script>
