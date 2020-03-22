# Tailwind Setup

_1.Create your new laravel project_ `laravel new project-name`

_2.Install Tailwind via NPPM_ `npm install tailwindcss`

_3.Add Tailwind to CSS_ to app.scss
`@tailwind base; @tailwind components; @tailwind utilities;`

_4.Create your Tailwind config file_ `npx tailwind init` tailwind.config.js file is then generated

_5.Include Tailwind in Laravel Mix Build Process_ Open webpack.mix.js and add the following line

---

mix.js("resources/js/app.js", "public/js");

const tailwindcss = require("tailwindcss");

mix.sass("resources/sass/app.scss", "public/css").options({
processCssUrls: false,
postCss: [tailwindcss("tailwind.config.js")]
});

---

_6.Run NPM_ `npm install && npm run dev`

_7.Test_
`<link href="{{ asset('css/app.css') }}" rel="stylesheet">` and if necessdary run `npm audit fix`

# Section 10 Mail

## Sending Raw Mail

_1. Define a template that holds your form code_

_2. Generates a controller that will be responsible to send a message_

---

public function show()
{
return view('contact');
}

    public function store()
    {
        request()->validate(['email' => 'required|email']);

        // send the email

        Mail::raw('It works!', function ($message) {
            $message->to(request('email'))
            ->subject('Hello There');

        });

        return redirect('/contact')
        ->with('message', 'Email sent!');
    }

---

_3. Output the flash message to your template_

---

@if (session('message'))

<p class="text-green-500 text-xs mt-2">
{{ session('message') }}
</p>
@endif

---

_4. Define a route_

---

Route::get('/contact', 'ContactController@show' );
Route::post('/contact', 'ContactController@store' );

---

## Simulate an Inbox using Mailtrap

_1. Creat an account on https://mailtrap.io_
_2. Create a new inbox on mailtrap_
_3. Copy down the credentials offer by mailtrap on your .env file_
_4. You are now ready to go_

## Send HTML Emails using Mailable Classes

_1. Create a mail through a command_ `php artisan make:mail ContactMe` A new folder is then generate where you will build your message

_2. Create a view base on the return statement in the generated file_ `return $this->view('emails.name');`

_3. Move to your ContactController_ and add the following code

---

request()->validate(['email' => 'required|email']);

        // send the email

        Mail::to(request('email'))
        ->send(new ContactMe());

        return redirect('/contact')
        ->with('message', 'Email sent!');

---

### For extra information

`<p>It sounds like you want to hear more about {{ $topic }}.</p>`

Define `public $topic;` in the ContactMe.php
and add the following code

---

public function \_\_construct($topic)
    {
        
        $this->topic = \$topic;
}

---

Then modify this line in the controller `send(new ContactMe('shirts'));`

In the build method add `$this->view('emails.contact-me')->subject('More information about' . $this->topic);` to reference the subject

---

public function \_\_construct(string $topic)
    {
        
        $this->topic = \$topic;
}

---

### Send Email Using Markdown

_1. Modify ContactMe.php_ use markdown in the build method`return $this->markdown('emails.contact-me')->subject('More information about ' . $this->topic);`

_2. In your clean template add a componen directive_

---

@component('mail::message')

# A heading

Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugiat deleniti aspernatur, id odio ipsa officia!

-   A list
-   goes
-   here

@component('mail::button', ['url' => 'https://laracasts.com'])
Visit Laracasts
@endcomponent

@endcomponent

---

Don't indent markdown

### Create Mail with markdown

_php artisan make:mail Contact --markdown=emails.contact_
