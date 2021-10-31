# Projekt - webbtjänst
Detta är en del av projektearbetet i kursen Webbutveckling III DT173G.
Uppgiften går ut på att skapa en webbtjänst som har stöd för CRUD där endast en inloggad användare på admin-sidan kan hantera innehållet. Sidan ska sen presenteras på ett snyggt sätt på en sida som endast läser från webbtjänsten.

Dett är webbtjänsten för projektet. 

## Install

Webbtjänsten har en install-fil som återställer databasen genom att kolla om det finns en tabell med namnet Courses. Om så är fallet kommer den att tas bort och sen skapas på nytt. Allt i databasens tabell kommer alltså att försvinna.

Lösen är borttaget från denna fil då jag inte ville lägga upp det på github.

## PHP
Sidan är skapad i PHP och kollar upp till en databas för att hämta, lägga till, ta bort eller redigera innehållet. 

Sidan har tre huvudsakliga endpoints. En för kurser, en för anställningar och en för webbsidor. Sen går det att skicka ett ID med URL:en med. Varje endpoint har en switch-sats med olika cases beroende på vilken metod som används (GET, PUT, POST, DELETE) och om det finns ett ID medskickat eller inte.

Switchsatsen anropar lämplig metod i lämplig klass och returnerar resultatet till användaren.

### Endpoints
* Hämta kurser: [länk](https://studenter.miun.se/~amhv2000/writeable/projekt-webbtjanst/courses.php)
* Hämta jobb: [länk](https://studenter.miun.se/~amhv2000/writeable/projekt-webbtjanst/jobs.php)
* Hämta webbsidor: [länk](https://studenter.miun.se/~amhv2000/writeable/projekt-webbtjanst/websites.php)

## Vill du klona?
Skriv i din terminal kommandot:
git clone https://github.com/Ztawh/Projekt-webb3.git

Men tänkt på att inte köra install-filen om du inte vill blåsa ur hela databasen.

### Länkar
Länk till admin-sidan: [länk](https://studenter.miun.se/~amhv2000/writeable/projekt-admin/index.php)
Länk till webbtjänsten:[länk](https://studenter.miun.se/~amhv2000/writeable/pub-webbklient-projekt/)
