--
-- PostgreSQL database dump
--

CREATE TABLE anexos (
    anex_radi_nume bigint NOT NULL,
    anex_codigo character varying(20) NOT NULL,
    anex_tipo smallint,
    anex_tamano integer,
    anex_solo_lect character varying(1),
    anex_creador character varying(20),
    anex_desc character varying(512),
    anex_numero integer,
    anex_nomb_archivo character varying(50),
    anex_borrado character varying(1),
    anex_origen smallint DEFAULT 0,
    anex_ubic character varying(15),
    anex_salida smallint DEFAULT 0,
    radi_nume_salida bigint,
    anex_radi_fech date,
    anex_estado smallint DEFAULT 0,
    usua_doc character varying(14),
    sgd_rem_destino smallint DEFAULT 0,
    anex_fech_envio date,
    sgd_dir_tipo smallint,
    anex_fech_impres date,
    anex_depe_creador smallint,
    sgd_doc_secuencia bigint,
    sgd_doc_padre character varying(20),
    sgd_arg_codigo smallint,
    sgd_tpr_codigo smallint,
    sgd_deve_codigo smallint,
    sgd_deve_fech date,
    sgd_fech_impres timestamp with time zone,
    anex_fech_anex timestamp with time zone,
    anex_depe_codi character varying(3),
    sgd_pnufe_codi smallint,
    sgd_dnufe_codi smallint,
    anex_usudoc_creador character varying(15),
    sgd_fech_doc date,
    sgd_apli_codi smallint,
    sgd_trad_codigo smallint,
    sgd_dir_direccion character varying(150),
    muni_codi smallint,
    dpto_codi smallint,
    sgd_exp_numero character varying(18)
);


--
-- TOC entry 1518 (class 1259 OID 18574)
-- Dependencies: 5
-- Name: anexos_historico; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE anexos_historico (
    anex_hist_anex_codi character varying(20) NOT NULL,
    anex_hist_num_ver smallint NOT NULL,
    anex_hist_tipo_mod character varying(2) NOT NULL,
    anex_hist_usua character varying(15) NOT NULL,
    anex_hist_fecha date NOT NULL,
    usua_doc character varying(14)
);


--
-- TOC entry 1425 (class 1259 OID 17660)
-- Dependencies: 5
-- Name: anexos_tipo; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE anexos_tipo (
    anex_tipo_codi smallint NOT NULL,
    anex_tipo_ext character varying(10) NOT NULL,
    anex_tipo_desc character varying(50)
);


--
-- TOC entry 1426 (class 1259 OID 17665)
-- Dependencies: 1889 1890 1891 5
-- Name: bodega_empresas; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE bodega_empresas (
    nombre_de_la_empresa character varying(160),
    nuir character varying(13),
    nit_de_la_empresa character varying(80),
    sigla_de_la_empresa character varying(80),
    direccion character varying(80),
    codigo_del_departamento smallint,
    codigo_del_municipio smallint,
    telefono_1 character varying(15),
    telefono_2 character varying(15),
    email character varying(50),
    nombre_rep_legal character varying(72),
    cargo_rep_legal character varying(50),
    identificador_empresa integer NOT NULL,
    are_esp_secue integer NOT NULL,
    id_cont smallint DEFAULT 1,
    id_pais smallint DEFAULT 170,
    activa smallint DEFAULT 1,
    flag_rups character varying(1)
);


--
-- TOC entry 1427 (class 1259 OID 17683)
-- Dependencies: 5
-- Name: carpeta; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE carpeta (
    carp_codi smallint NOT NULL,
    carp_desc character varying(80) NOT NULL
);


--
-- TOC entry 1496 (class 1259 OID 18141)
-- Dependencies: 5
-- Name: carpeta_per; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE carpeta_per (
    usua_codi smallint NOT NULL,
    depe_codi smallint NOT NULL,
    nomb_carp character varying(30),
    desc_carp character varying(30),
    codi_carp smallint NOT NULL
);


--
-- TOC entry 1493 (class 1259 OID 18101)
-- Dependencies: 1904 1905 5
-- Name: departamento; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE departamento (
    id_cont smallint DEFAULT 1 NOT NULL,
    id_pais smallint DEFAULT 170 NOT NULL,
    dpto_codi smallint NOT NULL,
    dpto_nomb character varying(70) NOT NULL
);


--
-- TOC entry 1495 (class 1259 OID 18123)
-- Dependencies: 1907 1908 1909 5
-- Name: dependencia; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE dependencia (
    depe_codi smallint NOT NULL,
    depe_nomb character varying(70) NOT NULL,
    dpto_codi smallint,
    depe_codi_padre smallint,
    muni_codi smallint,
    depe_codi_territorial smallint,
    dep_sigla character varying(100),
    dep_central smallint,
    dep_direccion character varying(100),
    depe_num_interna smallint,
    depe_num_resolucion smallint,
    depe_rad_tp1 smallint,
    depe_rad_tp2 smallint,
    id_cont smallint DEFAULT 1,
    id_pais smallint DEFAULT 170,
    depe_estado smallint DEFAULT 1
);


--
-- TOC entry 1497 (class 1259 OID 18152)
-- Dependencies: 5
-- Name: dependencia_visibilidad; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE dependencia_visibilidad (
    codigo_visibilidad bigint NOT NULL,
    dependencia_visible smallint NOT NULL,
    dependencia_observa smallint NOT NULL
);


--
-- TOC entry 1428 (class 1259 OID 17688)
-- Dependencies: 5
-- Name: estado; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE estado (
    esta_codi smallint NOT NULL,
    esta_desc character varying(100) NOT NULL
);


--
-- TOC entry 1519 (class 1259 OID 18589)
-- Dependencies: 5
-- Name: hist_eventos; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE hist_eventos (
    depe_codi smallint NOT NULL,
    hist_fech timestamp with time zone NOT NULL,
    usua_codi bigint NOT NULL,
    radi_nume_radi bigint NOT NULL,
    hist_obse character varying(600) NOT NULL,
    usua_codi_dest bigint,
    usua_doc character varying(14),
    usua_doc_old character varying(15),
    sgd_ttr_codigo smallint,
    hist_usua_autor character varying(14),
    hist_doc_dest character varying(14),
    depe_codi_dest smallint
);


--
-- TOC entry 1520 (class 1259 OID 18606)
-- Dependencies: 1951 5
-- Name: informados; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE informados (
    radi_nume_radi bigint NOT NULL,
    usua_codi bigint NOT NULL,
    depe_codi smallint NOT NULL,
    info_desc character varying(600),
    info_fech date NOT NULL,
    info_leido smallint DEFAULT 0,
    usua_codi_info smallint,
    info_codi character varying(14),
    usua_doc character varying(14)
);


--
-- TOC entry 1429 (class 1259 OID 17693)
-- Dependencies: 5
-- Name: medio_recepcion; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE medio_recepcion (
    mrec_codi smallint NOT NULL,
    mrec_desc character varying(100) NOT NULL,
    mrec_env smallint DEFAULT 0,
    mrec_rec smallint DEFAULT 0,
    mrec_pqr smallint DEFAULT 0,
    envio_directo smallint  DEFAULT 0
);


--
-- TOC entry 1494 (class 1259 OID 18112)
-- Dependencies: 1906 5
-- Name: municipio; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE municipio (
    id_cont smallint NOT NULL,
    id_pais smallint NOT NULL,
    dpto_codi smallint NOT NULL,
    muni_codi smallint NOT NULL,
    muni_nomb character varying(100) NOT NULL,
    homologa_muni character varying(10),
    homologa_idmuni smallint,
    activa smallint DEFAULT 1
);


--
-- TOC entry 1430 (class 1259 OID 17698)
-- Dependencies: 5
-- Name: par_serv_servicios; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE par_serv_servicios (
    par_serv_secue integer NOT NULL,
    par_serv_codigo character varying(5),
    par_serv_nombre character varying(100),
    par_serv_estado character varying(1)
);


--
-- TOC entry 1521 (class 1259 OID 18624)
-- Dependencies: 5
-- Name: prestamo; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE prestamo (
    pres_id bigint NOT NULL,
    radi_nume_radi bigint ,
    usua_login_actu character varying(20) NOT NULL,
    depe_codi smallint NOT NULL,
    usua_login_pres character varying(20),
    pres_desc character varying(200),
    pres_fech_pres timestamp with time zone,
    pres_fech_devo timestamp with time zone,
    pres_fech_pedi timestamp with time zone NOT NULL,
    pres_estado smallint,
    pres_requerimiento smallint,
    pres_depe_arch smallint,
    pres_fech_venc timestamp with time zone,
    dev_desc character varying(500),
    pres_fech_canc timestamp with time zone,
    usua_login_canc character varying(20),
    usua_login_rx character varying(20),
    sgd_exp_numero character varying(18),
    sgd_carpeta_id integer,
    pres_fech_renovacion1 date,
    canc_desc character varying(200)
);


--
-- TOC entry 1516 (class 1259 OID 18473)
-- Dependencies: 1937 1938 1939 1940 1941 1942 1943 1944 1945 1946 5
-- Name: radicado; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE radicado (
    radi_nume_radi bigint NOT NULL,
    radi_fech_radi timestamp with time zone NOT NULL,
    tdoc_codi smallint NOT NULL,
    trte_codi smallint,
    mrec_codi smallint,
    eesp_codi bigint,
    eotra_codi bigint,
    radi_tipo_empr character varying(2),
    radi_fech_ofic timestamp with time zone,
    tdid_codi smallint,
    radi_nume_iden character varying(15),
    radi_nomb character varying(90),
    radi_prim_apel character varying(50),
    radi_segu_apel character varying(50),
    radi_pais character varying(70),
    muni_codi smallint,
    cpob_codi smallint,
    carp_codi smallint,
    esta_codi smallint,
    dpto_codi smallint,
    cen_muni_codi smallint,
    cen_dpto_codi smallint,
    radi_dire_corr character varying(100),
    radi_tele_cont bigint,
    radi_nume_hoja smallint,
    radi_desc_anex character varying(100),
    radi_nume_deri bigint,
    radi_path character varying(100),
    radi_usua_actu bigint,
    radi_depe_actu smallint,
    radi_fech_asig date,
    radi_arch1 character varying(10),
    radi_arch2 character varying(10),
    radi_arch3 character varying(10),
    radi_arch4 character varying(10),
    ra_asun character varying(350),
    radi_usu_ante character varying(45),
    radi_depe_radi smallint,
    radi_rem character varying(60),
    radi_usua_radi bigint,
    codi_nivel smallint DEFAULT 1,
    flag_nivel integer DEFAULT 1,
    carp_per smallint DEFAULT 0,
    radi_leido smallint DEFAULT 0,
    radi_cuentai character varying(20),
    radi_tipo_deri smallint DEFAULT 0,
    listo character varying(2),
    sgd_tma_codigo smallint,
    sgd_mtd_codigo smallint,
    par_serv_secue integer,
    sgd_fld_codigo smallint DEFAULT 0,
    radi_agend smallint,
    radi_fech_agend date,
    radi_fech_doc date,
    sgd_doc_secuencia bigint,
    sgd_pnufe_codi smallint,
    sgd_eanu_codigo smallint,
    sgd_not_codi smallint,
    radi_fech_notif date,
    sgd_tdec_codigo smallint,
    sgd_apli_codi smallint,
    sgd_ttr_codigo smallint DEFAULT 0,
    usua_doc_ante character varying(14),
    radi_fech_antetx date,
    sgd_trad_codigo smallint,
    fech_vcmto date,
    tdoc_vcmto smallint,
    sgd_termino_real smallint,
    id_cont smallint DEFAULT 1,
    sgd_spub_codigo smallint DEFAULT 0,
    id_pais smallint DEFAULT 170,
    sgd_tres_codigo smallint,
    radi_nrr numeric(2,0) DEFAULT 0,
    medio_m character varying(15),
    sgd_apli_codigo smallint,
    sgd_apli_enlace character varying(16),
    sgd_spub_depe smallint DEFAULT 0
);


--
-- TOC entry 1539 (class 1259 OID 18936)
-- Dependencies: 5
-- Name: secr_tpr1_111; Type: SEQUENCE; Schema: public; Owner: -
--

--CREATE SEQUENCE secr_tpr1_111 START WITH 1 INCREMENT BY 1 NO MAXVALUE NO MINVALUE CACHE 1;


--
-- TOC entry 1431 (class 1259 OID 17703)
-- Dependencies: 5
-- Name: series; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE series (
    depe_codi integer NOT NULL,
    seri_nume integer NOT NULL,
    seri_tipo smallint NOT NULL,
    seri_ano smallint NOT NULL,
    dpto_codi smallint NOT NULL,
    bloq character varying(20)
);


--
-- TOC entry 1522 (class 1259 OID 18657)
-- Dependencies: 5
-- Name: sgd_acm_acusemsg; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_acm_acusemsg (
    sgd_msg_codi bigint NOT NULL,
    usua_doc character varying(14) NOT NULL,
    sgd_msg_leido smallint
);


--
-- TOC entry 1455 (class 1259 OID 17844)
-- Dependencies: 5
-- Name: sgd_actadd_actualiadicional; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_actadd_actualiadicional (
    sgd_actadd_codi smallint NOT NULL,
    sgd_apli_codi smallint,
    sgd_instorf_codi smallint,
    sgd_actadd_query character varying(500),
    sgd_actadd_desc character varying(150)
);


--
-- TOC entry 1499 (class 1259 OID 18205)
-- Dependencies: 5
-- Name: sgd_admin_depe_historico; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_admin_depe_historico (
    admin_depe_historico_codigo bigint NOT NULL,
    usuario_codigo_administrador bigint NOT NULL,
    dependencia_codigo_administrador smallint NOT NULL,
    usuario_documento_administrador character varying(14) NOT NULL,
    dependencia_modificada smallint NOT NULL,
    admin_observacion_codigo bigint NOT NULL,
    admin_fecha_evento date NOT NULL
);


--
-- TOC entry 1432 (class 1259 OID 17709)
-- Dependencies: 5
-- Name: sgd_admin_dependencia_estado; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_admin_dependencia_estado (
    codigo_estado bigint NOT NULL,
    descripcion_estado character varying(50) NOT NULL
);


--
-- TOC entry 1433 (class 1259 OID 17713)
-- Dependencies: 5
-- Name: sgd_admin_observacion; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_admin_observacion (
    codigo_observacion bigint NOT NULL,
    descripcion_observacion character varying(500) NOT NULL
);


--
-- TOC entry 1500 (class 1259 OID 18214)
-- Dependencies: 5
-- Name: sgd_admin_usua_historico; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_admin_usua_historico (
    admin_historico_codigo bigint NOT NULL,
    usuario_codigo_administrador bigint NOT NULL,
    dependencia_codigo_administrador smallint NOT NULL,
    usuario_documento_administrador character varying(14) NOT NULL,
    usuario_codigo_modificado bigint NOT NULL,
    dependencia_codigo_modificado smallint NOT NULL,
    usuario_documento_modificado character varying(14) NOT NULL,
    admin_observacion_codigo bigint NOT NULL,
    admin_fecha_evento date NOT NULL
);


--
-- TOC entry 1434 (class 1259 OID 17720)
-- Dependencies: 5
-- Name: sgd_admin_usua_perfiles; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_admin_usua_perfiles (
    codigo_perfil bigint NOT NULL,
    descripcion_perfil character varying(200) NOT NULL
);


--
-- TOC entry 1523 (class 1259 OID 18667)
-- Dependencies: 5
-- Name: sgd_agen_agendados; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_agen_agendados (
    sgd_agen_fech date,
    sgd_agen_observacion character varying(3000),
    radi_nume_radi bigint NOT NULL,
    usua_doc character varying(18) NOT NULL,
    depe_codi smallint,
    sgd_agen_codigo integer,
    sgd_agen_fechplazo date,
    sgd_agen_activo integer
);


--
-- TOC entry 1524 (class 1259 OID 18677)
-- Dependencies: 5
-- Name: sgd_anar_anexarg; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_anar_anexarg (
    sgd_anar_codi smallint NOT NULL,
    anex_codigo character varying(20),
    sgd_argd_codi smallint,
    sgd_anar_argcod smallint
);


--
-- TOC entry 1525 (class 1259 OID 18692)
-- Dependencies: 5
-- Name: sgd_anu_anulados; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_anu_anulados (
    sgd_anu_id smallint,
    sgd_anu_desc character varying(250),
    radi_nume_radi bigint,
    sgd_eanu_codi integer,
    sgd_anu_sol_fech date,
    sgd_anu_fech date,
    depe_codi smallint,
    usua_doc character varying(14),
    usua_codi smallint,
    depe_codi_anu smallint,
    usua_doc_anu character varying(14),
    usua_codi_anu smallint,
    usua_anu_acta integer,
    sgd_anu_path_acta character varying(200),
    sgd_trad_codigo smallint,
	motivo_anulacion_codigo smallint
);


--
-- TOC entry 1470 (class 1259 OID 17984)
-- Dependencies: 5
-- Name: sgd_aper_adminperfiles; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_aper_adminperfiles (
    sgd_aper_codigo smallint NOT NULL,
    sgd_aper_descripcion character varying(20)
);


--
-- TOC entry 1456 (class 1259 OID 17862)
-- Dependencies: 5
-- Name: sgd_aplfad_plicfunadi; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_aplfad_plicfunadi (
    sgd_aplfad_codi smallint NOT NULL,
    sgd_apli_codi smallint,
    sgd_aplfad_menu character varying(150) NOT NULL,
    sgd_aplfad_lk1 character varying(150) NOT NULL,
    sgd_aplfad_desc character varying(150) NOT NULL
);


--
-- TOC entry 1435 (class 1259 OID 17724)
-- Dependencies: 5
-- Name: sgd_apli_aplintegra; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_apli_aplintegra (
    sgd_apli_codi smallint NOT NULL,
    sgd_apli_descrip character varying(150),
    sgd_apli_lk1desc character varying(150),
    sgd_apli_lk1 character varying(150),
    sgd_apli_lk2desc character varying(150),
    sgd_apli_lk2 character varying(150),
    sgd_apli_lk3desc character varying(150),
    sgd_apli_lk3 character varying(150),
    sgd_apli_lk4desc character varying(150),
    sgd_apli_lk4 character varying(150)
);

CREATE TABLE sgd_aplicaciones
   (    sgd_apli_codigo smallint NOT NULL,
        sgd_apli_descrip character varying(30) NOT NULL,
        sgd_apli_estado smallint NOT NULL,
        sgd_apli_depe smallint NOT NULL,
         CONSTRAINT pk_codi_apli PRIMARY KEY (sgd_apli_codigo)
   ) ;
    COMMENT ON TABLE SGD_APLICACIONES  IS 'Aplicativos enlazados con Orfeo';
    COMMENT ON COLUMN SGD_APLICACIONES.SGD_APLI_CODIGO IS 'Código del aplicativo. Calculado manualmente';
    COMMENT ON COLUMN SGD_APLICACIONES.SGD_APLI_DESCRIP IS 'Nombre del aplicativo.';
    COMMENT ON COLUMN SGD_APLICACIONES.SGD_APLI_ESTADO IS 'Indica Habilitar (1) o Inhabilitar (0) la aparición del aplicativo en combos.';
    COMMENT ON COLUMN SGD_APLICACIONES.SGD_APLI_DEPE IS 'Código de la dependencia que gestiona los radicados del aplicativo actual.';


--
-- TOC entry 1457 (class 1259 OID 17872)
-- Dependencies: 5
-- Name: sgd_aplmen_aplimens; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_aplmen_aplimens (
    sgd_aplmen_codi smallint NOT NULL,
    sgd_apli_codi smallint,
    sgd_aplmen_ref character varying(20),
    sgd_aplmen_haciaorfeo smallint,
    sgd_aplmen_desdeorfeo smallint
);


--
-- TOC entry 1458 (class 1259 OID 17882)
-- Dependencies: 5
-- Name: sgd_aplus_plicusua; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_aplus_plicusua (
    sgd_aplus_codi smallint NOT NULL,
    sgd_apli_codi smallint,
    usua_doc character varying(14),
    sgd_trad_codigo smallint,
    sgd_aplus_prioridad smallint
);


--
-- TOC entry 1481 (class 1259 OID 18041)
-- Dependencies: 5
-- Name: sgd_arg_pliego; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_arg_pliego (
    sgd_arg_codigo smallint NOT NULL,
    sgd_arg_desc character varying(150) NOT NULL
);


--
-- TOC entry 1436 (class 1259 OID 17732)
-- Dependencies: 5
-- Name: sgd_argd_argdoc; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_argd_argdoc (
    sgd_argd_codi smallint NOT NULL,
    sgd_pnufe_codi smallint,
    sgd_argd_tabla character varying(100),
    sgd_argd_tcodi character varying(100),
    sgd_argd_tdes character varying(100),
    sgd_argd_llist character varying(150),
    sgd_argd_campo character varying(100)
);


--
-- TOC entry 1474 (class 1259 OID 18007)
-- Dependencies: 5
-- Name: sgd_argup_argudoctop; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_argup_argudoctop (
    sgd_argup_codi smallint NOT NULL,
    sgd_argup_desc character varying(50),
    sgd_tpr_codigo smallint
);


--
-- TOC entry 1513 (class 1259 OID 18442)
-- Dependencies: 1936 5
-- Name: sgd_camexp_campoexpediente; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_camexp_campoexpediente (
    sgd_camexp_codigo smallint NOT NULL,
    sgd_camexp_campo character varying(30) NOT NULL,
    sgd_parexp_codigo smallint NOT NULL,
    sgd_camexp_fk integer DEFAULT 0,
    sgd_camexp_tablafk character varying(30),
    sgd_camexp_campofk character varying(30),
    sgd_camexp_campovalor character varying(30),
    sgd_campexp_orden smallint
);


--
-- TOC entry 1501 (class 1259 OID 18233)
-- Dependencies: 5
-- Name: sgd_carp_descripcion; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_carp_descripcion (
    sgd_carp_depecodi smallint NOT NULL,
    sgd_carp_tiporad smallint NOT NULL,
    sgd_carp_descr character varying(40)
);


--
-- TOC entry 1437 (class 1259 OID 17740)
-- Dependencies: 5
-- Name: sgd_cau_causal; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_cau_causal (
    sgd_cau_codigo smallint NOT NULL,
    sgd_cau_descrip character varying(150)
);


--
-- TOC entry 1526 (class 1259 OID 18704)
-- Dependencies: 5
-- Name: sgd_caux_causales; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_caux_causales (
    sgd_caux_codigo bigint NOT NULL,
    radi_nume_radi bigint,
    sgd_dcau_codigo smallint,
    sgd_ddca_codigo smallint,
	sgd_cau_codigo smallint,
    sgd_caux_fecha date,
    usua_doc character varying(14)
);


--
-- TOC entry 1503 (class 1259 OID 18273)
-- Dependencies: 1931 1932 5
-- Name: sgd_ciu_ciudadano; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_ciu_ciudadano (
    tdid_codi smallint,
    sgd_ciu_codigo integer NOT NULL,
    sgd_ciu_nombre character varying(150),
    sgd_ciu_direccion character varying(150),
    sgd_ciu_apell1 character varying(50),
    sgd_ciu_apell2 character varying(50),
    sgd_ciu_telefono character varying(50),
    sgd_ciu_email character varying(50),
    muni_codi smallint,
    dpto_codi smallint,
    sgd_ciu_cedula character varying(13),
    id_cont smallint DEFAULT 1,
    id_pais smallint DEFAULT 170,
    sgd_ciu_act boolean DEFAULT TRUE NOT NULL
);


--
-- TOC entry 1488 (class 1259 OID 18076)
-- Dependencies: 5
-- Name: sgd_clta_clstarif; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_clta_clstarif (
    sgd_fenv_codigo integer,
    sgd_clta_codser integer,
    sgd_tar_codigo integer,
    sgd_clta_descrip character varying(100),
    sgd_clta_pesdes bigint,
    sgd_clta_peshast bigint
);


--
-- TOC entry 1473 (class 1259 OID 17997)
-- Dependencies: 5
-- Name: sgd_cob_campobliga; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_cob_campobliga (
    sgd_cob_codi smallint NOT NULL,
    sgd_cob_desc character varying(150),
    sgd_cob_label character varying(50),
    sgd_tidm_codi smallint
);


--
-- TOC entry 1459 (class 1259 OID 17892)
-- Dependencies: 5
-- Name: sgd_dcau_causal; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_dcau_causal (
    sgd_dcau_codigo smallint NOT NULL,
    sgd_cau_codigo smallint,
	sgd_dcau_estado smallint,
    sgd_dcau_descrip character varying(150)
);


--
-- TOC entry 1460 (class 1259 OID 17902)
-- Dependencies: 5
-- Name: sgd_ddca_ddsgrgdo; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_ddca_ddsgrgdo (
    sgd_ddca_codigo smallint NOT NULL,
    sgd_dcau_codigo smallint,
    par_serv_secue integer,
    sgd_ddca_descrip character varying(150)
);


--
-- TOC entry 1461 (class 1259 OID 17916)
-- Dependencies: 5
-- Name: sgd_def_contactos; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_def_contactos (
    ctt_id bigint NOT NULL,
    ctt_nombre character varying(60) NOT NULL,
    ctt_cargo character varying(60) NOT NULL,
    ctt_telefono character varying(25),
    ctt_id_tipo smallint NOT NULL,
    ctt_id_empresa bigint NOT NULL
);


--
-- TOC entry 1491 (class 1259 OID 18084)
-- Dependencies: 5
-- Name: sgd_def_continentes; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_def_continentes (
    id_cont smallint NOT NULL,
    nombre_cont character varying(20) NOT NULL
);


--
-- TOC entry 1492 (class 1259 OID 18089)
-- Dependencies: 1902 1903 5
-- Name: sgd_def_paises; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_def_paises (
    id_cont smallint DEFAULT 1 NOT NULL,
    id_pais smallint DEFAULT 170 NOT NULL,
    nombre_pais character varying(30) NOT NULL
);


--
-- TOC entry 1462 (class 1259 OID 17918)
-- Dependencies: 5
-- Name: sgd_deve_dev_envio; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_deve_dev_envio (
    sgd_deve_codigo smallint NOT NULL,
    sgd_deve_desc character varying(150) NOT NULL
);


--
-- TOC entry 1533 (class 1259 OID 18827)
-- Dependencies: 1956 1957 5
-- Name: sgd_dir_drecciones; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_dir_drecciones (
    sgd_dir_codigo bigint NOT NULL,
    sgd_dir_tipo smallint NOT NULL,
    sgd_oem_codigo integer,
    sgd_ciu_codigo integer,
    radi_nume_radi bigint,
    sgd_esp_codi integer,
    muni_codi smallint,
    dpto_codi smallint,
    sgd_dir_direccion character varying(150),
    sgd_dir_telefono character varying(50),
    sgd_dir_mail character varying(50),
    sgd_sec_codigo bigint,
    sgd_temporal_nombre character varying(150),
    anex_codigo bigint,
    sgd_anex_codigo character varying(20),
    sgd_dir_nombre character varying(150),
    sgd_doc_fun character varying(14),
    sgd_dir_nomremdes character varying(1000),
    sgd_trd_codigo smallint,
    sgd_dir_tdoc smallint,
    sgd_dir_doc character varying(14),
    id_pais smallint DEFAULT 170,
    id_cont smallint DEFAULT 1,
    mrec_codi smallint
);


--
-- TOC entry 1502 (class 1259 OID 18248)
-- Dependencies: 5
-- Name: sgd_dnufe_docnufe; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_dnufe_docnufe (
    sgd_dnufe_codi smallint NOT NULL,
    sgd_pnufe_codi smallint,
    sgd_tpr_codigo smallint,
    sgd_dnufe_label character varying(150),
    trte_codi smallint,
    sgd_dnufe_main character varying(1),
    sgd_dnufe_path character varying(150),
    sgd_dnufe_gerarq character varying(10),
    anex_tipo_codi smallint
);


--
-- TOC entry 1489 (class 1259 OID 18078)
-- Dependencies: 5
-- Name: sgd_eanu_estanulacion; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_eanu_estanulacion (
    sgd_eanu_desc character varying(150),
    sgd_eanu_codi integer NOT NULL
);


--
-- TOC entry 1438 (class 1259 OID 17745)
-- Dependencies: 5
-- Name: sgd_einv_inventario; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_einv_inventario (
    sgd_einv_codigo integer NOT NULL,
    sgd_depe_nomb character varying(400),
    sgd_depe_codi integer,
    sgd_einv_expnum character varying(18),
    sgd_einv_titulo character varying(400),
    sgd_einv_unidad integer,
    sgd_einv_fech date,
    sgd_einv_fechfin date,
    sgd_einv_radicados character varying(40),
    sgd_einv_folios integer,
    sgd_einv_nundocu integer,
    sgd_einv_nundocubodega integer,
    sgd_einv_caja integer,
    sgd_einv_cajabodega integer,
    sgd_einv_srd integer,
    sgd_einv_nomsrd character varying(400),
    sgd_einv_sbrd integer,
    sgd_einv_nomsbrd character varying(400),
    sgd_einv_retencion character varying(400),
    sgd_einv_disfinal character varying(400),
    sgd_einv_ubicacion character varying(400),
    sgd_einv_observacion character varying(400)
);


--
-- TOC entry 1439 (class 1259 OID 17753)
-- Dependencies: 1892 5
-- Name: sgd_eit_items; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

--CREATE TABLE sgd_eit_items (
--    sgd_eit_codigo integer NOT NULL,
--    sgd_eit_piso character varying(4) DEFAULT '0'::character varying,
--    sgd_eit_pisonom character varying(40),
--    sgd_eit_archivador character varying(4),
--    sgd_eit_itemso character varying(40),
--    sgd_eit_itemsn character varying(40),
--    sgd_eit_estante smallint,
--    sgd_eit_cajas integer,
--    sgd_eit_captol smallint,
--    sgd_eit_edificio character varying(400),
--    sgd_eit_zona character varying(40),
--    sgd_eit_dpto character varying(400),
--    sgd_eit_muni character varying(400),
--   sgd_eit_cod_padre numeric,
--    sgd_eit_nombre character varying(40),
--    sgd_eit_sigla character varying(10)
--);


CREATE TABLE sgd_eit_items
(
    sgd_eit_codigo integer NOT NULL ,
    sgd_eit_cod_padre integer DEFAULT 0,
    sgd_eit_nombre character varying(40),
    sgd_eit_sigla character varying(6),
    id_cont smallint,
    id_pais smallint,
    codi_dpto smallint,
    codi_muni smallint
);


CREATE TABLE sgd_arch_depe
(
    sgd_arch_depe character varying(4),
    sgd_arch_edificio integer,
    sgd_arch_item integer,
    sgd_arch_id integer NOT NULL,
    CONSTRAINT id PRIMARY KEY(sgd_arch_id)
);
--
-- TOC entry 1476 (class 1259 OID 18017)
-- Dependencies: 5
-- Name: sgd_ent_entidades; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_ent_entidades (
    sgd_ent_nit character varying(13) NOT NULL,
    sgd_ent_codsuc character varying(4) NOT NULL,
    sgd_ent_pias integer,
    dpto_codi smallint,
    muni_codi smallint,
    sgd_ent_descrip character varying(80),
    sgd_ent_direccion character varying(50),
    sgd_ent_telefono character varying(50)
);


--
-- TOC entry 1487 (class 1259 OID 18069)
-- Dependencies: 5
-- Name: sgd_enve_envioespecial; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_enve_envioespecial (
    sgd_fenv_codigo integer,
    sgd_enve_valorl character varying(30),
    sgd_enve_valorn character varying(30),
    sgd_enve_desc character varying(30)
);


--
-- TOC entry 1463 (class 1259 OID 17923)
-- Dependencies: 5
-- Name: sgd_estinst_estadoinstancia; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_estinst_estadoinstancia (
    sgd_estinst_codi smallint NOT NULL,
    sgd_apli_codi smallint,
    sgd_instorf_codi smallint,
    sgd_estinst_valor smallint,
    sgd_estinst_habilita smallint,
    sgd_estinst_mensaje character varying(100)
);


--
-- TOC entry 1527 (class 1259 OID 18724)
-- Dependencies: 1952 1953 5
-- Name: sgd_exp_expediente; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_exp_expediente (
    sgd_exp_numero character varying(18),
    radi_nume_radi bigint,
    sgd_exp_fech date,
    sgd_exp_fech_mod date,
    depe_codi smallint,
    usua_codi smallint,
    usua_doc character varying(15),
    sgd_exp_estado smallint DEFAULT 0,
    sgd_exp_titulo character varying(50),
    sgd_exp_asunto character varying(150),
    sgd_exp_carpeta character varying(30),
    sgd_exp_ufisica character varying(20),
    sgd_exp_isla character varying(10),
    sgd_exp_estante character varying(10),
    sgd_exp_caja character varying(10),
    sgd_exp_fech_arch date,
    sgd_srd_codigo smallint,
    sgd_sbrd_codigo smallint,
    sgd_fexp_codigo smallint DEFAULT 0,
    sgd_exp_subexpediente integer,
    sgd_exp_archivo smallint,
    sgd_exp_unicon smallint,
    sgd_exp_fechfin date,
    sgd_exp_folios character varying(4),
    sgd_exp_rete smallint,
    sgd_exp_entrepa smallint,
    sgd_exp_privado smallint,
    sgd_exp_edificio character varying(40),
    sgd_exp_carro character varying(40),
    radi_usua_arch character varying(15),
    sgd_exp_cd character varying(10),
    sgd_exp_nref character varying(7)
);


--
-- TOC entry 2425 (class 0 OID 0)
-- Dependencies: 1527
-- Name: COLUMN sgd_exp_expediente.radi_usua_arch; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN sgd_exp_expediente.radi_usua_arch IS 'login del usuario que archiva';


--
-- TOC entry 1528 (class 1259 OID 18752)
-- Dependencies: 5
-- Name: sgd_fars_faristas; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_fars_faristas (
    sgd_fars_codigo integer NOT NULL,
    sgd_pexp_codigo integer,
    sgd_fexp_codigoini integer,
    sgd_fexp_codigofin integer,
    sgd_fars_diasminimo smallint,
    sgd_fars_diasmaximo smallint,
    sgd_fars_desc character varying(100),
    sgd_trad_codigo smallint,
    sgd_srd_codigo smallint,
    sgd_sbrd_codigo smallint,
    sgd_fars_tipificacion smallint,
    sgd_tpr_codigo integer,
    sgd_fars_automatico integer,
    sgd_fars_rolgeneral integer
);


--
-- TOC entry 1477 (class 1259 OID 18021)
-- Dependencies: 1896 1897 5
-- Name: sgd_fenv_frmenvio; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_fenv_frmenvio (
    sgd_fenv_codigo integer NOT NULL,
    sgd_fenv_descrip character varying(40) NOT NULL,
    sgd_fenv_planilla smallint DEFAULT 0 NOT NULL,
    sgd_fenv_estado smallint DEFAULT 1 NOT NULL,
	sgd_fenv_porc float8
);


--
-- TOC entry 1514 (class 1259 OID 18453)
-- Dependencies: 5
-- Name: sgd_fexp_flujoexpedientes; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_fexp_flujoexpedientes (
    sgd_fexp_codigo integer NOT NULL,
    sgd_pexp_codigo integer,
    sgd_fexp_orden smallint,
    sgd_fexp_terminos smallint,
    sgd_fexp_imagen character varying(50),
    sgd_fexp_descrip character varying(50)
);


--
-- TOC entry 1529 (class 1259 OID 18762)
-- Dependencies: 5
-- Name: sgd_firrad_firmarads; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_firrad_firmarads (
    sgd_firrad_id bigint NOT NULL,
    radi_nume_radi bigint NOT NULL,
    usua_doc character varying(14) NOT NULL,
    sgd_firrad_firma bytea,
    sgd_firrad_fecha date NOT NULL,
    sgd_firrad_docsolic character varying(14) NOT NULL,
    sgd_firrad_fechsolic date NOT NULL
);


--
-- TOC entry 1479 (class 1259 OID 18033)
-- Dependencies: 1898 5
-- Name: sgd_fld_flujodoc; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_fld_flujodoc (
    sgd_fld_codigo smallint,
    sgd_fld_desc character varying(100),
    sgd_tpr_codigo smallint,
    sgd_fld_imagen character varying(50),
    sgd_fld_grupoweb integer DEFAULT 0
);


--
-- TOC entry 1440 (class 1259 OID 17762)
-- Dependencies: 5
-- Name: sgd_fun_funciones; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_fun_funciones (
    sgd_fun_codigo smallint NOT NULL,
    sgd_fun_descrip character varying(530),
    sgd_fun_fech_ini date,
    sgd_fun_fech_fin date
);


--
-- TOC entry 1537 (class 1259 OID 18929)
-- Dependencies: 5
-- Name: sgd_hfld_histflujodoc; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_hfld_histflujodoc (
    sgd_hfld_codigo integer,
    sgd_fexp_codigo smallint NOT NULL,
    sgd_exp_fechflujoant date,
    sgd_hfld_fech timestamp with time zone,
    sgd_exp_numero character varying(18),
    radi_nume_radi bigint,
    usua_doc character varying(10),
    usua_codi smallint,
    depe_codi smallint,
    sgd_ttr_codigo smallint,
    sgd_fexp_observa character varying(500),
    sgd_hfld_observa character varying(500),
    sgd_fars_codigo integer,
    sgd_hfld_automatico integer
);


--
-- TOC entry 1530 (class 1259 OID 18775)
-- Dependencies: 5
-- Name: sgd_hmtd_hismatdoc; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_hmtd_hismatdoc (
    sgd_hmtd_codigo integer NOT NULL,
    sgd_hmtd_fecha date NOT NULL,
    radi_nume_radi bigint NOT NULL,
    usua_codi bigint NOT NULL,
    sgd_hmtd_obse character varying(600) NOT NULL,
    usua_doc bigint,
    depe_codi smallint,
    sgd_mtd_codigo smallint
);


--
-- TOC entry 1441 (class 1259 OID 17770)
-- Dependencies: 5
-- Name: sgd_instorf_instanciasorfeo; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_instorf_instanciasorfeo (
    sgd_instorf_codi smallint NOT NULL,
    sgd_instorf_desc character varying(100)
);


--
-- TOC entry 1442 (class 1259 OID 17775)
-- Dependencies: 5
-- Name: sgd_masiva_excel; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_masiva_excel (
    sgd_masiva_dependencia smallint,
    sgd_masiva_usuario bigint,
    sgd_masiva_tiporadicacion smallint,
    sgd_masiva_codigo bigint NOT NULL,
    sgd_masiva_radicada smallint,
    sgd_masiva_intervalo smallint,
    sgd_masiva_rangoini character varying(15),
    sgd_masiva_rangofin character varying(15)
);


--
-- TOC entry 1504 (class 1259 OID 18295)
-- Dependencies: 5
-- Name: sgd_mat_matriz; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_mat_matriz (
    sgd_mat_codigo smallint NOT NULL,
    depe_codi smallint,
    sgd_fun_codigo smallint,
    sgd_prc_codigo smallint,
    sgd_prd_codigo smallint,
    sgd_mat_fech_ini date,
    sgd_mat_fech_fin date,
    sgd_mat_peso_prd numeric
);


--
-- TOC entry 1486 (class 1259 OID 18064)
-- Dependencies: 5
-- Name: sgd_mpes_mddpeso; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_mpes_mddpeso (
    sgd_mpes_codigo integer NOT NULL,
    sgd_mpes_descrip character varying(10)
);


--
-- TOC entry 1505 (class 1259 OID 18324)
-- Dependencies: 5
-- Name: sgd_mrd_matrird; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_mrd_matrird (
    sgd_mrd_codigo smallint NOT NULL,
    depe_codi smallint NOT NULL,
    sgd_srd_codigo smallint NOT NULL,
    sgd_sbrd_codigo smallint NOT NULL,
    sgd_tpr_codigo smallint NOT NULL,
    soporte character varying(10),
    sgd_mrd_fechini date,
    sgd_mrd_fechfin date,
    sgd_mrd_esta character varying(10)
);


--
-- TOC entry 1507 (class 1259 OID 18360)
-- Dependencies: 5
-- Name: sgd_msdep_msgdep; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_msdep_msgdep (
    sgd_msdep_codi bigint NOT NULL,
    depe_codi smallint NOT NULL,
    sgd_msg_codi bigint NOT NULL
);


--
-- TOC entry 1506 (class 1259 OID 18350)
-- Dependencies: 5
-- Name: sgd_msg_mensaje; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_msg_mensaje (
    sgd_msg_codi bigint NOT NULL,
    sgd_tme_codi smallint NOT NULL,
    sgd_msg_desc character varying(150),
    sgd_msg_fechdesp date NOT NULL,
    sgd_msg_url character varying(150) NOT NULL,
    sgd_msg_veces smallint NOT NULL,
    sgd_msg_ancho integer NOT NULL,
    sgd_msg_largo integer NOT NULL
);


CREATE TABLE SGD_MSA_MEDSOPARCHIVO
(    SGD_MSA_CODIGO integer NOT NULL,
    SGD_MSA_DESCRIP character varying(30) NOT NULL,
    SGD_MSA_ESTADO integer DEFAULT 1 NOT NULL ,
    SGD_MSA_SIGLA character varying(2),
    CONSTRAINT pk_SGD_MSA_CODIGO PRIMARY KEY (SGD_MSA_CODIGO)
);
--
-- TOC entry 1508 (class 1259 OID 18375)
-- Dependencies: 5
-- Name: sgd_mtd_matriz_doc; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_mtd_matriz_doc (
    sgd_mtd_codigo smallint NOT NULL,
    sgd_mat_codigo smallint,
    sgd_tpr_codigo smallint
);


--
-- TOC entry 1538 (class 1259 OID 18934)
-- Dependencies: 5
-- Name: sgd_noh_nohabiles; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_noh_nohabiles (
    noh_fecha date
);


--
-- TOC entry 1443 (class 1259 OID 17780)
-- Dependencies: 5
-- Name: sgd_not_notificacion; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_not_notificacion (
    sgd_not_codi smallint NOT NULL,
    sgd_not_descrip character varying(100) NOT NULL
);


--
-- TOC entry 1531 (class 1259 OID 18798)
-- Dependencies: 5
-- Name: sgd_ntrd_notifrad; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_ntrd_notifrad (
    radi_nume_radi bigint NOT NULL,
    sgd_not_codi smallint NOT NULL,
    sgd_ntrd_notificador character varying(150),
    sgd_ntrd_notificado character varying(150),
    sgd_ntrd_fecha_not date,
    sgd_ntrd_num_edicto integer,
    sgd_ntrd_fecha_fija date,
    sgd_ntrd_fecha_desfija date,
    sgd_ntrd_observaciones character varying(150)
);


--
-- TOC entry 1532 (class 1259 OID 18805)
-- Dependencies: 1954 1955 5
-- Name: sgd_oem_oempresas; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_oem_oempresas (
    sgd_oem_codigo integer NOT NULL,
    tdid_codi smallint,
    sgd_oem_oempresa character varying(150),
    sgd_oem_rep_legal character varying(150),
    sgd_oem_nit character varying(14),
    sgd_oem_sigla character varying(50),
    muni_codi smallint,
    dpto_codi smallint,
    sgd_oem_direccion character varying(150),
    sgd_oem_telefono character varying(50),
    id_cont smallint DEFAULT 1,
    id_pais smallint DEFAULT 170,
    sgd_oem_act boolean DEFAULT TRUE NOT NULL
);


--
-- TOC entry 1482 (class 1259 OID 18043)
-- Dependencies: 5
-- Name: sgd_panu_peranulados; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_panu_peranulados (
    sgd_panu_codi smallint NOT NULL,
    sgd_panu_desc character varying(200)
);


--
-- TOC entry 1444 (class 1259 OID 17785)
-- Dependencies: 5
-- Name: sgd_parametro; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_parametro (
    param_nomb character varying(30) NOT NULL,
    param_codi integer NOT NULL,
    param_valor character varying(100) NOT NULL
);


--
-- TOC entry 1509 (class 1259 OID 18390)
-- Dependencies: 5
-- Name: sgd_parexp_paramexpediente; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_parexp_paramexpediente (
    sgd_parexp_codigo smallint NOT NULL,
    depe_codi smallint NOT NULL,
    sgd_parexp_tabla character varying(30) NOT NULL,
    sgd_parexp_etiqueta character varying(15) NOT NULL,
    sgd_parexp_orden smallint,
    sgd_parexp_editable numeric(1,0)
);


--
-- TOC entry 1510 (class 1259 OID 18400)
-- Dependencies: 1933 1934 1935 5
-- Name: sgd_pexp_procexpedientes; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_pexp_procexpedientes (
    sgd_pexp_codigo integer NOT NULL,
    sgd_pexp_descrip character varying(100),
    sgd_pexp_terminos integer DEFAULT 0,
    sgd_srd_codigo smallint,
    sgd_sbrd_codigo smallint,
    sgd_pexp_automatico smallint DEFAULT 1,
    sgd_pexp_tieneflujo smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 1464 (class 1259 OID 17938)
-- Dependencies: 5
-- Name: sgd_pnufe_procnumfe; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_pnufe_procnumfe (
    sgd_pnufe_codi smallint NOT NULL,
    sgd_tpr_codigo smallint,
    sgd_pnufe_descrip character varying(150),
    sgd_pnufe_serie character varying(50)
);


--
-- TOC entry 1534 (class 1259 OID 18865)
-- Dependencies: 5
-- Name: sgd_pnun_procenum; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_pnun_procenum (
    sgd_pnun_codi smallint NOT NULL,
    sgd_pnufe_codi smallint,
    depe_codi smallint,
    sgd_pnun_prepone character varying(50)
);


--
-- TOC entry 1445 (class 1259 OID 17790)
-- Dependencies: 5
-- Name: sgd_prc_proceso; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_prc_proceso (
    sgd_prc_codigo smallint NOT NULL,
    sgd_prc_descrip character varying(150),
    sgd_prc_fech_ini date,
    sgd_prc_fech_fin date
);


--
-- TOC entry 1465 (class 1259 OID 17943)
-- Dependencies: 5
-- Name: sgd_prd_prcdmentos; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_prd_prcdmentos (
    sgd_prd_codigo smallint NOT NULL,
    sgd_prd_descrip character varying(200),
    sgd_prd_fech_ini date,
    sgd_prd_fech_fin date
);


--
-- TOC entry 1511 (class 1259 OID 18413)
-- Dependencies: 5
-- Name: sgd_rdf_retdocf; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_rdf_retdocf (
    sgd_mrd_codigo smallint NOT NULL,
    radi_nume_radi bigint NOT NULL,
    depe_codi smallint NOT NULL,
    usua_codi bigint NOT NULL,
    usua_doc character varying(14) NOT NULL,
    sgd_rdf_fech date NOT NULL
);


--
-- TOC entry 1535 (class 1259 OID 18880)
-- Dependencies: 1958 1959 1960 1961 1962 1963 1964 1965 1966 5
-- Name: sgd_renv_regenvio; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_renv_regenvio (
    sgd_renv_codigo integer NOT NULL,
    sgd_fenv_codigo integer,
    sgd_renv_fech timestamp with time zone,
    radi_nume_sal bigint,
    sgd_renv_destino character varying(150),
    sgd_renv_telefono character varying(50),
    sgd_renv_mail character varying(150),
    sgd_renv_peso character varying(10),
    sgd_renv_certificado smallint,
    sgd_renv_estado smallint,
    usua_doc bigint,
    sgd_renv_nombre character varying(100),
    sgd_rem_destino smallint DEFAULT 0,
    sgd_dir_codigo bigint,
    sgd_renv_planilla character varying(8),
    sgd_renv_fech_sal date,
    depe_codi smallint,
    sgd_dir_tipo smallint DEFAULT 0,
    radi_nume_grupo bigint,
    sgd_renv_dir character varying(150),
    sgd_renv_depto character varying(30),
    sgd_renv_mpio character varying(30),
    sgd_renv_tel character varying(20),
    sgd_renv_cantidad smallint DEFAULT 0,
    sgd_renv_tipo smallint DEFAULT 0,
    sgd_renv_observa character varying(200),
    sgd_renv_grupo bigint,
    sgd_deve_codigo smallint,
    sgd_deve_fech timestamp with time zone,
    sgd_renv_valortotal character varying(14) DEFAULT '0'::character varying,
    sgd_renv_valistamiento character varying(10) DEFAULT '0'::character varying,
    sgd_renv_vdescuento character varying(10) DEFAULT '0'::character varying,
    sgd_renv_vadicional character varying(14) DEFAULT '0'::character varying,
    sgd_depe_genera smallint,
    sgd_renv_pais character varying(30) DEFAULT 'Colombia'::character varying,
    sgd_renv_valor integer
);


--
-- TOC entry 1446 (class 1259 OID 17795)
-- Dependencies: 5
-- Name: sgd_rfax_reservafax; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_rfax_reservafax (
    sgd_rfax_codigo bigint,
    sgd_rfax_fax character varying(30),
    usua_login character varying(30),
    sgd_rfax_fech date,
    sgd_rfax_fechradi date,
    radi_nume_radi bigint,
    sgd_rfax_observa character varying(500)
);


--
-- TOC entry 1480 (class 1259 OID 18036)
-- Dependencies: 5
-- Name: sgd_rmr_radmasivre; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_rmr_radmasivre (
    sgd_rmr_grupo bigint NOT NULL,
    sgd_rmr_radi bigint NOT NULL
);


--
-- TOC entry 1447 (class 1259 OID 17804)
-- Dependencies: 5
-- Name: sgd_san_sancionados; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_san_sancionados (
    sgd_san_ref character varying(20) NOT NULL,
    sgd_san_decision character varying(60),
    sgd_san_cargo character varying(50),
    sgd_san_expediente character varying(20),
    sgd_san_tipo_sancion character varying(50),
    sgd_san_plazo character varying(100),
    sgd_san_valor numeric,
    sgd_san_radicacion character varying(15),
    sgd_san_fecha_radicado date,
    sgd_san_valorletras character varying(1000),
    sgd_san_nombreempresa character varying(160),
    sgd_san_motivos character varying(160),
    sgd_san_sectores character varying(160),
    sgd_san_padre character varying(15),
    sgd_san_fecha_padre date,
    sgd_san_notificado character varying(100)
);


--
-- TOC entry 1466 (class 1259 OID 17948)
-- Dependencies: 5
-- Name: sgd_sbrd_subserierd; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_sbrd_subserierd (
    sgd_srd_codigo smallint NOT NULL,
    sgd_sbrd_codigo smallint NOT NULL,
    sgd_sbrd_descrip character varying(200) NOT NULL,
    sgd_sbrd_fechini date NOT NULL,
    sgd_sbrd_fechfin date NOT NULL,
    sgd_sbrd_tiemag smallint,
    sgd_sbrd_tiemac smallint,
    sgd_sbrd_dispfin character varying(50),
    sgd_sbrd_soporte integer NOT NULL,
    sgd_sbrd_procedi character varying(500),
	sgd_mtd_codigo integer
);


--
-- TOC entry 1475 (class 1259 OID 18012)
-- Dependencies: 5
-- Name: sgd_sed_sede; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_sed_sede (
    sgd_sed_codi smallint NOT NULL,
    sgd_sed_desc character varying(50),
    sgd_tpr_codigo smallint
);


--
-- TOC entry 1478 (class 1259 OID 18028)
-- Dependencies: 5
-- Name: sgd_senuf_secnumfe; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_senuf_secnumfe (
    sgd_senuf_codi smallint NOT NULL,
    sgd_pnufe_codi smallint,
    depe_codi integer,
    sgd_senuf_sec character varying(50)
);


--
-- TOC entry 1512 (class 1259 OID 18426)
-- Dependencies: 5
-- Name: sgd_sexp_secexpedientes; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_sexp_secexpedientes (
    sgd_exp_numero character varying(18) NOT NULL,
    sgd_srd_codigo integer,
    sgd_sbrd_codigo integer,
    sgd_sexp_secuencia integer,
    depe_codi smallint,
    usua_doc character varying(15),
    sgd_sexp_fech date,
    sgd_fexp_codigo integer,
    sgd_sexp_ano smallint,
    usua_doc_responsable character varying(18),
    sgd_sexp_parexp1 character varying(250),
    sgd_sexp_parexp2 character varying(160),
    sgd_sexp_parexp3 character varying(160),
    sgd_sexp_parexp4 character varying(160),
    sgd_sexp_parexp5 character varying(160),
    sgd_pexp_codigo integer,
    sgd_exp_fech_arch date,
    sgd_fld_codigo smallint,
    sgd_exp_fechflujoant date,
    sgd_mrd_codigo smallint,
    sgd_exp_subexpediente bigint,
    sgd_sexp_nombre character varying(64),
    sgd_sexp_asunto character varying(250),
    sgd_sexp_nivelseg smallint,
    sgd_sexp_faseexp smallint,
    sgd_fech_soltransferencia timestamp without time zone,
    sgd_sexp_fechacierre date,
    sgd_sexp_cerrado smallint
);


--
-- TOC entry 1448 (class 1259 OID 17812)
-- Dependencies: 5
-- Name: sgd_srd_seriesrd; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_srd_seriesrd (
    sgd_srd_codigo smallint NOT NULL,
    sgd_srd_descrip character varying(50) NOT NULL,
    sgd_srd_fechini date NOT NULL,
    sgd_srd_fechfin date NOT NULL
);


--
-- TOC entry 1490 (class 1259 OID 18082)
-- Dependencies: 5
-- Name: sgd_tar_tarifas; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tar_tarifas (
    sgd_fenv_codigo integer,
    sgd_tar_codser integer,
    sgd_tar_codigo integer,
    sgd_tar_valenv1 bigint,
    sgd_tar_valenv2 bigint,
    sgd_tar_valenv1g1 bigint,
    sgd_clta_codser integer,
    sgd_tar_valenv2g2 bigint,
    sgd_clta_descrip character varying(100)
);


--
-- TOC entry 1467 (class 1259 OID 17961)
-- Dependencies: 5
-- Name: sgd_tdec_tipodecision; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tdec_tipodecision (
    sgd_apli_codi smallint NOT NULL,
    sgd_tdec_codigo smallint NOT NULL,
    sgd_tdec_descrip character varying(150),
    sgd_tdec_sancionar smallint,
    sgd_tdec_firmeza smallint,
    sgd_tdec_versancion smallint,
    sgd_tdec_showmenu smallint,
    sgd_tdec_updnotif smallint
);


--
-- TOC entry 1468 (class 1259 OID 17971)
-- Dependencies: 5
-- Name: sgd_tid_tipdecision; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tid_tipdecision (
    sgd_tid_codi smallint NOT NULL,
    sgd_tid_desc character varying(150),
    sgd_tpr_codigo smallint,
    sgd_pexp_codigo integer,
    sgd_tpr_codigop smallint
);


--
-- TOC entry 1472 (class 1259 OID 17992)
-- Dependencies: 5
-- Name: sgd_tidm_tidocmasiva; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tidm_tidocmasiva (
    sgd_tidm_codi smallint NOT NULL,
    sgd_tidm_desc character varying(150)
);


--
-- TOC entry 1484 (class 1259 OID 18053)
-- Dependencies: 1899 1900 1901 5
-- Name: sgd_tip3_tipotercero; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tip3_tipotercero (
    sgd_tip3_codigo smallint NOT NULL,
    sgd_dir_tipo smallint,
    sgd_tip3_nombre character varying(15),
    sgd_tip3_desc character varying(30),
    sgd_tip3_imgpestana character varying(20),
    sgd_tpr_tp1 smallint DEFAULT 0,
    sgd_tpr_tp2 smallint DEFAULT 0
);


--
-- TOC entry 1515 (class 1259 OID 18463)
-- Dependencies: 5
-- Name: sgd_tma_temas; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tma_temas (
    sgd_tma_codigo smallint NOT NULL,
    sgd_prc_codigo smallint,
    sgd_tma_descrip character varying(150)
);


--
-- TOC entry 1536 (class 1259 OID 18914)
-- Dependencies: 5
-- Name: sgd_tmd_temadepe; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tmd_temadepe (
    id integer NOT NULL,
    sgd_tma_codigo smallint NOT NULL,
    depe_codi smallint NOT NULL
);


--
-- TOC entry 1449 (class 1259 OID 17818)
-- Dependencies: 5
-- Name: sgd_tme_tipmen; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tme_tipmen (
    sgd_tme_codi smallint NOT NULL,
    sgd_tme_desc character varying(150)
);


--
-- TOC entry 1469 (class 1259 OID 17976)
-- Dependencies: 1894 1895 5
-- Name: sgd_tpr_tpdcumento; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tpr_tpdcumento (
    sgd_tpr_codigo smallint NOT NULL,
    sgd_tpr_descrip character varying(150),
    sgd_tpr_termino smallint,
    sgd_tpr_tpuso smallint,
    sgd_tpr_numera character varying(1),
    sgd_tpr_radica character varying(1),
    sgd_tpr_tp1 smallint DEFAULT 0,
    sgd_tpr_tp2 smallint DEFAULT 0,
    sgd_tpr_estado smallint,
    sgd_termino_real smallint
);


--
-- TOC entry 1450 (class 1259 OID 17823)
-- Dependencies: 1893 5
-- Name: sgd_trad_tiporad; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_trad_tiporad (
    sgd_trad_codigo smallint NOT NULL,
    sgd_trad_descr character varying(30),
    sgd_trad_icono character varying(30),
    sgd_trad_genradsal smallint,
    sgd_trad_diasbloqueo smallint DEFAULT 0
);


--
-- TOC entry 1483 (class 1259 OID 18048)
-- Dependencies: 5
-- Name: sgd_tres_tpresolucion; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_tres_tpresolucion (
    sgd_tres_codigo smallint NOT NULL,
    sgd_tres_descrip character varying(100) NOT NULL
);


--
-- TOC entry 1485 (class 1259 OID 18059)
-- Dependencies: 5
-- Name: sgd_ttr_transaccion; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_ttr_transaccion (
    sgd_ttr_codigo smallint NOT NULL,
    sgd_ttr_descrip character varying(100) NOT NULL
);


--
-- TOC entry 1451 (class 1259 OID 17829)
-- Dependencies: 5
-- Name: sgd_ush_usuhistorico; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_ush_usuhistorico (
    sgd_ush_admcod bigint NOT NULL,
    sgd_ush_admdep integer NOT NULL,
    sgd_ush_admdoc character varying(14) NOT NULL,
    sgd_ush_usucod bigint NOT NULL,
    sgd_ush_usudep integer NOT NULL,
    sgd_ush_usudoc character varying(14) NOT NULL,
    sgd_ush_modcod integer NOT NULL,
    sgd_ush_fechevento date NOT NULL,
    sgd_ush_usulogin character varying(20) NOT NULL
);


--
-- TOC entry 1452 (class 1259 OID 17831)
-- Dependencies: 5
-- Name: sgd_usm_usumodifica; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE sgd_usm_usumodifica (
    sgd_usm_modcod integer NOT NULL,
    sgd_usm_moddescr character varying(60) NOT NULL
);


--
-- TOC entry 1453 (class 1259 OID 17834)
-- Dependencies: 5
-- Name: tipo_doc_identificacion; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE tipo_doc_identificacion (
    tdid_codi smallint NOT NULL,
    tdid_desc character varying(100) NOT NULL
);


--
-- TOC entry 1454 (class 1259 OID 17839)
-- Dependencies: 5
-- Name: tipo_remitente; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE tipo_remitente (
    trte_codi smallint NOT NULL,
    trte_desc character varying(100) NOT NULL
);


--
-- TOC entry 1471 (class 1259 OID 17989)
-- Dependencies: 5
-- Name: ubicacion_fisica; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE ubicacion_fisica (
    ubic_depe_radi integer NOT NULL,
    ubic_depe_arch integer,
    ubic_inv_piso character varying(2) NOT NULL,
    ubic_inv_piso_desc character varying(40),
    ubic_inv_itemso character varying(40),
    ubic_inv_itemsn character varying(40),
    ubic_inv_archivador character varying(4)
);


--
-- TOC entry 1498 (class 1259 OID 18167)
-- Dependencies: 1910 1911 1912 1913 1914 1915 1916 1917 1918 1919 1920 1921 1922 1923 1924 1925 1926 1927 1928 1929 1930 5
-- Name: usuario; Type: TABLE; Schema: public; Owner: -; Tablespace:
--

CREATE TABLE usuario (
    usua_codi smallint NOT NULL,
    depe_codi smallint NOT NULL,
    usua_login character varying(20) NOT NULL,
    usua_fech_crea date NOT NULL,
    usua_pasw character varying(30) NOT NULL,
    usua_esta character varying(10) NOT NULL,
    usua_nomb character varying(45),
    perm_radi character(1) DEFAULT 0,
    usua_admin character(1) DEFAULT 0,
    usua_nuevo character(1) DEFAULT 0,
    usua_doc character varying(14) DEFAULT '0'::character varying,
    codi_nivel smallint DEFAULT 1,
    usua_sesion character varying(30),
    usua_fech_sesion date,
    usua_ext smallint,
    usua_nacim date,
    usua_email character varying(50),
    usua_at character varying(15),
    usua_piso smallint,
    perm_radi_sal integer DEFAULT 0,
    usua_admin_archivo smallint DEFAULT 0,
    usua_masiva smallint DEFAULT 0,
    usua_perm_dev smallint DEFAULT 0,
    usua_perm_numera_res character varying(1),
    usua_doc_suip character varying(15),
    usua_perm_numeradoc smallint,
    sgd_panu_codi smallint,
    usua_prad_tp1 smallint DEFAULT 0,
    usua_prad_tp2 smallint DEFAULT 0,
    usua_perm_envios smallint DEFAULT 0,
    usua_perm_modifica smallint DEFAULT 0,
    usua_perm_impresion smallint DEFAULT 0,
    sgd_aper_codigo smallint,
    usu_telefono1 character varying(14),
    usua_encuesta character varying(1),
    sgd_perm_estadistica smallint,
    usua_perm_sancionados smallint,
    usua_admin_sistema smallint,
    usua_perm_trd smallint,
    usua_perm_firma smallint,
    usua_perm_prestamo smallint,
    usuario_publico smallint,
    usuario_reasignar smallint,
    usua_perm_notifica smallint,
    usua_perm_expediente integer,
    usua_login_externo character varying(20),
    id_pais smallint DEFAULT 170,
    id_cont smallint DEFAULT 1,
    perm_tipif_anexo integer,
    perm_vobo character varying(1) DEFAULT '1'::character varying,
    perm_archi character(1) DEFAULT 1,
    perm_borrar_anexo integer,
    usua_auth_ldap integer,
    usua_perm_adminflujos smallint DEFAULT 0,
    usua_adm_plantilla smallint DEFAULT 0,
    usua_perm_intergapps smallint DEFAULT 0,
    usua_prad_tpx smallint DEFAULT 0,
    usua_prad_reprad smallint DEFAULT 0,
    usua_timereload smallint NOT NULL DEFAULT 1, -- Valor minutos de recarga carpetas
    usua_habalertas smallint NOT NULL DEFAULT 1,  -- Habilita(1)/Deshabilita(0) la visualizacion de alertas
    usua_perm_remit_tercero smallint DEFAULT 0,
    usua_vobo_perm boolean DEFAULT FALSE NOT NULL,
    usua_super_perm smallint DEFAULT 0,
    mail_notif boolean default false
);


CREATE TABLE sgd_mtr_mrecfenv
(
  mrec_codi integer NOT NULL,
  sgd_fenv_codigo integer NOT NULL,
  CONSTRAINT pk_mrecfenv PRIMARY KEY (mrec_codi, sgd_fenv_codigo),
  CONSTRAINT uk_fenv UNIQUE (sgd_fenv_codigo),
  CONSTRAINT uk_mrec UNIQUE (mrec_codi)
);


CREATE TABLE sgd_matriz_nivelrad
(
    radi_nume_radi bigint,
    usua_login character varying(20)
);

CREATE TABLE sgd_carpeta_expediente
(
  sgd_carpeta_id integer NOT NULL,
  sgd_carpeta_csc integer NOT NULL,
  sgd_carpeta_numero integer NOT NULL,
  sgd_carpeta_descripcion character varying(500),
  sgd_exp_numero character varying(21) NOT NULL,
  sgd_carpeta_nfolios integer
);

CREATE TABLE sgd_exp_radcarpeta
(
  radi_nume_radi bigint NOT NULL,
  sgd_carpeta_id integer NOT NULL
);

CREATE TABLE sgd_matriz_nivelexp
(
  usua_login character varying(20),
  sgd_exp_numero character varying(18)
);

CREATE TABLE motivo_modificacion (
    motivo_modificacion_codigo smallint NOT NULL,
    motivo_modificacion_descrip character varying(150) NOT NULL
);

CREATE TABLE sgd_mtd_metadatos (
    sgd_mtd_codigo integer not null,
    sgd_mtd_nombre character varying(32) not null,
    sgd_mtd_descrip character varying(320) not null,
    sgd_mtd_estado smallint default 0 not null,
    sgd_srd_codigo smallint,
    sgd_sbrd_codigo integer,
    sgd_tpr_codigo integer,
    sgd_mtd_oblig smallint default 0 not null,
    primary key (sgd_mtd_codigo)
);

CREATE TABLE sgd_mmr_matrimetaexpe (
    sgd_exp_numero character varying(18) not null,
    sgd_mtd_codigo integer not null,
    sgd_mmr_dato character varying(400),
    primary key (sgd_exp_numero ,sgd_mtd_codigo )
);

CREATE TABLE sgd_mmr_matrimetaradi (
    radi_nume_radi bigint not null,
    sgd_mtd_codigo integer not null,
    sgd_mmr_dato character varying(400),
    primary key (radi_nume_radi ,sgd_mtd_codigo )
);

create table ImpUsrRel ( 
    usua_doc character varying(14) DEFAULT '0',
    depe_codi smallint NOT NULL
);

CREATE TABLE motivo_anulacion
(
    motivo_anulacion_codigo integer NOT NULL,
    motivo_anulacion_descrip character varying(150) NOT NULL,
    PRIMARY KEY (motivo_anulacion_codigo)
);

ALTER TABLE ONLY motivo_modificacion
    ADD CONSTRAINT pkmotivos PRIMARY KEY (motivo_modificacion_codigo);

--
-- TOC entry 2242 (class 2606 OID 18577)
-- Dependencies: 1518 1518 1518
-- Name: anexos_historico_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY anexos_historico
    ADD CONSTRAINT anexos_historico_pkey PRIMARY KEY (anex_hist_anex_codi, anex_hist_num_ver);


--
-- TOC entry 2235 (class 2606 OID 18562)
-- Dependencies: 1517 1517
-- Name: anexos_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY anexos
    ADD CONSTRAINT anexos_pkey PRIMARY KEY (anex_codigo);


--
-- TOC entry 1968 (class 2606 OID 17663)
-- Dependencies: 1425 1425
-- Name: anexos_tipo_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY anexos_tipo
    ADD CONSTRAINT anexos_tipo_pkey PRIMARY KEY (anex_tipo_codi);


--
-- TOC entry 1971 (class 2606 OID 17674)
-- Dependencies: 1426 1426
-- Name: bodega_empresas_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY bodega_empresas
    ADD CONSTRAINT bodega_empresas_pkey PRIMARY KEY (identificador_empresa);


--
-- TOC entry 2159 (class 2606 OID 18144)
-- Dependencies: 1496 1496 1496 1496
-- Name: carpeta_per_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY carpeta_per
    ADD CONSTRAINT carpeta_per_pkey PRIMARY KEY (usua_codi, depe_codi, codi_carp);


--
-- TOC entry 1981 (class 2606 OID 17686)
-- Dependencies: 1427 1427
-- Name: carpeta_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY carpeta
    ADD CONSTRAINT carpeta_pkey PRIMARY KEY (carp_codi);


--
-- TOC entry 2151 (class 2606 OID 18106)
-- Dependencies: 1493 1493 1493 1493
-- Name: departamento_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY departamento
    ADD CONSTRAINT departamento_pkey PRIMARY KEY (id_cont, id_pais, dpto_codi);


--
-- TOC entry 2156 (class 2606 OID 18129)
-- Dependencies: 1495 1495
-- Name: dependencia_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY dependencia
    ADD CONSTRAINT dependencia_pkey PRIMARY KEY (depe_codi);


--
-- TOC entry 2163 (class 2606 OID 18155)
-- Dependencies: 1497 1497
-- Name: dependencia_visibilidad_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY dependencia_visibilidad
    ADD CONSTRAINT dependencia_visibilidad_pkey PRIMARY KEY (codigo_visibilidad);


--
-- TOC entry 1984 (class 2606 OID 17691)
-- Dependencies: 1428 1428
-- Name: estado_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY estado
    ADD CONSTRAINT estado_pkey PRIMARY KEY (esta_codi);


--
-- TOC entry 1988 (class 2606 OID 17696)
-- Dependencies: 1429 1429
-- Name: medio_recepcion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY medio_recepcion
    ADD CONSTRAINT medio_recepcion_pkey PRIMARY KEY (mrec_codi);


--
-- TOC entry 2154 (class 2606 OID 18116)
-- Dependencies: 1494 1494 1494 1494 1494
-- Name: municipio_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY municipio
    ADD CONSTRAINT municipio_pkey PRIMARY KEY (id_cont, id_pais, dpto_codi, muni_codi);


--
-- TOC entry 1991 (class 2606 OID 17701)
-- Dependencies: 1430 1430
-- Name: par_serv_servicios_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY par_serv_servicios
    ADD CONSTRAINT par_serv_servicios_pkey PRIMARY KEY (par_serv_secue);


--
-- TOC entry 2250 (class 2606 OID 18630)
-- Dependencies: 1521 1521
-- Name: prestamo_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY prestamo
    ADD CONSTRAINT prestamo_pkey PRIMARY KEY (pres_id);


--
-- TOC entry 2232 (class 2606 OID 18489)
-- Dependencies: 1516 1516
-- Name: radicado_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_pkey PRIMARY KEY (radi_nume_radi);


--
-- TOC entry 1995 (class 2606 OID 17706)
-- Dependencies: 1431 1431 1431 1431
-- Name: series_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY series
    ADD CONSTRAINT series_pkey PRIMARY KEY (depe_codi, seri_tipo, seri_ano);


--
-- TOC entry 2253 (class 2606 OID 18660)
-- Dependencies: 1522 1522 1522
-- Name: sgd_acm_acusemsg_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_acm_acusemsg
    ADD CONSTRAINT sgd_acm_acusemsg_pkey PRIMARY KEY (sgd_msg_codi, usua_doc);


--
-- TOC entry 2061 (class 2606 OID 17850)
-- Dependencies: 1455 1455
-- Name: sgd_actadd_actualiadicional_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_actadd_actualiadicional
    ADD CONSTRAINT sgd_actadd_actualiadicional_pkey PRIMARY KEY (sgd_actadd_codi);


--
-- TOC entry 2171 (class 2606 OID 18208)
-- Dependencies: 1499 1499
-- Name: sgd_admin_depe_historico_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_admin_depe_historico
    ADD CONSTRAINT sgd_admin_depe_historico_pkey PRIMARY KEY (admin_depe_historico_codigo);


--
-- TOC entry 1997 (class 2606 OID 17712)
-- Dependencies: 1432 1432
-- Name: sgd_admin_dependencia_estado_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_admin_dependencia_estado
    ADD CONSTRAINT sgd_admin_dependencia_estado_pkey PRIMARY KEY (codigo_estado);


--
-- TOC entry 1999 (class 2606 OID 17719)
-- Dependencies: 1433 1433
-- Name: sgd_admin_observacion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_admin_observacion
    ADD CONSTRAINT sgd_admin_observacion_pkey PRIMARY KEY (codigo_observacion);


--
-- TOC entry 2173 (class 2606 OID 18217)
-- Dependencies: 1500 1500
-- Name: sgd_admin_usua_historico_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_admin_usua_historico
    ADD CONSTRAINT sgd_admin_usua_historico_pkey PRIMARY KEY (admin_historico_codigo);


--
-- TOC entry 2001 (class 2606 OID 17723)
-- Dependencies: 1434 1434
-- Name: sgd_admin_usua_perfiles_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_admin_usua_perfiles
    ADD CONSTRAINT sgd_admin_usua_perfiles_pkey PRIMARY KEY (codigo_perfil);


--
-- TOC entry 2256 (class 2606 OID 18680)
-- Dependencies: 1524 1524
-- Name: sgd_anar_anexarg_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_anar_anexarg
    ADD CONSTRAINT sgd_anar_anexarg_pkey PRIMARY KEY (sgd_anar_codi);


--
-- TOC entry 2103 (class 2606 OID 17987)
-- Dependencies: 1470 1470
-- Name: sgd_aper_adminperfiles_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_aper_adminperfiles
    ADD CONSTRAINT sgd_aper_adminperfiles_pkey PRIMARY KEY (sgd_aper_codigo);


--
-- TOC entry 2063 (class 2606 OID 17865)
-- Dependencies: 1456 1456
-- Name: sgd_aplfad_plicfunadi_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_aplfad_plicfunadi
    ADD CONSTRAINT sgd_aplfad_plicfunadi_pkey PRIMARY KEY (sgd_aplfad_codi);


--
-- TOC entry 2004 (class 2606 OID 17730)
-- Dependencies: 1435 1435
-- Name: sgd_apli_aplintegra_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_apli_aplintegra
    ADD CONSTRAINT sgd_apli_aplintegra_pkey PRIMARY KEY (sgd_apli_codi);


--
-- TOC entry 2066 (class 2606 OID 17875)
-- Dependencies: 1457 1457
-- Name: sgd_aplmen_aplimens_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_aplmen_aplimens
    ADD CONSTRAINT sgd_aplmen_aplimens_pkey PRIMARY KEY (sgd_aplmen_codi);


--
-- TOC entry 2070 (class 2606 OID 17885)
-- Dependencies: 1458 1458
-- Name: sgd_aplus_plicusua_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_aplus_plicusua
    ADD CONSTRAINT sgd_aplus_plicusua_pkey PRIMARY KEY (sgd_aplus_codi);


--
-- TOC entry 2007 (class 2606 OID 17738)
-- Dependencies: 1436 1436
-- Name: sgd_argd_argdoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_argd_argdoc
    ADD CONSTRAINT sgd_argd_argdoc_pkey PRIMARY KEY (sgd_argd_codi);


--
-- TOC entry 2113 (class 2606 OID 18010)
-- Dependencies: 1474 1474
-- Name: sgd_argup_argudoctop_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_argup_argudoctop
    ADD CONSTRAINT sgd_argup_argudoctop_pkey PRIMARY KEY (sgd_argup_codi);


--
-- TOC entry 2217 (class 2606 OID 18446)
-- Dependencies: 1513 1513
-- Name: sgd_camexp_campoexpediente_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_camexp_campoexpediente
    ADD CONSTRAINT sgd_camexp_campoexpediente_pkey PRIMARY KEY (sgd_camexp_codigo);


--
-- TOC entry 2176 (class 2606 OID 18236)
-- Dependencies: 1501 1501 1501
-- Name: sgd_carp_descripcion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_carp_descripcion
    ADD CONSTRAINT sgd_carp_descripcion_pkey PRIMARY KEY (sgd_carp_depecodi, sgd_carp_tiporad);


--
-- TOC entry 2010 (class 2606 OID 17743)
-- Dependencies: 1437 1437
-- Name: sgd_cau_causal_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_cau_causal
    ADD CONSTRAINT sgd_cau_causal_pkey PRIMARY KEY (sgd_cau_codigo);


--
-- TOC entry 2259 (class 2606 OID 18707)
-- Dependencies: 1526 1526
-- Name: sgd_caux_causales_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_caux_causales
    ADD CONSTRAINT sgd_caux_causales_pkey PRIMARY KEY (sgd_caux_codigo);


--
-- TOC entry 2183 (class 2606 OID 18281)
-- Dependencies: 1503 1503
-- Name: sgd_ciu_ciudadano_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_ciu_ciudadano
    ADD CONSTRAINT sgd_ciu_ciudadano_pkey PRIMARY KEY (sgd_ciu_codigo);


--
-- TOC entry 2110 (class 2606 OID 18000)
-- Dependencies: 1473 1473
-- Name: sgd_cob_campobliga_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_cob_campobliga
    ADD CONSTRAINT sgd_cob_campobliga_pkey PRIMARY KEY (sgd_cob_codi);


--
-- TOC entry 2073 (class 2606 OID 17895)
-- Dependencies: 1459 1459
-- Name: sgd_dcau_causal_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_dcau_causal
    ADD CONSTRAINT sgd_dcau_causal_pkey PRIMARY KEY (sgd_dcau_codigo);


--
-- TOC entry 2075 (class 2606 OID 17905)
-- Dependencies: 1460 1460
-- Name: sgd_ddca_ddsgrgdo_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_ddca_ddsgrgdo
    ADD CONSTRAINT sgd_ddca_ddsgrgdo_pkey PRIMARY KEY (sgd_ddca_codigo);


--
-- TOC entry 2146 (class 2606 OID 18087)
-- Dependencies: 1491 1491
-- Name: sgd_def_continentes_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_def_continentes
    ADD CONSTRAINT sgd_def_continentes_pkey PRIMARY KEY (id_cont);


--
-- TOC entry 2149 (class 2606 OID 18094)
-- Dependencies: 1492 1492 1492
-- Name: sgd_def_paises_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_def_paises
    ADD CONSTRAINT sgd_def_paises_pkey PRIMARY KEY (id_cont, id_pais);


--
-- TOC entry 2078 (class 2606 OID 17921)
-- Dependencies: 1462 1462
-- Name: sgd_deve_dev_envio_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_deve_dev_envio
    ADD CONSTRAINT sgd_deve_dev_envio_pkey PRIMARY KEY (sgd_deve_codigo);


--
-- TOC entry 2298 (class 2606 OID 18835)
-- Dependencies: 1533 1533
-- Name: sgd_dir_drecciones_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_dir_drecciones
    ADD CONSTRAINT sgd_dir_drecciones_pkey PRIMARY KEY (sgd_dir_codigo);


--
-- TOC entry 2179 (class 2606 OID 18251)
-- Dependencies: 1502 1502
-- Name: sgd_dnufe_docnufe_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_dnufe_docnufe
    ADD CONSTRAINT sgd_dnufe_docnufe_pkey PRIMARY KEY (sgd_dnufe_codi);


--
-- TOC entry 2143 (class 2606 OID 18081)
-- Dependencies: 1489 1489
-- Name: sgd_eanu_estanulacion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_eanu_estanulacion
    ADD CONSTRAINT sgd_eanu_estanulacion_pkey PRIMARY KEY (sgd_eanu_codi);


--
-- TOC entry 2013 (class 2606 OID 17751)
-- Dependencies: 1438 1438
-- Name: sgd_einv_inventario_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_einv_inventario
    ADD CONSTRAINT sgd_einv_inventario_pkey PRIMARY KEY (sgd_einv_codigo);


--
-- TOC entry 2016 (class 2606 OID 17760)
-- Dependencies: 1439 1439
-- Name: sgd_eit_items_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_eit_items
    ADD CONSTRAINT sgd_eit_items_pkey PRIMARY KEY (sgd_eit_codigo);


--
-- TOC entry 2118 (class 2606 OID 18020)
-- Dependencies: 1476 1476 1476
-- Name: sgd_ent_entidades_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_ent_entidades
    ADD CONSTRAINT sgd_ent_entidades_pkey PRIMARY KEY (sgd_ent_nit, sgd_ent_codsuc);


--
-- TOC entry 2080 (class 2606 OID 17926)
-- Dependencies: 1463 1463
-- Name: sgd_estinst_estadoinstancia_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_estinst_estadoinstancia
    ADD CONSTRAINT sgd_estinst_estadoinstancia_pkey PRIMARY KEY (sgd_estinst_codi);


--
-- TOC entry 2276 (class 2606 OID 18755)
-- Dependencies: 1528 1528
-- Name: sgd_fars_faristas_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_fars_faristas
    ADD CONSTRAINT sgd_fars_faristas_pkey PRIMARY KEY (sgd_fars_codigo);


--
-- TOC entry 2121 (class 2606 OID 18026)
-- Dependencies: 1477 1477
-- Name: sgd_fenv_frmenvio_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_fenv_frmenvio
    ADD CONSTRAINT sgd_fenv_frmenvio_pkey PRIMARY KEY (sgd_fenv_codigo);


--
-- TOC entry 2220 (class 2606 OID 18456)
-- Dependencies: 1514 1514
-- Name: sgd_fexp_flujoexpedientes_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_fexp_flujoexpedientes
    ADD CONSTRAINT sgd_fexp_flujoexpedientes_pkey PRIMARY KEY (sgd_fexp_codigo);


--
-- TOC entry 2279 (class 2606 OID 18768)
-- Dependencies: 1529 1529
-- Name: sgd_firrad_firmarads_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_firrad_firmarads
    ADD CONSTRAINT sgd_firrad_firmarads_pkey PRIMARY KEY (sgd_firrad_id);


--
-- TOC entry 2019 (class 2606 OID 17768)
-- Dependencies: 1440 1440
-- Name: sgd_fun_funciones_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_fun_funciones
    ADD CONSTRAINT sgd_fun_funciones_pkey PRIMARY KEY (sgd_fun_codigo);


--
-- TOC entry 2282 (class 2606 OID 18781)
-- Dependencies: 1530 1530
-- Name: sgd_hmtd_hismatdoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_hmtd_hismatdoc
    ADD CONSTRAINT sgd_hmtd_hismatdoc_pkey PRIMARY KEY (sgd_hmtd_codigo);


--
-- TOC entry 2022 (class 2606 OID 17773)
-- Dependencies: 1441 1441
-- Name: sgd_instorf_instanciasorfeo_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_instorf_instanciasorfeo
    ADD CONSTRAINT sgd_instorf_instanciasorfeo_pkey PRIMARY KEY (sgd_instorf_codi);


--
-- TOC entry 2025 (class 2606 OID 17778)
-- Dependencies: 1442 1442
-- Name: sgd_masiva_excel_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_masiva_excel
    ADD CONSTRAINT sgd_masiva_excel_pkey PRIMARY KEY (sgd_masiva_codigo);


--
-- TOC entry 2188 (class 2606 OID 18301)
-- Dependencies: 1504 1504
-- Name: sgd_mat_matriz_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_mat_matriz
    ADD CONSTRAINT sgd_mat_matriz_pkey PRIMARY KEY (sgd_mat_codigo);


--
-- TOC entry 2141 (class 2606 OID 18067)
-- Dependencies: 1486 1486
-- Name: sgd_mpes_mddpeso_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_mpes_mddpeso
    ADD CONSTRAINT sgd_mpes_mddpeso_pkey PRIMARY KEY (sgd_mpes_codigo);


--
-- TOC entry 2192 (class 2606 OID 18327)
-- Dependencies: 1505 1505
-- Name: sgd_mrd_matrird_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_mrd_matrird
    ADD CONSTRAINT sgd_mrd_matrird_pkey PRIMARY KEY (sgd_mrd_codigo);


--
-- TOC entry 2198 (class 2606 OID 18363)
-- Dependencies: 1507 1507
-- Name: sgd_msdep_msgdep_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_msdep_msgdep
    ADD CONSTRAINT sgd_msdep_msgdep_pkey PRIMARY KEY (sgd_msdep_codi);


--
-- TOC entry 2195 (class 2606 OID 18353)
-- Dependencies: 1506 1506
-- Name: sgd_msg_mensaje_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_msg_mensaje
    ADD CONSTRAINT sgd_msg_mensaje_pkey PRIMARY KEY (sgd_msg_codi);


--
-- TOC entry 2201 (class 2606 OID 18378)
-- Dependencies: 1508 1508
-- Name: sgd_mtd_matriz_doc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_mtd_matriz_doc
    ADD CONSTRAINT sgd_mtd_matriz_doc_pkey PRIMARY KEY (sgd_mtd_codigo);


--
-- TOC entry 2028 (class 2606 OID 17783)
-- Dependencies: 1443 1443
-- Name: sgd_not_notificacion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_not_notificacion
    ADD CONSTRAINT sgd_not_notificacion_pkey PRIMARY KEY (sgd_not_codi);


--
-- TOC entry 2286 (class 2606 OID 18813)
-- Dependencies: 1532 1532
-- Name: sgd_oem_oempresas_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_oem_oempresas
    ADD CONSTRAINT sgd_oem_oempresas_pkey PRIMARY KEY (sgd_oem_codigo);


--
-- TOC entry 2130 (class 2606 OID 18046)
-- Dependencies: 1482 1482
-- Name: sgd_panu_peranulados_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_panu_peranulados
    ADD CONSTRAINT sgd_panu_peranulados_pkey PRIMARY KEY (sgd_panu_codi);


--
-- TOC entry 2031 (class 2606 OID 17788)
-- Dependencies: 1444 1444 1444
-- Name: sgd_parametro_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_parametro
    ADD CONSTRAINT sgd_parametro_pkey PRIMARY KEY (param_nomb, param_codi);


--
-- TOC entry 2204 (class 2606 OID 18393)
-- Dependencies: 1509 1509
-- Name: sgd_parexp_paramexpediente_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_parexp_paramexpediente
    ADD CONSTRAINT sgd_parexp_paramexpediente_pkey PRIMARY KEY (sgd_parexp_codigo);


--
-- TOC entry 2207 (class 2606 OID 18406)
-- Dependencies: 1510 1510
-- Name: sgd_pexp_procexpedientes_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_pexp_procexpedientes
    ADD CONSTRAINT sgd_pexp_procexpedientes_pkey PRIMARY KEY (sgd_pexp_codigo);


--
-- TOC entry 2084 (class 2606 OID 17941)
-- Dependencies: 1464 1464
-- Name: sgd_pnufe_procnumfe_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_pnufe_procnumfe
    ADD CONSTRAINT sgd_pnufe_procnumfe_pkey PRIMARY KEY (sgd_pnufe_codi);


--
-- TOC entry 2301 (class 2606 OID 18868)
-- Dependencies: 1534 1534
-- Name: sgd_pnun_procenum_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_pnun_procenum
    ADD CONSTRAINT sgd_pnun_procenum_pkey PRIMARY KEY (sgd_pnun_codi);


--
-- TOC entry 2034 (class 2606 OID 17793)
-- Dependencies: 1445 1445
-- Name: sgd_prc_proceso_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_prc_proceso
    ADD CONSTRAINT sgd_prc_proceso_pkey PRIMARY KEY (sgd_prc_codigo);


--
-- TOC entry 2087 (class 2606 OID 17946)
-- Dependencies: 1465 1465
-- Name: sgd_prd_prcdmentos_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_prd_prcdmentos
    ADD CONSTRAINT sgd_prd_prcdmentos_pkey PRIMARY KEY (sgd_prd_codigo);


--
-- TOC entry 2127 (class 2606 OID 18039)
-- Dependencies: 1480 1480 1480
-- Name: sgd_rmr_radmasivre_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_rmr_radmasivre
    ADD CONSTRAINT sgd_rmr_radmasivre_pkey PRIMARY KEY (sgd_rmr_grupo, sgd_rmr_radi);


--
-- TOC entry 2041 (class 2606 OID 17810)
-- Dependencies: 1447 1447
-- Name: sgd_san_sancionados_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_san_sancionados
    ADD CONSTRAINT sgd_san_sancionados_pkey PRIMARY KEY (sgd_san_ref);


--
-- TOC entry 2090 (class 2606 OID 17954)
-- Dependencies: 1466 1466 1466
-- Name: sgd_sbrd_subserierd_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_sbrd_subserierd
    ADD CONSTRAINT sgd_sbrd_subserierd_pkey PRIMARY KEY (sgd_srd_codigo, sgd_sbrd_codigo);


--
-- TOC entry 2115 (class 2606 OID 18015)
-- Dependencies: 1475 1475
-- Name: sgd_sed_sede_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_sed_sede
    ADD CONSTRAINT sgd_sed_sede_pkey PRIMARY KEY (sgd_sed_codi);


--
-- TOC entry 2124 (class 2606 OID 18031)
-- Dependencies: 1478 1478
-- Name: sgd_senuf_secnumfe_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_senuf_secnumfe
    ADD CONSTRAINT sgd_senuf_secnumfe_pkey PRIMARY KEY (sgd_senuf_codi);


--
-- TOC entry 2213 (class 2606 OID 18432)
-- Dependencies: 1512 1512
-- Name: sgd_sexp_secexpedientes_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_sexp_secexpedientes
    ADD CONSTRAINT sgd_sexp_secexpedientes_pkey PRIMARY KEY (sgd_exp_numero);


--
-- TOC entry 2045 (class 2606 OID 17815)
-- Dependencies: 1448 1448
-- Name: sgd_srd_seriesrd_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_srd_seriesrd
    ADD CONSTRAINT sgd_srd_seriesrd_pkey PRIMARY KEY (sgd_srd_codigo);


--
-- TOC entry 2093 (class 2606 OID 17964)
-- Dependencies: 1467 1467
-- Name: sgd_tdec_tipodecision_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tdec_tipodecision
    ADD CONSTRAINT sgd_tdec_tipodecision_pkey PRIMARY KEY (sgd_tdec_codigo);


--
-- TOC entry 2096 (class 2606 OID 17974)
-- Dependencies: 1468 1468
-- Name: sgd_tid_tipdecision_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tid_tipdecision
    ADD CONSTRAINT sgd_tid_tipdecision_pkey PRIMARY KEY (sgd_tid_codi);


--
-- TOC entry 2107 (class 2606 OID 17995)
-- Dependencies: 1472 1472
-- Name: sgd_tidm_tidocmasiva_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tidm_tidocmasiva
    ADD CONSTRAINT sgd_tidm_tidocmasiva_pkey PRIMARY KEY (sgd_tidm_codi);


--
-- TOC entry 2135 (class 2606 OID 18058)
-- Dependencies: 1484 1484
-- Name: sgd_tip3_tipotercero_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tip3_tipotercero
    ADD CONSTRAINT sgd_tip3_tipotercero_pkey PRIMARY KEY (sgd_tip3_codigo);


--
-- TOC entry 2223 (class 2606 OID 18466)
-- Dependencies: 1515 1515
-- Name: sgd_tma_temas_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tma_temas
    ADD CONSTRAINT sgd_tma_temas_pkey PRIMARY KEY (sgd_tma_codigo);


--
-- TOC entry 2309 (class 2606 OID 18917)
-- Dependencies: 1536 1536
-- Name: sgd_tmd_temadepe_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tmd_temadepe
    ADD CONSTRAINT sgd_tmd_temadepe_pkey PRIMARY KEY (id);


--
-- TOC entry 2048 (class 2606 OID 17821)
-- Dependencies: 1449 1449
-- Name: sgd_tme_tipmen_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tme_tipmen
    ADD CONSTRAINT sgd_tme_tipmen_pkey PRIMARY KEY (sgd_tme_codi);


--
-- TOC entry 2100 (class 2606 OID 17981)
-- Dependencies: 1469 1469
-- Name: sgd_tpr_tpdcumento_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tpr_tpdcumento
    ADD CONSTRAINT sgd_tpr_tpdcumento_pkey PRIMARY KEY (sgd_tpr_codigo);


--
-- TOC entry 2051 (class 2606 OID 17827)
-- Dependencies: 1450 1450
-- Name: sgd_trad_tiporad_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_trad_tiporad
    ADD CONSTRAINT sgd_trad_tiporad_pkey PRIMARY KEY (sgd_trad_codigo);


--
-- TOC entry 2133 (class 2606 OID 18051)
-- Dependencies: 1483 1483
-- Name: sgd_tres_tpresolucion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_tres_tpresolucion
    ADD CONSTRAINT sgd_tres_tpresolucion_pkey PRIMARY KEY (sgd_tres_codigo);


--
-- TOC entry 2138 (class 2606 OID 18062)
-- Dependencies: 1485 1485
-- Name: sgd_ttr_transaccion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY sgd_ttr_transaccion
    ADD CONSTRAINT sgd_ttr_transaccion_pkey PRIMARY KEY (sgd_ttr_codigo);


--
-- TOC entry 2055 (class 2606 OID 17837)
-- Dependencies: 1453 1453
-- Name: tipo_doc_identificacion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY tipo_doc_identificacion
    ADD CONSTRAINT tipo_doc_identificacion_pkey PRIMARY KEY (tdid_codi);


--
-- TOC entry 2058 (class 2606 OID 17842)
-- Dependencies: 1454 1454
-- Name: tipo_remitente_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY tipo_remitente
    ADD CONSTRAINT tipo_remitente_pkey PRIMARY KEY (trte_codi);


--
-- TOC entry 2169 (class 2606 OID 18191)
-- Dependencies: 1498 1498
-- Name: usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace:
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (usua_login);


--
-- TOC entry 2233 (class 1259 OID 18570)
-- Dependencies: 1517 1517 1517 1517
-- Name: anexos_idx_001; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX anexos_idx_001 ON anexos USING btree (anex_creador, anex_borrado, anex_estado, sgd_deve_codigo);


--
-- TOC entry 2160 (class 1259 OID 18151)
-- Dependencies: 1496
-- Name: carpetas_per; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX carpetas_per ON carpeta_per USING btree (codi_carp);


--
-- TOC entry 2161 (class 1259 OID 18150)
-- Dependencies: 1496 1496
-- Name: carpetas_per1; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX carpetas_per1 ON carpeta_per USING btree (usua_codi, depe_codi);


--
-- TOC entry 2059 (class 1259 OID 17861)
-- Dependencies: 1455
-- Name: idx_actadd_codi; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_actadd_codi ON sgd_actadd_actualiadicional USING btree (sgd_actadd_codi);


--
-- TOC entry 2254 (class 1259 OID 18691)
-- Dependencies: 1524
-- Name: idx_anar_anexarg; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_anar_anexarg ON sgd_anar_anexarg USING btree (sgd_anar_codi);


--
-- TOC entry 2236 (class 1259 OID 18569)
-- Dependencies: 1517
-- Name: idx_anex_codigo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_anex_codigo ON anexos USING btree (anex_codigo);


--
-- TOC entry 2237 (class 1259 OID 18573)
-- Dependencies: 1517
-- Name: idx_anex_depe_codi; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_anex_depe_codi ON anexos USING btree (anex_depe_codi);


--
-- TOC entry 2243 (class 1259 OID 18588)
-- Dependencies: 1518 1518
-- Name: idx_anex_hist; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_anex_hist ON anexos_historico USING btree (anex_hist_anex_codi, anex_hist_num_ver);


--
-- TOC entry 2238 (class 1259 OID 18571)
-- Dependencies: 1517
-- Name: idx_anex_numero; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_anex_numero ON anexos USING btree (anex_numero);


--
-- TOC entry 2239 (class 1259 OID 18568)
-- Dependencies: 1517
-- Name: idx_anex_radi; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_anex_radi ON anexos USING btree (anex_radi_nume);


--
-- TOC entry 2240 (class 1259 OID 18572)
-- Dependencies: 1517
-- Name: idx_anex_radi_sal; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_anex_radi_sal ON anexos USING btree (radi_nume_salida);


--
-- TOC entry 1969 (class 1259 OID 17664)
-- Dependencies: 1425
-- Name: idx_anex_tipo_codi; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_anex_tipo_codi ON anexos_tipo USING btree (anex_tipo_codi);


--
-- TOC entry 2101 (class 1259 OID 17988)
-- Dependencies: 1470
-- Name: idx_aper_adminperfiles; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_aper_adminperfiles ON sgd_aper_adminperfiles USING btree (sgd_aper_codigo);


--
-- TOC entry 1992 (class 1259 OID 17708)
-- Dependencies: 1431
-- Name: idx_bloqueo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_bloqueo ON series USING btree (bloq);


--
-- TOC entry 1972 (class 1259 OID 17681)
-- Dependencies: 1426
-- Name: idx_bodega_empresas; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_bodega_empresas ON bodega_empresas USING btree (identificador_empresa);


--
-- TOC entry 1973 (class 1259 OID 17679)
-- Dependencies: 1426 1426 1426 1426
-- Name: idx_bodega_inter; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_bodega_inter ON bodega_empresas USING btree (codigo_del_departamento, codigo_del_municipio, id_cont, id_pais);


--
-- TOC entry 1974 (class 1259 OID 17677)
-- Dependencies: 1426
-- Name: idx_bodega_nit; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_bodega_nit ON bodega_empresas USING btree (nit_de_la_empresa);


--
-- TOC entry 1975 (class 1259 OID 17675)
-- Dependencies: 1426
-- Name: idx_bodega_nombre; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_bodega_nombre ON bodega_empresas USING btree (nombre_de_la_empresa);


--
-- TOC entry 1976 (class 1259 OID 17676)
-- Dependencies: 1426
-- Name: idx_bodega_nuir; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_bodega_nuir ON bodega_empresas USING btree (nuir);


--
-- TOC entry 1977 (class 1259 OID 17678)
-- Dependencies: 1426
-- Name: idx_bodega_sigla; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_bodega_sigla ON bodega_empresas USING btree (sigla_de_la_empresa);


--
-- TOC entry 2174 (class 1259 OID 18247)
-- Dependencies: 1501 1501
-- Name: idx_carp_descripcion; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_carp_descripcion ON sgd_carp_descripcion USING btree (sgd_carp_depecodi, sgd_carp_tiporad);


--
-- TOC entry 1982 (class 1259 OID 17687)
-- Dependencies: 1427
-- Name: idx_carpetas; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_carpetas ON carpeta USING btree (carp_codi);


--
-- TOC entry 2244 (class 1259 OID 18990)
-- Dependencies: 1519 1519 1519 1519
-- Name: idx_consulta; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_consulta ON hist_eventos USING btree (depe_codi, hist_fech, usua_codi, radi_nume_radi);


--
-- TOC entry 2144 (class 1259 OID 18088)
-- Dependencies: 1491
-- Name: idx_def_continentes; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_def_continentes ON sgd_def_continentes USING btree (id_cont);


--
-- TOC entry 2147 (class 1259 OID 18100)
-- Dependencies: 1492
-- Name: idx_def_paises; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_def_paises ON sgd_def_paises USING btree (id_cont);


--
-- TOC entry 2157 (class 1259 OID 18140)
-- Dependencies: 1495
-- Name: idx_depe; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_depe ON dependencia USING btree (depe_codi);


--
-- TOC entry 2164 (class 1259 OID 18166)
-- Dependencies: 1497
-- Name: idx_dependencia_visibilidad; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_dependencia_visibilidad ON dependencia_visibilidad USING btree (codigo_visibilidad);


--
-- TOC entry 2288 (class 1259 OID 18859)
-- Dependencies: 1533
-- Name: idx_dir_ciu_codigo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_dir_ciu_codigo ON sgd_dir_drecciones USING btree (sgd_ciu_codigo);


--
-- TOC entry 2289 (class 1259 OID 18860)
-- Dependencies: 1533 1533 1533 1533
-- Name: idx_dir_int; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_dir_int ON sgd_dir_drecciones USING btree (muni_codi, dpto_codi, id_pais, id_cont);


--
-- TOC entry 2177 (class 1259 OID 18272)
-- Dependencies: 1502
-- Name: idx_dnufe_docnufe; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_dnufe_docnufe ON sgd_dnufe_docnufe USING btree (sgd_dnufe_codi);


--
-- TOC entry 2011 (class 1259 OID 17752)
-- Dependencies: 1438
-- Name: idx_einv_inventario; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_einv_inventario ON sgd_einv_inventario USING btree (sgd_einv_codigo);


--
-- TOC entry 2014 (class 1259 OID 17761)
-- Dependencies: 1439
-- Name: idx_eit_items; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_eit_items ON sgd_eit_items USING btree (sgd_eit_codigo);


--
-- TOC entry 1985 (class 1259 OID 17692)
-- Dependencies: 1428
-- Name: idx_estado; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_estado ON estado USING btree (esta_codi);


--
-- TOC entry 2260 (class 1259 OID 18744)
-- Dependencies: 1527
-- Name: idx_exp_asun; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_asun ON sgd_exp_expediente USING btree (sgd_exp_asunto);


--
-- TOC entry 2261 (class 1259 OID 18748)
-- Dependencies: 1527
-- Name: idx_exp_caja; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_caja ON sgd_exp_expediente USING btree (sgd_exp_caja);


--
-- TOC entry 2262 (class 1259 OID 18747)
-- Dependencies: 1527
-- Name: idx_exp_estant; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_estant ON sgd_exp_expediente USING btree (sgd_exp_estante);


--
-- TOC entry 2263 (class 1259 OID 18738)
-- Dependencies: 1527
-- Name: idx_exp_exp; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_exp ON sgd_exp_expediente USING btree (sgd_exp_numero);


--
-- TOC entry 2264 (class 1259 OID 18749)
-- Dependencies: 1527
-- Name: idx_exp_fechaa; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_fechaa ON sgd_exp_expediente USING btree (sgd_exp_fech_arch);


--
-- TOC entry 2265 (class 1259 OID 18750)
-- Dependencies: 1527
-- Name: idx_exp_fechh; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_fechh ON sgd_exp_expediente USING btree (sgd_exp_fechfin);


--
-- TOC entry 2266 (class 1259 OID 18751)
-- Dependencies: 1527
-- Name: idx_exp_folio; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_folio ON sgd_exp_expediente USING btree (sgd_exp_folios);


--
-- TOC entry 2267 (class 1259 OID 18746)
-- Dependencies: 1527
-- Name: idx_exp_isla; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_isla ON sgd_exp_expediente USING btree (sgd_exp_isla);


--
-- TOC entry 2268 (class 1259 OID 18743)
-- Dependencies: 1527
-- Name: idx_exp_titu; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_titu ON sgd_exp_expediente USING btree (sgd_exp_titulo);


--
-- TOC entry 2269 (class 1259 OID 18745)
-- Dependencies: 1527
-- Name: idx_exp_ufisi; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_exp_ufisi ON sgd_exp_expediente USING btree (sgd_exp_ufisica);


--
-- TOC entry 2270 (class 1259 OID 18741)
-- Dependencies: 1527 1527
-- Name: idx_expediente_depe_usua; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_expediente_depe_usua ON sgd_exp_expediente USING btree (depe_codi, usua_codi);


--
-- TOC entry 2271 (class 1259 OID 18740)
-- Dependencies: 1527
-- Name: idx_expediente_fecha; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_expediente_fecha ON sgd_exp_expediente USING btree (sgd_exp_fech);


--
-- TOC entry 2272 (class 1259 OID 18742)
-- Dependencies: 1527
-- Name: idx_expediente_usua_doc; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_expediente_usua_doc ON sgd_exp_expediente USING btree (usua_doc);


--
-- TOC entry 2274 (class 1259 OID 18761)
-- Dependencies: 1528
-- Name: idx_fars_faristas; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_fars_faristas ON sgd_fars_faristas USING btree (sgd_fars_codigo);


--
-- TOC entry 2218 (class 1259 OID 18462)
-- Dependencies: 1514
-- Name: idx_fexp_descrip; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_fexp_descrip ON sgd_fexp_flujoexpedientes USING btree (sgd_fexp_codigo);


--
-- TOC entry 2277 (class 1259 OID 18774)
-- Dependencies: 1529
-- Name: idx_firrad_firmarads; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_firrad_firmarads ON sgd_firrad_firmarads USING btree (sgd_firrad_id);


--
-- TOC entry 2017 (class 1259 OID 17769)
-- Dependencies: 1440
-- Name: idx_fun_funciones; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_fun_funciones ON sgd_fun_funciones USING btree (sgd_fun_codigo);


--
-- TOC entry 2280 (class 1259 OID 18797)
-- Dependencies: 1530
-- Name: idx_hmtd_hismatdoc; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_hmtd_hismatdoc ON sgd_hmtd_hismatdoc USING btree (sgd_hmtd_codigo);


--
-- TOC entry 2246 (class 1259 OID 18623)
-- Dependencies: 1520 1520 1520
-- Name: idx_informado_usuario; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_informado_usuario ON informados USING btree (usua_codi, depe_codi, info_fech);


--
-- TOC entry 2020 (class 1259 OID 17774)
-- Dependencies: 1441
-- Name: idx_instorf_instanciasorfeo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_instorf_instanciasorfeo ON sgd_instorf_instanciasorfeo USING btree (sgd_instorf_codi);


--
-- TOC entry 2185 (class 1259 OID 18323)
-- Dependencies: 1504 1504 1504 1504
-- Name: idx_mat; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_mat ON sgd_mat_matriz USING btree (depe_codi, sgd_fun_codigo, sgd_prc_codigo, sgd_prd_codigo);


--
-- TOC entry 2186 (class 1259 OID 18322)
-- Dependencies: 1504
-- Name: idx_mat_matriz; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_mat_matriz ON sgd_mat_matriz USING btree (sgd_mat_codigo);


--
-- TOC entry 1986 (class 1259 OID 17697)
-- Dependencies: 1429
-- Name: idx_medio_recepcion; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_medio_recepcion ON medio_recepcion USING btree (mrec_codi);


--
-- TOC entry 2139 (class 1259 OID 18068)
-- Dependencies: 1486
-- Name: idx_mpes; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_mpes ON sgd_mpes_mddpeso USING btree (sgd_mpes_codigo);


--
-- TOC entry 2189 (class 1259 OID 18348)
-- Dependencies: 1505
-- Name: idx_mrd_codigo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_mrd_codigo ON sgd_mrd_matrird USING btree (sgd_mrd_codigo);


--
-- TOC entry 2190 (class 1259 OID 18349)
-- Dependencies: 1505 1505 1505 1505
-- Name: idx_mrd_matrird; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_mrd_matrird ON sgd_mrd_matrird USING btree (depe_codi, sgd_srd_codigo, sgd_sbrd_codigo, sgd_tpr_codigo);


--
-- TOC entry 2196 (class 1259 OID 18374)
-- Dependencies: 1507
-- Name: idx_msdep_msgdep; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_msdep_msgdep ON sgd_msdep_msgdep USING btree (sgd_msdep_codi);


--
-- TOC entry 2193 (class 1259 OID 18359)
-- Dependencies: 1506
-- Name: idx_msg_mensaje; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_msg_mensaje ON sgd_msg_mensaje USING btree (sgd_msg_codi);


--
-- TOC entry 2199 (class 1259 OID 18389)
-- Dependencies: 1508
-- Name: idx_mtd_matriz_doc; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_mtd_matriz_doc ON sgd_mtd_matriz_doc USING btree (sgd_mtd_codigo);


--
-- TOC entry 2152 (class 1259 OID 18122)
-- Dependencies: 1494 1494 1494 1494
-- Name: idx_municipio; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_municipio ON municipio USING btree (id_cont, id_pais, dpto_codi, muni_codi);


--
-- TOC entry 2283 (class 1259 OID 18824)
-- Dependencies: 1532
-- Name: idx_oem_oempresas; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_oem_oempresas ON sgd_oem_oempresas USING btree (sgd_oem_codigo);


--
-- TOC entry 1989 (class 1259 OID 17702)
-- Dependencies: 1430
-- Name: idx_par_serv_servicios; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_par_serv_servicios ON par_serv_servicios USING btree (par_serv_secue);


--
-- TOC entry 2029 (class 1259 OID 17789)
-- Dependencies: 1444 1444
-- Name: idx_parametro_pk; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_parametro_pk ON sgd_parametro USING btree (param_nomb, param_codi);


--
-- TOC entry 2202 (class 1259 OID 18399)
-- Dependencies: 1509
-- Name: idx_parexp_paramexpediente; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_parexp_paramexpediente ON sgd_parexp_paramexpediente USING btree (sgd_parexp_codigo);


--
-- TOC entry 2128 (class 1259 OID 18047)
-- Dependencies: 1482
-- Name: idx_peranualdos; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_peranualdos ON sgd_panu_peranulados USING btree (sgd_panu_codi);


--
-- TOC entry 2205 (class 1259 OID 18412)
-- Dependencies: 1510
-- Name: idx_pexp_procexpedientes; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_pexp_procexpedientes ON sgd_pexp_procexpedientes USING btree (sgd_pexp_codigo);


--
-- TOC entry 2082 (class 1259 OID 17942)
-- Dependencies: 1464
-- Name: idx_pnufe_procnumfe; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_pnufe_procnumfe ON sgd_pnufe_procnumfe USING btree (sgd_pnufe_codi);


--
-- TOC entry 2299 (class 1259 OID 18879)
-- Dependencies: 1534
-- Name: idx_pnun_procenum; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_pnun_procenum ON sgd_pnun_procenum USING btree (sgd_pnun_codi);


--
-- TOC entry 2032 (class 1259 OID 17794)
-- Dependencies: 1445
-- Name: idx_prc_proceso; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_prc_proceso ON sgd_prc_proceso USING btree (sgd_prc_codigo);


--
-- TOC entry 2085 (class 1259 OID 17947)
-- Dependencies: 1465
-- Name: idx_prd_prcdmentos; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_prd_prcdmentos ON sgd_prd_prcdmentos USING btree (sgd_prd_codigo);


--
-- TOC entry 2248 (class 1259 OID 18656)
-- Dependencies: 1521
-- Name: idx_prestamo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_prestamo ON prestamo USING btree (pres_id);


--
-- TOC entry 2224 (class 1259 OID 18547)
-- Dependencies: 1516
-- Name: idx_radi_eesp; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_radi_eesp ON radicado USING btree (eesp_codi);


--
-- TOC entry 2247 (class 1259 OID 18622)
-- Dependencies: 1520
-- Name: idx_radicado; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_radicado ON informados USING btree (radi_nume_radi);


--
-- TOC entry 2225 (class 1259 OID 18548)
-- Dependencies: 1516 1516 1516 1516
-- Name: idx_radicado_inter; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_radicado_inter ON radicado USING btree (muni_codi, dpto_codi, id_cont, id_pais);


--
-- TOC entry 2208 (class 1259 OID 18425)
-- Dependencies: 1511 1511 1511
-- Name: idx_rdf_retdocf; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_rdf_retdocf ON sgd_rdf_retdocf USING btree (sgd_mrd_codigo, radi_nume_radi, depe_codi);


--
-- TOC entry 2035 (class 1259 OID 17800)
-- Dependencies: 1446
-- Name: idx_rfax_codigo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_rfax_codigo ON sgd_rfax_reservafax USING btree (sgd_rfax_codigo);


--
-- TOC entry 2036 (class 1259 OID 17801)
-- Dependencies: 1446
-- Name: idx_rfax_fax; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_rfax_fax ON sgd_rfax_reservafax USING btree (sgd_rfax_fax);


--
-- TOC entry 2037 (class 1259 OID 17802)
-- Dependencies: 1446
-- Name: idx_rfax_fech; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_rfax_fech ON sgd_rfax_reservafax USING btree (sgd_rfax_fech);


--
-- TOC entry 2038 (class 1259 OID 17803)
-- Dependencies: 1446
-- Name: idx_rfax_radi_nume_radi; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_rfax_radi_nume_radi ON sgd_rfax_reservafax USING btree (radi_nume_radi);


--
-- TOC entry 2125 (class 1259 OID 18040)
-- Dependencies: 1480 1480
-- Name: idx_rmr_radmasivre; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_rmr_radmasivre ON sgd_rmr_radmasivre USING btree (sgd_rmr_grupo, sgd_rmr_radi);


--
-- TOC entry 2088 (class 1259 OID 17960)
-- Dependencies: 1466 1466
-- Name: idx_sbrd_subserierd; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sbrd_subserierd ON sgd_sbrd_subserierd USING btree (sgd_srd_codigo, sgd_sbrd_codigo);


--
-- TOC entry 2122 (class 1259 OID 18032)
-- Dependencies: 1478
-- Name: idx_senuf_codi; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_senuf_codi ON sgd_senuf_secnumfe USING btree (sgd_senuf_codi);


--
-- TOC entry 1993 (class 1259 OID 17707)
-- Dependencies: 1431 1431 1431
-- Name: idx_series; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_series ON series USING btree (depe_codi, seri_tipo, seri_ano);


--
-- TOC entry 2209 (class 1259 OID 18438)
-- Dependencies: 1512
-- Name: idx_sexp_secexpedientes; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sexp_secexpedientes ON sgd_sexp_secexpedientes USING btree (sgd_exp_numero);


--
-- TOC entry 2251 (class 1259 OID 18666)
-- Dependencies: 1522 1522
-- Name: idx_sgd_acm_acusemsg; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_acm_acusemsg ON sgd_acm_acusemsg USING btree (sgd_msg_codi, usua_doc);


--
-- TOC entry 2002 (class 1259 OID 17731)
-- Dependencies: 1435
-- Name: idx_sgd_apli_aplintegra; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_apli_aplintegra ON sgd_apli_aplintegra USING btree (sgd_apli_codi);


--
-- TOC entry 2068 (class 1259 OID 17891)
-- Dependencies: 1458
-- Name: idx_sgd_aplus_plicusua; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_aplus_plicusua ON sgd_aplus_plicusua USING btree (sgd_aplus_codi);


--
-- TOC entry 2005 (class 1259 OID 17739)
-- Dependencies: 1436
-- Name: idx_sgd_argd_argdoc; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_argd_argdoc ON sgd_argd_argdoc USING btree (sgd_argd_codi);


--
-- TOC entry 2111 (class 1259 OID 18011)
-- Dependencies: 1474
-- Name: idx_sgd_argup_argudoctop; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_argup_argudoctop ON sgd_argup_argudoctop USING btree (sgd_argup_codi);


--
-- TOC entry 2215 (class 1259 OID 18452)
-- Dependencies: 1513
-- Name: idx_sgd_camexp_campoexpediente; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_camexp_campoexpediente ON sgd_camexp_campoexpediente USING btree (sgd_camexp_codigo);


--
-- TOC entry 2008 (class 1259 OID 17744)
-- Dependencies: 1437
-- Name: idx_sgd_cau_causal; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_cau_causal ON sgd_cau_causal USING btree (sgd_cau_codigo);


--
-- TOC entry 2257 (class 1259 OID 18723)
-- Dependencies: 1526
-- Name: idx_sgd_caux_causales; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_caux_causales ON sgd_caux_causales USING btree (sgd_caux_codigo);


--
-- TOC entry 2180 (class 1259 OID 18292)
-- Dependencies: 1503
-- Name: idx_sgd_ciu_ciudadano; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_ciu_ciudadano ON sgd_ciu_ciudadano USING btree (sgd_ciu_codigo);


--
-- TOC entry 2108 (class 1259 OID 18006)
-- Dependencies: 1473
-- Name: idx_sgd_cob_campobliga; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_cob_campobliga ON sgd_cob_campobliga USING btree (sgd_cob_codi);


--
-- TOC entry 2071 (class 1259 OID 17901)
-- Dependencies: 1459
-- Name: idx_sgd_dcau_causal; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_dcau_causal ON sgd_dcau_causal USING btree (sgd_dcau_codigo);


--
-- TOC entry 2076 (class 1259 OID 17922)
-- Dependencies: 1462
-- Name: idx_sgd_deve; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_deve ON sgd_deve_dev_envio USING btree (sgd_deve_codigo);


--
-- TOC entry 2290 (class 1259 OID 18856)
-- Dependencies: 1533
-- Name: idx_sgd_dir; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_dir ON sgd_dir_drecciones USING btree (sgd_dir_codigo);


--
-- TOC entry 2291 (class 1259 OID 18864)
-- Dependencies: 1533
-- Name: idx_sgd_dir_doc; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_dir_doc ON sgd_dir_drecciones USING btree (sgd_dir_doc);


--
-- TOC entry 2292 (class 1259 OID 18861)
-- Dependencies: 1533
-- Name: idx_sgd_dir_nombre; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_dir_nombre ON sgd_dir_drecciones USING btree (sgd_dir_nombre);


--
-- TOC entry 2293 (class 1259 OID 18863)
-- Dependencies: 1533
-- Name: idx_sgd_dir_nomremdes; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_dir_nomremdes ON sgd_dir_drecciones USING btree (sgd_dir_nomremdes);


--
-- TOC entry 2294 (class 1259 OID 18858)
-- Dependencies: 1533
-- Name: idx_sgd_dir_oem_codigo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_dir_oem_codigo ON sgd_dir_drecciones USING btree (sgd_oem_codigo);


--
-- TOC entry 2295 (class 1259 OID 18862)
-- Dependencies: 1533
-- Name: idx_sgd_doc_fun; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_sgd_doc_fun ON sgd_dir_drecciones USING btree (sgd_doc_fun);


--
-- TOC entry 2119 (class 1259 OID 18027)
-- Dependencies: 1477
-- Name: idx_sgd_fenv; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_fenv ON sgd_fenv_frmenvio USING btree (sgd_fenv_codigo);


--
-- TOC entry 2026 (class 1259 OID 17784)
-- Dependencies: 1443
-- Name: idx_sgd_not; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_not ON sgd_not_notificacion USING btree (sgd_not_codi);


--
-- TOC entry 2039 (class 1259 OID 17811)
-- Dependencies: 1447
-- Name: idx_sgd_san_sancionados; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_sgd_san_sancionados ON sgd_san_sancionados USING btree (sgd_san_ref);


--
-- TOC entry 2042 (class 1259 OID 17817)
-- Dependencies: 1448
-- Name: idx_srd_descrip; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_srd_descrip ON sgd_srd_seriesrd USING btree (sgd_srd_descrip);


--
-- TOC entry 2043 (class 1259 OID 17816)
-- Dependencies: 1448
-- Name: idx_srd_seriesrd; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_srd_seriesrd ON sgd_srd_seriesrd USING btree (sgd_srd_codigo);


--
-- TOC entry 2091 (class 1259 OID 17970)
-- Dependencies: 1467
-- Name: idx_tdec_tipodecision; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tdec_tipodecision ON sgd_tdec_tipodecision USING btree (sgd_tdec_codigo);


--
-- TOC entry 2105 (class 1259 OID 17996)
-- Dependencies: 1472
-- Name: idx_tdm_tidomasiva; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tdm_tidomasiva ON sgd_tidm_tidocmasiva USING btree (sgd_tidm_codi);


--
-- TOC entry 2094 (class 1259 OID 17975)
-- Dependencies: 1468
-- Name: idx_tid_tipdecision; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tid_tipdecision ON sgd_tid_tipdecision USING btree (sgd_tid_codi);


--
-- TOC entry 2053 (class 1259 OID 17838)
-- Dependencies: 1453
-- Name: idx_tipo_doc_identificacion; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tipo_doc_identificacion ON tipo_doc_identificacion USING btree (tdid_codi);


--
-- TOC entry 2056 (class 1259 OID 17843)
-- Dependencies: 1454
-- Name: idx_tipo_remitente; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tipo_remitente ON tipo_remitente USING btree (trte_codi);


--
-- TOC entry 2245 (class 1259 OID 18605)
-- Dependencies: 1519
-- Name: idx_tipotrans; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_tipotrans ON hist_eventos USING btree (sgd_ttr_codigo);


--
-- TOC entry 2221 (class 1259 OID 18472)
-- Dependencies: 1515
-- Name: idx_tma_temas; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tma_temas ON sgd_tma_temas USING btree (sgd_tma_codigo);


--
-- TOC entry 2307 (class 1259 OID 18928)
-- Dependencies: 1536
-- Name: idx_tmd_temadepe; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tmd_temadepe ON sgd_tmd_temadepe USING btree (id);


--
-- TOC entry 2046 (class 1259 OID 17822)
-- Dependencies: 1449
-- Name: idx_tme_tipmen; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tme_tipmen ON sgd_tme_tipmen USING btree (sgd_tme_codi);


--
-- TOC entry 2097 (class 1259 OID 17982)
-- Dependencies: 1469
-- Name: idx_tpr_tpdcumento; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tpr_tpdcumento ON sgd_tpr_tpdcumento USING btree (sgd_tpr_codigo);


--
-- TOC entry 2049 (class 1259 OID 17828)
-- Dependencies: 1450
-- Name: idx_trad_tiporad_codigo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_trad_tiporad_codigo ON sgd_trad_tiporad USING btree (sgd_trad_codigo);


--
-- TOC entry 2131 (class 1259 OID 18052)
-- Dependencies: 1483
-- Name: idx_tres_tpresolucion; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_tres_tpresolucion ON sgd_tres_tpresolucion USING btree (sgd_tres_codigo);


--
-- TOC entry 2136 (class 1259 OID 18063)
-- Dependencies: 1485
-- Name: idx_ttr_transaccion; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_ttr_transaccion ON sgd_ttr_transaccion USING btree (sgd_ttr_codigo);


--
-- TOC entry 2104 (class 1259 OID 17991)
-- Dependencies: 1471
-- Name: idx_ubicacion_fisica; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_ubicacion_fisica ON ubicacion_fisica USING btree (ubic_inv_piso);


--
-- TOC entry 2052 (class 1259 OID 17833)
-- Dependencies: 1452
-- Name: idx_usm_modcod; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_usm_modcod ON sgd_usm_usumodifica USING btree (sgd_usm_modcod);


--
-- TOC entry 2165 (class 1259 OID 18204)
-- Dependencies: 1498
-- Name: idx_usua_doc; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX idx_usua_doc ON usuario USING btree (usua_doc);


--
-- TOC entry 2166 (class 1259 OID 18203)
-- Dependencies: 1498
-- Name: idx_usua_login; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_usua_login ON usuario USING btree (usua_login);


--
-- TOC entry 2167 (class 1259 OID 18202)
-- Dependencies: 1498 1498
-- Name: idx_usuario; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX idx_usuario ON usuario USING btree (usua_codi, depe_codi);


--
-- TOC entry 2273 (class 1259 OID 18739)
-- Dependencies: 1527
-- Name: ind_exp_radi; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX ind_exp_radi ON sgd_exp_expediente USING btree (radi_nume_radi);


--
-- TOC entry 2226 (class 1259 OID 18549)
-- Dependencies: 1516
-- Name: ind_radicado_radi_path; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX ind_radicado_radi_path ON radicado USING btree (radi_path);


--
-- TOC entry 2302 (class 1259 OID 18909)
-- Dependencies: 1535
-- Name: ind_renv_codigo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX ind_renv_codigo ON sgd_renv_regenvio USING btree (sgd_renv_codigo);


--
-- TOC entry 2303 (class 1259 OID 18911)
-- Dependencies: 1535
-- Name: ind_renv_fech; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX ind_renv_fech ON sgd_renv_regenvio USING btree (sgd_renv_fech);


--
-- TOC entry 2304 (class 1259 OID 18912)
-- Dependencies: 1535
-- Name: ind_renv_fech_sal; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX ind_renv_fech_sal ON sgd_renv_regenvio USING btree (sgd_renv_fech_sal);


--
-- TOC entry 2305 (class 1259 OID 18913)
-- Dependencies: 1535
-- Name: ind_renv_grupo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX ind_renv_grupo ON sgd_renv_regenvio USING btree (sgd_renv_grupo);


--
-- TOC entry 2306 (class 1259 OID 18910)
-- Dependencies: 1535 1535 1535
-- Name: ind_renv_radi_sal; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX ind_renv_radi_sal ON sgd_renv_regenvio USING btree (sgd_fenv_codigo, radi_nume_sal, depe_codi);


--
-- TOC entry 2098 (class 1259 OID 17983)
-- Dependencies: 1469
-- Name: ind_tpr_tpdocdescrp; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX ind_tpr_tpdocdescrp ON sgd_tpr_tpdcumento USING btree (sgd_tpr_descrip);


--
-- TOC entry 2227 (class 1259 OID 18551)
-- Dependencies: 1516
-- Name: radicado_dependencia; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX radicado_dependencia ON radicado USING btree (radi_cuentai);


--
-- TOC entry 2228 (class 1259 OID 18545)
-- Dependencies: 1516 1516 1516
-- Name: radicado_idx_001; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX radicado_idx_001 ON radicado USING btree (radi_nume_radi, tdoc_codi, codi_nivel);


--
-- TOC entry 2229 (class 1259 OID 18550)
-- Dependencies: 1516 1516
-- Name: radicado_idx_003; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX radicado_idx_003 ON radicado USING btree (radi_depe_radi, sgd_eanu_codigo);


--
-- TOC entry 2230 (class 1259 OID 18998)
-- Dependencies: 1516 1516 1516 1516 1516
-- Name: radicado_orden; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX radicado_orden ON radicado USING btree (radi_fech_radi, carp_codi, radi_usua_actu, radi_depe_actu, radi_fech_asig);


--
-- TOC entry 1978 (class 1259 OID 17682)
-- Dependencies: 1426
-- Name: sgd_bodega_are_esp_secue; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_bodega_are_esp_secue ON bodega_empresas USING btree (are_esp_secue);


--
-- TOC entry 1979 (class 1259 OID 17680)
-- Dependencies: 1426
-- Name: sgd_bodega_rep_legal; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_bodega_rep_legal ON bodega_empresas USING btree (cargo_rep_legal);


--
-- TOC entry 2181 (class 1259 OID 18293)
-- Dependencies: 1503 1503 1503
-- Name: sgd_buscar_nombre; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_buscar_nombre ON sgd_ciu_ciudadano USING btree (sgd_ciu_nombre, sgd_ciu_apell1, sgd_ciu_apell2);


--
-- TOC entry 2284 (class 1259 OID 18826)
-- Dependencies: 1532
-- Name: sgd_busq_nit; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_busq_nit ON sgd_oem_oempresas USING btree (sgd_oem_nit);


--
-- TOC entry 2184 (class 1259 OID 18294)
-- Dependencies: 1503 1503 1503
-- Name: sgd_ciu_inte; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_ciu_inte ON sgd_ciu_ciudadano USING btree (muni_codi, dpto_codi, id_cont);


--
-- TOC entry 2296 (class 1259 OID 18857)
-- Dependencies: 1533 1533 1533
-- Name: sgd_dir_drecciones_idx_001; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_dir_drecciones_idx_001 ON sgd_dir_drecciones USING btree (sgd_dir_tipo, radi_nume_radi, sgd_esp_codi);


--
-- TOC entry 2023 (class 1259 OID 17779)
-- Dependencies: 1442
-- Name: sgd_masiva_codigo; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX sgd_masiva_codigo ON sgd_masiva_excel USING btree (sgd_masiva_codigo);


--
-- TOC entry 2210 (class 1259 OID 18441)
-- Dependencies: 1512
-- Name: sgd_sexp_proc; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_sexp_proc ON sgd_sexp_secexpedientes USING btree (sgd_fexp_codigo);


--
-- TOC entry 2211 (class 1259 OID 18440)
-- Dependencies: 1512
-- Name: sgd_sexp_sbrd; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_sexp_sbrd ON sgd_sexp_secexpedientes USING btree (sgd_sbrd_codigo);


--
-- TOC entry 2214 (class 1259 OID 18439)
-- Dependencies: 1512
-- Name: sgd_sexp_srd; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sgd_sexp_srd ON sgd_sexp_secexpedientes USING btree (sgd_srd_codigo);


--
-- TOC entry 2287 (class 1259 OID 18825)
-- Dependencies: 1532 1532
-- Name: sqg_busq_empresa; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE INDEX sqg_busq_empresa ON sgd_oem_oempresas USING btree (sgd_oem_oempresa, sgd_oem_sigla);


--
-- TOC entry 2064 (class 1259 OID 17871)
-- Dependencies: 1456
-- Name: sys_c005036; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX sys_c005036 ON sgd_aplfad_plicfunadi USING btree (sgd_aplfad_codi);


--
-- TOC entry 2067 (class 1259 OID 17881)
-- Dependencies: 1457
-- Name: sys_c005038; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX sys_c005038 ON sgd_aplmen_aplimens USING btree (sgd_aplmen_codi);


--
-- TOC entry 2081 (class 1259 OID 17937)
-- Dependencies: 1463
-- Name: sys_c005088; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX sys_c005088 ON sgd_estinst_estadoinstancia USING btree (sgd_estinst_codi);


--
-- TOC entry 2116 (class 1259 OID 18016)
-- Dependencies: 1475
-- Name: sys_c005196; Type: INDEX; Schema: public; Owner: -; Tablespace:
--

CREATE UNIQUE INDEX sys_c005196 ON sgd_sed_sede USING btree (sgd_sed_codi);


--
-- TOC entry 2378 (class 2606 OID 18563)
-- Dependencies: 1498 1517 2168
-- Name: anexos_anex_creador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY anexos
    ADD CONSTRAINT anexos_anex_creador_fkey FOREIGN KEY (anex_creador) REFERENCES usuario(usua_login);


--
-- TOC entry 2379 (class 2606 OID 18578)
-- Dependencies: 1518 2234 1517
-- Name: anexos_historico_anex_hist_anex_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY anexos_historico
    ADD CONSTRAINT anexos_historico_anex_hist_anex_codi_fkey FOREIGN KEY (anex_hist_anex_codi) REFERENCES anexos(anex_codigo);


--
-- TOC entry 2380 (class 2606 OID 18583)
-- Dependencies: 2168 1498 1518
-- Name: anexos_historico_anex_hist_usua_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY anexos_historico
    ADD CONSTRAINT anexos_historico_anex_hist_usua_fkey FOREIGN KEY (anex_hist_usua) REFERENCES usuario(usua_login);


--
-- TOC entry 2329 (class 2606 OID 18145)
-- Dependencies: 1496 2155 1495
-- Name: carpeta_per_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY carpeta_per
    ADD CONSTRAINT carpeta_per_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2325 (class 2606 OID 18107)
-- Dependencies: 1493 2148 1493 1492 1492
-- Name: departamento_id_cont_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY departamento
    ADD CONSTRAINT departamento_id_cont_fkey FOREIGN KEY (id_cont, id_pais) REFERENCES sgd_def_paises(id_cont, id_pais);


--
-- TOC entry 2328 (class 2606 OID 18135)
-- Dependencies: 1495 1495 2155
-- Name: dependencia_depe_codi_padre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY dependencia
    ADD CONSTRAINT dependencia_depe_codi_padre_fkey FOREIGN KEY (depe_codi_padre) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2327 (class 2606 OID 18130)
-- Dependencies: 1495 2153 1494 1494 1494 1494 1495 1495 1495
-- Name: dependencia_id_cont_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY dependencia
    ADD CONSTRAINT dependencia_id_cont_fkey FOREIGN KEY (id_cont, id_pais, dpto_codi, muni_codi) REFERENCES municipio(id_cont, id_pais, dpto_codi, muni_codi);


--
-- TOC entry 2331 (class 2606 OID 18161)
-- Dependencies: 1497 2155 1495
-- Name: dependencia_visibilidad_dependencia_observa_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY dependencia_visibilidad
    ADD CONSTRAINT dependencia_visibilidad_dependencia_observa_fkey FOREIGN KEY (dependencia_observa) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2330 (class 2606 OID 18156)
-- Dependencies: 1495 1497 2155
-- Name: dependencia_visibilidad_dependencia_visible_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY dependencia_visibilidad
    ADD CONSTRAINT dependencia_visibilidad_dependencia_visible_fkey FOREIGN KEY (dependencia_visible) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2381 (class 2606 OID 18594)
-- Dependencies: 2155 1519 1495
-- Name: hist_eventos_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY hist_eventos
    ADD CONSTRAINT hist_eventos_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2382 (class 2606 OID 18599)
-- Dependencies: 1519 2231 1516
-- Name: hist_eventos_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY hist_eventos
    ADD CONSTRAINT hist_eventos_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2383 (class 2606 OID 18612)
-- Dependencies: 2155 1495 1520
-- Name: informados_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY informados
    ADD CONSTRAINT informados_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2384 (class 2606 OID 18617)
-- Dependencies: 1520 2231 1516
-- Name: informados_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY informados
    ADD CONSTRAINT informados_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2326 (class 2606 OID 18117)
-- Dependencies: 1494 1493 2150 1494 1494 1493 1493
-- Name: municipio_id_cont_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY municipio
    ADD CONSTRAINT municipio_id_cont_fkey FOREIGN KEY (id_cont, id_pais, dpto_codi) REFERENCES departamento(id_cont, id_pais, dpto_codi);


--
-- TOC entry 2385 (class 2606 OID 18631)
-- Dependencies: 2155 1495 1521
-- Name: prestamo_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY prestamo
    ADD CONSTRAINT prestamo_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2386 (class 2606 OID 18636)
-- Dependencies: 2155 1521 1495
-- Name: prestamo_pres_depe_arch_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY prestamo
    ADD CONSTRAINT prestamo_pres_depe_arch_fkey FOREIGN KEY (pres_depe_arch) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2387 (class 2606 OID 18641)
-- Dependencies: 2231 1521 1516
-- Name: prestamo_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY prestamo
    ADD CONSTRAINT prestamo_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2389 (class 2606 OID 18651)
-- Dependencies: 2168 1521 1498
-- Name: prestamo_usua_login_actu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY prestamo
    ADD CONSTRAINT prestamo_usua_login_actu_fkey FOREIGN KEY (usua_login_actu) REFERENCES usuario(usua_login);


--
-- TOC entry 2388 (class 2606 OID 18646)
-- Dependencies: 2168 1521 1498
-- Name: prestamo_usua_login_pres_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY prestamo
    ADD CONSTRAINT prestamo_usua_login_pres_fkey FOREIGN KEY (usua_login_pres) REFERENCES usuario(usua_login);


--
-- TOC entry 2372 (class 2606 OID 18515)
-- Dependencies: 1983 1516 1428
-- Name: radicado_esta_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_esta_codi_fkey FOREIGN KEY (esta_codi) REFERENCES estado(esta_codi);


--
-- TOC entry 2367 (class 2606 OID 18490)
-- Dependencies: 1494 1516 2153 1494 1516 1494 1494 1516 1516
-- Name: radicado_id_cont_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_id_cont_fkey FOREIGN KEY (id_cont, id_pais, dpto_codi, muni_codi) REFERENCES municipio(id_cont, id_pais, dpto_codi, muni_codi);


--
-- TOC entry 2371 (class 2606 OID 18510)
-- Dependencies: 1987 1516 1429
-- Name: radicado_mrec_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_mrec_codi_fkey FOREIGN KEY (mrec_codi) REFERENCES medio_recepcion(mrec_codi);


--
-- TOC entry 2376 (class 2606 OID 18535)
-- Dependencies: 1516 1430 1990
-- Name: radicado_par_serv_secue_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_par_serv_secue_fkey FOREIGN KEY (par_serv_secue) REFERENCES par_serv_servicios(par_serv_secue);


--
-- TOC entry 2377 (class 2606 OID 18540)
-- Dependencies: 2003 1516 1435
-- Name: radicado_sgd_apli_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_sgd_apli_codi_fkey FOREIGN KEY (sgd_apli_codi) REFERENCES sgd_apli_aplintegra(sgd_apli_codi);


--
-- TOC entry 2375 (class 2606 OID 18530)
-- Dependencies: 1516 1508 2200
-- Name: radicado_sgd_mtd_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_sgd_mtd_codigo_fkey FOREIGN KEY (sgd_mtd_codigo) REFERENCES sgd_mtd_matriz_doc(sgd_mtd_codigo);


--
-- TOC entry 2368 (class 2606 OID 18495)
-- Dependencies: 1443 1516 2027
-- Name: radicado_sgd_not_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_sgd_not_codi_fkey FOREIGN KEY (sgd_not_codi) REFERENCES sgd_not_notificacion(sgd_not_codi);


--
-- TOC entry 2373 (class 2606 OID 18520)
-- Dependencies: 2092 1467 1516
-- Name: radicado_sgd_tdec_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_sgd_tdec_codigo_fkey FOREIGN KEY (sgd_tdec_codigo) REFERENCES sgd_tdec_tipodecision(sgd_tdec_codigo);


--
-- TOC entry 2374 (class 2606 OID 18525)
-- Dependencies: 1515 2222 1516
-- Name: radicado_sgd_tma_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_sgd_tma_codigo_fkey FOREIGN KEY (sgd_tma_codigo) REFERENCES sgd_tma_temas(sgd_tma_codigo);


--
-- TOC entry 2370 (class 2606 OID 18505)
-- Dependencies: 1453 2054 1516
-- Name: radicado_tdid_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_tdid_codi_fkey FOREIGN KEY (tdid_codi) REFERENCES tipo_doc_identificacion(tdid_codi);


--
-- TOC entry 2369 (class 2606 OID 18500)
-- Dependencies: 1454 1516 2057
-- Name: radicado_trte_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY radicado
    ADD CONSTRAINT radicado_trte_codi_fkey FOREIGN KEY (trte_codi) REFERENCES tipo_remitente(trte_codi);


--
-- TOC entry 2390 (class 2606 OID 18661)
-- Dependencies: 2194 1522 1506
-- Name: sgd_acm_acusemsg_sgd_msg_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_acm_acusemsg
    ADD CONSTRAINT sgd_acm_acusemsg_sgd_msg_codi_fkey FOREIGN KEY (sgd_msg_codi) REFERENCES sgd_msg_mensaje(sgd_msg_codi);


--
-- TOC entry 2310 (class 2606 OID 17851)
-- Dependencies: 1435 1455 2003
-- Name: sgd_actadd_actualiadicional_sgd_apli_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_actadd_actualiadicional
    ADD CONSTRAINT sgd_actadd_actualiadicional_sgd_apli_codi_fkey FOREIGN KEY (sgd_apli_codi) REFERENCES sgd_apli_aplintegra(sgd_apli_codi);


--
-- TOC entry 2311 (class 2606 OID 17856)
-- Dependencies: 1441 1455 2021
-- Name: sgd_actadd_actualiadicional_sgd_instorf_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_actadd_actualiadicional
    ADD CONSTRAINT sgd_actadd_actualiadicional_sgd_instorf_codi_fkey FOREIGN KEY (sgd_instorf_codi) REFERENCES sgd_instorf_instanciasorfeo(sgd_instorf_codi);


--
-- TOC entry 2334 (class 2606 OID 18209)
-- Dependencies: 1499 2155 1495
-- Name: sgd_admin_depe_historico_dependencia_modificada_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_admin_depe_historico
    ADD CONSTRAINT sgd_admin_depe_historico_dependencia_modificada_fkey FOREIGN KEY (dependencia_modificada) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2337 (class 2606 OID 18228)
-- Dependencies: 1998 1433 1500
-- Name: sgd_admin_usua_historico_admin_observacion_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_admin_usua_historico
    ADD CONSTRAINT sgd_admin_usua_historico_admin_observacion_codigo_fkey FOREIGN KEY (admin_observacion_codigo) REFERENCES sgd_admin_observacion(codigo_observacion);


--
-- TOC entry 2335 (class 2606 OID 18218)
-- Dependencies: 1495 2155 1500
-- Name: sgd_admin_usua_historico_dependencia_codigo_administrador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_admin_usua_historico
    ADD CONSTRAINT sgd_admin_usua_historico_dependencia_codigo_administrador_fkey FOREIGN KEY (dependencia_codigo_administrador) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2336 (class 2606 OID 18223)
-- Dependencies: 1500 2155 1495
-- Name: sgd_admin_usua_historico_dependencia_codigo_modificado_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_admin_usua_historico
    ADD CONSTRAINT sgd_admin_usua_historico_dependencia_codigo_modificado_fkey FOREIGN KEY (dependencia_codigo_modificado) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2391 (class 2606 OID 18672)
-- Dependencies: 2231 1516 1523
-- Name: sgd_agen_agendados_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_agen_agendados
    ADD CONSTRAINT sgd_agen_agendados_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2392 (class 2606 OID 18681)
-- Dependencies: 1524 2234 1517
-- Name: sgd_anar_anexarg_anex_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_anar_anexarg
    ADD CONSTRAINT sgd_anar_anexarg_anex_codigo_fkey FOREIGN KEY (anex_codigo) REFERENCES anexos(anex_codigo);


--
-- TOC entry 2393 (class 2606 OID 18686)
-- Dependencies: 1524 2006 1436
-- Name: sgd_anar_anexarg_sgd_argd_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_anar_anexarg
    ADD CONSTRAINT sgd_anar_anexarg_sgd_argd_codi_fkey FOREIGN KEY (sgd_argd_codi) REFERENCES sgd_argd_argdoc(sgd_argd_codi);


--
-- TOC entry 2394 (class 2606 OID 18694)
-- Dependencies: 2231 1516 1525
-- Name: sgd_anu_anulados_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_anu_anulados
    ADD CONSTRAINT sgd_anu_anulados_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2395 (class 2606 OID 18699)
-- Dependencies: 1489 1525 2142
-- Name: sgd_anu_anulados_sgd_eanu_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_anu_anulados
    ADD CONSTRAINT sgd_anu_anulados_sgd_eanu_codi_fkey FOREIGN KEY (sgd_eanu_codi) REFERENCES sgd_eanu_estanulacion(sgd_eanu_codi);


--
-- TOC entry 2312 (class 2606 OID 17866)
-- Dependencies: 1435 1456 2003
-- Name: sgd_aplfad_plicfunadi_sgd_apli_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_aplfad_plicfunadi
    ADD CONSTRAINT sgd_aplfad_plicfunadi_sgd_apli_codi_fkey FOREIGN KEY (sgd_apli_codi) REFERENCES sgd_apli_aplintegra(sgd_apli_codi);


--
-- TOC entry 2313 (class 2606 OID 17876)
-- Dependencies: 2003 1457 1435
-- Name: sgd_aplmen_aplimens_sgd_apli_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_aplmen_aplimens
    ADD CONSTRAINT sgd_aplmen_aplimens_sgd_apli_codi_fkey FOREIGN KEY (sgd_apli_codi) REFERENCES sgd_apli_aplintegra(sgd_apli_codi);


--
-- TOC entry 2314 (class 2606 OID 17886)
-- Dependencies: 2003 1435 1458
-- Name: sgd_aplus_plicusua_sgd_apli_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_aplus_plicusua
    ADD CONSTRAINT sgd_aplus_plicusua_sgd_apli_codi_fkey FOREIGN KEY (sgd_apli_codi) REFERENCES sgd_apli_aplintegra(sgd_apli_codi);


--
-- TOC entry 2364 (class 2606 OID 18447)
-- Dependencies: 1509 1513 2203
-- Name: sgd_camexp_campoexpediente_sgd_parexp_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_camexp_campoexpediente
    ADD CONSTRAINT sgd_camexp_campoexpediente_sgd_parexp_codigo_fkey FOREIGN KEY (sgd_parexp_codigo) REFERENCES sgd_parexp_paramexpediente(sgd_parexp_codigo);


--
-- TOC entry 2338 (class 2606 OID 18237)
-- Dependencies: 1501 1495 2155
-- Name: sgd_carp_descripcion_sgd_carp_depecodi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_carp_descripcion
    ADD CONSTRAINT sgd_carp_descripcion_sgd_carp_depecodi_fkey FOREIGN KEY (sgd_carp_depecodi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2339 (class 2606 OID 18242)
-- Dependencies: 1450 2050 1501
-- Name: sgd_carp_descripcion_sgd_carp_tiporad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_carp_descripcion
    ADD CONSTRAINT sgd_carp_descripcion_sgd_carp_tiporad_fkey FOREIGN KEY (sgd_carp_tiporad) REFERENCES sgd_trad_tiporad(sgd_trad_codigo);


--
-- TOC entry 2397 (class 2606 OID 18713)
-- Dependencies: 2231 1516 1526
-- Name: sgd_caux_causales_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_caux_causales
    ADD CONSTRAINT sgd_caux_causales_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2396 (class 2606 OID 18708)
-- Dependencies: 1459 1526 2072
-- Name: sgd_caux_causales_sgd_dcau_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_caux_causales
    ADD CONSTRAINT sgd_caux_causales_sgd_dcau_codigo_fkey FOREIGN KEY (sgd_dcau_codigo) REFERENCES sgd_dcau_causal(sgd_dcau_codigo);


--
-- TOC entry 2398 (class 2606 OID 18718)
-- Dependencies: 2074 1526 1460
-- Name: sgd_caux_causales_sgd_ddca_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_caux_causales
    ADD CONSTRAINT sgd_caux_causales_sgd_ddca_codigo_fkey FOREIGN KEY (sgd_ddca_codigo) REFERENCES sgd_ddca_ddsgrgdo(sgd_ddca_codigo);


--
-- TOC entry 2344 (class 2606 OID 18282)
-- Dependencies: 1503 1494 1494 1503 1503 2153 1494 1494 1503
-- Name: sgd_ciu_ciudadano_id_cont_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_ciu_ciudadano
    ADD CONSTRAINT sgd_ciu_ciudadano_id_cont_fkey FOREIGN KEY (id_cont, id_pais, dpto_codi, muni_codi) REFERENCES municipio(id_cont, id_pais, dpto_codi, muni_codi);


--
-- TOC entry 2345 (class 2606 OID 18287)
-- Dependencies: 2054 1453 1503
-- Name: sgd_ciu_ciudadano_tdid_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_ciu_ciudadano
    ADD CONSTRAINT sgd_ciu_ciudadano_tdid_codi_fkey FOREIGN KEY (tdid_codi) REFERENCES tipo_doc_identificacion(tdid_codi);


--
-- TOC entry 2322 (class 2606 OID 18001)
-- Dependencies: 2106 1472 1473
-- Name: sgd_cob_campobliga_sgd_tidm_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_cob_campobliga
    ADD CONSTRAINT sgd_cob_campobliga_sgd_tidm_codi_fkey FOREIGN KEY (sgd_tidm_codi) REFERENCES sgd_tidm_tidocmasiva(sgd_tidm_codi);


--
-- TOC entry 2315 (class 2606 OID 17896)
-- Dependencies: 1437 2009 1459
-- Name: sgd_dcau_causal_sgd_cau_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dcau_causal
    ADD CONSTRAINT sgd_dcau_causal_sgd_cau_codigo_fkey FOREIGN KEY (sgd_cau_codigo) REFERENCES sgd_cau_causal(sgd_cau_codigo);


--
-- TOC entry 2316 (class 2606 OID 17906)
-- Dependencies: 1430 1990 1460
-- Name: sgd_ddca_ddsgrgdo_par_serv_secue_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_ddca_ddsgrgdo
    ADD CONSTRAINT sgd_ddca_ddsgrgdo_par_serv_secue_fkey FOREIGN KEY (par_serv_secue) REFERENCES par_serv_servicios(par_serv_secue);


--
-- TOC entry 2317 (class 2606 OID 17911)
-- Dependencies: 1460 1459 2072
-- Name: sgd_ddca_ddsgrgdo_sgd_dcau_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_ddca_ddsgrgdo
    ADD CONSTRAINT sgd_ddca_ddsgrgdo_sgd_dcau_codigo_fkey FOREIGN KEY (sgd_dcau_codigo) REFERENCES sgd_dcau_causal(sgd_dcau_codigo);


--
-- TOC entry 2324 (class 2606 OID 18095)
-- Dependencies: 1492 2145 1491
-- Name: sgd_def_paises_id_cont_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_def_paises
    ADD CONSTRAINT sgd_def_paises_id_cont_fkey FOREIGN KEY (id_cont) REFERENCES sgd_def_continentes(id_cont);


--
-- TOC entry 2412 (class 2606 OID 18851)
-- Dependencies: 1494 1533 1494 1533 1533 1533 2153 1494 1494
-- Name: sgd_dir_drecciones_id_cont_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dir_drecciones
    ADD CONSTRAINT sgd_dir_drecciones_id_cont_fkey FOREIGN KEY (id_cont, id_pais, dpto_codi, muni_codi) REFERENCES municipio(id_cont, id_pais, dpto_codi, muni_codi);


--
-- TOC entry 2410 (class 2606 OID 18841)
-- Dependencies: 1516 1533 2231
-- Name: sgd_dir_drecciones_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dir_drecciones
    ADD CONSTRAINT sgd_dir_drecciones_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2409 (class 2606 OID 18836)
-- Dependencies: 2182 1503 1533
-- Name: sgd_dir_drecciones_sgd_ciu_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dir_drecciones
    ADD CONSTRAINT sgd_dir_drecciones_sgd_ciu_codigo_fkey FOREIGN KEY (sgd_ciu_codigo) REFERENCES sgd_ciu_ciudadano(sgd_ciu_codigo);


--
-- TOC entry 2411 (class 2606 OID 18846)
-- Dependencies: 1533 2285 1532
-- Name: sgd_dir_drecciones_sgd_oem_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dir_drecciones
    ADD CONSTRAINT sgd_dir_drecciones_sgd_oem_codigo_fkey FOREIGN KEY (sgd_oem_codigo) REFERENCES sgd_oem_oempresas(sgd_oem_codigo);


--
-- TOC entry 2340 (class 2606 OID 18252)
-- Dependencies: 1967 1502 1425
-- Name: sgd_dnufe_docnufe_anex_tipo_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dnufe_docnufe
    ADD CONSTRAINT sgd_dnufe_docnufe_anex_tipo_codi_fkey FOREIGN KEY (anex_tipo_codi) REFERENCES anexos_tipo(anex_tipo_codi);


--
-- TOC entry 2341 (class 2606 OID 18257)
-- Dependencies: 2083 1464 1502
-- Name: sgd_dnufe_docnufe_sgd_pnufe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dnufe_docnufe
    ADD CONSTRAINT sgd_dnufe_docnufe_sgd_pnufe_codi_fkey FOREIGN KEY (sgd_pnufe_codi) REFERENCES sgd_pnufe_procnumfe(sgd_pnufe_codi);


--
-- TOC entry 2342 (class 2606 OID 18262)
-- Dependencies: 2099 1502 1469
-- Name: sgd_dnufe_docnufe_sgd_tpr_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dnufe_docnufe
    ADD CONSTRAINT sgd_dnufe_docnufe_sgd_tpr_codigo_fkey FOREIGN KEY (sgd_tpr_codigo) REFERENCES sgd_tpr_tpdcumento(sgd_tpr_codigo);


--
-- TOC entry 2343 (class 2606 OID 18267)
-- Dependencies: 1502 2057 1454
-- Name: sgd_dnufe_docnufe_trte_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_dnufe_docnufe
    ADD CONSTRAINT sgd_dnufe_docnufe_trte_codi_fkey FOREIGN KEY (trte_codi) REFERENCES tipo_remitente(trte_codi);


--
-- TOC entry 2323 (class 2606 OID 18071)
-- Dependencies: 1477 1487 2120
-- Name: sgd_enve_envioespecial_sgd_fenv_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_enve_envioespecial
    ADD CONSTRAINT sgd_enve_envioespecial_sgd_fenv_codigo_fkey FOREIGN KEY (sgd_fenv_codigo) REFERENCES sgd_fenv_frmenvio(sgd_fenv_codigo);


--
-- TOC entry 2318 (class 2606 OID 17927)
-- Dependencies: 1435 2003 1463
-- Name: sgd_estinst_estadoinstancia_sgd_apli_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_estinst_estadoinstancia
    ADD CONSTRAINT sgd_estinst_estadoinstancia_sgd_apli_codi_fkey FOREIGN KEY (sgd_apli_codi) REFERENCES sgd_apli_aplintegra(sgd_apli_codi);


--
-- TOC entry 2319 (class 2606 OID 17932)
-- Dependencies: 1463 2021 1441
-- Name: sgd_estinst_estadoinstancia_sgd_instorf_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_estinst_estadoinstancia
    ADD CONSTRAINT sgd_estinst_estadoinstancia_sgd_instorf_codi_fkey FOREIGN KEY (sgd_instorf_codi) REFERENCES sgd_instorf_instanciasorfeo(sgd_instorf_codi);


--
-- TOC entry 2399 (class 2606 OID 18728)
-- Dependencies: 1527 2155 1495
-- Name: sgd_exp_expediente_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_exp_expediente
    ADD CONSTRAINT sgd_exp_expediente_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2400 (class 2606 OID 18733)
-- Dependencies: 1527 2231 1516
-- Name: sgd_exp_expediente_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_exp_expediente
    ADD CONSTRAINT sgd_exp_expediente_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2401 (class 2606 OID 18756)
-- Dependencies: 1528 1510 2206
-- Name: sgd_fars_faristas_sgd_pexp_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_fars_faristas
    ADD CONSTRAINT sgd_fars_faristas_sgd_pexp_codigo_fkey FOREIGN KEY (sgd_pexp_codigo) REFERENCES sgd_pexp_procexpedientes(sgd_pexp_codigo);


--
-- TOC entry 2365 (class 2606 OID 18457)
-- Dependencies: 1510 1514 2206
-- Name: sgd_fexp_flujoexpedientes_sgd_pexp_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_fexp_flujoexpedientes
    ADD CONSTRAINT sgd_fexp_flujoexpedientes_sgd_pexp_codigo_fkey FOREIGN KEY (sgd_pexp_codigo) REFERENCES sgd_pexp_procexpedientes(sgd_pexp_codigo);


--
-- TOC entry 2402 (class 2606 OID 18769)
-- Dependencies: 2231 1529 1516
-- Name: sgd_firrad_firmarads_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_firrad_firmarads
    ADD CONSTRAINT sgd_firrad_firmarads_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2403 (class 2606 OID 18782)
-- Dependencies: 2155 1495 1530
-- Name: sgd_hmtd_hismatdoc_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_hmtd_hismatdoc
    ADD CONSTRAINT sgd_hmtd_hismatdoc_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2404 (class 2606 OID 18787)
-- Dependencies: 2231 1516 1530
-- Name: sgd_hmtd_hismatdoc_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_hmtd_hismatdoc
    ADD CONSTRAINT sgd_hmtd_hismatdoc_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2405 (class 2606 OID 18792)
-- Dependencies: 1530 1508 2200
-- Name: sgd_hmtd_hismatdoc_sgd_mtd_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_hmtd_hismatdoc
    ADD CONSTRAINT sgd_hmtd_hismatdoc_sgd_mtd_codigo_fkey FOREIGN KEY (sgd_mtd_codigo) REFERENCES sgd_mtd_matriz_doc(sgd_mtd_codigo);


--
-- TOC entry 2346 (class 2606 OID 18302)
-- Dependencies: 1504 2155 1495
-- Name: sgd_mat_matriz_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mat_matriz
    ADD CONSTRAINT sgd_mat_matriz_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2347 (class 2606 OID 18307)
-- Dependencies: 1440 1504 2018
-- Name: sgd_mat_matriz_sgd_fun_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mat_matriz
    ADD CONSTRAINT sgd_mat_matriz_sgd_fun_codigo_fkey FOREIGN KEY (sgd_fun_codigo) REFERENCES sgd_fun_funciones(sgd_fun_codigo);


--
-- TOC entry 2348 (class 2606 OID 18312)
-- Dependencies: 1504 1445 2033
-- Name: sgd_mat_matriz_sgd_prc_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mat_matriz
    ADD CONSTRAINT sgd_mat_matriz_sgd_prc_codigo_fkey FOREIGN KEY (sgd_prc_codigo) REFERENCES sgd_prc_proceso(sgd_prc_codigo);


--
-- TOC entry 2349 (class 2606 OID 18317)
-- Dependencies: 1504 1465 2086
-- Name: sgd_mat_matriz_sgd_prd_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mat_matriz
    ADD CONSTRAINT sgd_mat_matriz_sgd_prd_codigo_fkey FOREIGN KEY (sgd_prd_codigo) REFERENCES sgd_prd_prcdmentos(sgd_prd_codigo);


--
-- TOC entry 2350 (class 2606 OID 18328)
-- Dependencies: 2155 1495 1505
-- Name: sgd_mrd_matrird_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mrd_matrird
    ADD CONSTRAINT sgd_mrd_matrird_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2351 (class 2606 OID 18333)
-- Dependencies: 1505 1448 2044
-- Name: sgd_mrd_matrird_sgd_srd_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mrd_matrird
    ADD CONSTRAINT sgd_mrd_matrird_sgd_srd_codigo_fkey FOREIGN KEY (sgd_srd_codigo) REFERENCES sgd_srd_seriesrd(sgd_srd_codigo);


--
-- TOC entry 2352 (class 2606 OID 18338)
-- Dependencies: 1466 1505 1505 2089 1466
-- Name: sgd_mrd_matrird_sgd_srd_codigo_fkey1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mrd_matrird
    ADD CONSTRAINT sgd_mrd_matrird_sgd_srd_codigo_fkey1 FOREIGN KEY (sgd_srd_codigo, sgd_sbrd_codigo) REFERENCES sgd_sbrd_subserierd(sgd_srd_codigo, sgd_sbrd_codigo);


--
-- TOC entry 2353 (class 2606 OID 18343)
-- Dependencies: 1505 2099 1469
-- Name: sgd_mrd_matrird_sgd_tpr_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mrd_matrird
    ADD CONSTRAINT sgd_mrd_matrird_sgd_tpr_codigo_fkey FOREIGN KEY (sgd_tpr_codigo) REFERENCES sgd_tpr_tpdcumento(sgd_tpr_codigo);


--
-- TOC entry 2355 (class 2606 OID 18364)
-- Dependencies: 1507 2155 1495
-- Name: sgd_msdep_msgdep_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_msdep_msgdep
    ADD CONSTRAINT sgd_msdep_msgdep_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2356 (class 2606 OID 18369)
-- Dependencies: 2194 1507 1506
-- Name: sgd_msdep_msgdep_sgd_msg_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_msdep_msgdep
    ADD CONSTRAINT sgd_msdep_msgdep_sgd_msg_codi_fkey FOREIGN KEY (sgd_msg_codi) REFERENCES sgd_msg_mensaje(sgd_msg_codi);


--
-- TOC entry 2354 (class 2606 OID 18354)
-- Dependencies: 2047 1449 1506
-- Name: sgd_msg_mensaje_sgd_tme_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_msg_mensaje
    ADD CONSTRAINT sgd_msg_mensaje_sgd_tme_codi_fkey FOREIGN KEY (sgd_tme_codi) REFERENCES sgd_tme_tipmen(sgd_tme_codi);


--
-- TOC entry 2357 (class 2606 OID 18379)
-- Dependencies: 1508 1504 2187
-- Name: sgd_mtd_matriz_doc_sgd_mat_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mtd_matriz_doc
    ADD CONSTRAINT sgd_mtd_matriz_doc_sgd_mat_codigo_fkey FOREIGN KEY (sgd_mat_codigo) REFERENCES sgd_mat_matriz(sgd_mat_codigo);


--
-- TOC entry 2358 (class 2606 OID 18384)
-- Dependencies: 1508 1469 2099
-- Name: sgd_mtd_matriz_doc_sgd_tpr_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_mtd_matriz_doc
    ADD CONSTRAINT sgd_mtd_matriz_doc_sgd_tpr_codigo_fkey FOREIGN KEY (sgd_tpr_codigo) REFERENCES sgd_tpr_tpdcumento(sgd_tpr_codigo);


--
-- TOC entry 2406 (class 2606 OID 18800)
-- Dependencies: 1531 2231 1516
-- Name: sgd_ntrd_notifrad_radi_nume_radi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_ntrd_notifrad
    ADD CONSTRAINT sgd_ntrd_notifrad_radi_nume_radi_fkey FOREIGN KEY (radi_nume_radi) REFERENCES radicado(radi_nume_radi);


--
-- TOC entry 2407 (class 2606 OID 18814)
-- Dependencies: 1532 1494 1532 2153 1494 1494 1494 1532 1532
-- Name: sgd_oem_oempresas_id_cont_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_oem_oempresas
    ADD CONSTRAINT sgd_oem_oempresas_id_cont_fkey FOREIGN KEY (id_cont, id_pais, dpto_codi, muni_codi) REFERENCES municipio(id_cont, id_pais, dpto_codi, muni_codi);


--
-- TOC entry 2408 (class 2606 OID 18819)
-- Dependencies: 2054 1453 1532
-- Name: sgd_oem_oempresas_tdid_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_oem_oempresas
    ADD CONSTRAINT sgd_oem_oempresas_tdid_codi_fkey FOREIGN KEY (tdid_codi) REFERENCES tipo_doc_identificacion(tdid_codi);


--
-- TOC entry 2359 (class 2606 OID 18394)
-- Dependencies: 1509 2155 1495
-- Name: sgd_parexp_paramexpediente_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_parexp_paramexpediente
    ADD CONSTRAINT sgd_parexp_paramexpediente_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2360 (class 2606 OID 18407)
-- Dependencies: 1466 2089 1466 1510 1510
-- Name: sgd_pexp_procexpedientes_sgd_srd_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_pexp_procexpedientes
    ADD CONSTRAINT sgd_pexp_procexpedientes_sgd_srd_codigo_fkey FOREIGN KEY (sgd_srd_codigo, sgd_sbrd_codigo) REFERENCES sgd_sbrd_subserierd(sgd_srd_codigo, sgd_sbrd_codigo);


--
-- TOC entry 2413 (class 2606 OID 18869)
-- Dependencies: 2155 1534 1495
-- Name: sgd_pnun_procenum_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_pnun_procenum
    ADD CONSTRAINT sgd_pnun_procenum_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2414 (class 2606 OID 18874)
-- Dependencies: 1534 2083 1464
-- Name: sgd_pnun_procenum_sgd_pnufe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_pnun_procenum
    ADD CONSTRAINT sgd_pnun_procenum_sgd_pnufe_codi_fkey FOREIGN KEY (sgd_pnufe_codi) REFERENCES sgd_pnufe_procnumfe(sgd_pnufe_codi);


--
-- TOC entry 2361 (class 2606 OID 18415)
-- Dependencies: 1495 2155 1511
-- Name: sgd_rdf_retdocf_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_rdf_retdocf
    ADD CONSTRAINT sgd_rdf_retdocf_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2362 (class 2606 OID 18420)
-- Dependencies: 2191 1505 1511
-- Name: sgd_rdf_retdocf_sgd_mrd_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_rdf_retdocf
    ADD CONSTRAINT sgd_rdf_retdocf_sgd_mrd_codigo_fkey FOREIGN KEY (sgd_mrd_codigo) REFERENCES sgd_mrd_matrird(sgd_mrd_codigo);


--
-- TOC entry 2415 (class 2606 OID 18894)
-- Dependencies: 1495 2155 1535
-- Name: sgd_renv_regenvio_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_renv_regenvio
    ADD CONSTRAINT sgd_renv_regenvio_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2416 (class 2606 OID 18899)
-- Dependencies: 1535 1462 2077
-- Name: sgd_renv_regenvio_sgd_deve_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_renv_regenvio
    ADD CONSTRAINT sgd_renv_regenvio_sgd_deve_codigo_fkey FOREIGN KEY (sgd_deve_codigo) REFERENCES sgd_deve_dev_envio(sgd_deve_codigo);


--
-- TOC entry 2417 (class 2606 OID 18904)
-- Dependencies: 1533 2297 1535
-- Name: sgd_renv_regenvio_sgd_dir_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_renv_regenvio
    ADD CONSTRAINT sgd_renv_regenvio_sgd_dir_codigo_fkey FOREIGN KEY (sgd_dir_codigo) REFERENCES sgd_dir_drecciones(sgd_dir_codigo);


--
-- TOC entry 2320 (class 2606 OID 17955)
-- Dependencies: 2044 1466 1448
-- Name: sgd_sbrd_subserierd_sgd_srd_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_sbrd_subserierd
    ADD CONSTRAINT sgd_sbrd_subserierd_sgd_srd_codigo_fkey FOREIGN KEY (sgd_srd_codigo) REFERENCES sgd_srd_seriesrd(sgd_srd_codigo);

ALTER TABLE ONLY sgd_sbrd_subserierd
    ADD CONSTRAINT fkey_sgd_sbrd_soporte FOREIGN KEY (sgd_sbrd_soporte) REFERENCES sgd_msa_medsoparchivo(sgd_msa_codigo);

--
-- TOC entry 2363 (class 2606 OID 18433)
-- Dependencies: 2206 1512 1510
-- Name: sgd_sexp_secexpedientes_sgd_pexp_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_sexp_secexpedientes
    ADD CONSTRAINT sgd_sexp_secexpedientes_sgd_pexp_codigo_fkey FOREIGN KEY (sgd_pexp_codigo) REFERENCES sgd_pexp_procexpedientes(sgd_pexp_codigo);


--
-- TOC entry 2321 (class 2606 OID 17965)
-- Dependencies: 1467 2003 1435
-- Name: sgd_tdec_tipodecision_sgd_apli_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_tdec_tipodecision
    ADD CONSTRAINT sgd_tdec_tipodecision_sgd_apli_codi_fkey FOREIGN KEY (sgd_apli_codi) REFERENCES sgd_apli_aplintegra(sgd_apli_codi);


--
-- TOC entry 2366 (class 2606 OID 18467)
-- Dependencies: 2033 1515 1445
-- Name: sgd_tma_temas_sgd_prc_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_tma_temas
    ADD CONSTRAINT sgd_tma_temas_sgd_prc_codigo_fkey FOREIGN KEY (sgd_prc_codigo) REFERENCES sgd_prc_proceso(sgd_prc_codigo);


--
-- TOC entry 2418 (class 2606 OID 18918)
-- Dependencies: 1495 1536 2155
-- Name: sgd_tmd_temadepe_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_tmd_temadepe
    ADD CONSTRAINT sgd_tmd_temadepe_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2419 (class 2606 OID 18923)
-- Dependencies: 1515 2222 1536
-- Name: sgd_tmd_temadepe_sgd_tma_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY sgd_tmd_temadepe
    ADD CONSTRAINT sgd_tmd_temadepe_sgd_tma_codigo_fkey FOREIGN KEY (sgd_tma_codigo) REFERENCES sgd_tma_temas(sgd_tma_codigo);


--
-- TOC entry 2332 (class 2606 OID 18192)
-- Dependencies: 1498 1495 2155
-- Name: usuario_depe_codi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_depe_codi_fkey FOREIGN KEY (depe_codi) REFERENCES dependencia(depe_codi);


--
-- TOC entry 2333 (class 2606 OID 18197)
-- Dependencies: 1470 1498 2102
-- Name: usuario_sgd_aper_codigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_sgd_aper_codigo_fkey FOREIGN KEY (sgd_aper_codigo) REFERENCES sgd_aper_adminperfiles(sgd_aper_codigo);


ALTER TABLE ONLY sgd_eit_items
    ADD CONSTRAINT sgd_eit_codigo_padre_fkey FOREIGN KEY (sgd_eit_cod_padre) REFERENCES sgd_eit_items(sgd_eit_codigo);

--SEGURIDAD
ALTER TABLE ONLY sgd_matriz_nivelrad
    ADD CONSTRAINT radi_nume_radi FOREIGN KEY (radi_nume_radi) REFERENCES radicado (radi_nume_radi);
ALTER TABLE ONLY sgd_matriz_nivelrad
    ADD CONSTRAINT usua_login FOREIGN KEY (usua_login)  REFERENCES usuario (usua_login);

CREATE INDEX fki_radi_nume_radi  ON sgd_matriz_nivelrad	  USING btree (radi_nume_radi);

CREATE INDEX fki_usua_login  ON sgd_matriz_nivelrad USING btree  (usua_login);

ALTER TABLE radicado
    ADD CONSTRAINT radicado_tipodocumental FOREIGN KEY (tdoc_codi) REFERENCES sgd_tpr_tpdcumento (sgd_tpr_codigo);


------------------------
--  ref constarinst for table SGD_CARPETA_EXPEDIENTE
-----------------------

ALTER TABLE "sgd_carpeta_expediente" ADD CONSTRAINT "ID_CARPETA_PK" PRIMARY KEY ("sgd_carpeta_id");

------------------------
--  ref constarinst for table SGD_EXP_RADCARPETA
-----------------------

ALTER TABLE "sgd_exp_radcarpeta" ADD CONSTRAINT "FK_carpeta_id" FOREIGN KEY ("sgd_carpeta_id")
   REFERENCES "sgd_carpeta_expediente" ("sgd_carpeta_id");

ALTER TABLE "sgd_exp_radcarpeta" ADD  CONSTRAINT "FK_radi_nume_radi" FOREIGN KEY ("radi_nume_radi")
  REFERENCES "radicado" ("radi_nume_radi");

ALTER TABLE "sgd_carpeta_expediente" ADD CONSTRAINT "FK_sgd_exp_numero" FOREIGN KEY ("sgd_exp_numero")
	  REFERENCES "sgd_sexp_secexpedientes" ("sgd_exp_numero");

ALTER TABLE "sgd_matriz_nivelexp" ADD CONSTRAINT expediente_exp_codigo FOREIGN KEY (sgd_exp_numero)
      REFERENCES sgd_sexp_secexpedientes (sgd_exp_numero);

ALTER TABLE "sgd_matriz_nivelexp" ADD CONSTRAINT usuario_usua_login FOREIGN KEY (usua_login)
      REFERENCES usuario (usua_login);


------------------------
--  ref constarinst for table PRESTAMO
-----------------------

ALTER TABLE "prestamo" ADD CONSTRAINT "FK_prest_exp" FOREIGN KEY ("sgd_exp_numero")
   REFERENCES "sgd_sexp_secexpedientes" ("sgd_exp_numero");

ALTER TABLE "prestamo" ADD CONSTRAINT "FK_prest_carpexp" FOREIGN KEY ("sgd_carpeta_id")
   REFERENCES "sgd_carpeta_expediente" ("sgd_carpeta_id");

----------------*********************

ALTER TABLE "sgd_mmr_matrimetaexpe" ADD constraint "fk_mmr_expediente" foreign key ("sgd_exp_numero")
   REFERENCES "sgd_sexp_secexpedientes" ("sgd_exp_numero");
ALTER TABLE "sgd_mmr_matrimetaexpe" ADD constraint "fk_mmr_metadato" foreign key ("sgd_mtd_codigo")
   REFERENCES "sgd_mtd_metadatos" ("sgd_mtd_codigo");
ALTER TABLE "sgd_mmr_matrimetaradi" ADD constraint "fk_mmr_metadato" foreign key ("sgd_mtd_codigo")
   REFERENCES "sgd_mtd_metadatos" ("sgd_mtd_codigo");
ALTER TABLE "sgd_mmr_matrimetaradi" ADD constraint "fk_mmr_radicado" foreign key ("radi_nume_radi")
   REFERENCES "radicado" ("radi_nume_radi");
ALTER TABLE "sgd_mtd_metadatos" ADD constraint "fk_mts_sbrd" foreign key ("sgd_srd_codigo", "sgd_sbrd_codigo")
   REFERENCES "sgd_sbrd_subserierd" ("sgd_srd_codigo", "sgd_sbrd_codigo");
ALTER TABLE "sgd_mtd_metadatos" ADD constraint "fk_mts_tdoc" foreign key ("sgd_tpr_codigo")
   REFERENCES "sgd_tpr_tpdcumento" ("sgd_tpr_codigo");

----------------*********************
--Funciones hechas en plpgsql para el calculo de fechas de dias habiles.
--dia_sig_an es implementada por la funcion sumadiashabiles para conocer el proximo dia habil
CREATE OR REPLACE FUNCTION dia_sig_ant(IN fechaini date, IN proxant character varying, OUT nuevodia date)
  RETURNS date AS
$BODY$
DECLARE
    diaSemana integer;
    BEGIN
        diaSemana =  cast(to_char(CAST(fechaIni AS DATE),'d') AS integer);
        IF (proxAnt = 'Anterior') then
            IF (diaSemana = 1) then
                 nuevoDia := fechaIni - cast('3 days' AS interval);
            ELSE
                 nuevoDia := fechaIni - cast('1 days' AS interval);
            end IF;

        ELSE IF (proxAnt = 'Proximo') then
            IF (diaSemana = 6) then
                 nuevoDia := fechaIni + cast('3 days' AS interval);
            ELSE IF (diaSemana = 7) THEN
            nuevoDia := fechaIni + cast('2 days' AS interval);
         ELSE 
            nuevoDia := fechaIni + cast('1 days' AS interval);
         END IF;
            end IF;

        ELSE
             nuevoDia := fechaIni;
        end IF;
        end IF;
        RETURN;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE;
--sumadiashabiles: funcion que retorna la proxima fecha segun la cantidad de dias habiles contando los festivos 

CREATE OR REPLACE FUNCTION sumadiashabiles(IN fecinicio date, IN numdias integer, OUT fechafin date)
  RETURNS date AS
$BODY$
DECLARE
    contador integer;
    diaSemana integer;
BEGIN
    IF (NumDias>0) THEN
        contador:=1;
        fechaFin:=FecInicio;
        WHILE (contador <= NumDias) LOOP
            fechaFin := dia_sig_ant(fechaFin,'Proximo');
            fechaFin := cast((fechaFin+ cast((SELECT count(*) FROM sgd_noh_nohabiles WHERE noh_fecha=fechaFin)||'days' AS interval)) AS date);
        fechaFin := cast((fechaFin+ cast((SELECT count(*) FROM sgd_noh_nohabiles WHERE noh_fecha=fechaFin)||'days' AS interval)) AS date);
        diaSemana =  to_char(fechaFin,'d');
        IF (diaSemana = 7) then
            fechaFin := fechaFin + cast('2 days' AS interval);
        ELSE IF(diaSemana = 1)THEN
            fechaFin := fechaFin + cast('1 days' AS interval);
            end IF;
        end IF;
        contador := contador+1;
        END LOOP;
    ELSE
        contador:=ABS(NumDias);
        fechaFin:=FecInicio;
        WHILE (contador>0 )LOOP
            fechaFin := dia_sig_ant(fechaFin,'Anterior');
            contador:=contador-1;
        END LOOP;
    END IF;
    fechaFin := cast((fechaFin+ cast((SELECT count(*) FROM sgd_noh_nohabiles WHERE noh_fecha= fechaFin)||' days' AS interval)) AS date);
    diaSemana =  to_char(fechaFin,'d');
    IF (diaSemana = 7) then
            fechaFin := fechaFin + cast('2 days' AS interval);
    ELSE IF(diaSemana = 1)THEN
        fechaFin := fechaFin + cast('1 days' AS interval);
     end IF;
    end IF;
    RETURN;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE;

--diasHabiles: funcion que retona el numero de dias hailes(teniendo en cuenta los festivos) faltantes o transcurridos entre dos fechas
--
CREATE OR REPLACE FUNCTION diashabiles(IN fecinicio date, IN fecfin date, OUT dias integer)
  RETURNS integer AS
$BODY$
DECLARE
    fechaAnterior date;
BEGIN
    dias:=0;
    fechaAnterior:=fecinicio;
    if(fechaAnterior<=fecfin) then
	    fechaAnterior := dia_sig_ant(fechaAnterior,'Proximo' );
	    WHILE (fechaAnterior<= fecfin) LOOP
		    fechaAnterior := dia_sig_ant(fechaAnterior,'Proximo' );
		    dias := dias-1;
	    END LOOP;
	    dias:=dias+(select count(*) from sgd_noh_nohabiles where noh_fecha between fecInicio and fecFin);
    else
	fechaAnterior:=fecinicio;
	WHILE (fechaAnterior > fecfin) LOOP
		    fechaAnterior := dia_sig_ant(fechaAnterior,'Anterior' );
		    dias := dias+1;
	END LOOP;
	dias:=dias-(select count(*) from sgd_noh_nohabiles where noh_fecha between fecInicio and fecFin);
    end if;
    RETURN;
END;
$BODY$
  LANGUAGE 'plpgsql' VOLATILE
