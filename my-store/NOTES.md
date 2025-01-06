https://www.youtube.com/watch?v=eUNWzJUvkCA
Laravel 11 Tutorial for Beginners - Laravel Crash Course (2024)

# Create Welcome page with controller

**Create Controller**
```
php artisan make:controller WelcomeController
```

*INFO  Controller [app/Http/Controllers/WelcomeController.php] created successfully.* 

**Create View**

```
php artisan make:view short-welcome
```

*INFO  View [resources/views/short-welcome.blade.php] created successfully.*

**Modify *resources/views/short-welcome.blade.php***

```html
<div>
    <h1>Welcome to my store</h1>
    The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh
</div>
```

**Create controller function to invoke the view**

*my-store/app/Http/Controllers/WelcomeController.php*

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('short-welcome');
    }
}
```

**Register the route**

Add to my-store/routes/web.php

```php
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
```
# Create a basic CRUD
create note table
-
**create Eloquent Model with migration**
php artisan make:model Note -m

   INFO  Model [app/Models/Note.php] created successfully.  

   INFO  Migration [database/migrations/2025_01_05_204515_create_notes_table.php] created successfully.  

**add new fields and constrans**

Edit the migration file created earlier *database/migrations/2025_01_05_204515_create_notes_table.php*
```PHP    
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->longText('note');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
```
**run migration to create table in the main database**
php artisan migrate

populate the note table
-
**Create note factory**

php artisan make:factory NoteFactory --model=Note

   INFO  Factory [database/factories/NoteFactory.php] created successfully.

**Adjust definition**

Edit *database/factories/NoteFactory.php* file
```PHP
    public function definition(): array
    {
        return [
            'note' => fake()->realText(2000),
            'user_id' => 1,
        ];
    }
```

**configure model to use factory**

Edit file *my-store/app/Models/Note.php*

```PHP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //<--
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory; //<--
}
```

**Populate data in seed startup**

Edit *my-store/database/seeders/DatabaseSeeder.php*

```PHP
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('pas123.'),
        ]);
        Note::factory(100)->create();
    }
```

php artisan migrate:refresh --seed
