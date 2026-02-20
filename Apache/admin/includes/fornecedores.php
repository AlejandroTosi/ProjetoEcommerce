<select name="fornecedor_id" required>
    <option value="">Selecione</option>

    <?php foreach($fornecedores as $f): ?>
        <option value="<?= $f['id'] ?>">
            <?= htmlspecialchars($f['razaoSocial']) ?>
        </option>
    <?php endforeach; ?>

</select>
