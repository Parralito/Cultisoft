/* Generar Deudas entre fechas */
SELECT  YEAR(fechas), FLOOR(count(*) / 30) from (
select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) fechas from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where fechas between '2015-07-03' and CURDATE()) as a
group by YEAR(fechas);





CREATE DEFINER=`kbsg`@`%` PROCEDURE `sp_SaveCobroMensual`(IN `datos` JSON)
BEGIN
	DECLARE fechaUltimoPago DATE;
	DECLARE cantMes int;
	
		
	set cantMes = CAST(JSON_UNQUOTE(JSON_EXTRACT(datos, "$.cantMes" )) as SIGNED);
	
	set fechaUltimoPago = CAST(JSON_UNQUOTE(JSON_EXTRACT(datos,"$.fechaUltimoPago")) as DATE);
	set fechaUltimoPago = DATE_ADD( fechaUltimoPago,INTERVAL cantMes MONTH);
	
	INSERT INTO cobromensual(fecha, fechamensualidad, estado, tipo, idguias, idfpago, observacion) 
	VALUES(NOW(), fechaUltimoPago, 'ACT', 'P', JSON_UNQUOTE(JSON_EXTRACT(datos,"$.idguias")), JSON_UNQUOTE(JSON_EXTRACT(datos,"$.idfpago")),JSON_UNQUOTE(JSON_EXTRACT(datos,"$.observacion")));
	

END


/* Cadena JSON */
(select  cast(
			concat('{',
				group_concat(substring(val, 2, length(val) - 2)),
			'}') as json)  allProperties
		from (
		select json_object(`parametro`.`descripcion`,`parametro`.`valor`) AS `val` from `parametro` where (`parametro`.`abr` in ('EM','ME')) 
union (select json_object(`tarifario`.`descripcion`,`tarifario`.`valor`) AS `val` from `tarifario` where (`tarifario`.`abr` in ('AL','MO','CO')))
		) dd
		where val != JSON_OBJECT())


