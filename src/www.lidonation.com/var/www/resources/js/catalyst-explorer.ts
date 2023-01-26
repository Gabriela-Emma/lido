import {createInertiaApp, usePage} from "@inertiajs/vue3";
import {computed, createApp, h, watch} from "vue";
import Layout from "./catalyst-explorer/Shared/Layout.vue";
import {createPinia} from "pinia";
import { marked } from 'marked';

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
        const pinia = createPinia();
        watch(
            pinia.state,
            (state) => {
                // persist the whole state to the local storage whenever it changes
                sessionStorage.setItem('piniaState', JSON.stringify(state))
            },
            { deep: true }
        );

        const app =  createApp({render: () => h(App, props)})
            .use(plugin)
            .use(pinia);

        app.config.globalProperties.$filters = {
            currency(value, locale: string='en-US') {
                if (typeof value !== "number") {
                    return value;
                }
                const formatter = new Intl.NumberFormat(locale, {
                    style: 'currency',
                    currency: 'USD',
                    maximumFractionDigits: 0
                });
                return formatter.format(value);
            },
            markdown(value) {
                return marked.parse(value);
            },
        };

        app.config.globalProperties.$utils = {
            localizeRoute(value) {
                const base = usePage().props?.base_url;
                const locale = usePage().props?.locale;
                return `${base}/${locale}/${value}`
            }
        }


        app.mount(el);
    },
}).then();
