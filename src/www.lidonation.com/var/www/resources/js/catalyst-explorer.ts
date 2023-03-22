import {createInertiaApp, usePage} from "@inertiajs/vue3";
import {createApp, h, nextTick, watch} from "vue";
import {createI18n} from 'vue-i18n'
import Layout from "./catalyst-explorer/Shared/Layout.vue";
import {createPinia} from "pinia";
import {marked} from 'marked';
import HeaderComponent from './catalyst-explorer/Shared/Components/HeaderComponent.vue';
import PrimeVue from 'primevue/config';
import route from "ziggy-js";
import {modal} from "momentum-modal";
import timeago from 'vue-timeago3';
import moment from "moment-timezone";
let messages = require('../../storage/app/snippets.json');
const axios = require('axios');


//cache snippets to disk
axios.get(`${window.location.origin}/api/cache/snippets`);


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
                resolve: (name) => import(`./catalyst-explorer/Pages/${name}`),
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
            number(number, maximumSignificantDigits = 2, locale: string = 'en-US') {
                return new Intl.NumberFormat(locale, {maximumSignificantDigits}).format(number);
            },
            shortNumber(value, digits = 0, locale: string = 'en-US') {
                // Nine Zeroes for Billions
                return Math.abs(Number(value)) >= 1.0e+9

                    ? (Math.abs(Number(value)) / 1.0e+9).toFixed(digits) + "B"
                    // Six Zeroes for Millions
                    : Math.abs(Number(value)) >= 1.0e+6

                        ? (Math.abs(Number(value)) / 1.0e+6).toFixed(digits) + "M"
                        // Three Zeroes for Thousands
                        : Math.abs(Number(value)) >= 1.0e+3

                            ? (Math.abs(Number(value)) / 1.0e+3).toFixed(digits) + "K"

                            : Math.abs(Number(value));
            },
            currency(value, locale: string = 'en-US') {
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
            timeAgo(time) {
                moment.updateLocale('en', {
                    relativeTime: {
                        future: 'in %s',
                        past: '%s ago',
                        s: (number) => number + 's ago',
                        ss: '%ds ago',
                        m: '1m ago',
                        mm: '%dm ago',
                        h: '1h ago',
                        hh: '%dh ago',
                        d: '1d ago',
                        dd: '%dd ago',
                        M: 'a month ago',
                        MM: '%d months ago',
                        y: 'a year ago',
                        yy: '%d years ago',
                    },
                });

                let secondsElapsed = moment().diff(time, 'seconds');
                let dayStart = moment('2018-01-01').startOf('day').seconds(secondsElapsed);

                if (secondsElapsed > 300) {
                    return moment(time).fromNow(true);
                } else if (secondsElapsed < 60) {
                    return dayStart.format('s') + 's ago';
                } else {
                    return dayStart.format('m:ss') + 'm ago';
                }
            },
        };

        app.config.globalProperties.$utils = {
            localizeRoute(value) {
                const base = usePage().props?.base_url;
                const locale = usePage().props?.locale;
                return `${base}/${locale}/${value}`
            },
            assetUrl(value) {
                const base = usePage().props?.asset_url;
                return `${base}${value}`
            }
        }

        app.config.globalProperties.$route = route;

        app.component('header-component', HeaderComponent);
        app.mount(el);
    },
}).then();
