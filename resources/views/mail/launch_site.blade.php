<pre>{{ var_export($launch_site->toArray(), true) }}</pre>

<a href="{{ url('/approve/hunter/' . $launch_site->id . '/' . $launch_site->approveToken->token ) }}">approve</a>
