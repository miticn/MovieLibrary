## Poktretanje projekta

Za pokretanje projekta se koristi sledeća naredba:  
```php artisan serve```


Povezivanje /storage/app/public sa /public/IMG se vrši sledećom komandom:  
```php artisan storage:link```


Pokretanje periodičnog povezivanja sa cineplexxom se vriši sledećom komandom:  
```php artisan schedule:work```  
Ova naredba služi za periodično ažuriranje samo u produkciji. U slučaju pokretanja sa servera videti sledeće [uputstvo](https://laravel.com/docs/9.x/scheduling#running-the-scheduler).  
