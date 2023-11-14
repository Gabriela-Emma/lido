  <div>
      <ul role="list" class="divide-y divide-gray-100 h-full px-2">
          {{-- {{dd($podcasts)}} --}}
          @foreach ($podcasts as $podcast)
              <li @click="queueOrPauseContent(@js($podcast->stream_id))"
                  class="flex flex-wrap items-center justify-between py-3 gap-x-6 gap-y-2 sm:flex-nowrap hover:cursor-pointer">
                  <div>
                      <p class="text-sm font-semibold leading-6 text-gray-900">
                      <span>EP{{ $podcast->episode }}:</span>
                      <span href="#" class="">{{ $podcast->title }}</span>
                      </p>
                      <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                          <p class="italic">
                              Authored by: {{ $podcast->author->name }}
                          </p>
                          <div class="text-xs">
                              <span>
                                  {{ Carbon\CarbonInterval::seconds($podcast->length)->cascade()->forHumans(null, true) }}
                              </span>
                          </div>
                          {{-- <p>
                      <time :datetime="discussion.dateTime">{{ discussion . date }}</time>
                  </p> --}}
                      </div>
                  </div>
                  <dl class="flex justify-between flex-none w-full gap-x-8 sm:w-auto">
                      <div class="flex -space-x-0.5">
                          <dt class="sr-only">Commenters</dt>
                          <dd>
                              <img class="w-6 h-6 rounded-full bg-gray-50 ring-2 ring-white"
                                  src="{{ $podcast->author->profile_photo_url ?? $podcast->author->garavatar }}"
                                  alt="{{ $podcast->author->name }}" />
                          </dd>
                      </div>
                  </dl>
              </li>
          @endforeach
      </ul>
  </div>
