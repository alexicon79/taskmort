# TESTFALL

- - -

## UC01-TF01

### Titel:
Normal navigering till sidan

### Input:
1. Ta bort eventuella existerande kakor
2. Navigera till www.alxlabs.se/taskmort/public

### Output:
- Feedback saknas
- Ej inloggad
- Formulär för inloggning syns

- - -

## UC01-TF02

### Titel:
Misslyckad inloggning utan inmatade uppgifter

### Beskrivning:
Se till att inloggning ej kan ske utan inmatade uppgifter

### Förkrav:
1. Testfall UC01-TF01

### Input:
1. Töm Username och Password
2. Klicka Login

### Output:
- "No username"
- Ej inloggad
- Formulär för inloggning syns

- - -

## ID: UC01-TF03

### Titel:
Misslyckad inloggning med bara användarnamn

### Beskrivning:
Se till att inloggning ej kan ske utan att fylla i lösenord

### Förkrav:
1. Testfall UC01-TF01

### Input:
1. Username "taskmort"
2. Klicka Login

### Output:
- "No password"
- Ej inloggad
- Formulär för inloggning syns

- - -

## ID: UC01-TF04

### Titel:
Misslyckad inloggning med bara lösenord

### Beskrivning:
Se till att inloggning ej kan ske utan att fylla i användarnamn

### Förkrav:
1. Testfall UC01-TF01

### Input:
1. Password "demo"
2. Klicka Login

### Output:
- "No username"
- Ej inloggad
- Formulär för inloggning syns

- - -

## ID:UC01-TF05

### Titel:
Misslyckad inloggning med felaktigt användarnamn

### Beskrivning:
Se till att inloggning ej kan ske utan att fylla i korrekt användarnamn

### Förkrav:
- Testfall UC01-TF01

### Input:
1. Testfall UC01-TF01
2. Username "troll"
3. Password "demo"
3. Klicka Login

### Output:
- Username "troll" ifyllt
- "Wrong username and/or password"
- Ej inloggad
- Formulär för inloggning syns

- - -

## ID: UC01-TF06

### Titel:
Lyckad inloggning med korrekta uppgifter

### Beskrivning:
Se till att inloggning fungerar med korrekta uppgifter

### Förkrav:
- Testfall UC01-TF01

### Input:
1. Username "taskmort"
2. Password "demo"
3. Klicka Login

### Output:
- Inloggning sker, bild på TASKMÔRTs logotyp visas

- - -

## ID: UC02-TF01

### Titel:
Utloggning

### Beskrivning:
Efter klick på menyvalet "Sign Out" är användaren inte längre inloggad.

### Förkrav:
- Testfall UC01-TF06

### Input:
- Klicka på menyval "Sign Out"
- Inloggningsfält syns
- Ej inloggad


- - - -


_KOMMENTAR: Övriga testfall tillhörande UC02 och UC03 är i stort sett samma som genomförts inom laboration 2 på kursen PHP och beskrivs därför ej vidare i detalj här._


- - - -


## ID: UC04-TF01

### Titel: 
Skapa ny lista

### Beskrivning:
Se till att ny lista skapas

### Förkrav:
- Testfall UC01-TF06

### Input:
1. Menyval "New"
2. Skriv in "my new list" i inputfältet
3. Klicka "Create List"

### Output:
- Lista visas 
- Titel "my-new-list.txt"
- Innehåll: "DEFAULT:" och "- Add some tasks..."

- - -

## ID: UC04-TF02

### Titel: 
Skapa ny lista med redan existerande listnamn

### Beskrivning:
Se till att ny lista skapas trots att listnamn redan existerar

### Förkrav:
- Testfall UC04-TF01

### Input:
1. Menyval "New"
2. Skriv in "my new list" i inputfältet
3. Klicka "Create List"

### Output:
- Lista visas 
- Titel "my-new-list-1.txt"
- Innehåll: "DEFAULT:" och "- Add some tasks..."

- - -

## ID: UC04-TF03

### Titel: 
Skapa ny lista med ogiltigt listnamn

### Beskrivning:
Se till att ny lista skapas trots att listnamn innehåller ogiltiga tecken

### Förkrav:
- Testfall UC01-TF06

### Input:
1. Menyval "New"
2. Skriv in "<tag>stillvalid" i inputfältet
3. Klicka "Create List"

### Output:
- Lista visas 
- Titel "stillvalid.txt"
- Innehåll: "DEFAULT:" och "- Add some tasks..."

- - -

## ID: UC04-TF04

### Titel: 
Skapa ny lista utan att ange listnamn

### Beskrivning:
Se till att ny lista skapas trots att listnamn ej anges

### Förkrav:
- Testfall UC01-TF06

### Input:
1. Menyval "New"
2. Klicka "Create List"

### Output:
- Lista visas 
- Titel "untitled.txt"
- Innehåll: "DEFAULT:" och "- Add some tasks..."

- - -

## ID: UC04-TF05

### Titel: 
Skapa ny lista med listnamn som innehåller blanksteg

### Beskrivning:
Se till att ny lista skapas trots att listnamn innehåller blanksteg

### Förkrav:
- Testfall UC01-TF06

### Input:
1. Menyval "New"
2. Skriv in "  s p a c e s  " i inputfältet (<- OBS! notera mellanslag)
3. Klicka "Create List"

### Output:
- Lista visas 
- Titel "s-p-a-c-e-s.txt"
- Innehåll: "DEFAULT:" och "- Add some tasks..."

- - -

## ID: UC05-TF01

### Titel: 
Översikt över alla befintliga listor

### Beskrivning:
Se till att alla listor visas

### Förkrav:
- Testfall UC04-TF01

### Input:
- Menyval "My Lists"

### Output:
- En eller flera listor visas, varav en heter "my-new-list.txt"

- - -

## ID: UC05-TF02

### Titel: 
Öppna enskild lista från översiktsvyn

### Beskrivning:
Se till att enskild lista kan öppnas från översiktsvyn

### Förkrav:
- Testfall UC04-TF01

### Input:
- Menyval "My Lists"
- Klicka på lista med namn "my-new-list.txt"

### Output:
- Lista visas 
- Titel "my-new-list.txt"

- - -

## ID: UC06-TF01

### Titel: 
Lägg till nytt "task"-objekt till lista i "view mode"

### Beskrivning:
Se till att objekt som läggs till är av typen "task"

### Förkrav:
- Testfall UC05-TF02

### Input:
- Klicka på "+"
- Skriv in "- något att göra"
- Tryck OK

### Output:
- "-något att göra" ligger överst i listan av listobjekt
- Ej ifylld cirkel till vänster om objektet


- - -

## ID: UC06-TF02

### Titel: 
Lägg till nytt "project"-objekt till lista i "view mode"

### Beskrivning:
Se till att objekt som läggs till är av typen "project"

### Förkrav:
- Testfall UC05-TF02

### Input:
- Klicka på "+"
- Skriv in "Mitt projekt:"
- Tryck OK

### Output:
- "MITT PROJEKT:" ligger överst i listan av listobjekt

- - -

## ID: UC06-TF03

### Titel: 
Lägg till nytt "note"-objekt till lista i "view mode"

### Beskrivning:
Se till att objekt som läggs till är av typen "note"

### Förkrav:
- Testfall UC05-TF02

### Input:
- Klicka på "+"
- Skriv in "En liten anteckning"
- Tryck OK

### Output:
- "En liten anteckning" ligger överst i listan av listobjekt

- - -

## ID: UC09-TF01

### Titel: 
Ange att en "task" är avslutad via musklick

### Beskrivning:
Se till att en öppen "task" markeras som avslutad när cirkeln till vänster om objektet klickas

### Förkrav:
- Testfall UC06-TF01

### Input:
- Klicka på cirkeln till vänster om "- något att göra"

### Output:
- "-något att göra @done"
- Objektet är överstruket

- - -

## ID: UC09-TF02

### Titel: 
Ange att en "task" är avslutad via textinmatning

### Beskrivning:
Se till att en öppen "task" markeras som avslutad när texten @done läggs till som suffix

### Förkrav:
- Testfall UC06-TF01

### Input:
- Klicka på / markera "- något att göra"
- lägg till "@done" efter befintlig text

### Output:
- "-något att göra @done"
- Objektet är överstruket

- - -

## ID: UC09-TF03

### Titel: 
Öppna en slutförd "task"

### Beskrivning:
Se till att en avslutad "task" öppnas när cirkeln till vänster om objektet klickas

### Förkrav:
- Testfall UC06-TF04

### Input:
- Klicka på cirkeln till vänster om "- något att göra @done"

### Output:
- "-något att göra"
- Objektet är inte överstruket

- - -

## ID: UC10-TF01

### Titel: 
Spara lista

### Beskrivning:
Se till att en tillagd "task" sparas

### Förkrav:
- Testfall UC05-TF02

### Input:
- Lägg till en ny task enl. testfall UC06-TF01
- Klicka på den gröna ikonen med två cirkelformade pilar
- Klicka på dokument-ikonen längst till höger

### Output:
- texten "- något att göra" syns 

- - -

## ID: UC11-TF01

### Titel: 
Spara lista och synkronisera till Dropbox

### Beskrivning:
Se till att en sparad lista synkroniseras till Dropbox

### Förkrav:
- Testfall UC05-TF02

### Efterkrav:
- Kontrollera att filen existerar lokalt

### Input:
- Lägg till en ny task enl. testfall UC06-TF01
- Klicka på den grå ikonen med texten "OFF"
- Klicka på den gröna ikonen med två cirkelformade pilar

### Output:
- texten "- något att göra" syns i den lokalt sparade textfilen "my-new-list.txt"

- - -

## ID: UC12-TF01

### Titel: 
Radera enskild lista från översiktsvyn

### Beskrivning:
Se till att enskild lista kan raderas från översiktsvyn

### Förkrav:
- Testfall UC04-TF01

### Input:
- Menyval "My Lists"
- Klicka på X-ikonen till höger om listan med namn "my-new-list.txt"
- Klicka OK

### Output:
- Listan raderad
- "my-new-list.txt" visas ej i översiktsvyn
