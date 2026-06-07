# JagdgesellschaftAI

## Beschreibung
Dieses Projekt wird komplett Vibe-Coded, zum einen um den Umgang zu erforschen abseits von Arbeitsprojekten, wo dieser Umgang häufig von Kunden eingeschränkt wird, zum anderen um neue Dinge ausprobieren zu können. 

## Grobe Wünsche die an mich heran getragen wurden
Wunsch 1: Du meinst, sowas wie eine Übersichtsseite mit allen Charakteren von einzelnen Gildenmitgliedern und Wertung und so schön übersichtlich, dass jeder endlich mal weiß, wie seine eigenen Twinks heißen? Mit Berufen? Oder ganz anders?

Wunsch 2: Übersichtsseite der Charaktere mit allen Pets, Vorlieben, besonderen Eigenschaften, Spezifikationen, Häusern… oder Gildengeschichte mit Szenen und den dazugehörigen Zitaten… so animiert.

Wunsch 3: Ich würde es lieben, wenn da auch die ganzen Videos und Clips, die Kati über die Jahre gemacht hat, verfügbar wären. 😍

Wunsch 4: Oder hilfreiche Informationen einbinden wie das Wunderblatt Die aktuell gelaufenen Dungeons 😉
Oder eine BIS Gear Übersicht 🤔


## Plan: 
 - ✔️ Grundgerüst 
   - ✔️ Docker
   - ✔️ Symfony
   - ✔️ PhpUnit Config
   - ✔️ PhpStan Config
   - ✔️ composer Befehle und git Hooks einrichten
 - Anbindung an die Blizzard API (https://community.developer.battle.net/documentation/world-of-warcraft)
   - Zugangsdaten lokal speichern (nicht ins git)
   - Oauth einrichten
   - Token speichern (Cookie vs Datenbank), depends on Strategie beim:
 - Login!
   - Eigene User, die manuell von einem Admin frei geschaltet werden müssen?
   - Login via Battle.Net und nur Mitglieder der Gilde dürfen?
 - Übersicht der Gildenmitglieder mit Wertung und Berufen
 - Dito Pets, Reittiere und Erfolge
 - Kalender? 
 - Upload für Clips und Screenshots 
 - Neueste gelaufene Dungeons
 - Bis Gear

### Laufen lassen

`docker compose up --build -d`

Adresse: http://jagdgesellschaft.local:6108/index.php
