CREATE SCHEMA IF NOT EXISTS "public";

CREATE SEQUENCE "public".adminbtp_idadminbtp_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".client_idclient_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".detailsdevis_iddetailsdevis_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".devis_iddevis_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".lieu_idlieu_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".payement_idpayement_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".travauxpartypemaison_idtravauxpartypemaison_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".typefinition_idtypefinition_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".typemaison_idtypemaison_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".typetravaux_idtypetravaux_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".typetravaux_idtypetravaux_seq1 START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".unite_idunite_seq START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".adminbtp ( 
	idadminbtp           integer DEFAULT nextval('adminbtp_idadminbtp_seq'::regclass) NOT NULL  ,
	email                varchar(200)    ,
	nomadmin             varchar(200)    ,
	mdp                  varchar(200)    ,
	CONSTRAINT pk_adminbtp PRIMARY KEY ( idadminbtp )
 );

CREATE  TABLE "public".client ( 
	idclient             integer DEFAULT nextval('client_idclient_seq'::regclass) NOT NULL  ,
	numero               varchar(200)    ,
	CONSTRAINT pk_client PRIMARY KEY ( idclient )
 );

CREATE  TABLE "public".formulairedevis ( 
	numeroclient         varchar(200)    ,
	ref_devis            varchar(200)    ,
	typemaison           varchar(200)    ,
	typefinition         varchar(200)    ,
	pourcentagefinition  double precision    ,
	datedevis            date    ,
	datededebuttravaux   date    ,
	lieu                 varchar(200)    
 );

CREATE  TABLE "public".formulairemaisonettravaux ( 
	nomtypemaison        varchar(200)    ,
	description          varchar(500)    ,
	surface              double precision    ,
	numerotravaux        varchar(200)    ,
	nomtypetravaux       varchar(200)    ,
	nomunite             varchar(100)    ,
	prixunitaire         double precision    ,
	quantite             double precision    ,
	duree                double precision    
 );

CREATE  TABLE "public".formulairepayement ( 
	ref_devis            varchar(200)    ,
	ref_payement         varchar(200)    ,
	datepayement         date    ,
	montant              double precision    
 );

CREATE  TABLE "public".historiquetypefinition ( 
	idhistoriquetypefinition serial  NOT NULL  ,
	datehistorique       date DEFAULT CURRENT_DATE   ,
	idtypefinition       integer  NOT NULL  ,
	pourcentage          double precision    ,
	CONSTRAINT pk_historiquetypefinition PRIMARY KEY ( idhistoriquetypefinition )
 );

CREATE  TABLE "public".lieu ( 
	idlieu               integer DEFAULT nextval('lieu_idlieu_seq'::regclass) NOT NULL  ,
	nomlieu              varchar(200)    ,
	CONSTRAINT pk_lieu PRIMARY KEY ( idlieu )
 );

CREATE  TABLE "public".typefinition ( 
	idtypefinition       integer DEFAULT nextval('typefinition_idtypefinition_seq'::regclass) NOT NULL  ,
	nomfinition          varchar    ,
	pourcentage          double precision    ,
	CONSTRAINT pk_typefinition PRIMARY KEY ( idtypefinition )
 );

CREATE  TABLE "public".typemaison ( 
	idtypemaison         integer DEFAULT nextval('typemaison_idtypemaison_seq'::regclass) NOT NULL  ,
	nomtypemaison        varchar(200)    ,
	duree                double precision    ,
	description          text    ,
	surface              double precision    ,
	CONSTRAINT pk_typemaison PRIMARY KEY ( idtypemaison )
 );

CREATE  TABLE "public".typetravaux ( 
	idtypetravaux        integer DEFAULT nextval('typetravaux_idtypetravaux_seq1'::regclass) NOT NULL  ,
	numerotypetravaux    varchar(200)  NOT NULL  ,
	nomtyetravaux        varchar(200)    ,
	CONSTRAINT pk_typetravaux_0 PRIMARY KEY ( idtypetravaux )
 );

CREATE  TABLE "public".unite ( 
	idunite              integer DEFAULT nextval('unite_idunite_seq'::regclass) NOT NULL  ,
	nomunite             varchar(100)    ,
	CONSTRAINT pk_unite PRIMARY KEY ( idunite )
 );

CREATE  TABLE "public".devis ( 
	iddevis              integer DEFAULT nextval('devis_iddevis_seq'::regclass) NOT NULL  ,
	ref_devis            varchar(200)    ,
	datedevis            date DEFAULT CURRENT_DATE   ,
	idclient             integer  NOT NULL  ,
	idtypemaison         integer  NOT NULL  ,
	idtypefinition       integer  NOT NULL  ,
	datededebuttravaux   date    ,
	totalprixdevis       double precision    ,
	pourcentagefinition  double precision    ,
	duree                double precision    ,
	idlieu               integer  NOT NULL  ,
	lieu                 varchar(200)    ,
	CONSTRAINT pk_devis PRIMARY KEY ( iddevis )
 );

CREATE  TABLE "public".payement ( 
	idpayement           integer DEFAULT nextval('payement_idpayement_seq'::regclass) NOT NULL  ,
	ref_payement         varchar(200)    ,
	datepayement         date DEFAULT CURRENT_DATE   ,
	iddevis              integer  NOT NULL  ,
	montant              double precision    ,
	CONSTRAINT pk_payement PRIMARY KEY ( idpayement )
 );

CREATE  TABLE "public".travaux ( 
	idtravaux            integer DEFAULT nextval('typetravaux_idtypetravaux_seq'::regclass) NOT NULL  ,
	numerotravaux        varchar(200)  NOT NULL  ,
	nomtypetravaux       varchar(300)    ,
	prixunitaire         double precision    ,
	idunite              integer  NOT NULL  ,
	quantiteparunite     double precision DEFAULT 1   ,
	idtypetravaux        integer DEFAULT 1 NOT NULL  ,
	CONSTRAINT pk_typetravaux PRIMARY KEY ( idtravaux )
 );

CREATE  TABLE "public".travauxpartypemaison ( 
	idtravauxpartypemaison integer DEFAULT nextval('travauxpartypemaison_idtravauxpartypemaison_seq'::regclass) NOT NULL  ,
	idtypemaison         integer  NOT NULL  ,
	idtravaux            integer  NOT NULL  ,
	quantite             double precision    ,
	prixunitaire         double precision    ,
	CONSTRAINT pk_travauxpartypemaison PRIMARY KEY ( idtravauxpartypemaison )
 );

CREATE  TABLE "public".detailsdevis ( 
	iddetailsdevis       integer DEFAULT nextval('detailsdevis_iddetailsdevis_seq'::regclass) NOT NULL  ,
	datedevis            date DEFAULT CURRENT_DATE   ,
	iddevis              integer  NOT NULL  ,
	idtravaux            integer  NOT NULL  ,
	prixunitaire         double precision    ,
	quantiteunitaire     double precision DEFAULT 1   ,
	quantite             double precision    ,
	idunite              integer  NOT NULL  ,
	CONSTRAINT pk_detailsdevis PRIMARY KEY ( iddetailsdevis )
 );

CREATE  TABLE "public".historiqueprix ( 
	idhistoriqueprix     serial  NOT NULL  ,
	datehistoriqueprix   date DEFAULT CURRENT_DATE   ,
	idtravaux            integer  NOT NULL  ,
	prix                 double precision DEFAULT 0   ,
	CONSTRAINT pk_historiqueprix PRIMARY KEY ( idhistoriqueprix )
 );

ALTER TABLE "public".detailsdevis ADD CONSTRAINT fk_detailsdevis_devis FOREIGN KEY ( iddevis ) REFERENCES "public".devis( iddevis );

ALTER TABLE "public".detailsdevis ADD CONSTRAINT fk_detailsdevis_travaux FOREIGN KEY ( idtravaux ) REFERENCES "public".travaux( idtravaux );

ALTER TABLE "public".detailsdevis ADD CONSTRAINT fk_detailsdevis_unite FOREIGN KEY ( idunite ) REFERENCES "public".unite( idunite );

ALTER TABLE "public".devis ADD CONSTRAINT fk_devis_client FOREIGN KEY ( idclient ) REFERENCES "public".client( idclient );

ALTER TABLE "public".devis ADD CONSTRAINT fk_devis_lieu FOREIGN KEY ( idlieu ) REFERENCES "public".lieu( idlieu );

ALTER TABLE "public".devis ADD CONSTRAINT fk_devis_typefinition FOREIGN KEY ( idtypefinition ) REFERENCES "public".typefinition( idtypefinition );

ALTER TABLE "public".devis ADD CONSTRAINT fk_devis_typemaison FOREIGN KEY ( idtypemaison ) REFERENCES "public".typemaison( idtypemaison );

ALTER TABLE "public".historiqueprix ADD CONSTRAINT fk_historiqueprix_travaux FOREIGN KEY ( idtravaux ) REFERENCES "public".travaux( idtravaux );

ALTER TABLE "public".payement ADD CONSTRAINT fk_payement_devis FOREIGN KEY ( iddevis ) REFERENCES "public".devis( iddevis );

ALTER TABLE "public".travaux ADD CONSTRAINT fk_travaux_typetravaux_0 FOREIGN KEY ( idtypetravaux ) REFERENCES "public".typetravaux( idtypetravaux );

ALTER TABLE "public".travaux ADD CONSTRAINT fk_typetravaux_unite FOREIGN KEY ( idunite ) REFERENCES "public".unite( idunite );

ALTER TABLE "public".travauxpartypemaison ADD CONSTRAINT fk_travauxpartypemaison_travaux FOREIGN KEY ( idtravaux ) REFERENCES "public".travaux( idtravaux );

ALTER TABLE "public".travauxpartypemaison ADD CONSTRAINT fk_travauxpartypemaison_typemaison FOREIGN KEY ( idtypemaison ) REFERENCES "public".typemaison( idtypemaison );

ALTER TABLE "public".typefinition ADD CONSTRAINT fk_typefinition_historiquetypefinition FOREIGN KEY ( idtypefinition ) REFERENCES "public".historiquetypefinition( idhistoriquetypefinition );

CREATE VIEW "public".insertiondetails AS SELECT travaux.idtravaux,
    travauxpartypemaison.prixunitaire,
    travauxpartypemaison.quantite,
    travaux.idunite
   FROM (travauxpartypemaison
     JOIN travaux ON ((travaux.idtravaux = travauxpartypemaison.idtravaux)));

CREATE VIEW "public".montantparannee AS SELECT date_part('year'::text, devis.datedevis) AS annees,
    sum((devis.totalprixdevis + ((devis.totalprixdevis * devis.pourcentagefinition) / (100)::double precision))) AS montant
   FROM devis
  GROUP BY (date_part('year'::text, devis.datedevis))
  ORDER BY (date_part('year'::text, devis.datedevis));

CREATE VIEW "public".montantparmois AS SELECT to_char((devis.datedevis)::timestamp with time zone, 'Month'::text) AS month,
    sum((devis.totalprixdevis + ((devis.totalprixdevis * devis.pourcentagefinition) / (100)::double precision))) AS montant,
    date_part('year'::text, devis.datedevis) AS annees
   FROM devis
  GROUP BY (to_char((devis.datedevis)::timestamp with time zone, 'Month'::text)), (date_part('month'::text, devis.datedevis)), (date_part('year'::text, devis.datedevis))
  ORDER BY (date_part('month'::text, devis.datedevis));

CREATE VIEW "public".montanttotaledevis AS SELECT sum((devis.totalprixdevis + ((devis.totalprixdevis * devis.pourcentagefinition) / (100)::double precision))) AS montant
   FROM devis;

CREATE VIEW "public".payementpardevis AS SELECT payement.iddevis,
    sum(payement.montant) AS prixtotalpayer
   FROM payement
  GROUP BY payement.iddevis;

CREATE VIEW "public".v_devis AS SELECT devis.iddevis,
    devis.datedevis,
    client.idclient,
    client.numero,
    devis.idtypemaison,
    typemaison.nomtypemaison,
    typemaison.description,
    typefinition.idtypefinition,
    typefinition.nomfinition,
    devis.datededebuttravaux,
    devis.totalprixdevis,
    devis.pourcentagefinition,
    devis.duree
   FROM (((devis
     JOIN client ON ((devis.idclient = client.idclient)))
     JOIN typemaison ON ((typemaison.idtypemaison = devis.idtypemaison)))
     JOIN typefinition ON ((devis.idtypefinition = typefinition.idtypefinition)));

CREATE VIEW "public".v_payement AS SELECT devis.iddevis,
    payementpardevis.prixtotalpayer AS prixdejapayer,
    ((devis.totalprixdevis + ((devis.totalprixdevis * devis.pourcentagefinition) / (100)::double precision)) - payementpardevis.prixtotalpayer) AS resteapayer
   FROM (payementpardevis
     JOIN devis ON ((payementpardevis.iddevis = devis.iddevis)));

CREATE VIEW "public".v_travauxpartypemaison AS SELECT travauxpartypemaison.idtravauxpartypemaison,
    travauxpartypemaison.idtypemaison,
    travauxpartypemaison.idtravaux,
    travaux.idunite,
    travaux.quantiteparunite,
    travauxpartypemaison.quantite,
    travauxpartypemaison.prixunitaire
   FROM (travaux
     JOIN travauxpartypemaison ON ((travauxpartypemaison.idtravaux = travaux.idtravaux)));

CREATE VIEW "public".devisavecresteapayer AS SELECT v_devis.iddevis,
    v_devis.datedevis,
    v_devis.datededebuttravaux,
    v_devis.totalprixdevis,
    v_devis.pourcentagefinition,
    v_devis.duree,
    COALESCE(v_payement.prixdejapayer, (0)::double precision) AS prixdejapayer,
    COALESCE(v_payement.resteapayer, (0)::double precision) AS resteapayer,
    v_devis.idclient,
    v_devis.numero,
    v_devis.idtypemaison,
    v_devis.nomtypemaison,
    v_devis.idtypefinition,
    v_devis.nomfinition,
    (v_devis.totalprixdevis + ((v_devis.totalprixdevis * v_devis.pourcentagefinition) / (100)::double precision)) AS prixavaecfinition,
    (v_devis.datededebuttravaux + (v_devis.duree)::integer) AS datefin,
    ((v_payement.resteapayer * (100)::double precision) / (v_devis.totalprixdevis + ((v_devis.totalprixdevis * v_devis.pourcentagefinition) / (100)::double precision))) AS pourcentagedejapayer
   FROM (v_devis
     LEFT JOIN v_payement ON ((v_devis.iddevis = v_payement.iddevis)));

CREATE VIEW "public".prixpartypemaison AS SELECT sum((v_travauxpartypemaison.prixunitaire + ((v_travauxpartypemaison.prixunitaire * v_travauxpartypemaison.quantite) / v_travauxpartypemaison.quantiteparunite))) AS prixtotal,
    v_travauxpartypemaison.idtypemaison
   FROM v_travauxpartypemaison
  GROUP BY v_travauxpartypemaison.idtypemaison;

CREATE VIEW "public".prixpartypemaisonsanspourcentage AS SELECT sum(v_travauxpartypemaison.prixunitaire) AS prixtotal,
    v_travauxpartypemaison.idtypemaison
   FROM v_travauxpartypemaison
  GROUP BY v_travauxpartypemaison.idtypemaison;

CREATE VIEW "public".v_detailsdevis AS SELECT v_devis.datedevis,
    detailsdevis.iddevis,
    travaux.idtravaux,
    travaux.numerotravaux,
    travaux.nomtypetravaux,
    travaux.idtypetravaux,
    typetravaux.nomtyetravaux,
    typetravaux.numerotypetravaux,
    detailsdevis.prixunitaire,
    detailsdevis.quantiteunitaire,
    detailsdevis.quantite,
    detailsdevis.idunite,
    unite.nomunite,
    v_devis.idtypemaison,
    v_devis.nomtypemaison,
    v_devis.idtypefinition,
    v_devis.pourcentagefinition,
    v_devis.duree,
    v_devis.totalprixdevis
   FROM ((((detailsdevis
     JOIN v_devis ON ((v_devis.iddevis = detailsdevis.iddevis)))
     JOIN travaux ON ((detailsdevis.idtravaux = travaux.idtravaux)))
     JOIN typetravaux ON ((typetravaux.idtypetravaux = travaux.idtypetravaux)))
     JOIN unite ON ((unite.idunite = detailsdevis.idunite)));

CREATE VIEW "public".ainsererdansdevis AS SELECT formulairedevis.ref_devis,
    formulairedevis.datedevis,
    formulairedevis.datededebuttravaux,
    client.idclient,
    typemaison.idtypemaison,
    typefinition.idtypefinition,
    prixpartypemaisonsanspourcentage.prixtotal,
    typemaison.duree,
    typefinition.pourcentage,
    lieu.idlieu,
    lieu.nomlieu
   FROM (((((formulairedevis
     JOIN client ON (((client.numero)::text = (formulairedevis.numeroclient)::text)))
     JOIN typemaison ON (((typemaison.nomtypemaison)::text = (formulairedevis.typemaison)::text)))
     JOIN typefinition ON (((typefinition.nomfinition)::text = (formulairedevis.typefinition)::text)))
     JOIN lieu ON (((lieu.nomlieu)::text = (formulairedevis.lieu)::text)))
     JOIN prixpartypemaisonsanspourcentage ON ((prixpartypemaisonsanspourcentage.idtypemaison = typemaison.idtypemaison)));


