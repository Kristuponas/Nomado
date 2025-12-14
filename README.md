# Nomado – Projekto instaliavimo instrukcija

Šis dokumentas paaiškina, kaip nuo nulio pasileisti **Nomado** projektą vietinėje virtualioje mašinoje (Ubuntu) naudojant **Apache + PHP**.

---

## Reikalavimai

- Ubuntu / Debian pagrindu veikianti OS (rekomenduojama VM)
- `sudo` teisės
- Interneto ryšys

---

## 1. Reikalingų paketų įdiegimas

Atnaujink paketų sąrašą ir įdiek reikalingą programinę įrangą:

```bash
sudo apt update
sudo apt install -y apache2 php php-mysql git
```

Patikrink ar viskas įdiegta:

```bash
apache2 -v
php -v
git --version
```

---

## 2. Projekto klonavimas iš GitHub

Klonuok repozitoriją į savo `home` katalogą:

```bash
cd ~
git clone https://github.com/Kristuponas/Nomado.git
```

Projektas bus patalpintas:

```text
/home/USER/Nomado
```

---

## 3. Vietinio domeno pririšimas (`/etc/hosts`)

Kad projektas būtų pasiekiamas per domeną `www.ktu_booking.com`, reikia atnaujinti `hosts` failą.

```bash
sudo nano /etc/hosts
```

Pridėk šią eilutę:

```text
127.0.0.1   www.ktu_booking.com
```

Išsaugok (`CTRL+O`, `ENTER`) ir išeik (`CTRL+X`).

---

## 4. Apache Virtual Host konfigūracija

Repozitorijoje jau yra paruoštas Apache konfigūracijos failas:

```text
ktu.booking.com.conf
```

### 4.1. Konfigūracijos failo nukopijavimas

```bash
sudo cp ~/Nomado/ktu.booking.com.conf /etc/apache2/sites-available/
```

### 4.2. Virtual Host įjungimas

```bash
sudo a2ensite ktu.booking.com.conf
sudo systemctl reload apache2
```

---

## 5. Svarbu: `DocumentRoot`

Atidaryk Apache konfigūracijos failą:

```bash
sudo nano /etc/apache2/sites-available/ktu.booking.com.conf
```

Įsitikink, kad `DocumentRoot` rodo į katalogą, kuriame yra `index.php`, pvz.:

```apache
DocumentRoot /home/USER/Nomado/public
```

> **Pastaba:** jei `DocumentRoot` neteisingas – puslapis neveiks (403 arba tuščias ekranas).

---

## 6. Failų teisės

Apache naudoja vartotoją `www-data`, todėl būtina suteikti teises:

```bash
sudo chown -R www-data:www-data ~/Nomado
sudo chmod -R 755 ~/Nomado
```

---

## 7. Projekto paleidimas

Atidaryk naršyklę ir eik į:

```
http://www.ktu_booking.com/
```

Jei projektas sukonfigūruotas teisingai – turėtum matyti veikiantį puslapį.

---

## Autoriai

- Projektas: **Nomado**
- Repozitorija: https://github.com/Kristuponas/Nomado

---
