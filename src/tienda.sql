DROP TABLE IF EXISTS articulos CASCADE;

CREATE TABLE articulos  (
    id          bigserial     PRIMARY KEY,
    codigo      varchar(13)   NOT NULL UNIQUE,
    descripcion varchar(255)  NOT NULL,
    precio      numeric(7, 2) NOT NULL
);

-- Carga inicial de datos de prueba;

INSERT INTO articulos (codigo, descripcion, precio)
    VALUES ('101', 'Yogur piña', 200.50),
           ('202', 'Tigreton', 50.10),
           ('303', 'Disco duro SSD 500 GB', 150.30);