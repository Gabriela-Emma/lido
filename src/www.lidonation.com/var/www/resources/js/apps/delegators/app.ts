// import './bootstrap';
import '../../../scss/catalyst-explorer.scss';

import { createApp, h } from 'vue';
import { createInertiaApp, usePage } from "@inertiajs/vue3";
import { ZiggyVue } from "../../../../vendor/tightenco/ziggy/dist/vue.m.js";
import Layout from './Layouts/Public.vue';
import { createI18n } from 'vue-i18n';
// @ts-ignore
import VuePlyr from 'vue-plyr';
import HeaderComponent from "@apps/catalyst-explorer/Components/Global/HeaderComponent.vue";
import { createPinia } from 'pinia';
import { shortNumber } from "@/global/utils/shortNumber";
import { currency } from "@/global/utils/currency";
import { timeAgo } from "@/global/utils/timeago";
import { marked } from 'marked';
import ziggy from '../../global/models/ziggy';
import page from '@/global/utils/page';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    progress: {
        color: '#fcdc0b',
    },
    title: (title) => `${title} - ${appName}`,
    // @ts-ignore
    // resolve: (name) => resolvePageComponent(`./catalyst-explorer/Pages/${name}.vue`, import.meta.glob('../catalyst-explorer/Pages/**/*.vue')),
    resolve: name => {
        const pages = import.meta.glob('../delegators/Pages/**/*.vue', { eager: true });
        let page = pages[`./Pages/${name}.vue`]
        // @ts-ignore
        page.default.layout = page?.default?.layout || Layout
        return page
    },
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();

        const i18n = createI18n({
            locale: <string>props.initialPage.props.locale,
            fallbackLocale: "en",
            messages: {},
        });

        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .use(pinia)
            .use(VuePlyr, {
                plyr: {}
            });

        app.provide('$utils', {
            localizeRoute(value: string) {
                const base = page.props.ziggy.base_url;
                const locale = page.props.ziggy.locale;
                return `${base}/${locale}/${value}`
            },
            assetUrl(value: string) {
                const base = usePage().props?.asset_url;
                return `${base}${value}`
            },
            // contrastColor: contrastColor
        });

        app.config.globalProperties.$filters = {
            shortNumber: shortNumber,
            currency: currency,
            timeAgo: timeAgo,
            number(number: number, maximumSignificantDigits = 2, locale: string = 'en-US') {
                return new Intl.NumberFormat(locale, { maximumSignificantDigits }).format(number);
            },
            markdown(value: string) {
                return marked.parse(value);
            },
        };

        app.component('header-component', HeaderComponent);
        app.mount(el);
    },
}).then();
