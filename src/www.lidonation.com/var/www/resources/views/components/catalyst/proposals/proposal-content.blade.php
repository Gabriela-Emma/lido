@props(['proposal'])

<div x-data="translateProposal">

    <div class=" text-white items-center border-t border-x border-slate-300 w-full bg-white" x-init="getContent({{json_encode($proposal->content)}})">
        <div class="items-center p-3 ">
            <div class="flex flex-row justify-between items-center h-10">
                <button x-show="!translate" @click="translate = !translate"
                    class="p-2 font-medium rounded-md mr-3 text-white  bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                                inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                    type="button">
                    Translate
                </button>

                <div>
                    <template x-if="translate" class="inline">
                        <div class=" items-center">
                            <div class=" w-full flex flex-col items-center ">
                                <div class="w-full px-4">
                                    <div class="">
                                        <div class="w-full shadow-sm ">
                                            <div @click.away="close()" x-init="getLangOptions()"
                                                class="my-2 p-1 bg-white flex border border-gray-200 rounded">
                                                <input placeholder="Select target language" x-model="filter"
                                                    x-transition:leave="transition ease-in duration-100"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" @mousedown="open()"
                                                    @click="toggleDropdown()"
                                                    @keydown.enter.stop.prevent="selectOption()"
                                                    @keydown.arrow-up.prevent="focusPrevOption()"
                                                    @keydown.arrow-down.prevent="focusNextOption()"
                                                    class="p-1 px-2 appearance-none outline-none w-full text-gray-800">
                                                <div
                                                    class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200">
                                                    <button @click="toggleDropdown()"
                                                        class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%"
                                                            height="100%" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline x-show="!isOpen()" points="18 15 12 20 6 15">
                                                            </polyline>
                                                            <polyline x-show="isOpen()" points="18 15 12 9 6 15">
                                                            </polyline>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div x-show="isOpen()"
                                            class="absolute z-50 w-1/4 mt-1 bg-white rounded-md shadow-lg">
                                            <div class="py-1" x-show="filteredOptions().length">
                                                <template x-for="(option, index) in filteredOptions()"
                                                    :key="option.value">
                                                    <div class="cursor-pointer text-black w-full border-gray-100 p-2 border-b hover:bg-teal-100"
                                                        :class="classOption(option.value, index)"
                                                        x-on:click="onOptionClick(index)" x-text="option.name">
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-show="targetLang" x-init="getModelData({{$proposal->id}})">
                    <button @click="getTranslation()" 
                        class="p-2 font-medium  rounded-md mr-3 text-white  bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                                    inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                        type="button">
                        Start Translation
                    </button>
                </div>

                <div class="" x-show="editing">
                  <button
                      class="p-2 font-medium  rounded-md mr-3 text-white  bg-teal-600 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-600text-center
                                  inline-flex items-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800"
                      type="button">
                      Save Translation
                  </button>
              </div>
            </div>
        </div>
    </div>
    <div x-data="{ heightClass: 'max-h-[50rem] overflow-clip', funded: @js($proposal->funded) }" :class=" {editing:'h-full'}" class="relative p-4 border border-slate-300 rounded-sm break-normal" x-show="1" >
        <div>
            <article :class="heightClass" x-transition x-show="1">
                @if ($proposal->content)
                    <x-markdown x-html="marked.parse(proposalContent)"></x-markdown>
                @endif

                @if ($proposal->definition_of_success)
                    <h2>Definition of Success</h2>
                    <x-markdown>{{ $proposal->definition_of_success }}</x-markdown>
                @endif
            </article>
        </div>
        <div x-show="0" >
          <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edit if needed and save transalation.</label>
          <textarea :class="heightClass" x-transition 
          class="block p-4 w-full h-[50rem]   text-gray-900 bg-white rounded-md border border-slate-300 focus:ring-teal-500 focus:border-teal-500" x-model="(proposalContent)">          
          </textarea>
        </div>
        <div @click="heightClass = ''" x-show="heightClass"
            class="absolute w-full  p-4 text-center bg-white/95 hover:cursor-pointer group bottom-4">
            <span class="font-bold text-teal-600 group-hover:text-slate-600">
                Expand
            </span>
          </div>
    </div>


</div>

<script>
function translateProposal() {
    return {
        model_id:null,
        translate: false,
        editing: false,
        openDropdown: false,
        startTranslation: false,
        translatedContent: null,
        filter: "",
        show: false,
        selected:null ,
        focusedOptionIndex: null,
        options:[],
        proposalContent:[],
        data:{},
        targetLang:"",
        locale:null,
        close() {
            this.show = false;
            this.filter = this.selectedName();
            this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
        },
        open() {
            this.show = true;
            this.filter = "";
        },
        toggleDropdown() {
            if (this.show) {
                this.close();
            } else {
                this.open();
            }
        },
        isOpen() {
            return this.show === true;
        },
        selectedName() {
            this.locale
            this.targetLang = this.selected.value 
            this.data['targetLanguage'] = this.targetLang.toUpperCase();
            return this.selected ? this.selected.name + " (" + this.selected.value + ")" : this.filter;
        },
        getLangOptions(){
            window.axios.get('/languageOptions')
            .then((res) => {
            this.options = res.data
            }
            )
        },
        classOption(id, index) {
            const isSelected = this.selected ? id == this.selected.value : false;
            const isFocused = index == this.focusedOptionIndex;
            return {
                "cursor-pointer w-full border-gray-100 border-b hover:bg-teal-100": true,
                "bg-teal-300": isSelected,
                "bg-teal-100": isFocused
            };
        },
        filteredOptions() {
            return this.options.filter(option => {
                return (
                    option.name.toLowerCase().indexOf(this.filter.toLowerCase()) > -1 ||
                    option.value.toUpperCase().indexOf(this.filter.toLowerCase()) > -1
                );
            });
        },
        onOptionClick(index) {
            this.focusedOptionIndex = index;
            this.selectOption();
        },
        selectOption() {
            if (!this.isOpen()) {
                return;
            }
            this.focusedOptionIndex = this.focusedOptionIndex ?? 0;
            const selected = this.filteredOptions()[this.focusedOptionIndex];
            if (this.selected && this.selected.value == selected.value) {
                this.filter = "";
                this.selected = null;
            } else {
                this.selected = selected;
                this.filter = this.selectedName();
            }
            this.close();
        },
        focusPrevOption() {
            if (!this.isOpen()) {
                return;
            }
            const optionsNum = Object.keys(this.filteredOptions()).length - 1;
            if (this.focusedOptionIndex > 0 && this.focusedOptionIndex <= optionsNum) {
                this.focusedOptionIndex--;
            } else if (this.focusedOptionIndex == 0) {
                this.focusedOptionIndex = optionsNum;
            }
        },
        focusNextOption() {
            const optionsNum = Object.keys(this.filteredOptions()).length - 1;
            if (!this.isOpen()) {
                this.open();
            }
            if (this.focusedOptionIndex == null || this.focusedOptionIndex == optionsNum) {
                this.focusedOptionIndex = 0;
            } else if (this.focusedOptionIndex >= 0 && this.focusedOptionIndex < optionsNum) {
                this.focusedOptionIndex++;
            }
        },
        getContent(content){
            this.proposalContent = content;
        },
        getModelData(id){
            this.model_id = id;
            this.data['content'] = this.proposalContent;
        },
        getTranslation(){
            window.axios.post('/translate/' + `${this.model_id}`,this.data)
            // .then((res) => {
            //     this.proposalContent = res.data;
            // })
        }        
    };
}
</script>
