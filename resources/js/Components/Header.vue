<template>
    <div class="relative bg-white">
        <div class="absolute inset-0 shadow z-30 pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-30">
            <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-5 sm:px-6 sm:py-4 lg:px-8 md:justify-start md:space-x-10">
                <div>
                    <a href="#" class="flex">
                        <span class="sr-only">{{ $page.props.app.name }}</span>
                        <Logo class="h-8" />
                    </a>
                </div>

                <div class="-mr-2 -my-2 md:hidden flex items-center">
                    <img class="rounded-full shadow mr-2 w-8 h-8 object-cover object-center bg-gray-200" :src="account.avatar_url" />

                    <button @click.prevent="open = !open" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                        <span class="sr-only">Open menu</span>
                        <!-- Heroicon name: outline/menu -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div class="hidden md:flex-1 md:flex md:items-center">
                    <nav class="flex space-x-10 flex-1 md:mr-12">
                        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                            Your DMs
                        </a>
                        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                            Contacts
                        </a>
                    </nav>

                    <div class="flex items-center">
                        <AccountSelector />
                    </div>

                    <div class="flex items-center border-l pl-4 ml-4">
                        <UserDropdown />
                    </div>
                </div>

            </div>
        </div>

        <!--
          Mobile menu, show/hide based on mobile menu state.
        -->
        <transition name="scale-fade">
            <div v-show="open" class="absolute z-30 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                    <div class="pt-5 pb-6 px-5 sm:pb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
                            </div>
                            <div class="-mr-2">
                                <button @click.prevent="open = false" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                    <span class="sr-only">Close menu</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="py-6 px-5">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" class="rounded-md text-base font-medium text-gray-900 hover:text-gray-700">
                                Your DMs
                            </a>

                            <a href="#" class="rounded-md text-base font-medium text-gray-900 hover:text-gray-700">
                                Contacts
                            </a>
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <AccountSelector @selected="open = false" />
                                <UserDropdown />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

    </div>
</template>

<script>
import {defineComponent} from "vue";
import Logo from "./Logo";
import AccountSelector from "./AccountSelector";
import UserDropdown from "./UserDropdown";

export default defineComponent({
    data() {
        return {
            open: false,
        }
    },

    components: {
        Logo,
        AccountSelector,
        UserDropdown,
    },

    computed: {
        user() {
            return this.$page.props.user
        },
        account() {
            return this.$page.props.account
        },
    }
})
</script>
