<x-mail::message>
    Dear Unifreight team!
    There is a new application from new potential customer. Please check and contact:

    Email: {{$email}}
    Phone: {{$phone}}
    Name: {{$name}}

<x-mail::button :url="'https://unifreightco.com/'">
Go to a website
</x-mail::button>

Thanks,<br>
Unifreight Team
</x-mail::message>
