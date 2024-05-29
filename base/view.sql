-- v_devis
create or replace view v_devis as(
    select iddevis,datedevis,client.idclient, numero , devis.idtypemaison , typemaison.nomtypemaison , typemaison.description ,
    typefinition.idtypefinition,typefinition.nomfinition , 
    datededebuttravaux,totalprixdevis,pourcentagefinition,devis.duree
    from devis
    join client
    on devis.idclient = client.idclient
    join typemaison
    on typemaison.idtypemaison = devis.idtypemaison
    join typefinition
    on devis.idtypefinition = typefinition.idtypefinition
);

-- details devis
create or replace view v_detailsdevis as(
    select v_devis.datedevis,detailsdevis.iddevis,travaux.idtravaux,travaux.numerotravaux  , travaux.nomtypetravaux , travaux.idtypetravaux , typetravaux.nomtyetravaux , typetravaux.numerotypetravaux,
    detailsdevis.prixunitaire,detailsdevis.quantiteunitaire,detailsdevis.quantite,detailsdevis.idunite, unite.nomunite , v_devis.idtypemaison, 
    v_devis.nomtypemaison , v_devis.idtypefinition  , v_devis.pourcentagefinition , v_devis.duree , v_devis.totalprixdevis
    from detailsdevis
    join v_devis
    on v_devis.iddevis = detailsdevis.iddevis
    join travaux
    on detailsdevis.idtravaux = travaux.idtravaux
    join typetravaux
    on typetravaux.idtypetravaux = travaux.idtypetravaux
    join unite
    on unite.idunite = detailsdevis.idunite
);

-- prix par type de maison

create or replace view v_travauxpartypemaison as(
    select idtravauxpartypemaison,idtypemaison,travauxpartypemaison.idtravaux, travaux.idunite , travaux.quantiteparunite ,
    quantite,travauxpartypemaison.prixunitaire
    from travaux
    join travauxpartypemaison
    on travauxpartypemaison.idtravaux = travaux.idtravaux
);

-- prix par type de maison
create or replace view PrixParTypeMaison as(
    select sum(prixunitaire+(prixunitaire*quantite/quantiteparunite)) as prixtotal , idtypemaison
    from v_travauxpartypemaison
    group by idtypemaison
);

-- payementpardevis
create or replace view payementpardevis as (
    select iddevis , sum(montant) as prixtotalpayer
    from payement
    group by iddevis
);

-- reste a payer
create or replace view v_payement as (
    select devis.iddevis , prixtotalpayer as prixdejapayer , (devis.totalprixdevis+(devis.totalprixdevis*pourcentagefinition/100))-prixtotalpayer as resteapayer
    from payementpardevis
    join devis
    on payementpardevis.iddevis = devis.iddevis
);

-- Devis Avec Reste A Payer
create or replace view DevisAvecResteAPayer as(
    select v_devis.iddevis , datedevis,datededebuttravaux,
    totalprixdevis,pourcentagefinition,duree,coalesce(prixdejapayer , 0) as prixdejapayer,coalesce(resteapayer , totalprixdevis+(totalprixdevis*pourcentagefinition/100)) as resteapayer, 
    idclient,numero,idtypemaison,nomtypemaison,
    idtypefinition,nomfinition , totalprixdevis+(totalprixdevis*pourcentagefinition/100) as prixavaecfinition , datededebuttravaux + Cast(duree as Integer) AS datefin,
    coalesce(resteapayer*100/(totalprixdevis+(totalprixdevis*pourcentagefinition/100)),0) as pourcentagedejapayer
    from v_devis
    left join v_payement
    on v_devis.iddevis = v_payement.iddevis
);

-- montant totale des devis
create or replace view montanttotaledevis as(
    select sum(totalprixdevis+(totalprixdevis*pourcentagefinition/100)) as montant
    from devis
);

-- histogramme par mois
CREATE OR REPLACE VIEW montantparmois AS (
    SELECT TO_CHAR(datedevis, 'Month') AS month,
           SUM(totalprixdevis + (totalprixdevis * pourcentagefinition / 100)) AS montant , EXTRACT(Year FROM datedevis) AS annees
    FROM devis
    GROUP BY TO_CHAR(datedevis, 'Month'), EXTRACT(MONTH FROM datedevis),EXTRACT(Year FROM datedevis)
    ORDER BY EXTRACT(MONTH FROM datedevis)
);

-- histogramme par annees
CREATE OR REPLACE VIEW montantparannee AS (
    SELECT EXTRACT(Year FROM datedevis) AS annees,
           SUM(totalprixdevis + (totalprixdevis * pourcentagefinition / 100)) AS montant
    FROM devis
    GROUP BY EXTRACT(Year FROM datedevis)
    ORDER BY EXTRACT(Year FROM datedevis)
);

-- prix par maison sans pourcentage
create or replace view PrixParTypeMaisonSansPourcentage as(
    select sum(prixunitaire) as prixtotal , idtypemaison
    from v_travauxpartypemaison
    group by idtypemaison
);


-- vue d'insertion de devis
create or replace view AInsererDansDevis as(
    select ref_devis , datedevis , datededebuttravaux ,  client.idclient ,typemaison.idtypemaison,typefinition.idtypefinition,
    prixtotal , duree , pourcentage , lieu.idlieu , lieu.nomlieu
    from formulairedevis
    join client
    on client.numero = formulairedevis.numeroclient
    join typemaison
    on typemaison.nomtypemaison = formulairedevis.typemaison
    join typefinition on typefinition.nomfinition = formulairedevis.typefinition
    join lieu on lieu.nomlieu = formulairedevis.lieu
    join PrixParTypeMaisonSansPourcentage on PrixParTypeMaisonSansPourcentage.idtypemaison = typemaison.idtypemaison
);

-- view d'insertion des details
create or replace view InsertionDetails as(
    select travaux.idtravaux,travauxpartypemaison.prixunitaire,travauxpartypemaison.quantite, travaux.idunite
    from travauxpartypemaison
    join travaux
    on travaux.idtravaux = travauxpartypemaison.idtravaux
);

create or replace view montanttotalprixdejapayer as(
    select sum(montant) as prixdejapayer
    from payement
);