<template>
  <div class="container mx-auto">

    <loading></loading>

    <div class="bg-teal-600 p-4 rounded shadow-lg text-white text-center my-2" v-if="! loading && issue.status === 'closed'">
        This issue has been closed by {{ issue.closed_by.name}} on {{ issue.closed_on }}.
    </div>

    <div class="my-3" v-if="! loading">
      <h1 class="text-xl flex items-center">

        <router-link :to="{name: 'show-project', params: {id: project.id }}" class="btn btn-teal flex items-center mr-2">
          <svg width="20" height="20" class="inline-block" viewBox="0 0 20 20">
              <path fill="#fff" d="M3.24,7.51c-0.146,0.142-0.146,0.381,0,0.523l5.199,5.193c0.234,0.238,0.633,0.064,0.633-0.262v-2.634c0.105-0.007,0.212-0.011,0.321-0.011c2.373,0,4.302,1.91,4.302,4.258c0,0.957-0.33,1.809-1.008,2.602c-0.259,0.307,0.084,0.762,0.451,0.572c2.336-1.195,3.73-3.408,3.73-5.924c0-3.741-3.103-6.783-6.916-6.783c-0.307,0-0.615,0.028-0.881,0.063V2.575c0-0.327-0.398-0.5-0.633-0.261L3.24,7.51 M4.027,7.771l4.301-4.3v2.073c0,0.232,0.21,0.409,0.441,0.366c0.298-0.056,0.746-0.123,1.184-0.123c3.402,0,6.172,2.709,6.172,6.041c0,1.695-0.718,3.24-1.979,4.352c0.193-0.51,0.293-1.045,0.293-1.602c0-2.76-2.266-5-5.046-5c-0.256,0-0.528,0.018-0.747,0.05C8.465,9.653,8.328,9.81,8.328,9.995v2.074L4.027,7.771z"></path>
          </svg>
        </router-link>

        <button v-if="issue.status !== 'closed'" @click="$modal.show('close_issue', {issue})" class="btn btn-red flex items-center mr-1 whitespace-no-wrap">
          Close Issue
            <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                <path fill="#fff" d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
            </svg>
        </button>
      
        {{ issue.title }}
      </h1>

      <div class="flex justify-between flex-wrap items-center ml-2 text-gray-600 mt-2">
        <div class="whitespace-no-wrap my-1">
          <span class="rounded text-white p-1" :class="{'bg-green-600' : issue.status === 'opened', 'bg-red-600': issue.status === 'closed'}">{{ issue.status }}</span>
          {{ issue.created_at }} - {{ followups_count }} followups - priority
          <span class="h-3 w-3 rounded-full inline-block"
                          :class="{'bg-red-600' : issue.priority === 'high',
                                    'bg-yellow-600': issue.priority === 'medium',
                                    'bg-teal-600': issue.priority === 'low'}">
          </span>
        </div>

        <div v-if="issue.status != 'closed'">

          <button @click="$modal.show('create-followup')" class="btn btn-teal flex items-center ml-1 whitespace-no-wrap">
            Open followup
              <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                  <path fill="#fff" d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10"></path>
              </svg>
          </button>

        </div>

      </div>
    </div>

    <div class="flex flex-col md:flex-row" v-if="! loading">

      <!-- Left Sidebar -->
      <div class="w-full md:w-2/3 p-1">
      <!-- Opened Issue -->
        <div class="bg-white rounded shadow-lg">
          <div class="flex justify-between items-center bg-gray-300 p-2 rounded border">
            <h1 class="" v-text="issue.owner.name"></h1>

            <button class="text-yellow-700 text-sm flex items-center" v-if="issueOwner && issue.status === 'opened'">
                <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                    <path fill="#b7791f" d="M18.303,4.742l-1.454-1.455c-0.171-0.171-0.475-0.171-0.646,0l-3.061,3.064H2.019c-0.251,0-0.457,0.205-0.457,0.456v9.578c0,0.251,0.206,0.456,0.457,0.456h13.683c0.252,0,0.457-0.205,0.457-0.456V7.533l2.144-2.146C18.481,5.208,18.483,4.917,18.303,4.742 M15.258,15.929H2.476V7.263h9.754L9.695,9.792c-0.057,0.057-0.101,0.13-0.119,0.212L9.18,11.36h-3.98c-0.251,0-0.457,0.205-0.457,0.456c0,0.253,0.205,0.456,0.457,0.456h4.336c0.023,0,0.899,0.02,1.498-0.127c0.312-0.077,0.55-0.137,0.55-0.137c0.08-0.018,0.155-0.059,0.212-0.118l3.463-3.443V15.929z M11.241,11.156l-1.078,0.267l0.267-1.076l6.097-6.091l0.808,0.808L11.241,11.156z"></path>
                </svg>
            </button>
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
    <closeIssue />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import loading from '../partials/loading'
import followups from '../Followups/followups'
import createFollowup from '../Followups/modals/createfollowup'
import closeIssue from './modals/closeIssue'

export default {
  name: 'show-issue',

  components: { loading, followups, createFollowup, closeIssue },

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
}
</script>
