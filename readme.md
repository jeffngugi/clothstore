<h1> Clothstore API </h1>
#This is a clothstore API writen in PHP Laravel

<h2> Technologies used </h2>


<h2>How to set-up and run the project </h2>
For easy setup, ensure you have composer, LEMP(or XAMP) are installed in your machine. 
<p>1.Run <code> git clone https://github.com/jeffngugi/clothstore.git </code> to clone the project into your computer
<p>2. Run <code> cd clothstore </code> to move into your project.
<p>3. Run <code>composer install </code> to install the required packages.</p>
<p>4 To create a .env file <code>cp .env.example .env </code> and edit the .en file with your environment variables </p> 
<p>5. Run <code>php artisan key:generate </code> and <code>php artisan jwt:secret </code> to generate application key and jwt key respectively</p>
<p>6. Run <code>php artisan migrate</code> for the migrations </p>
<p>7. To start the project, run <code>php artisan serve</code> </p>



<h2>API Endpoints </h2>
<h3>User Registration <b>POST <code>auth/register</code></h3>
<p>Headers : None <br />
&nbsp; <b> Request </b> <br />
<code>{
    "name":"jeff ngugi",
    "email":"email@mail.com",
    "password":"yourpass",
    "password_confirmation:"yourpass"
}
</code>
<br />
