--------------------------------------------------------
-- Archivo creado  - martes-enero-12-2016   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table ASUNTO
--------------------------------------------------------

  CREATE TABLE "ORFEODB"."ASUNTO" 
   (	"ID" NUMBER(*,0), 
	"NOMBRE" VARCHAR2(100 BYTE), 
	"DESCRIPCION" VARCHAR2(20 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
SET DEFINE OFF;

