<template>
    <modal name="create-user" height="auto" :adaptive="true" :clickToClose="false">
        <div class="p-6">
            <div class="flex flex-col md:flex-row  justify-between items-center">
                <h1 class="self-start text-xl text-gray-600">Create New User </h1>

                <button @click="$modal.hide('create-user')" class="self-end btn btn-teal text-white mx-2">X</button>
            </div>

            <form class="my-3 mx-3" method="post">
                <div class="my-2">
                    <label for="name">Name</label>
                    <input type="text" v-model="user.name" class="p-2 my-2 bg-gray-300 rounded block ml-3 w-full" placeholder="Name" required>
                </div>

                <div class="my-2">
                    <label for="email">Email</label>
                    <input type="text" v-model="user.email" class="p-2 my-2 bg-gray-300 rounded block ml-3 w-full" placeholder="Email" required>
                </div>

                <div class="my-2">
                    <label for="password">Password</label>
                    <input type="password" class="p-2 my-2 bg-gray-300 rounded block ml-3 w-full" v-model="user.password" required>
                </div>

                <div class="my-2">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="p-2 my-2 bg-gray-300 rounded block ml-3 w-full" v-model="user.password_confirmation" required>
                </div>

                <div class="my-2">
                    <label for="role">Role</label>
                    <select v-model="user.role" class="appearance-none block bg-gray-300 p-2 my-2 ml-3 rounded w-full" required>
                        <option value="tester">Tester</option>
                        <option value="developer">Developer</option>
                    </select>
                </div>

                <button @click.prevent="createUser" class="btn btn-teal mt-6 mb-2 w-full">Create</button>
            </form>
        </div>
    </modal>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'create-user',
    data() {
        return {
            user: {
                name: '',
                email: '',
                role: '',
                password: '',
                password_confirmation: ''
            }
        }
    },

    methods: {
        createUser() {
            if (this.user.name && this.user.email && this.user.role && this.user.password && this.user.password_confirmation) {
                this.$store.dispatch('managers/users/createUser', this.user)
                           .then( response => {
                               this.$modal.hide('create-user')
                               this.$router.push({name: 'users-show', params: {id: response.data.id}})
                           })
            }
        }
    }
}
</script>