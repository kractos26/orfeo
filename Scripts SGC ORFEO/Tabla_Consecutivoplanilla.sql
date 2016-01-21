--------------------------------------------------------
-- Archivo creado  - martes-enero-12-2016   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table CONSECUTIVOPLANILLA
--------------------------------------------------------

  CREATE TABLE "CONSECUTIVOPLANILLA" 
   (	"FECHAINI" DATE, 
	"FECHAFIN" DATE, 
	"LOGIN" VARCHAR2(20 BYTE), 
	"CONSECUTIVO" NUMBER(*,0), 
	"RUTA" VARCHAR2(200 BYTE), 
	"DEPENDENCIA" NUMBER(*,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SYS_C0014205
--------------------------------------------------------

  CREATE UNIQUE INDEX "SYS_C0014205" ON "CONSECUTIVOPLANILLA" ("CONSECUTIVO") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  Constraints for Table CONSECUTIVOPLANILLA
--------------------------------------------------------

  ALTER TABLE "CONSECUTIVOPLANILLA" ADD PRIMARY KEY ("CONSECUTIVO")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
