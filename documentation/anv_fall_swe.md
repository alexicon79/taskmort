# ANVÄNDNINGSFALL TASKMÔRT

## UC-06 [fully dressed]. Lägg till nytt objekt till lista i "view mode" (def.5)

#### Omfattning / scope: 
Webbapplikationen TASKMÔRT

#### Nivå:
User goal

#### Primär aktör:
Användare

#### Intressenter:

- ANVÄNDARE: Vill på ett smidigt och snabbt sätt kunna lägga till olika typer av objekt till sin lista.
- SYSTEMUTVECKLARE: Vill att inmatad data ska vara korrekt, och att användaren ska behöva gå igenom så få onödiga steg och delmoment som möjligt.
- DROPBOX: Vill spara lista i korrekt format.
- EXAMINATOR LNU: Vill att krav för projektet uppfylls.

#### Förhandskrav:
Användare är inloggad i systemet. Lista visas i "view mode" (def.5).

###Huvudscenario:

1. Startar när användare vill lägga till nytt objekt till listan. 
2. Systemet presenterar inmatningsfält.
3. Användare fyller i text enligt fördefinierad syntax för att skapa nytt listobjekt.
4. Systemet döljer inmatningsfältet och lägger till korrekt listobjekt överst i listan.
5. Användare flyttar sitt nya objekt till lämplig plats i listan.
6. Systemet sparar listan.

###Alternativ:

- 3a. Användare väljer att läsa mer om syntax: Systemet visar information om godkänd syntax. Tillbaka till steg 2 i huvudscenario.
- 3b. Användare skapar en "task" (def.1): Gå till steg 4 i huvudscenariot.
- 3c. Användare skapar ett "project" (def.2): Gå till steg 4 i huvudscenariot.
- 3d. Användare skapar en "note" (def.3): Gå till steg 4 i huvudscenariot.
- 3e. Användare skapar en "completed task" (def.4): Gå till steg 4 i huvudscenariot.
- 3f. Användare matar in ogiltig data: Systemet korrigerar ogiltig inmatning. Gå till steg 4 i huvudscenariot.

###Definition:

1. Task: en att-göra-punkt.
2. Project: sammanfattande rubrik för noll eller flera att-göra-punkter.
3. Note: en anteckning.
4. Completed Task: en genomförd att-göra-punkt.
5. View mode: gränsnitt som visar lista i ett grafiskt format, och låter användare interagera med listobjekt med hjälp av en rad gränsnittselement i form av knappar etc.
6. Edit mode: gränsnitt som visar lista i "plain text"-format, och låter användare lägga till / ta bort objekt med enbart text.


- - -

## UC-01. Logga in i systemet.
Startar när användare vill logga in i systemet. Systemet presenterar inloggningsfönster med information om applikationen. Användare fyller i giltigt användarnamn och lösenord. Vid felaktig inmatning visar systemet lämpligt meddelande. Vid korrekt inmatning loggas användare in i systemet och sparar temporärt undan inloggninsuppgifter på servern.

#### Aktörer:

- Användare: Anger inloggningsuppgifter
- System: Validerar inloggningsuppgifter och utöför lämplig åtgärd

- - -

## UC-02. Logga in i systemet och stanna inloggad.
Startar när användare vill logga in i systemet och anger att han/hon vill stanna inloggad. Användare fyller i giltigt användarnamn och lösenord. Vid felaktig inmatning visar systemet lämpligt meddelande. Vid korrekt inmatning loggas användare in i systemet och cookie sparas hos klienten för att komma ihåg användare.

#### Aktörer:
- Användare: Anger inloggningsuppgifter och att han/hon vill stanna inloggad.
- System: Validerar inloggningsuppgfter och sparar undan korrekta uppgifter i cookie.

- - -

## UC-03. Logga ut.
Startar när användare vill logga ut ur systemet. Användare loggas ut. Systemet presenterar inloggningsfönster med information om applikationen.

- - -

## UC-04. Skapa ny lista.
Startar när användare vill skapa ny lista. Systemet presenterar inmatningsfält där användare kan fylla i önskat namn på listan. Användare fyller i önskat namn. Systemet kontrollerar och korrigerar ogiltig inmatning. Om lista redan existerar lägger systemet till ett prefix till filnamnet för att undvika dublett. Systemet visar den nya listan med lite autogenererat innehåll. 

#### Aktörer:
- Användare: Namnger sin nya lista
- System: Korrigerar inmatning vid behov och skapar ny lista med autogenererat innehåll.

- - -

## UC-05. Titta på lista.
Startar när användare vill se lista. Systemet presenterar alla användarens listor. Användare väljer lista att titta på. Systemet visar lista i "view mode".

- - -


## UC-07. Lägga till nytt objekt till lista i "edit mode".
Startar när användare vill lägga till nytt objekt till lista i "edit mode". Systemet visar inmatningsfält som låter användare lägga till/ta bort i rent textformat. Användare fyller i information och anger att han/hon vill spara när färdig. Systemet sparar listan och visar i "view mode".

#### Aktörer:
- Användare: Fyller i text i rent textformat.
- System: Tolkar inmatad syntax och genererar list-objekt som kan visas i "view mode".

- - -

## UC-08. Radera objekt från lista i "view mode".
Startar när användare vill ta bort objekt från lista. Systemet visar en ikon för radering i anslutning till varje listobjekt. Användare väljer att radera objekt. Systemet tar bort objektet från listan och sparar listan.

- - -

## UC-09. Stänga en "task" i "view mode"
Startar när användare vill stänga en "task" (dvs den är genomförd). Systemet visar ikon för att stänga "task" i anslutning till varje task-objekt. Användare väljer att stänga "task". Systemet lägger till prefixet @done, presenterar detta grafiskt för användaren och sparar listan.

#### Aktörer:
- Användare: Anger att en "task" är genomförd
- System: Lägger till korrekt prefix, visar att användarens "task" nu är stängd och sparar lista.

- - -

## UC-10. Spara lista.
Startar när användare vill spara lista, eller när användare manipulerar/lägger till nytt listobjekt. Systemet läser in eventuella inmatade uppgifter hos klienten och sparar innehåll till fil.

- - -

## UC-11. Spara lista till Dropbox.
Startar när användare vill spara lista till Dropbox. Systemet anger i sitt grundläge att Dropbox-synkronisering ej är aktiverat. Användare väljer att aktivera Dropbox-synkronisering. Systemet anger att Dropbox-synkronisering är aktiverat. Användare sparar lista. Systemet sparar en kopia av listan till användarens Dropbox-konto.

#### Aktörer:
- Användare: Anger att listan ska sparas till användarens Dropbox-konto.
- System: Sparar en kopia av listan till användarens Dropbox-konto.
- Dropbox: Vill spara lista i korrekt format.

- - -

## UC-12. Radera lista.
Startar när användare vill radera en lista. Systemet visar en ikon för radering i anslutning till varje lista. Användare väljer att radera lista. Systemet presenterar ett fönster som frågar om användare är säker. Om användaren bekräftar raderar systemet listan, annars inte. 










