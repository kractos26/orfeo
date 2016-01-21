create table ImpUsrRel ( usua_doc character varying(14) DEFAULT '0',depe_codi smallint NOT NULL);
CREATE TABLE UsrSuperRel (
    usua_doc VARCHAR2(14 CHAR) NOT NULL,
    depe_codi DECIMAL (3) NOT NULL
);
ALTER TABLE sgd_oem_oempresas ADD COLUMN sgd_oem_act boolean DEFAULT TRUE NOT NULL;
ALTER TABLE sgd_ciu_ciudadano ADD COLUMN sgd_ciu_act boolean DEFAULT TRUE NOT NULL;
ALTER TABLE usuario ADD COLUMN usua_vobo_perm boolean DEFAULT FALSE NOT NULL;
ALTER TABLE usuario ADD COLUMN usua_vobo_perm boolean DEFAULT FALSE NOT NULL;
alter table carpeta_per alter column nomb_carp type character varying(30);
ALTER TABLE usuario ADD COLUMN usua_super_perm smallint DEFAULT 0;

--/** Ajuste 08-10-2012 se toma como referencia hallazgo de coljuegos.
CREATE TABLE motivo_anulacion
(
    motivo_anulacion_codigo integer NOT NULL,
    motivo_anulacion_descrip character varying(150) NOT NULL,
    PRIMARY KEY (motivo_anulacion_codigo)
);
--RQ-IYU-1 Adicion de notificaciones por correo
alter table usuario add column email_notif boolean default false

--Actualizacion de longitud del campo login en anexo
ALTER TABLE anexos ALTER COLUMN anex_creador TYPE character varying(20);