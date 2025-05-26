INSERT INTO team (status_id, institution_id, name, has_issues)
SELECT
  --Asignar un status aleatorio entre 1 y 56 (cantidad de statuses)
  (floor(random()*56) + 1)::int AS status_id,
  --Asignar una institución aleatoria entre 1 y 150
  (floor(random()*150) + 1)::int AS institution_id,
  --Generar un nombre de equipo combinando adjetivo, sustantivo y el índice
  arr.adj[(floor(random()*10)+1)] || ' ' ||
  arr.noun[(floor(random()*10)+1)] || ' Team ' || gs.i AS name,
  --10% de equipos con issues (TRUE), 90% sin issues (FALSE)
  (random() < 0.1) AS has_issues
FROM generate_series(1,100) AS gs(i)
CROSS JOIN LATERAL (
  VALUES (
    ARRAY['Red','Blue','Golden','Mighty','Flying','Thunder','Iron','Silver','Black','Crimson'],
    ARRAY['Eagles','Tigers','Wolves','Dragons','Sharks','Panthers','Hawks','Warriors','Knights','Falcons']
  )
) AS arr(adj, noun);
