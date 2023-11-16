import './bootstrap';
import '../scss/lido.scss';
import Rellax from 'rellax/rellax';
import Chart from 'chart.js/auto';
import {WordCloudController, WordElement} from 'chartjs-chart-wordcloud';
import globalVideoPlayer from './global/utils/globalVideoPlayer';

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
window.globalReactions = globalReactions
