create database construction;
\c construction;

create table sexe(
    idsexe serial not null primary key,
    nomsexe varchar(200)
);

insert into sexe(nomsexe) values ('homme') , ('femme');

create table utilisateur(
    idutilisateur serial not null primary key,
    nom varchar(200),
    dtn date,
    email varchar(100),
    mdp varchar(200),
    idsexe int not null,
    identifiant int default 0,
    foreign key(idsexe) references sexe(idsexe)
);
