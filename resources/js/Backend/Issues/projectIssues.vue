<template>
    <div class="flex flex-col my-4 text-sm border-t border-teal pt-8" v-if="! loading">
        <div class="flex justify-between items-center">
            <h1 class="text-xl text-gray-600">Issues</h1>

            <button @click="$modal.show('open-new-issue')" v-if="isTester && project.status == 'opened'" class="btn btn-teal">Open New Issue
                <span class="px-2 py-1 bg-teal-700 rounded-full"><i class="fas fa-plus"></i></span>
            </button>
        </div>

        <div class="w-full md:w-2/3 bg-white rounded shadow-lg p-4 my-4 self-center">
            <div class="bg-gray-200 p-3 rounded flex flex-col md:flex-row items-center">
                <button @click="isActive = 'opened'" class="mx-2 btn btn-green my-3 md:my-0">Opened ({{ project.opened_issues }}) <i class="fas fa-info-circle"></i></button>
                <button @click="isActive = 'closed'" class="mx-2 btn btn-teal">Closed ({{ project.closed_issues }}) <i class="fas fa-check"></i></button>
            </div>

            <div v-if="isActive === 'opened'">
                <div class="flex flex-col md:flex-row justify-between items-center border-b border-r border-l p-4" v-for="issue in openedIssues" :key="issue.id">
                    <div>
                        <span class="h-3 w-3 rounded-full inline-block"
                            :class="{'bg-red-600' : issue.priority === 'high',
                                     'bg-yellow-600': issue.priority === 'medium',
                                     'bg-teal-600': issue.priority === 'low'}">
                        </span>

                        <router-link :to="{name: 'show-issue', params: {projectId: project.id, issueId: issue.id }}" class="hover:opacity-75 cursor-pointer">
                            <span v-text="issue.title"></span>
                        </router-link>

                        <span class="ml-3 block text-sm text-gray-600" v-if="issue.owner != null"># Opened {{ issue.created_at }}. By {{ issue.owner.name }}</span>
                    </div>

                    <span class="self-end">
                        <i class="far fa-comments"></i>
                        {{ issue.followups.length }}
                    </span>
                </div>
            </div>

            <div v-if="isActive === 'closed'">
                <div class="flex flex-col md:flex-row justify-between items-center  border-b border-r border-l p-4" v-for="issue in closedIssues" :key="issue.id">
                    <div>
                        <span class="h-3 w-3 rounded-full inline-block"
                            :class="{'bg-red-600' : issue.priority === 'high',
                                     'bg-yellow-600': issue.priority === 'medium',
                                     'bg-teal-600': issue.priority === 'low'}">
                        </span>

                        <router-link :to="{name: 'show-issue', params: {projectId: project.id, issueId: issue.id }}" class="hover:opacity-75 cursor-pointer">
                            <span v-text="issue.title"></span>
                        </router-link>

                        <span class="ml-3 block text-sm text-gray-600"># Closed on {{ issue.closed_on }}. By {{ issue.closed_by.name }}</span>
                    </div>

                    <span class="self-end">
                        <i class="far fa-comments"></i>
                        {{ issue.followups.length }}
                    </span>
                </div>
            </div>
        </div>

        <openNewIssue />
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import openNewIssue from './modals/openNewIssue'

export default {
    name: 'project-issues',

    components: { openNewIssue },

    data() {
        return {
            isActive: 'opened'
        }
    },

    watch: {
      project: function() {
        this.issueCreatedEvent()
      }
    },

    computed: {
        ...mapGetters('projects', ['project']),
        ...mapGetters('issues', ['openedIssues', 'closedIssues']),
        ...mapGetters(['loading','isTester'])
    },

    methods: {
      issueCreatedEvent() {
          Echo.channel('project-issues.'+ this.project.id)
              .listen('IssueCreated', (event) => {
                  this.$store.commit('issues/push_new_issue', event.issue)
              } )
      }
    }
}
</script>
