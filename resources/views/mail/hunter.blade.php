<pre>{{ var_export($hunter->toArray(), true) }}</pre>

<a href="{{ url('/approve/hunter/' . $hunter->id . '/' . $hunter->approveToken->token ) }}">approve</a>
