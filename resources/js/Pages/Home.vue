<template>
    <div class="flex flex-col gap-y-3 items-start px-8 py-6">
        <span>Hello {{ user.name }}</span>
    </div>
</template>

<script>
export default {
    data() {
        return {

        }
    },

    props: {
        user: Object,
        tweets: Array,
    },

    methods: {

    }
}
</script>
