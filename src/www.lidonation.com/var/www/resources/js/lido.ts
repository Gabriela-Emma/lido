import './bootstrap';
import '../scss/lido.scss';
import Rellax from 'rellax/rellax';
import Chart from 'chart.js/auto';
import {WordCloudController, WordElement} from 'chartjs-chart-wordcloud';
import globalVideoPlayer from './global/utils/globalVideoPlayer';
import {Splide} from '@splidejs/splide';

Chart.register(WordCloudController, WordElement);

// @ts-ignore
window.Chart = Chart;

const rellaxElement = document.getElementsByClassName("rellax")
let rellax = [];
if (rellaxElement.length > 0) {
    for (let i = 1; i < rellaxElement.length; i++) {
        rellax[i] = new Rellax('.rellax', {
            horizontal: true,
            vertical: true
        });
    }
}

const globalReactions = function globalReactions(counts) {
    return {
        reactionsCount: counts,

        async addReaction(reaction, id) {
            let data = {
                comment: reaction
            }
            const res = await window.axios.post(`/react/post/${id}`, data);
            this.reactionsCount = res.data;
        },
    }
}


declare global {
    interface Window {
        globalVideoPlayer: typeof globalVideoPlayer;
        globalReactions:typeof globalReactions
    }
}

window.globalVideoPlayer = globalVideoPlayer;
window.globalReactions = globalReactions;

let secondarySlider, primarySlider;
if (document.getElementById('proposal-secondary-slide')) {
    secondarySlider = new Splide('#proposal-secondary-slide', {
        rewind: true,
        fixedWidth: 100,
        fixedHeight: 64,
        isNavigation: true,
        gap: 10,
        // @ts-ignore
        focus: 'left',
        arrows: false,
        pagination: false,
        cover: true,
        breakpoints: {
            '600': {
                fixedWidth: 66,
                fixedHeight: 40,
            }
        }
    }).mount();
}
if (document.getElementById('proposal-primary-slide')) {
    primarySlider = new Splide('#proposal-primary-slide', {
        type: 'fade',
        heightRatio: 0.3,
        pagination: false,
        arrows: false,
        height: 640,
        cover: true,
        disableOverlayUI: false,
        lazyLoad: 'sequential',
        breakpoints: {
            1650: {
                height: 580,
            },
            960: {
                height: 270,
            },
        },
        video: {
            loop: false,
            playerOptions: {
                youtube: {},
            }
        }
    });
}

if (
    document.getElementById('proposal-primary-slide') &&
    document.getElementById('proposal-secondary-slide')
) {
    primarySlider.sync(secondarySlider).mount({Video});
} else {
    // primarySlider.mount({Video});
}

