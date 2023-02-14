@component('mail::message')
### Hello {{$catalystUser?->name}}!

## Your Catalyst Explorer profile claim has been verified!

You may manage all proposals you are the primary author of via your [Proposals Dashboard]({{localizeRoute('catalystExplorer.myProposals')}}).

If you would like other members of your team to be able to manage your proposal, they will need to claim their profile,
then you will be able to assign permissions from the [Groups Dashboard]({{localizeRoute('catalystExplorer.myGroups')}}).

If you have any questions or need any support email hello@lidonation.com or reach out on twitter @lidonation.
@endcomponent
