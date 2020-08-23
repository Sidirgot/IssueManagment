<template>
    <div class="container mx-auto">

        <router-link :to="{name: 'users-index'}" class="btn btn-teal">
            <svg width="20" height="20" class="inline-block" viewBox="0 0 20 20">
                <path fill="#fff" d="M3.24,7.51c-0.146,0.142-0.146,0.381,0,0.523l5.199,5.193c0.234,0.238,0.633,0.064,0.633-0.262v-2.634c0.105-0.007,0.212-0.011,0.321-0.011c2.373,0,4.302,1.91,4.302,4.258c0,0.957-0.33,1.809-1.008,2.602c-0.259,0.307,0.084,0.762,0.451,0.572c2.336-1.195,3.73-3.408,3.73-5.924c0-3.741-3.103-6.783-6.916-6.783c-0.307,0-0.615,0.028-0.881,0.063V2.575c0-0.327-0.398-0.5-0.633-0.261L3.24,7.51 M4.027,7.771l4.301-4.3v2.073c0,0.232,0.21,0.409,0.441,0.366c0.298-0.056,0.746-0.123,1.184-0.123c3.402,0,6.172,2.709,6.172,6.041c0,1.695-0.718,3.24-1.979,4.352c0.193-0.51,0.293-1.045,0.293-1.602c0-2.76-2.266-5-5.046-5c-0.256,0-0.528,0.018-0.747,0.05C8.465,9.653,8.328,9.81,8.328,9.995v2.074L4.027,7.771z"></path>
            </svg>
        </router-link>

         <div class="flex flex-col md:flex-row justify-between items-center mt-2">
            <h1 class="self-start text-lg text-gray-600 my-3 md:my-0">
                Users Profile
            </h1>

            <div class="self-end flex">
                <button @click.prevent="$modal.show('user-delete')" class="btn btn-red text-white mx-2">
                    <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                        <path fill="#fff" d="M17.114,3.923h-4.589V2.427c0-0.252-0.207-0.459-0.46-0.459H7.935c-0.252,0-0.459,0.207-0.459,0.459v1.496h-4.59c-0.252,0-0.459,0.205-0.459,0.459c0,0.252,0.207,0.459,0.459,0.459h1.51v12.732c0,0.252,0.207,0.459,0.459,0.459h10.29c0.254,0,0.459-0.207,0.459-0.459V4.841h1.511c0.252,0,0.459-0.207,0.459-0.459C17.573,4.127,17.366,3.923,17.114,3.923M8.394,2.886h3.214v0.918H8.394V2.886z M14.686,17.114H5.314V4.841h9.372V17.114z M12.525,7.306v7.344c0,0.252-0.207,0.459-0.46,0.459s-0.458-0.207-0.458-0.459V7.306c0-0.254,0.205-0.459,0.458-0.459S12.525,7.051,12.525,7.306M8.394,7.306v7.344c0,0.252-0.207,0.459-0.459,0.459s-0.459-0.207-0.459-0.459V7.306c0-0.254,0.207-0.459,0.459-0.459S8.394,7.051,8.394,7.306"></path>
                    </svg>
                </button>

                <button @click.prevent="$modal.show('edit-user')" class="btn btn-yellow text-white mx-2">
                    <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                        <path fill="#fff" d="M18.303,4.742l-1.454-1.455c-0.171-0.171-0.475-0.171-0.646,0l-3.061,3.064H2.019c-0.251,0-0.457,0.205-0.457,0.456v9.578c0,0.251,0.206,0.456,0.457,0.456h13.683c0.252,0,0.457-0.205,0.457-0.456V7.533l2.144-2.146C18.481,5.208,18.483,4.917,18.303,4.742 M15.258,15.929H2.476V7.263h9.754L9.695,9.792c-0.057,0.057-0.101,0.13-0.119,0.212L9.18,11.36h-3.98c-0.251,0-0.457,0.205-0.457,0.456c0,0.253,0.205,0.456,0.457,0.456h4.336c0.023,0,0.899,0.02,1.498-0.127c0.312-0.077,0.55-0.137,0.55-0.137c0.08-0.018,0.155-0.059,0.212-0.118l3.463-3.443V15.929z M11.241,11.156l-1.078,0.267l0.267-1.076l6.097-6.091l0.808,0.808L11.241,11.156z"></path>
                    </svg>
                </button>

                
            </div>
        </div>

        <loading></loading>

        <div class="bg-white rounded p-3 mt-4 text-sm w-full md:w-1/3 mx-auto shadow" v-show="! loading">
            <div class="my-2">
                <label for="name">Name</label>
                <pre class="bg-gray-300 p-2 ml-3 my-2" v-text="user.name"></pre>
            </div>

            <div class="my-2">
                <label for="email">Email</label>
                <pre class="bg-gray-300 p-2 ml-3 my-2" v-text="user.email"></pre>
            </div>

            <div class="my-2">
                <label for="role">Role</label>
                <pre class="bg-gray-300 p-2 ml-3 my-2" v-text="user.role"></pre>
            </div>
        </div>

        <editUser />

        <modal name="user-delete"  height="auto" :adaptive="true" :clickToClose="false">
            <div class="p-6">
                <div class="flex flex-col md:flex-row  justify-between items-center">
                    <h1 class="self-start text-xl text-gray-600">Delete User</h1>

                    <button @click="$modal.hide('user-delete')" class="self-end btn btn-teal text-white mx-2">X</button>
                </div>

                <p class="bg-gray-300 p-4 rounded my-6">
                    Are you sure you want to delete <span class="text-red-600">{{ user.name }}</span>?
                </p>

                <button @click.prevent="deleteUser" class="btn btn-red w-full">Confirm</button>
            </div>
        </modal>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import loading from '../../partials/loading'
import editUser from './modals/edit-user'

export default {
    name: 'users-show',

    components: { loading, editUser },

    created() {
        if (this.users.length) {
            this.$store.commit('managers/users/set_user', this.users.find(user => user.id === this.$route.params.id))
        } else {
            this.$store.dispatch('managers/users/fetchUser', this.$route.params.id)
        }
    },

    computed: {
       ...mapGetters('managers/users', ['users', 'user']),
       ...mapGetters(['loading'])
    },

    methods: {
        deleteUser() {
            this.$store.dispatch('managers/users/deleteUser', this.user)
            this.$modal.hide('user-delete')
            this.$router.push({name: 'users-index'})
        }
    }


}
</script>