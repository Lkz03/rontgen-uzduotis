# Kodo struktūros dokumentacija

## Naudotojai

`admin` naudotojo prieiga.

`user` naudotojo prieiga.

---

## Struktūra

`default` visų puslapių naudojamas 'header':

- Naudojama `getSession()` funkcija, kad patikrint prijungtą naudotoją.
- Pagal prijungtą naudotoją yra atiduodi atitinkami mygtukai.

---

`AppController` bazinė controller klasė:

- Nurodomi `Auth` komponento nustatymai.

---

`ClientController` user naudotojo valdymas:

- `User` gali siųsti turimas lėšas.
- `User` gali pasipildyti lėšas.

![User](./src/Images/user.png)

---

`ClientPaymentsController` user naudotojo naudojama 'controller' klasė lėšų papildimui:

- POST `topup` naudoja privačią funkciją `buildPayseraRequest`, kuri sugeneruoja užklausą `Paysera`.
- Naudotojas yra grąžinamas į `topup` puslapį, jei yra klaida.
- Naudotojas yra perkeliamas į `dashboard`, jei pavyko Paysera užklausa.

---

`ClientTransfersController` user naudotojo naudojama 'controller' klasė siųsti lėšas:

- Įvykus klaidai yra parodomas 'Error' pranešimas.
- Pavykus naudotojas yra perkeliamas į `dashboard` puslapį.

---

`ErrorController` CakePHP klasė:

- Pateikia 'errors' ataskymus naudotojui.

---

`PagesController` CakePHP klasė:

- Naudojama automatiškai pateikti puslapius pagal 'controllers' funkcijas.

---

`PaymentsController` -> `DEPRECATED`:

- Anksčiau naudota klasė `Paysera` užklausoms tvarkyti.

---

`TransfersController` klasė, kuri valdo lėšas:

- Siunčiamos lėšos iš `wallet` į `wallet`.
- Patvirtinami lėšų pavedimai(pliusinė suma, užtenka lėšų, nesiunčiama į savo `wallet`).

---

`UsersController` naudotojų `CRUD` klasė:

- Atliekami `CRUD` veiksmai naudotojams.
- Atliekama naudotojo prijungimo ir registravimo logika.
- Pateikiami naudotojai.
- Patikrinama `admin` reikiamybė ir ar naudotojas turi `admin` prieigą.

---

Toliau pateikiamu `CRUD` kontroleriai(turi ir `index` funckijas pateikti atitinkamų modelių informaciją):

- `TransactionsController`.
- `WalletsController`.

---

Aplikacijos 'Flow' diagramos buvo kurtos siekiant suprasti sistemą.
Todėl, nėra baigtos, kadangi, išsiaiškinus, kaip veikia sistema, jų nebekūriau.
Dėl to, kad sutaupyti laiką sudėtingesnėms užduotims.

![Admin](./src/Images/admin.png)