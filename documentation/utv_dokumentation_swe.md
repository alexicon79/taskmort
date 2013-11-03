# UTVECKLARDOKUMENTATION, TASKMÔRT (v.0.5 beta)

## UPPHOVSMAN:
Alexander Hall

## INFO:
TASKMÔRT skapades under två veckor i oktober-november 2013 inom ramarna för kursen "Webbutveckling med PHP 7,5 hp" vid Linnéuniversitetet, Växjo/Kalmar. 

## PROJEKTBEGRÄNSNINGAR:
- Enskild uppgift
- Inga ramverk, all kod skall vara skriven av studenten
- Bibliotek och komponenter får användas men det skall vara en tydlig separation mellan studentens egen kod och biblioteket (exempelvis bibliotek ligger under vendors). Den egna koden måste vara av tillräcklig mängd.


## INTRODUKTION:
TASKMÔRT är en textfilsbaserad webbapplikation för att skapa och hantera att-göra-listor. Med enkel syntax kan användare lägga till uppgifter, bocka av uppgifter, lägga till projekt och skriva anteckningar. En bärande idé bakom TASKMÔRT är att alla listor baseras på enkla textfiler (.txt), vilket möjliggör enkel synkronisering med en rad andra, mer eller mindre närbesläktade applikationer (t. ex. TaskPaper och nvALT för OS X, Listacular för iOS, m.fl). TASKMÔRT är integrerat med Dropbox, och tanken är att användaren ska kunna ha sina listor/textfiler lätt tillgängliga i den miljö de för stunden helst önskar.

TASKMÔRT fungerar med andra ord som ett ett slags interaktivt gränssnitt "ovanpå" enkla textfiler. Ambitionen har hela tiden varit att skapa ett så användbart och grafiskt tilltalande gränssnitt som möjligt, men att samtidigt behålla den enkelhet, flexibilitet och snabbhet som hantering av helt vanliga textfiler kan innebära. 


## TEKNISKA SPECIFIKATIONER:
TASKMÔRT har byggts från grunden (dvs utan externa ramverk) i PHP och JavaScript enligt MVC-mönster. Funktionaliteten för tolkning av applikationens syntax bygger på att varje rad i den aktuella textfilen matchas mot en rad s.k. reguljära uttryck, och dessa textrader "översätts" därefter till lämplig HTML-kod. De listor som skapas i applikationen sparas lokalt på servern, och kan även synkroniseras/kopplas upp mot Dropbox via deras API. 

#### TASKMÔRT har i nuläget följande grundläggande funktionalitet:
- Inloggningssystem inkl. validering av uppgifter och möjlighet att spara inloggningsuppgifter i cookies.
- Hantering av filer/listor: skapa ny lista, radera lista, titta på lista och redigera lista.
- "View mode": interaktivt gränssnitt för hantering av listor.
- "Edit mode": textbaserat gränssnitt för hantering av listor i rent textformat.
- Synkronisering med Dropbox.


## VIDAREUTVECKLING / PLANERAD FUNKTIONALITET
TASKMÔRT är fortfarande under utveckling, och huvudfokus har i denna version varit att implementera applikationens övergripande design/gränssnitt samt de viktigaste funktionerna/kraven på ett så bra och stabilt sätt som möjligt. Fokus har även legat på att ta fram en genomtänkt och flexibel arkitektur som gör det möjligt att i ett senare skede bygga vidare på applikationen utan att behöva ändra grunderna alltför mycket.

#### Följande funktionalitet kommer att läggas till efter hand:
- Möjlighet att registrera nya användare och hantera flera konton.
- Djupare integration med Dropbox (läsa in listor, byta konto, osv).
- Möjlighet att sortera uppgifter efter taggar.
- Möjlighet att på ett enkelt sätt exportera och skicka listor per epost.
- Arkivering av slutförda uppgifter.
- Grafisk lösning för att lägga till slutdatum (ev. med notifkationer).
