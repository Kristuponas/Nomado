#@(#) script.ddl

DROP TABLE IF EXISTS Vertinimas;
DROP TABLE IF EXISTS Megstamiausias_Viesbutis_Vartotojas;
DROP TABLE IF EXISTS Filtravimo_Konfiguracijos_Tag;
DROP TABLE IF EXISTS Viesbutis_Tag;
DROP TABLE IF EXISTS Vartotojo_Istorija;
DROP TABLE IF EXISTS Rezervacija;
DROP TABLE IF EXISTS Nuotraukos;
DROP TABLE IF EXISTS Megstamiausias_Viesbutis;
DROP TABLE IF EXISTS Komentaras;
DROP TABLE IF EXISTS Filtravimo_Konfiguracija;
DROP TABLE IF EXISTS Viesbutis;
DROP TABLE IF EXISTS Vartotojas;
DROP TABLE IF EXISTS Vartotoju_tipas;
DROP TABLE IF EXISTS Sezonas;
DROP TABLE IF EXISTS Patvirtinimas;
DROP TABLE IF EXISTS Vietove;
DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag
(
	kategorija varchar (50) NOT NULL,
	pavadinimas varchar (50) NOT NULL,
	tipas varchar (30) NOT NULL,
	id int NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE Vietove
(
	salis varchar (50) NOT NULL,
	miestas varchar (30) NOT NULL,
	adresas varchar (50) NOT NULL,
	id int NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE Patvirtinimas
(
	id int NOT NULL,
	name char (14) NOT NULL,
	PRIMARY KEY(id)
);
INSERT INTO Patvirtinimas(id, name) VALUES(1, 'laukiamas');
INSERT INTO Patvirtinimas(id, name) VALUES(2, 'patvirtintas');
INSERT INTO Patvirtinimas(id, name) VALUES(3, 'nepatvirtintas');

CREATE TABLE Sezonas
(
	id int NOT NULL,
	name char (9) NOT NULL,
	PRIMARY KEY(id)
);
INSERT INTO Sezonas(id, name) VALUES(1, 'vasara');
INSERT INTO Sezonas(id, name) VALUES(2, 'ruduo');
INSERT INTO Sezonas(id, name) VALUES(3, 'ziema');
INSERT INTO Sezonas(id, name) VALUES(4, 'pavasaris');

CREATE TABLE Vartotoju_tipas
(
	id int NOT NULL,
	name char (5) NOT NULL,
	PRIMARY KEY(id)
);
INSERT INTO Vartotoju_tipas(id, name) VALUES(1, 'admin');
INSERT INTO Vartotoju_tipas(id, name) VALUES(2, 'user');

CREATE TABLE Vartotojas
(
	asmens_kodas varchar (11) NOT NULL,
	vardas varchar (30) NOT NULL,
	pavarde varchar (25) NOT NULL,
	el_pastas varchar (70) NOT NULL,
	tipas int NOT NULL,
	id int NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(tipas) REFERENCES Vartotoju_tipas (id)
);

CREATE TABLE Viesbutis
(
	pavadinimas varchar (50) NOT NULL,
	aprasymas varchar (255) NOT NULL,
	trumpas_aprasymas varchar (255) NOT NULL,
	nuolaida double precision NOT NULL,
	sukurimo_data date NOT NULL,
	kaina float NOT NULL,
	reitingas double precision NOT NULL,
	kambariu_skaicius int NOT NULL,
	sezonas int NOT NULL,
	id int NOT NULL,
	fk_Vietove int NOT NULL,
	PRIMARY KEY(id),
	UNIQUE(fk_Vietove),
	FOREIGN KEY(sezonas) REFERENCES Sezonas (id),
	CONSTRAINT yra FOREIGN KEY(fk_Vietove) REFERENCES Vietove (id)
);

CREATE TABLE Filtravimo_Konfiguracija
(
	pavadinimas varchar (50) NOT NULL,
	kaina_nuo double precision NOT NULL,
	kaina_iki double precision NOT NULL,
	kambariu_skaicius int NOT NULL,
	id int NOT NULL,
	fk_Vartotojas int NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT koreguoja FOREIGN KEY(fk_Vartotojas) REFERENCES Vartotojas (id)
);

CREATE TABLE Komentaras
(
	turinys varchar (255) NOT NULL,
	sukurimo_data date NOT NULL,
	redagavimo_data date NOT NULL,
	patvirtinimas int NOT NULL,
	id int NOT NULL,
	fk_Komentaras int NULL,
	fk_Vartotojas int NOT NULL,
	fk_Viesbutis int NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(patvirtinimas) REFERENCES Patvirtinimas (id),
	CONSTRAINT atsako FOREIGN KEY(fk_Komentaras) REFERENCES Komentaras (id),
	CONSTRAINT pateikia FOREIGN KEY(fk_Vartotojas) REFERENCES Vartotojas (id),
	CONSTRAINT komentaras_turi FOREIGN KEY(fk_Viesbutis) REFERENCES Viesbutis (id)
);

CREATE TABLE Megstamiausias_Viesbutis
(
	pridejimo_data date NOT NULL,
	aprasas varchar (255) NOT NULL,
	id int NOT NULL,
	fk_Viesbutis int NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(fk_Viesbutis) REFERENCES Viesbutis (id)
);

CREATE TABLE Nuotraukos
(
	url varchar (255) NOT NULL,
	ikelimo_data date NOT NULL,
	formatas varchar (5) NOT NULL,
	dydis double precision NOT NULL,
	id int NOT NULL,
	fk_Viesbutis int NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT nuotraukos_turi FOREIGN KEY(fk_Viesbutis) REFERENCES Viesbutis (id)
);

CREATE TABLE Rezervacija
(
	pradzios_data date NOT NULL,
	pabaigos_data date NOT NULL,
	sukurimo_data date NOT NULL,
	busena int NOT NULL,
	id int NOT NULL,
	fk_Vartotojas int NOT NULL,
	fk_Viesbutis int NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(busena) REFERENCES Patvirtinimas (id),
	CONSTRAINT uzsako FOREIGN KEY(fk_Vartotojas) REFERENCES Vartotojas (id),
	CONSTRAINT yra_rezervuojamas FOREIGN KEY(fk_Viesbutis) REFERENCES Viesbutis (id)
);

CREATE TABLE Vartotojo_Istorija
(
	perziuros_data date NOT NULL,
	id int NOT NULL,
	fk_Vartotojas int NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT vartotojo_istorija_turi FOREIGN KEY(fk_Vartotojas) REFERENCES Vartotojas (id)
);

CREATE TABLE Viesbutis_Tag
(
	reiksme varchar (40) NOT NULL,
	id int NOT NULL,
	fk_Tag int NOT NULL,
	fk_Viesbutis int NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT apibudina FOREIGN KEY(fk_Tag) REFERENCES Tag (id),
	CONSTRAINT viesbutis_tag_turi FOREIGN KEY(fk_Viesbutis) REFERENCES Viesbutis (id)
);

CREATE TABLE Filtravimo_Konfiguracijos_Tag
(
	reiksme varchar (50) NOT NULL,
	parametro_tipas varchar (50) NOT NULL,
	id int NOT NULL,
	fk_Tag int NOT NULL,
	fk_Filtravimo_Konfiguracija int NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT nurodo FOREIGN KEY(fk_Tag) REFERENCES Tag (id),
	CONSTRAINT filtravimo_konfig_turi FOREIGN KEY(fk_Filtravimo_Konfiguracija) REFERENCES Filtravimo_Konfiguracija (id)
);

CREATE TABLE Megstamiausias_Viesbutis_Vartotojas
(
	fk_Megstamiausias_Viesbutis int NOT NULL,
	fk_Vartotojas int NOT NULL,
	PRIMARY KEY(fk_Megstamiausias_Viesbutis, fk_Vartotojas),
	FOREIGN KEY(fk_Megstamiausias_Viesbutis) REFERENCES Megstamiausias_Viesbutis (id),
	FOREIGN KEY(fk_Vartotojas) REFERENCES Vartotojas (id)
);

CREATE TABLE Vertinimas
(
	bendras int NOT NULL,
	svara int NOT NULL,
	lokacija int NOT NULL,
	patogumas int NOT NULL,
	komunikacija int NOT NULL,
	id int NOT NULL,
	fk_Komentaras int NOT NULL,
	PRIMARY KEY(id),
	UNIQUE(fk_Komentaras),
	CONSTRAINT priklauso FOREIGN KEY(fk_Komentaras) REFERENCES Komentaras (id)
);
