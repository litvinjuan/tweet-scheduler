<template>
    <div class="flex flex-col gap-y-3 items-start px-8 py-6">
        <span>Hello {{ user.name }}</span>

        <div class="mt-6">

            <form @submit.prevent="tweet" class="flex flex-col items-start gap-y-4">
                <textarea class="border border-gray-400 rounded-md w-64" rows="5" v-model="form.body"></textarea>
                <span class="mt-1 text-sm text-red-600">{{ form.errors.body }}</span>

                <button type="submit" class="rounded-lg shadow-md px-4 py-2 bg-blue-400 text-white">Tweet</button>

                <span class="mt-3 text-sm text-red-600">{{ form.errors.generic }}</span>
            </form>

        </div>

        <div class="mt-12 flex flex-col items-start gap-y-4">
            <div v-for="tweet in tweets" :key="tweet" class="border rounded-md p-4">
                <span>{{ tweet.text }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: this.$inertia.form({
                body: ''
            })
        }
    },

    props: {
        user: Object,
        tweets: Array,
    },

    methods: {
        tweet() {
            this.form.post(this.route('tweet'))
        }
    }
}
</script>
