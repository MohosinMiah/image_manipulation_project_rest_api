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





