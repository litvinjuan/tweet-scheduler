<template>
    <div>
        <Header />

        <main>
            <slot />
        </main>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import Header from "../Components/Header";

export default defineComponent({
    components: {
        Header,
    },
})
</script>
