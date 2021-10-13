# Projekt - Webbutveckling III

-

## Install

Webbtjänsten har en install-fil som återställer databasen genom att kolla om det finns en tabell med namnet Courses. Om så är fallet kommer den att tas bort och sen skapas på nytt. Allt i databasens tabell kommer alltså att försvinna.

Lösen är borttaget från denna fil då jag inte ville lägga upp det på github.

## Course.php

Denna fil innehåller en klass som sköter uppkopplingen till databasen samt hantering av kurser vid olika requests (GET, PUT, POST, DELETE). Klassens konstruktor kopplar upp till databasen med mysqli.

Metoderna i klassen är:

* getCourses(). Denna returnerar alla kurser från databasen.
* getOneCourse(id). Denna returnerar en kurs med ett visst id.
* addCourse(courseId, name, prog, syllabus). Denna lägger till en ny kurs med de angivna värdena.
* deleteCourse(id). Denna tar bort en kurs med ett visst id.
* editCourse(id, courseId, name, prog, syllabus). Denna redigerar en kurs med ett visst id. Den uppdaterar med de angivna värdena.

## rest.php

Denna fil innehåller först en rad olika headers med inställningar för webbtjänsten. Inställningarna är att webbtjänsten ska gå att komma åt från andra domäner, att data skickas i JSON-format, att metoderna GET, PUT, POST och DELETE tillåts m.m.

En instans av klassen skapas.

Sen följer en switch-sats med olika cases för de olika metoderna GET, PUT, POST eller DELETE. 

* case GET - Vid ett GET-anrop utan medskickat id anropas metoden getCourses. Om klienten har skickat med ett id anropas metoden getOneCOurse istället. Om det lyckades skickas HTTP response status 200. Om det inte lyckades skickas ett felmeddelande. Resultatet skrivs sen ut.
* case POST - JSON-datan som är medskickad görs om till ett objekt. Metoden addCourse anropas sedan. Om den lyckades lägga till kursen skickas HTTP response status 200, om det inte lyckades skickas HTTP response status 503. Ett meddelande om resultatet skrivs sen ut.
* case PUT - Om anropet inte har ett id medskickat kommer HTTP response status vara 400. Om id är medskickat kommer den datan som är medskickad att hämtas och göras om till ett objekt, sen anropas metoden editCourse där samtliga värden skickas med. Om den kunde uppdatera kursen skickas HTTP response status 200. Om den inte lyckas skickas HTTP response status 503. Ett meddelande om resultatet skrivs sen ut.
* case DELETE- Om det inte är ett id medskickat skickas HTTP response status 400. Om det är ett id med skickat anropas metoden deleteCourse där id skickas med. Metoden raderar ur databasen på plats id. Ett meddelande om resultatet skrivs sen ut.

## Installera
Klona repot
* git clone

### Webbtjänsten
<!--Länk till webbtjänsten (get allt): [länk](https://studenter.miun.se/~amhv2000/writeable/webbtjanst/rest.php)
Länk till webbtjänsten (get id=10): [länk](https://studenter.miun.se/~amhv2000/writeable/webbtjanst/rest.php?id=10)-->
