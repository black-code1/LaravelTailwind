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
