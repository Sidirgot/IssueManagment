<template>
    <modal name="edit-user" height="auto" :adaptive="true" :clickToClose="false">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Update User Details</h1>

                <button @click="$modal.hide('edit-user')" class="self-end btn btn-teal text-white mx-2"><i class="fas fa-times"></i></button>
            </div>

            <form class="my-3 mx-3">

                <div class="my-2">
                    <label for="name">Name</label>
                    <input type="text" v-model="user.name" class="p-2 my-2 bg-gray-200 rounded block ml-3 w-full" placeholder="Name">
                </div>

                <div class="my-2">
                    <label for="email">Email</label>
                    <input type="text" v-model="user.email" class="p-2 my-2 bg-gray-200 rounded block ml-3 w-full" placeholder="Email">
                </div>

                <div class="my-2">
                    <label for="password">Password</label>
                    <input type="password" class="p-2 my-2 bg-gray-200 rounded block ml-3 w-full" v-model="user.password" autocomplete="new-password">
                </div>

                <div class="my-2">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="p-2 my-2 bg-gray-200 rounded block ml-3 w-full" v-model="user.password_confirmation" autocomplete="new-password">
                </div>

                <div class="my-2">
                    <label for="role">Role</label>
                    <select v-model="user.role" class="appearance-none block bg-gray-200 p-2 my-2 ml-3 rounded w-full">
                        <option value="tester">Tester</option>
                        <option value="developer">Developer</option>
                    </select>
                </div>

                <button @click.prevent="updateUser" class="btn btn-teal my-2 w-full">Update User <i class="fas fa-check"></i></button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex';
import loading from '../../../partials/loading'

export default {
    name: 'edit-user',

    components: {loading},

    computed: {
        ...mapGetters('managers/users', ['user']),
        ...mapGetters(['loading'])
    },

    methods: {
        updateUser() {
            this.$store.dispatch('managers/users/updateUser', this.user)
            this.$modal.hide('edit-user')
        }
    }
}
</script>