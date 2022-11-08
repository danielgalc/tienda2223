<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de artículos</title>
</head>

<body>
    <?php
    require 'auxiliar.php';

    $codigo = $_GET['codigo'];
    /* $descripcion = $_GET['descripcion']; */

    ?>

    <div>
        <form action="" method="get">
            <fieldset>
                <legend>Criterios de búsqueda</legend>
                <p>
                    <label>
                        Código:
                        <input type="text" name="codigo">
                    </label>
                </p>
                <button type="submit">Buscar</button>
            </fieldset>
        </form>
    </div>


    <?php
    $pdo = conectar();
    $pdo->beginTransaction();
    $pdo->exec('LOCK TABLE articulos IN SHARE MODE');
    $where = [];
    $execute = [];
    if (isset($codigo) && $codigo != '') {
        $where[] = 'lower(codigo) LIKE lower(:codigo)';
        $execute[':codigo'] = "%$codigo%";
    }
    $where = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
    $sent = $pdo->prepare("SELECT COUNT(*) FROM articulos $where");
    $sent->execute($execute);
    $total = $sent->fetchColumn();
    $sent = $pdo->prepare("SELECT * FROM articulos $where ORDER BY codigo");
    $sent->execute($execute);
    $pdo->commit();
    $nf = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
    ?>

    <div>
        <table style="margin: auto" border="1">
            <thead>
                <th>Código</th>
                <th>Descripción</th>
                <th>Precio</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila) : ?>
                    <tr>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= mb_substr($fila['descripcion'], 0, 30) ?></td>
                        <td><?= $nf->format($fila['precio']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>

</html>