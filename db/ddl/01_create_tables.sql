-- --------------------------------------------------
-- 1. Lookup tables
-- --------------------------------------------------
CREATE TABLE title (
  id SERIAL PRIMARY KEY,
  name VARCHAR(16) UNIQUE NOT NULL
);

CREATE TABLE us_tshirt_size (
  id SERIAL PRIMARY KEY,
  name VARCHAR(8) UNIQUE NOT NULL
);

CREATE TABLE country (
  id SERIAL PRIMARY KEY,
  name VARCHAR(128) UNIQUE NOT NULL
);

CREATE TABLE institution (
  id SERIAL PRIMARY KEY,
  name VARCHAR(128) UNIQUE NOT NULL
);

CREATE TABLE status (
  id SERIAL PRIMARY KEY,
  name VARCHAR(16) UNIQUE NOT NULL
);

CREATE TABLE team_role (
  id   SERIAL PRIMARY KEY,
  name VARCHAR(255) UNIQUE NOT NULL
);

-- --------------------------------------------------
-- 2. Core entities
-- --------------------------------------------------
CREATE TABLE "user" (
  id                         SERIAL PRIMARY KEY,
  title_id                   INTEGER NOT NULL
    REFERENCES title(id),
  us_tshirt_size_id          INTEGER
    REFERENCES us_tshirt_size(id),
  home_country_id            INTEGER
    REFERENCES country(id),
  residenc_country_id        INTEGER
    REFERENCES country(id),
  institution_id             INTEGER
    REFERENCES institution(id),
  passport_country           INTEGER
    REFERENCES country(id),
  first_name                 VARCHAR(128) NOT NULL,
  last_name                  VARCHAR(128) NOT NULL,
  local_name                 VARCHAR(128),
  badge_name                 VARCHAR(128),
  certificate_name           VARCHAR(128),
  sex                        CHAR(1),
  date_of_birth              DATE,
  home_town                  VARCHAR(128),
  home_state                 VARCHAR(128),
  job_title                  VARCHAR(64),
  company                    VARCHAR(64),
  special_needs              TEXT,
  secondary_email            VARCHAR(255),
  inform_other_contestants   BOOLEAN,
  include_email              BOOLEAN,
  open_to_employment_opportunities BOOLEAN,
  area_of_study              VARCHAR(128),
  degree_persued             VARCHAR(128),
  start_of_bachelor_degree   DATE,
  expected_graduation_date   DATE,
  total_sememesters_completed INTEGER,
  phone                      VARCHAR(15),
  mobile                     VARCHAR(15),
  home_airport_code          VARCHAR(4),
  emergency_phone            VARCHAR(15),
  emergency_contact_name     VARCHAR(128),
  street                     VARCHAR(255),
  street_line_2              VARCHAR(255),
  street_line_3              VARCHAR(255),
  city                       VARCHAR(128),
  state                      VARCHAR(128),
  postal_code                VARCHAR(8),
  profile_picture_url        TEXT,
  resume_url                 TEXT,
  twitter_username           VARCHAR(255),
  twitter_hashtag            VARCHAR(32),
  facebook_page              VARCHAR(255),
  top_coder                  VARCHAR(255),
  code_forces                VARCHAR(255),
  linkedin                   VARCHAR(255),
  social_info                TEXT
);

CREATE TABLE team (
  id             SERIAL PRIMARY KEY,
  status_id      INTEGER
    REFERENCES status(id),
  institution_id INTEGER
    REFERENCES institution(id),
  name           VARCHAR(255) NOT NULL,
  has_issues     BOOLEAN
);

CREATE TABLE team_members (
  id           SERIAL PRIMARY KEY,
  user_id      INTEGER NOT NULL
    REFERENCES "user"(id),
  team_id      INTEGER NOT NULL
    REFERENCES team(id),
  team_role_id INTEGER NOT NULL
    REFERENCES team_role(id)
);

CREATE TABLE contest (
  id                       SERIAL PRIMARY KEY,
  name                     VARCHAR(255) NOT NULL,
  start_date               DATE NOT NULL,
  end_date                 DATE NOT NULL,
  registration_start_date  DATE NOT NULL,
  registration_end_date    DATE NOT NULL
);

CREATE TABLE team_contests (
  id         SERIAL PRIMARY KEY,
  team_id    INTEGER NOT NULL
    REFERENCES team(id),
  contest_id INTEGER NOT NULL
    REFERENCES contest(id)
);
