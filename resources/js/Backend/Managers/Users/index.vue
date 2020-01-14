<template>
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h1 class="self-start text-xl text-gray-600 my-3 md:my-0">User Management</h1>

            <button @click.prevent="$modal.show('create-user')" class="btn btn-teal text-white mx-2">Add New User <i class="fas fa-plus"></i></button>
        </div>

        <loading></loading>

        <div class="bg-white rounded shadow-lg p-3 mt-4 mx-2" v-show="! loading">
            <table class="table-fixed w-full rounded text-center text-sm">
                <thead class="bg-gray-200">
                    <th class="py-2">Name</th>
                    <th class="py-2">Email</th>
                </thead>
                <tbody class="break-words">
                    <tr v-if="users.length == 0">
                        <td colspan="2" rowspan="2" class="p-2 text-teal-600 rounded font-bold">No users in system.</td>
                    </tr>
                    <tr class="border-b border-gray-200" v-for="user in users" :key="user.id">
                        <td class="leading-loose">
                            <router-link :to="{name: 'users-show', params: {id: user.id}}" class="text-teal-500 font-bold">{{ user.name }}</router-link>
                        </td>
                        <td class="leading-loose" v-text="user.email"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-right border-t border-gray-200 pt-2" v-show="! loading">
            <pagination @fetchData="fetchUsers"></pagination>
        </div>

        <createUser />
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import loading from '../../partials/loading'
import createUser from './modals/createUser'
import pagination from '../../partials/pagination'

export default {
    name: 'users-index',

    components: {loading, createUser, pagination},

    created() {
        this.fetchUsers()
    },

    computed: {
        ...mapGetters('managers/users',['users']),
        ...mapGetters(['loading']),
    },

    methods: {
        fetchUsers(page_url) {
            this.$store.dispatch('managers/users/fetchUsers', page_url)
        }
    }
}
</script>