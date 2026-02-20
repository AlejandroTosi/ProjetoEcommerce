<select name="categoria_id" required>
    <option value="">Selecione</option>

    <?php foreach($categoria as $f): ?>
        <option value="<?= $f['id'] ?>">
            <?= htmlspecialchars($f['tipo']) ?>
        </option>
    <?php endforeach; ?>

</select>
