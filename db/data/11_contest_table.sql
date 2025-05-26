INSERT INTO contest (name, start_date, end_date, registration_start_date, registration_end_date)
WITH base AS (
  SELECT
    gs.i,
    -- Fecha de inicio de registro aleatoria entre 2020-01-01 y +2000 días (~2025)
    (date '2020-01-01' + (floor(random()*2000)::int) * interval '1 day')::date AS reg_start,
    -- Duración del periodo de registro: 1–30 días
    (floor(random()*30)::int + 1)             AS reg_span,
    -- Tiempo entre fin de registro y comienzo del concurso: 1–30 días
    (floor(random()*30)::int + 1)             AS pre_start_span,
    -- Duración del concurso: 1–5 días
    (floor(random()*5)::int  + 1)             AS contest_duration
  FROM generate_series(1,100) AS gs(i)
)
SELECT
  -- Nombre único
  'Contest ' || i                                    AS name,
  -- Fecha de inicio = reg_start + reg_span + pre_start_span
  (reg_start + (reg_span + pre_start_span) * interval '1 day')::date   AS start_date,
  -- Fecha de fin = start_date + contest_duration
  (reg_start + (reg_span + pre_start_span + contest_duration) * interval '1 day')::date AS end_date,
  -- Inicio y fin del registro
  reg_start                                          AS registration_start_date,
  (reg_start + reg_span * interval '1 day')::date    AS registration_end_date
FROM base;
