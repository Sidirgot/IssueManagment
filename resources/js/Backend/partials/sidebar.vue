<template>
    <aside class="hidden md:block mx-4 my-4 w-48">
         <!-- Managers SIDEBAR ROUTES -->
        <div class="flex flex-col" v-if="isManager">
            <router-link :to="{name: 'managers-dashboard'}" class="my-2">
                <i class="fas fa-home"></i>
                Dashboard
            </router-link>

            <router-link :to="{name: 'users-index'}" class="my-2">
                <i class="fas fa-users"></i>
                Users
            </router-link>

            <router-link :to="{name: 'projects-index'}" class="my-2">
                <i class="fas fa-project-diagram"></i>
                Projects
            </router-link>
        </div>


        <!-- Tester/Developer SIDEBAR ROUTES -->
        <div class="flex flex-col" v-if="isTester || isDeveloper">
            <router-link :to="{name: 'team-dashboard'}" class="my-2">
                <i class="fas fa-home"></i>
                Dashboard
            </router-link>

            <router-link :to="{name: 'projects'}" class="my-2">
                <i class="fas fa-project-diagram"></i>
                Projects
            </router-link>
        </div>


    </aside>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    computed: {
        ...mapGetters(['isManager', 'isTester', 'isDeveloper'])
    }
}
</script>