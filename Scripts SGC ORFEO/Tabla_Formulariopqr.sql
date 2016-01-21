--------------------------------------------------------
-- Archivo creado  - martes-enero-12-2016   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table FORMULARIOPQR
--------------------------------------------------------

  CREATE TABLE "FORMULARIOPQR" 
   (	"ID" NUMBER(*,0), 
	"NOMBRE" VARCHAR2(30 BYTE), 
	"DESCRIPCION" VARCHAR2(500 BYTE), 
	"SERIE" NUMBER, 
	"SUBSERIE" NUMBER, 
	"TIPODOCUMEN" NUMBER
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
REM INSERTING into FORMULARIOPQR
SET DEFINE OFF;
Insert into FORMULARIOPQR (ID,NOMBRE,DESCRIPCION,SERIE,SUBSERIE,TIPODOCUMEN) values ('1','PETICION',null,null,null,null);
Insert into FORMULARIOPQR (ID,NOMBRE,DESCRIPCION,SERIE,SUBSERIE,TIPODOCUMEN) values ('2','QUEJA','Es la manifestación de inconformidad generada en el comportamiento, en la atención o por conductas irregulares de los empleados.',null,null,null);
Insert into FORMULARIOPQR (ID,NOMBRE,DESCRIPCION,SERIE,SUBSERIE,TIPODOCUMEN) values ('3','RECLAMO','Oposiciones que se formulan a una decisión considerada injusta. Exigencia de los derechos del usuario, relacionada con la prestación de los servicios que se ofrecen al público y que tiene el objeto de que se revise una actuación administrativa motivo de la inconformidad y se tome una decisión.',null,null,null);
Insert into FORMULARIOPQR (ID,NOMBRE,DESCRIPCION,SERIE,SUBSERIE,TIPODOCUMEN) values ('4','DENUNCIA','Notificación que se hace a la autoridad de que se ha cometido un delito o de que alguien es el autor de un delito.',null,null,null);
Insert into FORMULARIOPQR (ID,NOMBRE,DESCRIPCION,SERIE,SUBSERIE,TIPODOCUMEN) values ('5','CONSULTA','Es el requerimiento que se hace a las autoridades en relación con las materias a cargo, se trata de asuntos más especiales y que requieren de la autoridad de un estudio más profundo y detallado para aportar una respuesta. Por ejemplo asuntos técnicos especializados.',null,null,null);
Insert into FORMULARIOPQR (ID,NOMBRE,DESCRIPCION,SERIE,SUBSERIE,TIPODOCUMEN) values ('6','FELICITACIÓN','Es el reconocimiento que usted hace a la labor desempeñada por la Institución o por sus funcionarios.',null,null,null);
Insert into FORMULARIOPQR (ID,NOMBRE,DESCRIPCION,SERIE,SUBSERIE,TIPODOCUMEN) values ('7','SUGERENCIA','Es la insinuación o formulación de ideas tendientes al mejoramiento de un servicio o de la misma entidad.',null,null,null);
--------------------------------------------------------
--  DDL for Index SYS_C0014429
--------------------------------------------------------

  CREATE UNIQUE INDEX "SYS_C0014429" ON "FORMULARIOPQR" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  Constraints for Table FORMULARIOPQR
--------------------------------------------------------

  ALTER TABLE "FORMULARIOPQR" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
