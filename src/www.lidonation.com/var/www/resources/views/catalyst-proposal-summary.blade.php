<style>
    html,
    body {
        height: auto;
    }

    footer, #header, #mobile-menu, #top-blob, .global-banner, #global-video-player-wrapper {
        display: none !important;
    }
</style>
<x-public-layout class="proposal bg-gradient-to-br from-primary-800 via-primary-600 to-accent-900"
                 :metaTitle="$proposal->title">
    <x-catalyst.proposals.social-card :proposal="$proposal" />
</x-public-layout>
