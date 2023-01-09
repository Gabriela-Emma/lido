<div x-data="{ replying: {{json_encode($this->writing)}} }" >
    <div class="flex">
        <div class="flex-shrink-0 mr-3">
            <img class="w-8 h-8 rounded-sm sm:w-10 sm:h-10" src="{{$review->gravatar}}"
                 alt="Commenter gravatar">
        </div>

        <div class="flex-1 px-4 leading-relaxed sm:px-6">
            <div class="flex flex-row gap-1 items-center">
                <strong>{{$review->name}}</strong>
                @if(!!$review?->rating?->rating)
                    <x-public.stars :amount="$review?->rating?->rating" :size="3"/>
                @endif
            </div>

            @if($review->created_at_formatted)
            <div class="space-x-1 text-xs text-gray-400">
                <span>{{$review->created_at_formatted}}</span>
            </div>
            @endif

            <x-markdown>{{$review->content}}</x-markdown>

            @if($editable)
            <span @click="replying=!replying">
                <span class="text-sm font-semibold text-teal-600 hover:text-yellow-500 hover:cursor-pointer"
                      wire:click="$emitSelf('replyToReview', {{$review->id}})">reply</span>
            </span>
            @endif

            @if($review->children?->isNotEmpty())
                <div class="flex items-center mt-4">
                    <div class="py-16 pt-8 max-w-5xl">
                        <livewire:discussions.reviews-component :discussion="$discussion" :reviews="$review->children"/>
                    </div>
                </div>
            @endif

            @if($review->assessment_review_assessor)
            <div class="bg-primary-30 py-6 px-4 sm:px-6 sm:rounded-sm gap-10 lg:grid lg:grid-cols-12 mt-3">
                <div class="col-span-12 mb-4 md:mb-1">
                    <h2>Assessment Quality Assurance </h2>
                    <p class="text-sm">Assessment Quality Assurance is an offered role to veteran in the Cardano Project Catalyst Community.
                        The purpose is to review PA assessments of proposals, providing a second layer of Quality Assurance.</p>
                </div>

                <div class="text-sm lg:col-span-7">
                    <div class="w-full md:w96 h-28">
                        <div
                            x-data="{
                                        labels: ['vPA Result'],
                                        values: [
                                            @js($review->assessment_review_assessor?->assessment_review?->excellent_count),
                                            @js($review->assessment_review_assessor?->assessment_review?->good_count),
                                            @js($review->assessment_review_assessor?->assessment_review?->filtered_out_count)
                                        ],
                                        canvas: 'review_{{$review->id}}_qa_canvas',
                                        init() {
                                            let chart = new Chart(this.$refs[this.canvas].getContext('2d'), {
                                                type: 'bar',
                                                data: {
                                                    labels: this.labels,
                                                    datasets: [{
                                                        data: [{{$review->assessment_review_assessor?->assessment_review?->excellent_count}}],
                                                        label: 'Excellent',
                                                        barThickness: 20,
                                                        backgroundColor: '#00b2b2',
                                                        borderColor: '#00b2b2'
                                                    },{
                                                        data: [{{$review->assessment_review_assessor?->assessment_review?->good_count}}],
                                                        label: 'Good',
                                                        barThickness: 16,
                                                        backgroundColor: '#456eb6',
                                                        borderColor: '#456eb6'
                                                    },{
                                                        data: [{{$review->assessment_review_assessor?->assessment_review?->filtered_out_count}}],
                                                        label: 'Filtered Out',
                                                        barThickness: 16,
                                                        backgroundColor: '#807d9c',
                                                        borderColor: '#807d9c'
                                                    }],
                                                },
                                                options: {
                                                    indexAxis: 'y',
                                                    responsive: true,
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
                                                }
                                            });

                                            this.$watch('values', () => {
                                                chart.data.labels = this.labels
                                                chart.data.datasets[0].data = this.values
                                                chart.update()
                                            })
                                        }
                                    }"
                            class="w-full h-28"
                        >
                            <canvas x-ref="review_{{$review->id}}_qa_canvas" class="rounded-sm"></canvas>
                        </div>
                    </div>
                </div>

                <dl class="mt-8 divide-y divide-phuffy2-200 lg:mt-0 lg:col-span-5">
                    <div class="pb-2 flex items-center text-xs md:text-sm justify-between">
                        <dt class="text-gray-600">Assessor ID</dt>
                        <dd class="font-medium text-gray-900">
                            {{ $review?->assessment_review_assessor?->assessor?->assessor_id }}
                        </dd>
                    </div>
                    <div class="py-2 flex items-center text-xs md:text-sm justify-between">
                        <dt class="text-gray-600">Total QA Ratings</dt>
                        <dd class="font-medium text-gray-900">
                            {{ $review?->total_qas ?? '-' }}
                        </dd>
                    </div>
                    <div class="py-2 flex text-sm md:text-base items-center justify-between">
                        <dt class="text-gray-600">QA Rating Outcome</dt>
                        <dd class="font-medium text-gray-900">
                            {{ $review?->meta_data->vpa_rating }}
                        </dd>
                    </div>
                </dl>
            </div>
            @endif
        </div>
    </div>

    @if($this->replySubmitted && !$this->writing)
        <div class="flex flex-row justify-center p-8">
            <div class="p-4 rounded-md bg-accent-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: solid/check-circle -->
                        <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xl font-medium text-black">
                            {{$snippets->commentThanksMessage}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div x-show="replying">
        <div class="pt-4">
            <x-public.review-form
                :parentId="$parentId"
                :modelId="$discussion->id"
                :model="$discussion"
                :prompt="'Replying to ' . $review->name . (!!$review->title ? (': ' . $review->title) : '')"
                :modelType="'App\Models\Discussion'" />
        </div>
    </div>
</div>
