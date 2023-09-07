<template>
    <div
        class="relative flex flex-col justify-start w-full mb-4 bg-white rounded-sm shadow-sm break-inside-avoid drip">
        <div class="p-5 break-words break-long-words">
            <b class="block text-sm font-bold">{{ assessment.label }}</b>
            <div v-html="$filters.markdown(assessment.rationale)"></div>
        </div>

        <div class="p-5 mt-16 divide-y divide-teal-300 specs">
            <div
                class="flex flex-row items-center justify-between gap-4 py-4 border-t border-teal-300 spec-amount-received">
                <div class="text-sm text-teal-800 opacity-50">{{ $t('Assessor') }}</div>
                <div class="text-base font-bold text-teal-800">
                    {{ assessment.assessor }}
                </div>
            </div>
            <div class="flex flex-row items-center justify-between gap-4 py-4 spec-amount-received">
                <div class="text-sm text-teal-800 opacity-50">{{ $t('Rating') }}</div>
                <div>
                    <Rating :modelValue="assessment.rating" :stars="5" :readonly="true" :cancel="false">
                        <template #onicon>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-4 h-4 text-teal-500">
                                <path
                                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                            </svg>
                        </template>
                        <template #officon>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                        </template>
                    </Rating>
                </div>
            </div>

            <div class="flex flex-row items-center justify-between gap-4 py-4 spec-title">
                <div class="text-sm text-teal-800 opacity-50">{{ $t('Proposal') }}</div>
                <a class="inline-flex text-base font-medium text-teal-800 hover:text-yellow-500"
                   target="_blank" :href="$utils.localizeRoute(`proposals/${assessment?.proposal?.slug}`)">
                    {{ assessment.proposal.title }}
                </a>
            </div>

            <!--            <div class="flex flex-row items-center justify-between gap-4 py-4">-->
            <!--                <div class="text-sm text-teal-800 opacity-50">Status</div>-->
            <!--                <div class="text-base font-medium text-teal-800">-->
            <!--                    {{ assessment.project_status || '-' }}-->
            <!--                </div>-->
            <!--            </div>-->

            <!--            <div class="flex flex-row items-center justify-between gap-4 py-4">-->
            <!--                <div class="text-sm text-teal-800 opacity-50">-->
            <!--                    Completion Target-->
            <!--                </div>-->
            <!--                <div class="text-base font-medium text-teal-800">-->
            <!--                    {{ assessment.completion_target || '-' }}-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
        <div v-if="new Date(assessment.proposal.fund.launched_at) <= new Date(launchTimestamp)">
        <div class="p-2 bg-stone-100">
            <b class="block text-sm font-bold">
                {{ $t('vPA Quality Assurance') }}
            </b>
<!--            <div>-->
<!--                Assessment Quality Assurance is an offered role to veteran in the Cardano Project Catalyst Community.-->
<!--                The purpose is to review PA assessments of proposals, providing a second layer of Quality Assurance.-->
<!--            </div>-->
        </div>
        <div class="p-2 bg-stone-100">
            <Bar
                :id="`assessment-${assessment.id}`"
                :options="chartOptions"
                :data="chartData"
            />
        </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {inject, ref} from "vue";
import Assessment from "../../models/assessment";
import Rating from 'primevue/rating';
import {Bar} from 'vue-chartjs';
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const $utils: any = inject('$utils');
const props = withDefaults(
    defineProps<{
        locale?: string,
        assessment: Assessment
    }>(),
    {
        assessment: () => {
            return {} as Assessment;
        },
    },
);

let chartData = ref({
    labels: ['vPA Result'],
    datasets: [
        {
            label: 'Excellent',
            barThickness: 20,
            backgroundColor: '#00b2b2',
            borderColor: '#00b2b2',
            data: [props.assessment.qa_excellent_count]
        },
        {
            label: 'Good',
            barThickness: 16,
            backgroundColor: '#456eb6',
            borderColor: '#456eb6',
            data: [props.assessment.qa_good_count]
        },
        {
            label: 'Filtered Out',
            barThickness: 16,
            backgroundColor: '#807d9c',
            borderColor: '#807d9c',
            data: [props.assessment.qa_filtered_out_count]
        }
    ]
});

const launchTimestamp = '2023-06-01T00:00:00.000000Z';

let chartOptions = ref({
    responsive: true,
    indexAxis: 'y',
    maintainAspectRatio: false,
    scales: {
        x: {
            display: true,
            stacked: true,
            grid: {
                borderColor: '#cdc9e8',
                color: '#cdc9e8'
            },
            ticks: {
                min: 1,
                stepSize: 2,
                beginAtZero: false,
            }
        },
        y: {
            stacked: true,
            display: false,
            grid: {
                borderColor: '#cdc9e8',
                color: '#cdc9e8'
            },
        }
    },
    plugins: {
        legend: {
            display: true,
            position: 'top',
            align: 'center',
            labels: {
                boxWidth: 20,
                boxHeight: 8,
                padding: 16
            },

        },
        tooltip: {
            displayColors: false,
            callbacks: {
                title() {
                    return '';
                },
                label(point) {
                    return `${point.dataset.label}: ${point.dataset.data[0]}`
                }
            }
        }
    }
});
</script>
