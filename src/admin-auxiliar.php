<?php

function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=tienda', 'tienda', 'tienda');
}