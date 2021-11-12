import Authenticated from "./Layouts/Authenticated";
import {createApp, h} from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress'
import {ZiggyVue} from 'ziggy';

require('./bootstrap');

InertiaProgress.init()

createInertiaApp({
    resolve: name => {
        const page = require(`./Pages/${name}`).default
        if (page.layout === undefined && !name.startsWith('Auth/')) {
            page.layout = Authenticated
        }
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('InertiaHead', Head)
            .component('InertiaLink', Link)
            .mount(el)
    },
})
