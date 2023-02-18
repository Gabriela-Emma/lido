@props([
    'catalystProfile',
    'owner'
])
<div class="z-6" x-data="{
    name: @js($catalystProfile?->name),
    email: @js($catalystProfile?->email),
    profile: @js($catalystProfile->id),
    loggedIn: @js(\Illuminate\Support\Facades\Auth::check()),
    step: 1,
    submitting: false,
    submitted: false,
    async followProfile(event) {
        if (!loggedIn) {
            return;
        }
        this.submitting = true;
         this.$dispatch('following-profile');
        const res = await window.axios.post(`/api/catalyst-explorer/profiles/${this.profile}/follow`);
        if (res.status === 200 || res.status === 201) {
            this.$dispatch('profile-followed');
            this.submitted = true;
            this.submitting = false;
        }
    }
}" @follow-profile.window="followProfile">
    <h1 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-2xl xl:text-3xl font-bold 2xl:text-4xl decorate light items-center'>
        Login to follow {{$catalystProfile->name}}
    </h1>
    <div class="text-slate-800 max-w-md bg-white/75 p-4" x-data="{
        async emailLogin(event) {
            const login = Object.fromEntries(new FormData(event.target));
            const user = {
                email: login.email,
                password: login.password
            };

            try {
                const res = await window.axios.post(`/api/catalyst-explorer/login`, user);
                console.log({res});
                document.location.reload();
            } catch (e) {
                if (e?.response?.status === 401) {
                    this.$dispatch('new-notice', {
                        name: 'Error',
                        message: 'Failed to log you in. You will be able to login after you earn your first reward? If you have already earned rewards, check your password or make sure you are connected with the correct wallet.',
                        type: 'error'
                    });
                } else {
                    this.$dispatch('new-notice', {
                        name: 'Error',
                        message: e?.response?.data?.message || e.message || e.info,
                        type: 'error'
                    });
                }
            }
        }
    }">
        <x-cardano.email-login />
    </div>
</div>
