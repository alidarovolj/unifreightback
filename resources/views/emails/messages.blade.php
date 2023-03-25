<x-mail::message>
    Dear CREOAD team!
    There is a new application from new potential customer. Please check and contact:

    Email: {{$email}}
    Phone: {{$phone}}
    Name: {{$name}}
    Type: {{$type}}

<x-mail::button :url="'https://creoad.kz/'">
Go to a website
</x-mail::button>

Thanks,<br>
Olzhas
</x-mail::message>
