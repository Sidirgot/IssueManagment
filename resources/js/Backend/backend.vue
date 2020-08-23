<template>
    <div>
        <topnav></topnav>

        <div class="flex">
            <sidebar></sidebar>

            <main class="py-4 px-4 w-full">
                <router-view></router-view>
            </main>
        </div>
        
        <div class="text-center opacity-75">
            Created by <a href="https://sidirgot.com/profile" target="_blank" class="text-teal-700 font-bold traking-widest hover:opacity-50">Sidirgot</a>.
            &copy; 2020.
        </div>

        <flashmessage></flashmessage>
    </div>
</template>

<script>
import sidebar from './partials/sidebar'
import topnav from './partials/topnav/topnav'
import flashmessage from './partials/flashmessage'

export default {
    components: {sidebar, topnav, flashmessage},

    name: 'backend',

}
</script>
