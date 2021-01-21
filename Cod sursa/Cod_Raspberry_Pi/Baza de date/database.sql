CREATE TABLE utilizatori (
    id_utilizator       INTEGER AUTO_INCREMENT PRIMARY KEY NOT NULL,
    mac_utilizator     varchar(50) NOT NULL
);

ALTER TABLE utilizatori AUTO_INCREMENT=1;

ALTER TABLE utilizatori ADD CONSTRAINT utilizatori_mac_uk UNIQUE ( mac_utilizator );


CREATE TABLE detalii_utilizatori (
    nume_utilizator      varchar(50) NOT NULL,
    prenume_utilizator   varchar(50) NOT NULL,
    id_utilizator        INTEGER NOT NULL,
	id_produs			 INTEGER NOT NULL,
	ultima_conectare	 DATETIME NOT NULL
);

CREATE UNIQUE INDEX detalii_utilizatori__idx ON
    detalii_utilizatori (
        id_utilizator
    ASC );
	
CREATE TABLE produse (
    id_produs          INTEGER AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nume_produs        varchar(30) NOT NULL,
	disponibilitate    INTEGER,
	RGB				   BOOLEAN
);

ALTER TABLE produse AUTO_INCREMENT=1;

ALTER TABLE produse ADD CONSTRAINT produse_nume_produs_uk UNIQUE ( nume_produs );

ALTER TABLE detalii_utilizatori
    ADD CONSTRAINT detalii_utilizatori_fk FOREIGN KEY ( id_utilizator )
        REFERENCES utilizatori ( id_utilizator );
		
ALTER TABLE detalii_utilizatori
    ADD CONSTRAINT produs_utilizatori_fk FOREIGN KEY ( id_produs )
        REFERENCES produse ( id_produs );
