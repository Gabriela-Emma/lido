require('./bootstrap');

window.moment = require('moment');

window['moment-timezone'] = require('moment-timezone');

// require('@splidejs/splide');
// window['Grid'] = require('@splidejs/splide-extension-grid');
// window['Video'] = require('@splidejs/splide-extension-video');
// window['Splide'] = require('@splidejs/splide');

// import Splide from '@splidejs/splide';
// import { Grid } from '@splidejs/splide-extension-grid';
// import { Video } from '@splidejs/splide-extension-video';


// Swahili learn to earn Modal
window.addEventListener('DOMContentLoaded', () => {
    setTimeout(
        function openModal(){
            let lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            let slteModal = document.querySelector('#slteModal')
            
            if ( lang == 'sw') {
                slteModal.style.display = 'block';
        }}, 1000*10);
});
