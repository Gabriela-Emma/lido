import {createInertiaApp} from "@inertiajs/vue3";
import {createApp, h} from "vue";
import Layout from "./catalyst-explorer/Shared/Layout.vue";
import {createPinia} from "pinia";

// boot inertia app
createInertiaApp({
    progress: {
        color: '#fcdc0b',
    },
    resolve: name => {
        const page = require(`./catalyst-explorer/Pages/${name}`).default;
        page.layout ??= Layout;

        return page
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(createPinia())
            .mount(el)
    },
}).then();
