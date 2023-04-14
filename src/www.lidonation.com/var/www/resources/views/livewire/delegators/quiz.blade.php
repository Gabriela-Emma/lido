@if($everyEpochQuestion['answers'])
    <div>
        <div class="flex flex-col justify-center items-center" x-show="!!quiz && !stakeAccount"
             @lido-rewards-loaded.window="seeRewards(true)">
            <h2>
                Let's get you connected!
            </h2>
            <x-delegators.connect-wallet/>
        </div>
        <div x-show="!!quiz && stakeAccount" x-transition
             class="flex flex-col gap-4 justify-center items-center">
            <div>
                <p class="text-xl lg:text-2xl xl:text-4xl 2xl:text-6xl">
                    <span x-show="correct">You're Correct!</span>
                    <span x-show="!correct">Sorry, that's not quite it.</span>
                </p>
            </div>
            <div class="text-center">
                <svg x-show="correct" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="currentColor" class="w-16 h-16 text-green-500 mx-auto">
                    <path fill-rule="evenodd"
                          d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                          clip-rule="evenodd"/>
                </svg>
                <svg x-show="!correct" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="currentColor" class="w-16 h-16 text-pink-600 mx-auto">
                    <path fill-rule="evenodd"
                          d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm-4.34 7.964a.75.75 0 01-1.061-1.06 5.236 5.236 0 013.73-1.538 5.236 5.236 0 013.695 1.538.75.75 0 11-1.061 1.06 3.736 3.736 0 00-2.639-1.098 3.736 3.736 0 00-2.664 1.098z"
                          clip-rule="evenodd"/>
                </svg>
                <div class="my-4" x-show="!correct">
                    <x-markdown>
                        {{$everyEpochQuestion['content']}}
                    </x-markdown>
                </div>
            </div>
            <div class="border-b border-teal-900 w-full">
                <div x-show="correct">
                    <h2 class="text-center">Claim your reward</h2>
                    <div class="flex gap-4 my-4 w-full">
                        <livewire:rewards.claim-lido-rewards-component :rewards-template="$rewardsTemplate"
                                                                       :every-epoch="$everyEpoch"/>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <p class="italic font-medium text-slate-100">
                                LIDO delegators gets a bonus!
                            </p>
                        </div>
                    </div>
                    <div
                        class="-mx-4 mt-4 overflow-hidden ring-1 ring-teal-800 sm:-mx-6 md:mx-0 md:rounded-sm">
                        <table class="min-w-full divide-y divide-teal-800">
                            <thead class="">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-100 sm:pl-6">
                                    Stake
                                </th>
                                <th scope="col"
                                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-100 sm:table-cell">
                                    Bonus
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-teal-800">
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                    100 staked
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                    15%
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                    1,000 staked
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                    30%
                                </td>
                            </tr>

                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                    8,000 staked
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                    55%
                                </td>
                            </tr>

                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                    20,000 staked
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                    85%
                                </td>
                            </tr>

                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                    30,000 staked
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                    100%
                                </td>
                            </tr>

                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                    50,000 staked
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                    125%
                                </td>
                            </tr>

                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                    75,000 staked
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                    150%
                                </td>
                            </tr>

                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                    100,000 staked
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                    200%
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <form class="" @submit.prevent="submitResponse" x-show="!quiz" x-transition>
            <h2 class="text-xl md:text-2xl xl:text-3xl 2xl:text-4xl mb-3">
                {{$everyEpochQuiz->title}} <span class="text-white text-lg text-yellow-500"> - Take the quiz!</span>
            </h2>
            @csrf
            <div
                class="rounded-sm border border-dashed border-white p-4 flex flex-col gap-6">
                <div class="space-y-3">
                    <p class="text-lg md:text-xl xl:text-2xl 2xl:text-3x xl:leading-12 2xl:leading-12 inline box-border box-decoration-clone p-2 tracking-wide bg-white text-teal-900 relative -left-8">
                        {{$everyEpochQuestion['title']}}
                    </p>
                    <div class="text-slate-100 font-thin italic flex gap-2">
                        <p>Hint:</p>
                        <x-markdown>
                            {{$everyEpochQuestion['content']}}
                        </x-markdown>
                    </div>
                    <input name="question" type="hidden" value="{{$everyEpochQuestion['id']}}"/>
                    <input name="quiz" type="hidden" value="{{$everyEpochQuiz['id']}}"/>
                </div>
                <div>
                    <div
                        x-data='{
                            value: null,
                            myResponseQuestionId: @js($myResponse?->question_answer_id),
                            prefilled: false,
                            select(option) { this.value = option },
                            isSelected(option) { return this.value === option },
                            hasRovingTabindex(option, el) {
                                // If this is the first option element and no option has been selected, make it focusable.
                                if (this.value === null && Array.from(el.parentElement.children).indexOf(el) === 0) return true

                                return this.isSelected(option)
                            },
                            selectNext(e) {
                                let el = e.target
                                let siblings = Array.from(el.parentElement.children)
                                let index = siblings.indexOf(el)
                                let next = siblings[index === siblings.length - 1 ? 0 : index + 1]

                                next.click(); next.focus();
                            },
                            selectPrevious(e) {
                                let el = e.target
                                let siblings = Array.from(el.parentElement.children)
                                let index = siblings.indexOf(el)
                                let previous = siblings[index === 0 ? siblings.length - 1 : index - 1]

                                previous.click(); previous.focus();
                            },
                            init() {
                                this.option = this.myResponseQuestionId;
                                this.select(this.option);
                                this.prefilled = !!this.myResponseQuestionId;
                            }
                        }'
                        @keydown.down.stop.prevent="selectNext"
                        @keydown.right.stop.prevent="selectNext"
                        @keydown.up.stop.prevent="selectPrevious"
                        @keydown.left.stop.prevent="selectPrevious"
                        role="radiogroup"
                        :aria-labelledby="$id('radio-group-label')"
                        x-id="['radio-group-label']"
                        class="max-w-lg w-full h-full relative">
                        <!-- Radio Group Label -->
                        <label :id="$id('radio-group-label')" role="none" class="hidden">
                            {{$everyEpochQuestion['content']}}<span x-text="value"></span>
                        </label>
                        <input name="answer" type="hidden" x-model="value"/>

                        <div class="mt-4 space-y-2 relative h-full w-full">
                            <div class="absolute w-full h-full left-0 top-0 z-10"
                                 x-show="prefilled"></div>

                            <!-- Option -->
                            @foreach($everyEpochQuestion['answers'] as $answer)
                                <div
                                    x-data="{ option: {{$answer['id']}} }"
                                    @click="select(option)"
                                    @keydown.enter.stop.prevent="select(option)"
                                    @keydown.space.stop.prevent="select(option)"
                                    :aria-checked="isSelected(option)"
                                    :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                    :aria-labelledby="$id('radio-option-label')"
                                    :aria-describedby="$id('radio-option-description')"
                                    x-id="['radio-option-label', 'radio-option-description']"
                                    role="radio"
                                    data-answer="{{ json_encode($answer) }}"
                                    class="flex cursor-pointer border border-slate-200 w-full justify-between items-center p-2 bg-slate-100/80 rounded-sm text-slate-800 answer"
                                >
                                    <span class="mr-3">
                                        <!-- Primary Label -->
                                        @if(!$myResponse)
                                            <p class="text-lg leading-none"
                                               :id="$id('radio-option-label')">{{ $answer['content'] }}</p>
                                        @else
                                            @if($myResponse->question_answer_id === $answer['id'])
                                                <p class="{{$myResponse->correct ? 'text-green-500' : 'text-pink-500'}} text-lg leading-none">
                                                    {{ $answer['content'] }}
                                                </p>
                                            @else
                                                <p class="text-lg leading-none {{ $answer['correct'] ? 'text-green-600 font-bold' : '' }}">
                                                    {{ $answer['content'] }}
                                                </p>
                                            @endif
                                        @endif

                                        @if($answer['hint'])
                                            <!-- Hint -->
                                            <span :id="$id('radio-option-description')"
                                                  class="mt-0.5 text-sm text-slate-700">
                                            {{$answer['hint']}}
                                        </span>
                                        @endif
                                    </span>

                                    <!-- Checked Indicator -->
                                    @if(!$myResponse)
                                        <span
                                            :class="{ 'bg-green-500': isSelected(option) }"
                                            class="mt-1 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full border-2 border-white ring-1 ring-slate-600"
                                            aria-hidden="true"></span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <footer class="mt-4">
                <div
                    class="flex {{!!$myResponse?->question_answer_id ? 'justify-between' : 'justify-end'}} items-center gap-8">
                    @if($myResponse)
                        <div class="text-slate-200 text-sm">
                            <div class="font-bold">
                                Quiz Completed
                                <x-carbon :date="$myResponse->created_at" human/>
                                !
                            </div>
                            <p class="text-xs">
                                Come back next epoch for another chance to play.
                            </p>
                        </div>
                    @endif
                    <button type="submit" :disabled="@js($myResponse?->question_answer_id)"
                            class="inline-flex items-center gap-2 rounded-sm border border-slate-300 bg-white px-3 py-2 text-lg font-medium leading-5 text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        <span>Submit</span>
                        <span class="text-slate-400 text-sm">
                            {{ !!$myResponse?->question_answer_id ? ' - completed' : '' }}
                        </span>
                    </button>
                </div>
            </footer>
        </form>
    </div>
@else
    <p>Error loading quiz.</p>
@endif
