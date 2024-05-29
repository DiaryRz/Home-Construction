--  meme import du maison et travaux  

    create table formulaireMaisonEtTravaux(
        nomtypemaison varchar(200),
        description varchar(500),
        surface double precision,
        numerotravaux varchar(200),
        nomtypetravaux varchar(200),
        nomunite varchar(100),
        prixunitaire double precision,
        quantite double precision,
        duree double precision
    );


-- devis
    create table formulaireDevis(
        numeroclient varchar(200),
        ref_devis varchar(200),
        typemaison varchar(200),
        typefinition varchar(200),
        pourcentagefinition double precision,
        datedevis date,
        datededebuttravaux date,
        lieu varchar(200)
    );

-- 
    create table formulairePayement(
        ref_devis varchar(200),
        ref_payement varchar(200),
        datepayement date,
        montant double precision
    );
