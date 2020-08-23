<template>
    <div class="flex justify-between items-center w-full bg-white shadow-lg">

        <div class="hidden md:flex items-center hover:opacity-50 transition-opacity duration-700 mx-2">
            <img src="/assets/logo.png" class="w-12" alt="">

            <span class="tracking-widest font-bold text-xl text-teal-600 uppercase self-end ml-2">Sidirgot</span>
        </div>

        <mobileSidebar />

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
                <button @click.prevent="logout" class="bg-teal-600 hover:bg-teal-700 transition duration-700 px-4 py-4 text-white">
                    <svg width="20" height="20" viewBox="0 0 20 20">
                        <path fill="#fff" d="M16.76,7.51l-5.199-5.196c-0.234-0.239-0.633-0.066-0.633,0.261v2.534c-0.267-0.035-0.575-0.063-0.881-0.063c-3.813,0-6.915,3.042-6.915,6.783c0,2.516,1.394,4.729,3.729,5.924c0.367,0.189,0.71-0.266,0.451-0.572c-0.678-0.793-1.008-1.645-1.008-2.602c0-2.348,1.93-4.258,4.303-4.258c0.108,0,0.215,0.003,0.321,0.011v2.634c0,0.326,0.398,0.5,0.633,0.262l5.199-5.193C16.906,7.891,16.906,7.652,16.76,7.51 M11.672,12.068V9.995c0-0.185-0.137-0.341-0.318-0.367c-0.219-0.032-0.49-0.05-0.747-0.05c-2.78,0-5.046,2.241-5.046,5c0,0.557,0.099,1.092,0.292,1.602c-1.261-1.111-1.979-2.656-1.979-4.352c0-3.331,2.77-6.041,6.172-6.041c0.438,0,0.886,0.067,1.184,0.123c0.231,0.043,0.441-0.134,0.441-0.366V3.472l4.301,4.3L11.672,12.068z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <updateProfile></updateProfile>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import updateProfile from '../../Team/Profile/update'
import mobileSidebar from '../mobileSidebar'

export default {
    components: { updateProfile, mobileSidebar },

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
