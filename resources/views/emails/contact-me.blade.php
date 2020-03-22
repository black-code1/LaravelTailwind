@component('mail::message')
# A heading

Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugiat deleniti aspernatur, id odio ipsa officia!

- A list
- goes
- here

@component('mail::button', ['url' => 'https://laracasts.com'])
Visit Laracasts
@endcomponent
    
@endcomponent