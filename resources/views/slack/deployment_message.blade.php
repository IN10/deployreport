{!! $user !!} just deployed to {{ $stage }}. {{ $messages->count() === 0 ? 'No messages were mentioned in this release.' : 'The following messages were mentioned in this release:' }}
@if ($messages->count() > 0)
@foreach ($messages as $message)
* {{ $message }}
@endforeach
@endif
