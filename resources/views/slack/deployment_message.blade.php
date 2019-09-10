{!! $user !!} just deployed to {{ $stage }}. {{ $messages->count() === 0 ? 'No tickets were mentioned in this release.' : 'The following tickets were mentioned in this release:' }}
@if ($messages->count() > 0)
@foreach ($messages as $message)
* {{ $message }}
@endforeach
@endif
