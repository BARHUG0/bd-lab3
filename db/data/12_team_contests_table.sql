INSERT INTO team_contests (team_id, contest_id)
SELECT
  -- team_id aleatorio entre 1 y 100
  (floor(random() * 100) + 1)::int AS team_id,
  -- contest_id aleatorio entre 1 y 100
  (floor(random() * 100) + 1)::int AS contest_id
FROM generate_series(1,100);
