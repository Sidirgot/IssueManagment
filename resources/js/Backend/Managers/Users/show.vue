<template>
    <div class="container mx-auto">
         <div class="flex flex-col md:flex-row justify-between items-center">
            <h1 class="self-start text-lg text-gray-600 my-3 md:my-0">Users Profile</h1>

            <div class="self-end flex">
                <button @click.prevent="$modal.show('user-delete')" class="btn btn-red text-white mx-2"><i class="fas fa-trash"></i> </button>
                <button @click.prevent="$modal.show('edit-user')" class="btn btn-yellow text-white mx-2">Edit <i class="fas fa-edit"></i> </button>

                <router-link :to="{name: 'users-index'}" class="btn btn-teal text-white">Back <i class="fas fa-undo"></i> </router-link>
            </div>
        </div>

        <loading></loading>

        <div class="bg-white rounded p-3 mt-4 text-sm w-full md:w-1/3 mx-auto shadow" v-show="! loading">
            <div class="my-2">
                <label for="name">Name</label>
                <pre class="bg-gray-200 p-2 ml-3 my-2" v-text="user.name"></pre>
            </div>

            <div class="my-2">
                <label for="email">Email</label>
                <pre class="bg-gray-200 p-2 ml-3 my-2" v-text="user.email"></pre>
            </div>

            <div class="my-2">
                <label for="role">Role</label>
                <pre class="bg-gray-200 p-2 ml-3 my-2" v-text="user.role"></pre>
            </div>
        </div>

        <editUser />
        <modal name="user-delete"  height="auto" :adaptive="true" :clickToClose="false">
            <div class="p-6">
                <div class="flex flex-col md:flex-row  justify-between items-center">
                    <h1 class="self-start text-xl text-gray-600">Delete User</h1>

                    <button @click="$modal.hide('user-delete')" class="self-end btn btn-teal text-white mx-2">Cancel</button>
                </div>

                <p class="bg-gray-200 p-4 rounded my-6">
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