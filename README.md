## This project name is Album Organization. Create Album and Upload Image and other functionality using Rest API


## Technical Worling Flow

<h3>1)  Album Model : <code> php artisan make:model Album -m </code> </h3>
<p>
<code>
    $table->id();
    $table->string('name');
    $table->foreignId('user_id');
    $table->timestamps();
</code>
</p>
<hr>

<h3>2)  Album Model : <code> php artisan make:model ImageManipulation -m </code> </h3>
<p>
<code>
    $table->id();
    $table->string('name');
    $table->string('path');
    $table->string('type');
    $table->string('data');
    $table->string('output_path');
    $table->timestamp('created_at');
    $table->foreignId('user_id');
    $table->foreignId('album_id');

</code>
</p>
<hr>

<h3>3)  Album Controller : <code> php artisan make:controller AlbumController --model=Album --requests --api </code> </h3>
<p>
Artisan to generate form request classes for the controller's storage and update methods
</p>
<hr>


<h3>4)  Album Resource : <code> php artisan make:resource V1\\AlbumResource </code> </h3>

<hr>

<h3>5)  ImageManipulation Controller : <code> php artisan make:controller V1\\ImageManipulationController --model=ImageManipulation --requests --api </code> </h3>

<hr>

<h3>6)  ImageManipulation Resource : <code> php artisan make:resource V1\\ImageManipulationResource </code> </h3>

<hr>

<h3>7)  Image Resize Package <b>Intervention Image </b> :  <code> composer require intervention/image </code> </h3>
<p>
URL <a href="http://image.intervention.io/">Intervention Image </a>
</p>

<h3>8)  Issue Solved Faced : Intervention Image :: GD Library extension not available with this PHP installation </h3> 
<h4> Solution : find the line ;extension=gd in your php.ini file and change it to extension=gd.
Credit <a href="https://stackoverflow.com/questions/34009844/gd-library-extension-not-available-with-this-php-installation-ubuntu-nginx">GD Library extension not available</a>
</h4>


<hr>

<h3>9) Authentication : 
<code> composer require laravel/breeze --dev </code> 
<code> php artisan breeze:install </code>
<code> npm install </code>
<code>npm run dev </code>
<code> php artisan migrate </code>
</h3> 
<p>Source : <a href="https://laravel.com/docs/8.x/starter-kits">laravel/breeze</a>
<hr>


<h3>10)  API Authentication used = sanctum: <code> composer require laravel/sanctum </code>

<hr>


<h3>11) DashBoardController : <code> php artisan make:controller DashBoardController </code> </h3> 

<hr>






