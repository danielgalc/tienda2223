DROP TABLE IF EXISTS articulos CASCADE;

CREATE TABLE articulos  (
    id          bigserial     PRIMARY KEY,
    codigo      varchar(13)   NOT NULL UNIQUE,
    descripcion varchar(255)  NOT NULL,
    precio      numeric(7, 2) NOT NULL
);

-- Carga inicial de datos de prueba;

INSERT INTO articulos (codigo, descripcion, precio)
    VALUES ('1238123710318', 'Yogur piña', 200.50),
           ('9482934923894', 'Tigreton', 50.10),
           ('8346197462349', 'Disco duro SSD 500 GB', 150.30);