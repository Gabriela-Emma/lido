import {createInertiaApp, usePage} from "@inertiajs/vue3";
import {createApp, h, nextTick, watch} from "vue";
import {createI18n} from 'vue-i18n'
import Layout from "./earn/Shared/Layout.vue";
import {createPinia} from "pinia";
import {marked} from 'marked';
import HeaderComponent from './earn/Shared/Components/HeaderComponent.vue';
import PrimeVue from 'primevue/config';
import route from "ziggy-js";
import {modal} from "momentum-modal";
import timeago from 'vue-timeago3';
import {timeAgo} from "./lib/utils/timeago";
import {currency} from "./lib/utils/currency";
let messages = require('../../storage/app/snippets.json');
import './bootstrap';
import axios from "./lib/utils/axios";
// const axios = require('axios');

//cache snippets to disk
axios.get(`${window.location.origin}/api/cache/snippets`);
createInertiaApp({
    progress: {
        color: '#C02025',
    },
    resolve: name => {
        const page = require(`./earn/Pages/${name}`).default;
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
            {deep: true}
        );

        const i18n = createI18n({
            locale: <string>props.initialPage.props.locale,
            fallbackLocale: "en",
            messages: messages,
        });

        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(modal, {
                resolve: (name) => import(`./earn/Pages/${name}`),
            })
            .use(PrimeVue)
            .use(timeago)
            .use(pinia)
            .use(i18n);

        app.directive('focus', {
            mounted(el, binding, vnode) {
                if (binding.modifiers?.ignoreEmpty) {
                    nextTick(() => {
                        if (binding.modifiers?.ignoreEmpty) {
                            if (!el.value || typeof el.value === 'undefined') {
                                return;
                            }
                            el.focus();
                        }
                    }).then();
                } else {
                    el.focus();
                }
            }
        });

        app.config.globalProperties.$filters = {
            currency: currency,
            timeAgo: timeAgo,
            number(number, maximumSignificantDigits = 2, locale: string = 'en-US') {
                return new Intl.NumberFormat(locale, {maximumSignificantDigits}).format(number);
            },
            markdown(value) {
                return marked.parse(value);
            }
        };

        app.provide('$utils', {
            localizeRoute(value) {
                const base = usePage().props?.base_url;
                const locale = usePage().props?.locale;
                return `${base}/${locale}/${value}`
            },
            assetUrl(value) {
                const base = usePage().props?.asset_url;
                return `${base}${value}`
            }
        });

        app.config.globalProperties.$route = route;

        app.component('header-component', HeaderComponent);
        app.mount(el);
    },
}).then();
