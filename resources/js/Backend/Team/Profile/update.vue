<template>
    <modal name="updateProfile" height="auto" :adaptive="true" :clickToClose="false">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Update Profile</h1>

                <button @click="$modal.hide('updateProfile')" class="self-end btn btn-teal text-white mx-2">X</button>
            </div>

            <form class="my-3 mx-3">

                <div class="my-2">
                    <label for="name">Name</label>
                    <input type="text" v-model="auth_user.name" class="p-2 my-2 bg-gray-200 rounded block ml-3 w-full" placeholder="Name">
                </div>

                <div class="my-2">
                    <label for="email">Email</label>
                    <input type="text" v-model="auth_user.email" class="p-2 my-2 bg-gray-200 rounded block ml-3 w-full" placeholder="Email">
                </div>

                <div class="my-2">
                    <label for="password">Password</label>
                    <input type="password" class="p-2 my-2 bg-gray-200 rounded block ml-3 w-full" v-model="auth_user.password" autocomplete="new-password">
                </div>

                <div class="my-2">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="p-2 my-2 bg-gray-200 rounded block ml-3 w-full" v-model="auth_user.password_confirmation" autocomplete="new-password">
                </div>

                <button @click.prevent="updateProfile" class="btn btn-teal mt-6 mb-2 w-full">Save Changes</button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: 'updateProfile',

    computed: {
        ...mapGetters(['auth_user'])
    },

    methods: {
        updateProfile() {
            this.$store.dispatch('team/updateProfile', this.auth_user)
            this.$modal.hide('updateProfile')
        }
    }
}
</script>