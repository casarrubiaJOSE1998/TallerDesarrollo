CREATE TABLE personas (
  identificacion INTEGER UNSIGNED  NOT NULL  ,
  nombre TEXT  NOT NULL  ,
  apellido TEXT  NOT NULL  ,
  tipo_identificacion VARCHAR(8)  NOT NULL  ,
  profesion TEXT  NOT NULL    ,
PRIMARY KEY(identificacion));



CREATE TABLE usuarios (
  user_name VARCHAR(20)  NOT NULL  ,
  id INTEGER UNSIGNED  NOT NULL  ,
  user_password TEXT  NULL    ,
PRIMARY KEY(user_name)  ,
INDEX usuarios_FKIndex1(id),
  FOREIGN KEY(id)
    REFERENCES personas(identificacion)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE compromisos (
  idcompromiso INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  organizador INTEGER UNSIGNED  NOT NULL  ,
  fecha_inicio DATE  NOT NULL  ,
  fecha_fin DATE  NOT NULL  ,
  hora_inicio TIME  NOT NULL  ,
  hora_fin TIME  NOT NULL  ,
  titulo VARCHAR(100)  NOT NULL  ,
  descripcion TEXT  NOT NULL  ,
  lugar TEXT  NOT NULL  ,
  modalidad TEXT  NOT NULL  ,
  capacidad INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(idcompromiso)  ,
INDEX compromisos_FKIndex1(organizador),
  FOREIGN KEY(organizador)
    REFERENCES personas(identificacion)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE participantes (
  idparticipante INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  compromiso INTEGER UNSIGNED  NOT NULL  ,
  participante INTEGER UNSIGNED  NOT NULL    ,
PRIMARY KEY(idparticipante)  ,
INDEX participantes_FKIndex1(participante)  ,
INDEX participantes_FKIndex2(compromiso),
  FOREIGN KEY(participante)
    REFERENCES personas(identificacion)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(compromiso)
    REFERENCES compromisos(idcompromiso)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE acta (
  idacta INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  pertenece INTEGER UNSIGNED  NOT NULL  ,
  fecha DATE  NULL  ,
  hora TIME  NULL  ,
  lugar_emision TEXT  NULL  ,
  descripcion TEXT  NULL    ,
PRIMARY KEY(idacta)  ,
INDEX acta_FKIndex1(pertenece),
  FOREIGN KEY(pertenece)
    REFERENCES compromisos(idcompromiso)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);




