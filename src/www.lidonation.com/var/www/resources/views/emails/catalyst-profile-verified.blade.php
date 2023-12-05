@component('mail::message')
### Hello {{$catalystUser?->name}}!

## Your Catalyst Explorer profile claim has been verified!

Set a password to start managing your profile!

After you've set a password, you may manage all proposals you are the primary author of via your [Proposals Dashboard]({{localizeRoute('catalyst-explorer.myProposals')}}).

If you would like other members of your team to be able to manage your proposal, they will need to claim their profile,
then you will be able to assign permissions from the [Groups Dashboard]({{localizeRoute('catalyst-explorer.myGroups')}}).

If you have any questions or need any support email hello@lidonation.com or reach out on twitter @lidonation.

@component('mail::button', ['url' => $setPasswordLink, 'color' => 'primary'])
Set Password
@endcomponent

@endcomponent
