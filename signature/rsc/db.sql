CREATE database pdm_signature;
USE pdm_signature;

CREATE TABLE users(
   id_users int(3) NOT NULL AUTO_INCREMENT,
   nom_user VARCHAR(50),
   prenom_user VARCHAR(50),
   fonction_user VARCHAR(50),
   mail_user VARCHAR(50),
   adresse_user VARCHAR(50),
   telephone_user VARCHAR(50),
   PRIMARY KEY(id_users)
);

CREATE TABLE templates(
   id_templates int(3) NOT NULL AUTO_INCREMENT,
   nom_template VARCHAR(50),
   codehtml_template VARCHAR(50),
   PRIMARY KEY(id_templates)
);

CREATE TABLE avatar(
   id_avatar int(3) NOT NULL AUTO_INCREMENT,
   url_avatar VARCHAR(200),
   id_users INT NOT NULL,
   PRIMARY KEY(id_avatar),
   FOREIGN KEY(id_users) REFERENCES users(id_users)
);

CREATE TABLE template_user(
   id_users INT,
   id_templates INT,
   PRIMARY KEY(id_users, id_templates),
   FOREIGN KEY(id_users) REFERENCES users(id_users),
   FOREIGN KEY(id_templates) REFERENCES templates(id_templates)
);