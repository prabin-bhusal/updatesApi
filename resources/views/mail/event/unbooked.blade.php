<x-mail::message>
# Event Unbooked
Sad to see you unable to attend the event, You have successfully unbooked an event for {{ $event->start_date }}

## Event Information:

- **Title:** {{ $event->title }}


- **Description:** {{ $event->content }}

- **Venue:** {{ $event->venue }}

- **Start Date:** {{ $event->start_date }}

- **End Date:** {{ $event->end_date }}

<x-mail::button :url="''">
Search for other events happenning
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
