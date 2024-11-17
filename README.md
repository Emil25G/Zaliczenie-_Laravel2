## Projekt komunikatora szkolnego

### Jak rozpocząć?

1. Pobierz lokalnie chat
2. Upewnij się, że masz zainstalowanego XAMMPA oraz COMPOSER.
3. Następnie w CMD (lub innej konsoli), w katalogu chat-p wykonujemy komende **php artisan serv**
4. Uruchamiamy xammp, apache oraz mysql
5. Następnie trzeba wykonać migrację **php artisan migrate** (wgrywa wszystkie tabele do SQL)
6. Wykonujemy seed **php artisan db:seed** w celu wprowadzenia testowych użytkowników
7. Wpisujemy localhost:port (pewnie 8000)\login
8. Bawimy się


UWAGA! Na razie rejestracja i wylogowanie nie działa.

Konta testowe:
[
'class_id' => 1,
'fname' => 'Jan',
'lname' => 'Kowalski',
'email' => 'test@wp.pl',
'password' => Hash::make('test'),
'role' => 'nauczyciel'
]

[
'class_id' => null,
'fname' => 'Administrator',
'lname' => '',
'email' => 'admin@chat.pl',
'password' => Hash::make('admin'),
'role' => 'admin',
]

[
'class_id' => 1,
'fname' => 'Piotr',
'lname' => 'Nowak',
'email' => 'test2@wp.pl',
'password' => Hash::make('test1'),
'role' => 'uczeń'
]

[
'class_id' => 1,
'fname' => 'Paweł',
'lname' => 'Gondor',
'email' => 'test3@wp.pl',
'password' => Hash::make('test'),
'role' => 'uczeń',
]
