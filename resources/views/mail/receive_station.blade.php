<pre>{{ var_export($receive_station->toArray(), true) }}</pre>

<a href="{{ url('/approve/hunter/' . $receive_station->id . '/' . $receive_station->approveToken->token ) }}">approve</a>
