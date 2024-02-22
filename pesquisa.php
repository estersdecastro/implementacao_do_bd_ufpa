<?php
    error_reporting(E_ERROR | E_PARSE);

    // Inclua o arquivo de configuração
    require 'config.php';

    $lnk = new PDO(
        "{$dbData->driver}:host={$dbData->host};port={$dbData->port};dbname={$dbData->dbname}",
        $dbData->user,
        $dbData->password
    );

    $sql = 'SELECT * FROM "PEA" ORDER BY titulo ASC';
    $titulo = $_GET
      ['titulo'];

    if(!is_null($titulo) && !empty($titulo)) 
        $sql = "SELECT * FROM \"PEA\" WHERE titulo LIKE '".$titulo."' ORDER BY titulo ASC";

    $qry = $lnk->query($sql);
    $count = $qry->rowCount();
    $qry->execute();
    $data = $qry->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<h1 style="
    text-align: center;
    height: 7;
    margin-top: 150;
    margin-bottom:70;
"> Consulta de PEA </h1>

<form method="get" >
    <div class="col-lg-3">
        <div class="form-group">
            <label for="titulo">Título: </label>
            <input class="form-control" id="titulo" placeholder="Título do PEA" name="titulo" value="<?= $titulo ?? "" ?>">
        </div>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top: 24;">Buscar</button>
</form>

<?php
    if(!is_null($titulo) && !empty($titulo)) {
        if($count > 0) {
            echo 'Encontrado registros com o título ' . $titulo;
        } else {
            echo 'Nenhum registro foi encontrado com o título ' . $titulo;
        }
    }
?>

<table class="table table-striped">
    <thead>
      <th>Título</th>
      <th>Formato</th>
      <th>Tipo</th>
      <th >Local</th>
      <th>Uso</th>
      <th>Fonte Original</th>
      <th>CID PCD</th>
      <th>Comentário</th>
    </thead>

    <tbody>
      <?php foreach($data as $row): ?>
        <tr>
            <td><?php echo $row['titulo']; ?></td>
            <td><?php echo $row['formato']; ?></td>
            <td><?php echo $row['tipo']; ?></td>
            <td>
              <a href="<?php echo $row['local']; ?>" target="_blank">
                Baixar
              </a>
            </td>
            </td>
            <td><?php echo $row['uso']; ?></td>
            <td><?php echo $row['fonte_original']; ?></td>
            <td><?php echo $row['cid_pcd']; ?></td>
            <td><?php echo $row['comentario']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
</table>

<p><a href="dashboard.php">Voltar</a></p>
<p><a href="index.php">Sair</a></p>
<?php include 'footer.php'; ?>
