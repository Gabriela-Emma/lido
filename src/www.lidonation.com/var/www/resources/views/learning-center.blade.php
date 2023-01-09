<x-public-layout class="team" :metaTitle="'Learning Center'">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class='font-black block'>{{__('Learning') }}</span>
            <span class='font-thin'>{{__('Center') }}.</span>
        </x-slot>

        <p>
            Articles, how-tos, personal experiences, and cryptography paper explorations for the community by the
            community.
            Please enjoy; we encourage you to be an active participant by dropping us a note, leaving a comment, or
            submit content!
        </p>
    </x-public.page-header>

    <section class="relative py-32 bg-pool-bw-light bg-cover bg-right-bottom bg-opacity-50 bg-white"
             style="background-blend-mode: lighten" aria-labelledby="quick-links-title">
        <div class="container">
            <div
                class="rounded-md bg-gray-200 overflow-hidden shadow divide-y divide-gray-300 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
                <div
                    class="rounded-tl-md rounded-tr-md sm:rounded-tr-none relative group bg-white p-6 hover:ring-2 hover:ring-inset hover:ring-primary-500 hover:ring-opacity-75">
                    <div>
                      <span class="rounded-lg inline-flex p-3 bg-secondary-50 text-secondary-700">
                          <img class="h-6 w-6" src="{{asset('img/baby-icon.png')}}">
                      </span>
                    </div>
                    <div class="mt-8">
                        <h2 class="text-2xl font-medium">
                            <a href="{{localizeRoute('noobs')}}" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Noobs
                            </a>
                        </h2>
                        <p class="mt-2 text-gray-500">
                            What is Cardano or what does cardano have to do staking, delegation, voting, identity? If
                            you're new to cardano/ada and not sure how to answer these questions,
                            visit here.
                        </p>
                    </div>
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                      <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"/>
                      </svg>
                    </span>
                </div>

                <div
                    class="sm:rounded-tr-lg relative group bg-white p-6 hover:ring-2 hover:ring-inset hover:ring-primary-500 hover:ring-opacity-75">
                    <div>
                      <span class="rounded-lg inline-flex p-3 bg-accent-50 text-accent-700 ring-4 ring-white">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 145.556 120.735"><defs><style>.cls-1{isolation:isolate;}.cls-2{mix-blend-mode:multiply;}.cls-3{fill:none;stroke:#4a5557;stroke-linecap:round;stroke-miterlimit:10;stroke-width:0.694px;}.cls-4{fill:#f9bfbb;}</style></defs><title>brain</title><g class="cls-1"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1" class="cls-2"><path class="cls-3" d="M65.4,4.581A6.523,6.523,0,0,0,53.18,5.2,7.415,7.415,0,0,0,39.538,7.588,5.982,5.982,0,0,0,32.9,6.1c-2.565,1.027-3.292,3-3.389,5.714a3.969,3.969,0,0,0-6.775,2.968,4.524,4.524,0,0,0-5.655,4.508,9.444,9.444,0,0,0-7.842,11.47,6.579,6.579,0,0,0-3.364,2.2C3.855,35.53,4.3,39.478,4.639,39.545A.181.181,0,0,0,4.7,39.54a5.116,5.116,0,0,0-1.314,8.932,11.91,11.91,0,0,0-3.02,7.217c-.29,5.8,4.054,9.466,4.558,9.877a11.751,11.751,0,0,0,5.167,6.99,11.622,11.622,0,0,0,7.6,1.519A6.66,6.66,0,0,0,23,76.051a6.244,6.244,0,0,0,3.5-1.672,8.17,8.17,0,0,0,6.989,2.279,7.94,7.94,0,0,0,5.167-3.646,4.76,4.76,0,0,0,3.8,3.5,4.963,4.963,0,0,0,5.166-4.559l4.863,1.519a10.757,10.757,0,0,0-4.559,8.358,10.3,10.3,0,0,0,5.47,9.117A8.407,8.407,0,0,0,67.22,97.78a15.19,15.19,0,0,0,3.718,1.331,14.574,14.574,0,0,0,15.1-5.782,8.035,8.035,0,0,0,6.264-.482,7.822,7.822,0,0,0,3.372-3.694,16.438,16.438,0,0,0,9,.16c7.16-1.955,10.274-8.284,10.761-9.315A11.721,11.721,0,0,0,127.8,76.785c4.526,2.173,9.668,1.837,13.171-.963a12.177,12.177,0,0,0,4.176-8.352,14,14,0,0,0-2.891-9.8,7.873,7.873,0,0,0,1.124-6.424,7.735,7.735,0,0,0-3.534-4.5,5.14,5.14,0,0,0,.643-3.694,5.472,5.472,0,0,0-3.373-3.694,6.049,6.049,0,0,0-3.212-6.746,7.175,7.175,0,0,0-1.767-5.3,7.284,7.284,0,0,0-5.782-2.248,8.143,8.143,0,0,0-8.192-6.425,10.722,10.722,0,0,0-4.176-7.388,10.948,10.948,0,0,0-9.476-1.446,7.392,7.392,0,0,0-3.533-4.5,7.472,7.472,0,0,0-8.031.964,6.144,6.144,0,0,0-10.6-2.731A11.859,11.859,0,0,0,75.072.367,12.407,12.407,0,0,0,65.4,4.581Z"/><path class="cls-3" d="M92.193,7.952a4.167,4.167,0,0,1-1.636,1.239c-1.456.6-3.117.637-4.508,1.377a5.1,5.1,0,0,0-2.256,6.192,6.081,6.081,0,0,0-7.984,7.131,3.213,3.213,0,0,0-4.281-.608,5.783,5.783,0,0,0-2.308,4.035,36.636,36.636,0,0,0-.163,4.782A21.847,21.847,0,0,1,60.2,48.911"/><path class="cls-3" d="M89.8,44.465a4.669,4.669,0,0,1-2.091,2.2,2.538,2.538,0,0,1-2.863-.43c-1.259-1.366-.161-3.6-.637-5.4-.593-2.235-3.657-3.05-5.708-1.982s-3.162,3.368-3.673,5.623A13.989,13.989,0,0,0,76.85,55.742,10.209,10.209,0,0,0,87.209,59.8a11.725,11.725,0,0,0,2.834-.842c1.922-.933,3.458-2.5,5.245-3.669a6.392,6.392,0,0,1,6.366-.837l.437-3.7c.391-3.325.7-7-1.253-9.722a13.65,13.65,0,0,0-4.86-3.669l-3.545-1.918"/><path class="cls-3" d="M107.392,35.843a15.261,15.261,0,0,0-5.185,9.471"/><path class="cls-3" d="M83.149,39.516a30.011,30.011,0,0,0,.284-11.164,15.142,15.142,0,0,0,9.807-9.009,9.6,9.6,0,0,0,10.314-7.756"/><path class="cls-3" d="M72.547,6.492a5.555,5.555,0,0,0-5.09,6.766,5.357,5.357,0,0,0-5.733,2.877,9.3,9.3,0,0,0-.442,6.736c.379,1.412.966,2.77,1.2,4.212.77,4.657-2.15,9.041-4.925,12.859"/><path class="cls-3" d="M95.643,26.856c1.524,2.516,5.248,3.034,7.821,1.608,1.675-.927,2.916-2.464,4.425-3.642,3.035-2.37,6.779-2.029,9.989-.064a6.922,6.922,0,0,1,3.508,5.739c-.044,2.677-2.061,5.079-1.873,7.749.139,1.951,1.421,3.6,2.325,5.332a13,13,0,0,1,1.072,9.581,10.509,10.509,0,0,1-6.492,6.95"/><path class="cls-3" d="M49.5,14.217a7.194,7.194,0,0,1,3.341,6.28A9.082,9.082,0,0,1,49.649,27"/><path class="cls-3" d="M61.516,22.84a12.3,12.3,0,0,1-3.038,5.044,5.351,5.351,0,0,1-5.5,1.212c-1.257-.543-2.18-1.691-3.446-2.214-1.87-.774-4.079.019-5.6,1.36a22.99,22.99,0,0,0-3.629,4.842A10.44,10.44,0,0,1,36,37.236a5.84,5.84,0,0,1-7.354-2.689,5.225,5.225,0,0,1,3.074-6.971"/><path class="cls-3" d="M28.388,31.644a1.486,1.486,0,0,1-.972.689,7.465,7.465,0,0,1-8.221-2.85,3.787,3.787,0,0,1-.605-1.31c-.467-2.184,1.15-2.676,2.927-2.6a8.606,8.606,0,0,1,2.042-8.155,10.993,10.993,0,0,1,7.892-3.32,14.722,14.722,0,0,1,10.542,4.456,15.19,15.19,0,0,0,1.824,2.012,2.373,2.373,0,0,0,2.534.405"/><path class="cls-3" d="M43.165,29.257c1.3,1.316,2.69,2.893,2.5,4.73A5.46,5.46,0,0,1,44.4,36.655c-2.165,2.827-5.144,5.13-6.465,8.437a9.759,9.759,0,0,0,5.352,12.645"/><path class="cls-3" d="M53.75,29.017c1.178,4.1-.277,8.438-1.648,12.477C50.376,46.579,48.745,51.8,48.75,57.173s1.88,10.988,6.076,14.339"/><path class="cls-3" d="M61.183,50.17a7.586,7.586,0,0,1,3,4.866c.067.331.45,5.5-.548,5.06A9.475,9.475,0,0,1,69.157,67.8"/><path class="cls-3" d="M108.91,61.905c-2.313.66-2.878,3.729-4.73,5.263-2.415,2-5.982.821-9.034.1A25.684,25.684,0,0,0,77.884,69.29c-3.395,1.7-6.36,4.141-9.587,6.144s-6.9,3.608-10.694,3.347"/><path class="cls-3" d="M42.19,8.626a19.912,19.912,0,0,0-1.253,4.934,7.389,7.389,0,0,0,.671,4.728"/><path class="cls-3" d="M8.66,37.67a13.981,13.981,0,0,1,6.175-9.953"/><path class="cls-3" d="M36.858,48.913a2.865,2.865,0,0,1-3.2,2.447,4.423,4.423,0,0,1-3.33-2.746,3.667,3.667,0,0,1-3.045,4.354,4.175,4.175,0,0,1-4.377-3.3,9.9,9.9,0,0,1,.073,3.028,3.35,3.35,0,0,1-1.633,2.437,3.823,3.823,0,0,1-3.569-.436c-3.082-1.824-4.531-5.57-4.839-9.139"/><path class="cls-3" d="M12.522,60.312c-3.1-1.269-5.8-3.859-6.473-7.136a10.856,10.856,0,0,1,1.792-7.823,32.189,32.189,0,0,1,5.507-6.079"/><path class="cls-3" d="M28.05,22.429a69.991,69.991,0,0,0,5.271,7.059"/><path class="cls-3" d="M67.052,81.635A14.851,14.851,0,0,1,68.9,75.32"/><path class="cls-3" d="M101.51,54.312l2.393,1.2"/><path class="cls-3" d="M126.8,29.39a15.136,15.136,0,0,1,4.139,12"/><path class="cls-3" d="M128.809,31.72a7.326,7.326,0,0,0,1.373-1.561"/><path class="cls-3" d="M130.835,36.327l2.447-.311"/><path class="cls-3" d="M18.561,54.868a17.018,17.018,0,0,0,9.268,14.54"/><path class="cls-3" d="M67.371,88.756a6.628,6.628,0,0,0,3.412-1.034,6.79,6.79,0,0,0,2.791-3.792,7.205,7.205,0,0,0,1.645-.709,7.751,7.751,0,0,0,3.057-3.476"/><path class="cls-3" d="M69.7,83.542,73.617,84q.294,2.347.587,4.7"/><path class="cls-3" d="M86.631,87.537a8.79,8.79,0,0,0-1.674-14.276"/><path class="cls-3" d="M90.508,74.358a5.619,5.619,0,0,0-1.38,4.184"/><path class="cls-3" d="M94.739,78.768a41.914,41.914,0,0,0,18.621-.352"/><path class="cls-3" d="M125.563,58.505a13.083,13.083,0,0,1,5.308,3.166,8.006,8.006,0,0,1,1.614,6.47,13.8,13.8,0,0,1-2.917,6.157"/><path class="cls-3" d="M130.794,51.964a6.982,6.982,0,0,1,2.166,4.956,9.861,9.861,0,0,1-1.49,5.278"/><path class="cls-3" d="M133.224,56.936A6.423,6.423,0,0,0,137.3,53"/><path class="cls-3" d="M137.229,57.719a8.031,8.031,0,0,0-1.485-2.184"/><path class="cls-3" d="M136.2,51.978a4.977,4.977,0,0,0,2.227,1.287"/><path class="cls-3" d="M123.059,49.517a6.849,6.849,0,0,0,7.41-4.457"/><path class="cls-3" d="M127.7,51.925l-.742-2.684"/><path class="cls-3" d="M129.817,46.843l1.565.592"/><path class="cls-3" d="M42.963,49.535c1.209,2.117,1.02,4.742.542,7.132s-1.214,4.789-.982,7.216a9.3,9.3,0,0,0,3.73,6.537"/><path class="cls-3" d="M42.18,64.255a8.528,8.528,0,0,1-5.11-.826"/><path class="cls-3" d="M11.408,38.055c2.374.264,4.246,2.04,6.254,3.332a16.871,16.871,0,0,0,4.319,1.982c2.054.61,4.575.7,6.03-.87"/><path class="cls-3" d="M70.677,101.594A15.386,15.386,0,0,0,86.866,95.62a8.621,8.621,0,0,0,4.9,0A8.785,8.785,0,0,0,96.637,91.8,17.958,17.958,0,0,0,107.4,91.33a18.2,18.2,0,0,0,9.615-8.5,13.493,13.493,0,0,0,4.439.032,13.939,13.939,0,0,0,7-3.375,11.783,11.783,0,0,0,13.022-1.584"/><path class="cls-4" d="M80.857,115.3c4.186,1.63,9.671-.052,11.456-4.175,2.737,3.858,6.121,7.591,10.637,9a16.752,16.752,0,0,0,10.852-.682,37.641,37.641,0,0,0,9.447-5.709,59.745,59.745,0,0,0,14.163-14.847c3.678-5.808,5.918-12.678,5.437-19.535a19.307,19.307,0,0,1-15.159,2.771,19.4,19.4,0,0,1-9.79,3.2A19.937,19.937,0,0,1,97.4,94.835a8.5,8.5,0,0,1-10.432,3.309,13.391,13.391,0,0,1-14.749,6.237C73.8,108.524,76.255,113.5,80.857,115.3Z"/><path class="cls-3" d="M95.328,101.22c-3.332,13.162,16.578,14.472,24.361,12.487"/><path class="cls-3" d="M88.261,101.132c5.6,1.044,11.28-1.032,16.437-3.444s10.29-5.246,15.951-5.848c6.728-.715,13.543,1.812,20.225.75"/><path class="cls-3" d="M127.6,91.768a5.18,5.18,0,0,0,3.191-3.355,5.026,5.026,0,0,0-.609-3.877l2.032-1.554"/><path class="cls-3" d="M121.578,84.775l8.6-.359"/></g></g></g></svg>
                      </span>
                    </div>
                    <div class="mt-8">
                        <h2 class="text-2xl font-medium">
                            <a href="{{localizeRoute('white-papers')}}" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Paper Talk
                            </a>
                        </h2>
                        <p class="mt-2 text-gray-500">
                            This section takes notable and consequential papers across the blockchain space and talks about what
                            adopting its ideas within the paper means for the bourgeoisie and proletariat alike.
                        </p>
                    </div>
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                      <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"/>
                      </svg>
                    </span>
                </div>

                <div
                    class="relative group bg-white p-6 hover:ring-2 hover:ring-inset hover:ring-primary-500 hover:ring-opacity-75">
                    <div>
                      <span class="rounded-lg inline-flex p-3 bg-pink-50 text-pink-700 ring-4 ring-white">
                        <!-- Heroicon name: outline/users -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                      </span>
                    </div>
                    <div class="mt-8">
                        <h2 class="text-2xl font-medium">
                            <a href="{{localizeRoute('blockchain-glossary')}}" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Blockchain Glossary
                            </a>
                        </h2>
                        <p class="mt-2  text-gray-500">
                            Nuanced definitions of popular blockchain phrases and words to help you speak the speak, or
                            at least know what the kids are talking about.
                        </p>
                    </div>
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                      <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"/>
                      </svg>
                    </span>
                </div>

                <div
                    class="rounded-bl-lg rounded-br-lg sm:rounded-bl-none relative group bg-white p-6 hover:ring-2 hover:ring-inset hover:ring-primary-500 hover:ring-opacity-75">
                    <div>
                  <span class="rounded-lg inline-flex p-3 bg-primary-50 text-teal-700 ring-4 ring-white">
                    <!-- Heroicon name: outline/academic-cap -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                  </span>
                    </div>
                    <div class="mt-8">
                        <h2 class="text-2xl font-medium">
                            <a href="{{localizeRoute('news')}}" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                News
                            </a>
                        </h2>
                        <p class="mt-2 text-gray-500">
                            Curated and sometimes summarized announcements and news from notable teams and communities in
                            the Cardano ecosystem and blockchain space. We generally try to keep it positive and/or helpful; no FUD
                            here!
                        </p>
                    </div>
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"/>
                  </svg>
                </span>
                </div>
            </div>
        </div>
    </section>

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
