<template>
    <div class="flex flex-col my-4 text-sm border-t border-teal pt-8" v-if="! loading">
        <div class="flex justify-between items-center">
            <h1 class="text-xl text-gray-600">Issues</h1>

            <button @click="$modal.show('open-new-issue')" v-if="isTester && project.status == 'opened'" class="btn btn-teal flex items-center">Open New Issue
                <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                    <path fill="#fff" d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10"></path>
                </svg>
            </button>
        </div>

        <div class="w-full md:w-2/3 bg-white rounded shadow-lg p-4 my-4 self-center">
            <div class="my-2">
                <span>
                    <span class="h-3 w-3 rounded-full inline-block bg-red-600"></span>
                    High
                </span>

                <span>
                    <span class="h-3 w-3 rounded-full inline-block bg-yellow-600"></span>
                    Medium
                </span>

                <span>
                    <span class="h-3 w-3 rounded-full inline-block bg-teal-600"></span>
                    Low
                </span>
            </div>
            <div class="bg-gray-300 p-3 rounded flex flex-col md:flex-row items-center">
                <button @click="isActive = 'opened'" class="mx-2 btn btn-green my-3 md:my-0">
                    Opened ({{ project.opened_issues }})
                </button>
                <button @click="isActive = 'closed'" class="mx-2 btn btn-teal">
                    Closed ({{ project.closed_issues }})
                </button>
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

                    <span class="self-end flex items-center">
                        <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
							<path fill="#000" d="M17.659,3.681H8.468c-0.211,0-0.383,0.172-0.383,0.383v2.681H2.341c-0.21,0-0.383,0.172-0.383,0.383v6.126c0,0.211,0.172,0.383,0.383,0.383h1.532v2.298c0,0.566,0.554,0.368,0.653,0.27l2.569-2.567h4.437c0.21,0,0.383-0.172,0.383-0.383v-2.681h1.013l2.546,2.567c0.242,0.249,0.652,0.065,0.652-0.27v-2.298h1.533c0.211,0,0.383-0.172,0.383-0.382V4.063C18.042,3.853,17.87,3.681,17.659,3.681 M11.148,12.87H6.937c-0.102,0-0.199,0.04-0.27,0.113l-2.028,2.025v-1.756c0-0.211-0.172-0.383-0.383-0.383H2.724V7.51h5.361v2.68c0,0.21,0.172,0.382,0.383,0.382h2.68V12.87z M17.276,9.807h-1.533c-0.211,0-0.383,0.172-0.383,0.383v1.755L13.356,9.92c-0.07-0.073-0.169-0.113-0.27-0.113H8.851v-5.36h8.425V9.807z"></path>
						</svg>
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

                    <span class="self-end flex items-center">
                        <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
							<path fill="#000" d="M17.659,3.681H8.468c-0.211,0-0.383,0.172-0.383,0.383v2.681H2.341c-0.21,0-0.383,0.172-0.383,0.383v6.126c0,0.211,0.172,0.383,0.383,0.383h1.532v2.298c0,0.566,0.554,0.368,0.653,0.27l2.569-2.567h4.437c0.21,0,0.383-0.172,0.383-0.383v-2.681h1.013l2.546,2.567c0.242,0.249,0.652,0.065,0.652-0.27v-2.298h1.533c0.211,0,0.383-0.172,0.383-0.382V4.063C18.042,3.853,17.87,3.681,17.659,3.681 M11.148,12.87H6.937c-0.102,0-0.199,0.04-0.27,0.113l-2.028,2.025v-1.756c0-0.211-0.172-0.383-0.383-0.383H2.724V7.51h5.361v2.68c0,0.21,0.172,0.382,0.383,0.382h2.68V12.87z M17.276,9.807h-1.533c-0.211,0-0.383,0.172-0.383,0.383v1.755L13.356,9.92c-0.07-0.073-0.169-0.113-0.27-0.113H8.851v-5.36h8.425V9.807z"></path>
						</svg>
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
