USE xgarda04;
SET NAMES 'utf8';

drop table if exists ap_predmet;
drop table if exists rezervace;
drop table if exists akademicky_pracovnik;
drop table if exists predmet;
drop table if exists ucebna;
drop table if exists vybaveni_ucebny;

CREATE TABLE ucebna (
    Oznaceni VARCHAR(4) NOT NULL,
    Cislo_mistnosti INTEGER NOT NULL,
    Budova VARCHAR(1) NOT NULL,
    Kapacita INTEGER NOT NULL,
    PRIMARY KEY (Oznaceni),
    UNIQUE (Cislo_mistnosti, Budova)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE prislusenstvi (
    Inventarni_cislo INTEGER NOT NULL AUTO_INCREMENT,
    Nazev VARCHAR(50) NOT NULL,
    Urceni VARCHAR(30),
    Porizovaci_cena INTEGER NOT NULL,
    Datum_porizeni DATE NOT NULL,
    Mistnost VARCHAR(4) NOT NULL,
    PRIMARY KEY (Inventarni_cislo),
    FOREIGN KEY (Mistnost) REFERENCES ucebna(Oznaceni) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE akademicky_pracovnik (
    ID INTEGER NOT NULL AUTO_INCREMENT,
    Rodne_cislo BIGINT NOT NULL,
    Jmeno VARCHAR(20) NOT NULL,
    Prijmeni VARCHAR(20) NOT NULL,
    Login VARCHAR(20) NOT NULL,
    Heslo VARCHAR(20) NOT NULL,
    Zarazeni VARCHAR(20) NOT NULL,
    PRIMARY KEY (Rodne_cislo),
    UNIQUE (ID)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE predmet (
    Zkratka VARCHAR(4) NOT NULL,
    Nazev VARCHAR(50) NOT NULL,
    Garant VARCHAR(30) NOT NULL,
    Hodinova_dotace INTEGER NOT NULL,
    Kredity INTEGER NOT NULL,
    PRIMARY KEY (Zkratka)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE rezervace (
    ID INTEGER NOT NULL AUTO_INCREMENT,
    Datum_pridani DATE NOT NULL,
    Cas_pridani VARCHAR(10) NOT NULL,
    Oznaceni VARCHAR(4) NOT NULL,
    Rodne_cislo BIGINT NOT NULL,
    Zkratka VARCHAR(4) NOT NULL,
    Jednorazova VARCHAR(1) NOT NULL,
    PRIMARY KEY (ID, Oznaceni, Rodne_cislo, Zkratka),
    FOREIGN KEY (Oznaceni) REFERENCES ucebna(Oznaceni) ON DELETE CASCADE,
    FOREIGN KEY (Rodne_cislo) REFERENCES akademicky_pracovnik(Rodne_cislo) ON DELETE CASCADE,
    FOREIGN KEY (Zkratka) REFERENCES predmet(Zkratka) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;  


INSERT INTO akademicky_pracovnik (Rodne_Cislo, Jmeno, Prijmeni, Login, Heslo, Zarazeni) VALUES('9009213939', 'Al', 'Koholik', 'ap1', 'ap1', 'Akademicky pracovnik');
INSERT INTO akademicky_pracovnik (Rodne_Cislo, Jmeno, Prijmeni, Login, Heslo, Zarazeni) VALUES('1234567890', 'Jarda', 'Jágr', 'admin', 'admin', 'Administrator');
INSERT INTO akademicky_pracovnik (Rodne_Cislo, Jmeno, Prijmeni, Login, Heslo, Zarazeni) VALUES('0123456789', 'Petr', 'Bečka', 'ap2', 'ap2', 'Akademicky pracovnik'); 

INSERT INTO ucebna (Oznaceni, Cislo_mistnosti, Budova, Kapacita) VALUES('D105', '105', 'D', '300');
INSERT INTO ucebna (Oznaceni, Cislo_mistnosti, Budova, Kapacita) VALUES('D206', '206', 'D', '160');
INSERT INTO ucebna (Oznaceni, Cislo_mistnosti, Budova, Kapacita) VALUES('D207', '207', 'D', '70');

INSERT INTO prislusenstvi (Nazev, Urceni, Porizovaci_cena, Datum_porizeni, Mistnost) VALUES('Projektor', 'k promitani', '100000', STR_TO_DATE('03,11,2015', '%d,%m,%Y'), 'D105');
INSERT INTO prislusenstvi (Nazev, Urceni, Porizovaci_cena, Datum_porizeni, Mistnost) VALUES('Projektor', 'k promitani', '100000', STR_TO_DATE('12,11,2015', '%d,%m,%Y'), 'D207');
INSERT INTO prislusenstvi (Nazev, Urceni, Porizovaci_cena, Datum_porizeni, Mistnost) VALUES('Projektor', 'k promitani', '100000', STR_TO_DATE('03,11,2015', '%d,%m,%Y'), 'D206');

INSERT INTO predmet (Zkratka, Nazev, Garant, Hodinova_dotace, Kredity) VALUES('IPZ', 'Periferní zařízení', 'Kotásek', '3', '4');
INSERT INTO predmet (Zkratka, Nazev, Garant, Hodinova_dotace, Kredity) VALUES('IMS', 'Modelování a simulace', 'Peringer', '3', '5');
INSERT INTO predmet (Zkratka, Nazev, Garant, Hodinova_dotace, Kredity) VALUES('ISA', 'Síťové aplikace a správa sítí', 'Matoušek', '3', '5');