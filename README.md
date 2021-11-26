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


