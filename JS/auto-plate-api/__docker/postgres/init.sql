
CREATE TABLE IF NOT EXISTS public.plates (
    id SERIAL primary key not null,
    plate varchar(10) not null,
    plate_clean varchar(10) not null,
    timestamp timestamp not null
);

ALTER TABLE public.plates OWNER TO postgres;

CREATE EXTENSION fuzzystrmatch;
