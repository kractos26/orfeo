--------------------------------------------------------
-- Archivo creado  - martes-enero-12-2016   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Function SUMADIASHABILES
--------------------------------------------------------

  CREATE OR REPLACE FUNCTION "SUMADIASHABILES" (fecinicio in date, numdias in integer)
  RETURN date AS
    contador integer;
    diaSemana varchar2(10);
    fechafin date;
    diasNH number;
BEGIN
    IF (numdias = 0 or numdias is null) then
        fechafin:=fecinicio;
    ELSE
          IF (NumDias>0) THEN
              contador:=1;
              fechaFin:=FecInicio;
              WHILE (contador <= NumDias) LOOP
                  fechaFin := dia_sig_ant(fechaFin,'Proximo' );
                  contador := contador+1;
              END LOOP;
        
          ELSE
              contador:=ABS(NumDias);
              fechaFin:=to_char(FecInicio,'YYYY/mm/dd');
              WHILE (contador>0 )LOOP
                  fechaFin := dia_sig_ant(fechaFin,'Anterior');
                  contador:=contador-1;
              END LOOP;
          END IF;
          select count(*) into diasNH from sgd_noh_nohabiles where noh_fecha between fecinicio and fechaFin;
          fechaFin := fechaFin+ diasNH;
          diaSemana :=  to_char(fechaFin,'DY');
          IF (diaSemana = 'SAT' or diaSemana = 'SUN' or diaSemana = 'SÁB' or diaSemana = 'DOM') then
                  fechaFin := fechaFin + 2;
          end if;
    END IF;
    RETURN fechafin;
END sumadiashabiles;

----------------------------------------------------------
--diashabiles():Funcion que recibe como parametros fecha inicial y fecha final
--y retorna dias habiles que han transcurrido entre dichas fechas teniendo en cuenta los festivos.
----------------------------------------------------------

/
