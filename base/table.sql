create database homeconstruction;
\c homeconstruction;

-- données admin
insert into adminbtp(email,nomadmin,mdp) values ('admin@gmail.com' , 'admin' , '0000');

-- insertion type de maison
insert into typemaison(nomtypemaison ,duree , description) values
('Villa Basse' , 102 , 'Villa basse avec 4 chambres et une terasse et cours compris!'),
('Villa Residentiel' , 300 , 'Villa de 2 etages avec 3 chambres a chaque etages et chaque chambre a une salle de bain , sans cours mais avec parking'),
('Maison de campagne' , 200 , 'Maison a 2 etages avec styles vintage et 5 chambres par etages , 1 salle de bain par etages');

-- insertion finition
insert into typefinition(nomfinition,pourcentage) values
('Standar' , 0),
('Gold' , 20),
('Premum' , 30),
('VIP' , 40);

-- type travaux
insert into typetravaux(numerotypetravaux,nomtyetravaux) values
('000' , 'Travaux de preparatoire'),
('100' , 'Travaux de terrassement'),
('200' , 'Travaux en infrastructures');

-- unite
insert into unite(nomunite) values
('m2'),
('m3'),
('m'),
('kg');

-- travaux
insert into travaux( numerotravaux,nomtypetravaux,prixunitaire,idunite,quantiteparunite,idtypetravaux) values
('001', 'mur de soutenement et demi Cloture ht 1m' , 190000 , 3 , 1 , 1),
('101', 'Decapage des terrains meubles' , 3072.87 , 1 , 1 , 2),
('201', 'Maconnerie de moellons , ep = 35cm' , 172114.40 , 3 , 1 , 3);

-- devis temporaire
insert into devis(idclient,idtypemaison,idtypefinition,datededebuttravaux,totalprixdevis,pourcentagefinition,duree) values
(1,1,1,'2024-05-02',112545,12,100),
(1,2,2,'2024-05-02',10000,10,200),
(2,1,1,'2024-05-02',112545,12,100);


-- travaux par type maison
insert into travauxpartypemaison(idtypemaison,idtravaux,quantite,prixunitaire) values
(1,11 , 12 , 12500),
(1,12 , 2.5 , 1200),
(2,13 , 23 , 200);

-- insert into typetravaux(idtypetravaux,numerotypetravaux,nomtyetravaux) values(1,'1','travaux');