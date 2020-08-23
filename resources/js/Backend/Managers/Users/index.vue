<template>
    <div class="container mx-auto">
        

        <loading></loading>

        <div class="bg-white rounded shadow-lg p-3 mt-4 mx-2" v-show="! loading">
            <div class="flex flex-wrap justify-between items-center py-4 ">
                <h1 class="self-start text-xl text-gray-600 my-3 md:my-0">Users Table</h1>

                <button @click.prevent="$modal.show('create-user')" class="btn btn-teal text-white mx-2 flex items-center">
                    New User 
                    <svg width="20" height="20" class="mx-1" viewBox="0 0 20 20">
                        <path fill="#fff" d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10"></path>
                    </svg>
                </button>
            </div>

            <table class="table-fixed w-full rounded text-center text-sm">
                <thead class="bg-gray-300 leading-10">
                    <th class="py-2">Name</th>
                    <th class="py-2">Email</th>
                </thead>
                <tbody class="break-words">
                    <tr v-if="users.length == 0">
                        <td colspan="2" rowspan="2" class="p-2 text-teal-600 rounded font-bold">No users in system.</td>
                    </tr>
                    <tr class="border-b border-gray-300 leading-8 odd:bg-white even:bg-gray-300" v-for="user in users" :key="user.id">
                        <td class="leading-loose py-2">
                            <router-link :to="{name: 'users-show', params: {id: user.id}}" class="text-teal-600 font-bold hover:opacity-50 transition duration-700">{{ user.name }}</router-link>
                        </td>
                        <td class="leading-loose py-2" v-text="user.email"></td>
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