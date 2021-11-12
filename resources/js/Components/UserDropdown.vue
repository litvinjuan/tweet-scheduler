<template>
    <div @click.prevent="open = false" v-show="open" class="hidden sm:block absolute z-40 inset-0 top-0 left-0 w-screen h-screen"></div>

    <div class="relative inline-block text-left">
        <div>
            <button @click.prevent="open = !open" type="button" class="inline-flex items-center justify-center py-2 bg-white text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none" id="menu-button-lg" aria-expanded="true" aria-haspopup="true">
                <img class="rounded-full shadow w-8 h-8 object-cover object-center bg-gray-200" :src="`https://ui-avatars.com/api/?name=${user.name}`" />
                <!-- Heroicon name: solid/chevron-down -->
                <svg class="-mr-1 ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- Dropdown menu, show/hide based on menu state. -->
        <transition name="scale-fade">
            <div v-show="open" class="origin-top-right absolute z-50 right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button-lg" tabindex="-1">
                <div class="px-4 py-3" role="none">
                    <p class="text-sm" role="none">
                        Signed in as
                    </p>
                    <p class="text-sm font-medium text-gray-900 truncate" role="none">
                        {{ user.email }}
                    </p>
                </div>
                <div class="py-1" role="none">
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-lg-0">Manage Accounts</a>
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-lg-1">Support</a>
                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-lg-2">License</a>
                </div>
                <div class="py-1" role="none">
                    <inertia-link :href="route('auth.logout')" method="POST" class="text-gray-700 block w-full text-left px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-lg-3">
                        Sign out
                    </inertia-link>
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
    }
})
</script>
