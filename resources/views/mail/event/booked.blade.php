<x-mail::message>
# Event Booked
Congratulations, You have successfully booked an event for {{ $event->start_date }}

## Event Information:

- **Title:** {{ $event->title }}


- **Description:** {{ $event->content }}

- **Venue:** {{ $event->venue }}

- **Start Date:** {{ $event->start_date }}

- **End Date:** {{ $event->end_date }}

    <x-mail::button :url="''">
        Visit for more info
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>