DO
$$
BEGIN
   IF NOT EXISTS (
     SELECT FROM pg_database WHERE datname = 'crud'
   ) THEN
      CREATE DATABASE crud;
   END IF;
END
$$;
