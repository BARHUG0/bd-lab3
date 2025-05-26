INSERT INTO "user" (
  title_id,
  us_tshirt_size_id,
  home_country_id,
  residenc_country_id,
  institution_id,
  passport_country,
  first_name,
  last_name,
  local_name,
  badge_name,
  certificate_name,
  sex,
  date_of_birth,
  home_town,
  home_state,
  job_title,
  company,
  special_needs,
  secondary_email,
  inform_other_contestants,
  include_email,
  open_to_employment_opportunities,
  area_of_study,
  degree_persued,
  start_of_bachelor_degree,
  expected_graduation_date,
  total_sememesters_completed,
  phone,
  mobile,
  home_airport_code,
  emergency_phone,
  emergency_contact_name,
  street,
  street_line_2,
  street_line_3,
  city,
  state,
  postal_code,
  profile_picture_url,
  resume_url,
  twitter_username,
  twitter_hashtag,
  facebook_page,
  top_coder,
  code_forces,
  linkedin,
  social_info
)
SELECT
  -- Foreign keys
  (floor(random() * 110) + 1)::int,
  (floor(random() * 11)  + 1)::int,
  (floor(random() * 180) + 1)::int,
  (floor(random() * 180) + 1)::int,
  (floor(random() * 150) + 1)::int,
  (floor(random() * 180) + 1)::int,

  -- Names
  first_names[(floor(random()*10)+1)],
  last_names[(floor(random()*10)+1)],

  -- Derived name fields
  ( first_names[(floor(random()*10)+1)] || ' ' || last_names[(floor(random()*10)+1)] ),
  -- badge: initials + index
  ( substring(first_names[(floor(random()*10)+1)] from 1 for 1) ||
    substring(last_names[(floor(random()*10)+1)] from 1 for 1) || gs::text ),
  upper( first_names[(floor(random()*10)+1)] || ' ' || last_names[(floor(random()*10)+1)] ),

  -- Sex
  CASE WHEN random()<0.5 THEN 'M' ELSE 'F' END,

  -- Birthdate between 1970-01-01 and 2005-12-31
  date '1970-01-01' + (floor(random()*13000)) * interval '1 day',

  -- Location
  home_towns[(floor(random()*10)+1)],
  home_states[(floor(random()*10)+1)],

  -- Job and company
  job_titles[(floor(random()*10)+1)],
  companies[(floor(random()*10)+1)],

  -- Special needs (10% chance of 'None', otherwise NULL)
  CASE WHEN random()<0.1 THEN 'None' ELSE NULL END,

  -- Secondary email
  lower(first_names[(floor(random()*10)+1)] || '.' ||
        last_names[(floor(random()*10)+1)] || '@example.com'),

  -- Booleans
  (random() < 0.5),
  (random() < 0.5),
  (random() < 0.5),

  -- Academic
  areas[(floor(random()*10)+1)],
  degrees[(floor(random()*10)+1)],

  -- Bachelor dates: start between 2015 and 2021
  (date_trunc('year', current_date) - (floor(random()*7)+1) * interval '1 year')::date,
  -- Expected +4 years
  ((date_trunc('year', current_date) - (floor(random()*7)+1) * interval '1 year') + interval '4 years')::date,

  -- Semesters completed 1–12
  (floor(random()*12)+1)::int,

  -- Phones
  lpad((floor(random()*9000000)+1000000)::text,7,'0'),
  lpad((floor(random()*9000000000)+1000000000)::bigint::text,10,'0'),

  -- Airport code (4 hex chars)
  substr(md5(gs::text),1,4),

  -- Emergency phone
  lpad((floor(random()*9000000)+1000000)::text,7,'0'),

  -- Emergency contact
  first_names[(floor(random()*10)+1)] || ' ' || last_names[(floor(random()*10)+1)],

  -- Address
  (floor(random()*9999)+1)::text || ' ' ||
    street_names[(floor(random()*10)+1)] || ' St.',
  'Apt ' || (floor(random()*500)+1)::text,
  CASE WHEN random()<0.5 THEN 'Block ' || (floor(random()*20)+1)::text ELSE NULL END,

  -- City/State/Postcode
  home_towns[(floor(random()*10)+1)],
  home_states[(floor(random()*10)+1)],
  lpad((floor(random()*90000)+10000)::text,5,'0'),

  -- URLs
  'https://pics.example.com/' || gs::text || '.jpg',
  'https://resumes.example.com/' || gs::text || '.pdf',

  -- Social handles
  '@' || lower(first_names[(floor(random()*10)+1)] || last_names[(floor(random()*10)+1)]),
  '# ' || upper(substring(first_names[(floor(random()*10)+1)] from 1 for 1) ||
               last_names[(floor(random()*10)+1)]),
  'facebook.com/' || lower(first_names[(floor(random()*10)+1)] || '.' ||
                           last_names[(floor(random()*10)+1)]),

  -- Coding profiles
  'topcoder_' || gs::text,
  'https://codeforces.com/profile/' || lower(first_names[(floor(random()*10)+1)]),
  'linkedin.com/in/' || lower(first_names[(floor(random()*10)+1)] ||
                              last_names[(floor(random()*10)+1)]),

  -- Freeform info
  'Generated record #' || gs::text

FROM generate_series(1,100) AS gs
  CROSS JOIN LATERAL (
    VALUES
      (ARRAY['Alice','Bruno','Carla','Diego','Esteban','Fernanda','Gabriel','Helena','Ignacio','Julia']),
      (ARRAY['Lopez','Martinez','Gonzalez','Perez','Rodriguez','Diaz','Vega','Sanchez','Ramirez','Torres']),
      (ARRAY['Guatemala City','Antigua','Quetzaltenango','Chiquimula','Escuintla','Peten','Huehuetenango','Coban','Mazatenango','Jalapa']),
      (ARRAY['Guatemala','Sacatepequez','Quetzaltenango','Chiquimula','Escuintla','Peten','Huehuetenango','Alta Verapaz','Suchitepequez','Jalapa']),
      (ARRAY['Engineer','Designer','Manager','Analyst','Developer','Consultant','Director','Coordinator','Specialist','Administrator']),
      (ARRAY['Acme Corp','Globex','Initech','Stark Industries','Wayne Enterprises','Widget Co','Umbrella Corp','Cyberdyne','Hooli','Soylent Corp']),
      (ARRAY['Main','Oak','Pine','Maple','Cedar','Elm','View','Lake','Hill','River']),
      (ARRAY['Computer Science','Electrical Engineering','Business Administration','Mechanical Engineering','Psychology','Economics','Biology','Chemistry','Physics','Mathematics']),
      (ARRAY['BSc','BA','BEng','MBA','PhD','MSc','BBA','BS','BCom','BTech'])
  ) AS arr(
    first_names,
    last_names,
    home_towns,
    home_states,
    job_titles,
    companies,
    street_names,
    areas,
    degrees
  );
