<template>
    <div class="flex flex-col gap-y-3 items-start px-8 py-6">
        <span>this is a test</span>

        <a :href="route('auth.redirect')" class="bg-blue-400 text-white px-3 py-1 rounded-lg shadow-md">
            Log in via twitter
        </a>
    </div>
</template>

<script>
export default {

}
</script>
