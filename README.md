# dualmedia zadanie rekrutacyjne

# Jak uruchomić projekt?:

	By uruchomić projekt wymagany jest docker.
	wykonujemy polecenie: docker compose build
	wchodzimy w kontener: docker compose exec php sh
	i wykonujemy następujące polecenia:
	composer install
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate
	php bin/console doctrine:fixtures:load
    Gotowe! w pliku requests.http znajdują się zapytania, którymi można strzelać na kontroler.
	
# Co zrobiłem:
	  
	  1. Utworzyłem repozytorium na github oraz zainicjowałem projekt w wskazanej wersji symfony 6.4
	  2. Stworzyłem obraz dockerowy z php'em, bazą danych mysql oraz ngnixem wraz z jego konfiguracją tak by można było wykonywać requesty https
	  3. Stworzyłem Encje dla produktu i zamówienia, na pola dodatkowo nałożyłem odpowiednie Asserty.
	  4. Dodałem tabelę pośredniczącą zawierającą id zamówienia, id produktu oraz ilość
	  Gdyż ilość jest to bardziej wg mnie cecha pozycji zamówienia niż samego produktu. Dodatkowo na tabele został nałożony unique constraint by produkty się nie powtarzały.
	  5. Dodałem fixtury produktu by mieć co dodawać do zamówienia oraz do późniejszych testów.
	  6. stworzyłem kontroler z metodą create który poprzez formularz przyjmuje request i mapuje dane już w odpowiednie encje oraz później go submituje, sprawdza walidacje i zapisuje do bazy.
	  7. Stworzyłem metode pobierającą, której trzeba podać id zamówienia. Metoda zwraca dane wg grup serializacji które nałożyłem na poszczególne pola.
	  8. Powstał EventListener który dodaje odpowiedni nagłówek do każdej zwrotki.
	  9. Stworzyłem kalkulator w oparciu o polecony wzorzec (nie jestem do końca pewien czy o to dokłądnie chodziło), który osobno liczy kwote vat wszystkich produktów i osobno kwote netto wszystkich produktów a potem zbiera otagowane serwisy
	  i dzięki wspólnemu interfejsowi sumuje całość.
	  10. Do Kontrolera jak i klas kalkulatora dopisałem odpowiednio test funkcjonalny i testy jednostkowe.