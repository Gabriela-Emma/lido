import axios from "axios";

// @ts-ignore
window.axios = axios;
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// @ts-ignore
window.axios.defaults.withCredentials = true;
// @ts-ignore
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    // @ts-ignore
    'Accept-Language': document.querySelector('html')?.getAttribute('lang'), // + ';q=0.9,en-US,en;q=0.5',
    // @ts-ignore
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};
// @ts-ignore
const _axios = window.axios;
export default _axios;
