<template>
    <div>
        <topnav></topnav>

        <div class="flex">
            <sidebar></sidebar>

            <main class="py-4 px-4 w-full">
                <router-view></router-view>
            </main>
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
