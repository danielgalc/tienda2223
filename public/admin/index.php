<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Listado de artículos</title>
</head>

<body>
    <?php
    require '../../src/admin-auxiliar.php';
    require '../../src/auxiliar.php';

    $codigo = $_GET['codigo'];
    /* $descripcion = $_GET['descripcion']; */

    ?>

    <div>
        <form action="" method="get">
            <fieldset>
                <p>
                    <label class="block mb-2 text-sm font-bold text-gray-900 dark:text-gray-300">
                        Código:
                        <input type="text"  name="codigo"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-25   p-2.5 
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </label>
                </p>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 
                mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Buscar</button>
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
    <div class="overflow-x-auto relative">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="py-3 px-6">Código</th>
                <th scope="col" class="py-3 px-6">Descripción</th>
                <th scope="col" class="py-3 px-6">Precio</th>
                <th scope="col" class="py-3 px-6">Acciones</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6"><?= $fila['codigo'] ?></td>
                        <td class="py-4 px-6"><?= mb_substr($fila['descripcion'], 0, 30) ?></td>
                        <td class="py-4 px-6"><?= $nf->format($fila['precio']) ?></td>
                        <td class="py-4 px-6"><a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    </div>
    <script src="/js/flowbite.js"></script>
</body>

</html>