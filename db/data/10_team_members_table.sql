INSERT INTO team_members (user_id, team_id, team_role_id)
SELECT
  -- Elegir un usuario aleatorio entre 1 y 100
  (floor(random()*100) + 1)::int AS user_id,
  -- Elegir un equipo aleatorio entre 1 y 100
  (floor(random()*100) + 1)::int AS team_id,
  -- Elegir un rol de equipo aleatorio entre 1 y 140
  (floor(random()*130) + 1)::int AS team_role_id
FROM generate_series(1,200);
