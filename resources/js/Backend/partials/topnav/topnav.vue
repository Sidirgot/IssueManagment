<template>
    <div class="flex justify-between items-center w-full bg-white shadow-lg">
        <h1 class="ml-4">Sidirgot</h1>
        <div class="flex items-center">

            <div class="relative mx-2">
                <button @click="open = !open" class="focus:outline-none" :class="{'text-teal-600': open}">{{ auth_user.name }} <i class="fas fa-sort-down"></i></button>

                <transition name="dropdown">
                    <div v-show="open" class="dropdown absolute bg-white shadow-xl rounded p-4">
                        <button @click="toggleSettings" class="flex items-center focus:outline-none hover:text-teal-600 text-sm whitespace-no-wrap"><i class="fas fa-cog mx-2"></i> Change Settings</button>
                    </div>
                </transition>
            </div>

            <form method="POST" class="ml-2">
                <button @click.prevent="logout" class="bg-teal-600 hover:bg-teal-700 px-4 py-4 text-white">Logout <i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>

        <updateProfile></updateProfile>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import updateProfile from '../../Team/Profile/update'

export default {
    components: { updateProfile },

    data() {
        return {
            open: false,
        }
    },

    created() {
        this.$store.dispatch('userData')
    },

    computed: {
        ...mapGetters(['auth_user'])
    },

    methods: {
        toggleSettings() {
            this.$modal.show('updateProfile')
            this.open = false
        },

        logout() {
            this.$store.dispatch('logout')
        }
    }

}
</script>

<style scoped>
.dropdown {
    top: 2.5rem;
    left: -0.5rem;
}

.dropdown-enter,
.dropdown-leave-to {
    top: 2rem;
    opacity: 0;
}

.dropdown-enter-active,
.dropdown-leave-active {
  transition: all .3s;
}

</style>
