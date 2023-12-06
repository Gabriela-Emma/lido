import '../../../scss/rewards.scss';
import {createInertiaApp, usePage} from "@inertiajs/vue3";
import {createApp, h, nextTick} from "vue";
import {createI18n} from 'vue-i18n'
import {createPinia} from "pinia";
import {marked} from 'marked';
import PrimeVue from 'primevue/config';
import route from "ziggy-js";
import {modal} from "momentum-modal";
import timeago from 'vue-timeago3';
import {shortNumber} from "@/global/utils/shortNumber";
import {currency} from "@/global/utils/currency";
import {timeAgo} from "@/global/utils/timeago";
import Layout from "@/apps/rewards/Shared/Layout.vue";
import {contrastColor} from "@/global/utils/contrastColor";
import HeaderComponent from "@/apps/rewards/Shared/Components/HeaderComponent.vue";
import axios from "@/global/utils/axios";

//cache snippets to disk
axios.get(`${window.location.origin}/api/cache/snippets`);

createInertiaApp({
    progress: {
        color: '#fcdc0b',
    },
    // @ts-ignore
    resolve: name => {
        const pages = import.meta.glob('../rewards/Pages/**/*.vue', { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        // @ts-ignore
        page.default.layout = page?.default?.layout || Layout
        return page
    },
    setup({el, App, props, plugin}) {
        const pinia = createPinia();
        const i18n = createI18n({
            locale: <string>props.initialPage.props.locale,
            fallbackLocale: "en",
            messages: {},
        });

        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(modal, {
                resolve: name => {
                    const pages = import.meta.glob('../Pages/**/*.vue', { eager: true });
                    console.log({pages});
                    let page = pages[`./Pages/${name}.vue`]
                    // @ts-ignore
                    page.default.layout = page?.default?.layout || Layout
                    return page
                },
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
            shortNumber: shortNumber,
            currency: currency,
            timeAgo: timeAgo,
            number(number, maximumSignificantDigits = 2, locale: string = 'en-US') {
                return new Intl.NumberFormat(locale, {maximumSignificantDigits}).format(number);
            },
            markdown(value) {
                return marked.parse(value);
            },
        };

        app.provide('$utils', {
            localizeRoute(value: any) {
                const base = usePage().props?.base_url;
                const locale = usePage().props?.locale;
                return `${base}/${locale}/${value}`
            },
            assetUrl(value: any) {
                const base = usePage().props?.asset_url;
                return `${base}${value}`
            },
            contrastColor: contrastColor
        });
        app.mixin({ methods: { route } });

        app.config.globalProperties.$route = route;

        app.component('header-component', HeaderComponent);
        app.mount(el);
    },
}).then();
