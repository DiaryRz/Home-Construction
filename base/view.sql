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

create or replace view PrixParTypeMaison as(
    select sum(prixunitaire*quantite/quantiteparunite) as prixtotal , idtypemaison 
    from v_travauxpartypemaison
    group by idtypemaison 
);
