<template>
    <div class="relative inline-block text-left">
        <div>
            <button @click.prevent="open = !open" type="button" class="inline-flex items-center justify-center py-1 px-2 bg-gray-200 rounded-lg shadow text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none" id="menu-button-lg" aria-expanded="true" aria-haspopup="true">
                <template v-if="currentAccount">
                    <img v-if="currentAccount.avatar_url" class="rounded-full shadow mr-2 w-6 h-6 object-cover object-center bg-gray-200" :src="currentAccount.avatar_url" />
                    <span class="text-xs leading-none">@{{ currentAccount.username }}</span>
                </template>
                <!-- Heroicon name: solid/chevron-down -->
                <svg class="-mr-1 ml-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- Dropdown menu, show/hide based on menu state. -->
        <transition name="scale-fade">
            <div v-show="open" class="origin-top-right absolute z-50 left-0 sm:left-auto sm:right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button-lg" tabindex="-1">
                <div class="py-1" role="none">

                    <template v-for="account in user.accounts" :key="account.id">

                        <inertia-link
                            :href="account.id === currentAccount.id ? '#' : route('accounts.switch', { account })"
                            method="POST"
                            @click.native.prevent="selected"
                            :class="{ 'opacity-50 pointer-events-none': account.id === currentAccount.id }"
                            class="inline-flex items-center gap-x-2 text-gray-700 px-4 py-2 text-sm w-full"
                            role="menuitem" tabindex="-1"
                            id="menu-item-lg-0"
                        >
                            <img class="rounded-full shadow w-6 h-6 object-cover object-center bg-gray-200" :src="account.avatar_url" />
                            <span class="leading-none">@{{ account.username }}</span>
                        </inertia-link>

                    </template>

                </div>
                <div class="py-1" role="none">
                    <a :href="route('accounts.add')" class="text-gray-700 block w-full text-left px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-lg-3">
                        Add a new one
                    </a>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    data() {
        return {
            open: false,
        }
    },

    computed: {
        user() {
            return this.$page.props.user
        },
        currentAccount() {
            return this.$page.props.account
        },
    },

    methods: {
        selected() {
            this.open = false
            this.$emit('selected')
        }
    }
})
</script>
