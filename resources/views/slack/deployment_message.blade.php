{!! $user !!} just deployed to {{ $stage }}. {{ $tickets->count() === 0 ? 'No tickets were mentioned in this release.' : 'The following tickets were mentioned in this release:' }}
@if ($tickets->count() > 0)
@foreach ($tickets as $ticket)
* {{ $ticket->message }}
@endforeach
@endif
