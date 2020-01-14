<template>
  <div class="container mx-auto">

    <loading></loading>

    <div class="flex justify-end" v-if="! loading">
      <router-link :to="{name: 'show-project', params: {id: project.id }}" class="btn btn-teal">Back <i class="fas fa-undo"></i></router-link>
    </div>

    <div class="bg-teal-600 p-4 rounded shadow-lg text-white text-center my-2" v-if="! loading && issue.status === 'closed'">
        This issue has been closed by {{ issue.closed_by.name}} on {{ issue.closed_on }}.
    </div>

    <div class="my-3" v-if="! loading">
      <h1 class="text-xl" v-text="issue.title"></h1>

      <div class="flex justify-between items-center ml-2 text-gray-600 mt-2">
        <div>
          <span class="rounded text-white p-1" :class="{'bg-green-600' : issue.status === 'opened', 'bg-red-600': issue.status === 'closed'}">{{ issue.status }}</span>
          {{ issue.created_at }} - {{ followups_count }} followups - priority
          <span class="h-3 w-3 rounded-full inline-block"
                          :class="{'bg-red-600' : issue.priority === 'high',
                                    'bg-yellow-600': issue.priority === 'medium',
                                    'bg-teal-600': issue.priority === 'low'}">
          </span>
        </div>

        <div v-if="issue.status != 'closed'">
          <button @click="closeIssue" class="btn btn-yellow" >Close Issue <i class="fas fa-lock"></i></button>
          <button @click="$modal.show('create-followup')" class="btn btn-teal">
            Open followup
            <span class="px-2 py-1 bg-teal-700 rounded-full"><i class="fas fa-plus"></i></span>
          </button>
        </div>
      </div>
    </div>

    <div class="flex flex-col md:flex-row" v-if="! loading">

      <!-- Left Sidebar -->
      <div class="w-full md:w-2/3 p-1">
      <!-- Opened Issue -->
        <div class="bg-white rounded shadow-lg">
          <div class="flex justify-between items-center bg-gray-200 p-2 rounded border">
            <h1 class="" v-text="issue.owner.name"></h1>

            <button class="text-yellow-700 text-sm" v-if="issueOwner && issue.status === 'opened'"><i class="fas fa-edit"></i></button>
          </div>

          <p class="p-2" v-text="issue.description"></p>

        </div>
        <!-- End Opened Issue -->

        <!-- Issue followups -->
        <div class="pt-6">
          <followups></followups>
        </div>
        <!-- End Issue followups -->
      </div>
      <!-- End Left Sidebar -->

      <!-- Right sidebar -->
      <div class="w-full md:w-1/3 p-1 text-sm">
      <!-- Project Manager Box -->
        <div class="mb-2 bg-white rounded shadow-lg p-3">
            <span class="block mb-3 border-b pb-1">Project Manager</span>
            <span class="bg-teal-600 text-white rounded px-1 mx-2 my-1" v-text="project.manager.name"></span>
        </div>

        <!-- Project Testers Box -->
        <div class="my-2 bg-white rounded shadow-lg p-3 text-sm">
          <h1 class="border-b pb-1">Testers</h1>

          <div class="flex flex-wrap my-2">
              <span v-for="tester in project.project_testers" :key="tester.name" class="bg-teal-600 text-white rounded px-1 mx-2 my-1">
                  {{ tester.name }}
              </span>

              <p v-if="project.project_testers == 0" class="text-center bg-teal-600 text-white rounded my-3 p-1">No Testers Assigned To This Project</p>
          </div>
        </div>

        <!-- Project Developers Box -->
        <div class="my-2 bg-white rounded shadow-lg p-3 text-sm">

          <h1 class="border-b pb-1">Developers</h1>

          <div class="flex flex-wrap my-2">
              <span v-for="developer in project.project_developers" :key="developer.id" class="bg-teal-600 text-white rounded px-1 mx-2 my-1">
                  {{ developer.name }}
              </span>

              <p v-if="project.project_developers == 0" class=" text-center bg-teal-600 text-white rounded my-3 p-1 text-sm">No Developers Assigned To This Project</p>
          </div>
        </div>
      </div>
      <!-- End of right sidebar -->

    </div>

    <createFollowup />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import loading from '../partials/loading'
import followups from '../Followups/followups'
import createFollowup from '../Followups/modals/createfollowup'

export default {
  name: 'show-issue',

  components: { loading, followups, createFollowup },

  created() {
    if (! this.project.id) {
      this.$store.dispatch('projects/fetchProject', this.$route.params.projectId)
      this.$store.dispatch('issues/fetchProjectIssue', this.$route.params)
    }

    if (this.issues.length) {
      this.$store.commit('issues/findIssue', this.$route.params.issueId)
    }
  },

  computed: {
    ...mapGetters('projects', ['project']),
    ...mapGetters('issues', ['issue', 'issues']),
    ...mapGetters('followups', ['followups_count']),
    ...mapGetters(['loading', 'auth_user']),

    issueOwner() {
      return this.auth_user.id === this.issue.owner.id
    }
  },

  methods: {
    closeIssue() {

      var payload = {issue: this.issue, project: this.project}

      this.$store.dispatch('issues/closeIssue', payload)

      this.$router.push({name: 'show-project', params: {id:  this.$route.params.projectId}})

    },
  }
}
</script>
