<?php
//Debug::dump($data);
?>
<div class="d-flex flex-row flex-wrap">
    <div>
        <form>
            <div class="form-group row">
                <label  class="col-sm-4 col-form-label text-primary">miesiąc</label>
                <div class="col-sm-8">
                    <input type="text" readonly class="form-control-plaintext" value="<?php echo $data->date ?>">
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-4 col-form-label text-primary">dostępny budżet na ten miesiąc</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="budget" placeholder="wprowadź kwotę" value="<?php echo $data->budget ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-4 col-form-label text-primary">budżet z ostatniego miesiąca</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control-plaintext"  value="0" readonly="true">
                </div>
            </div>

            <div class="form-group row">
                <label  class="col-sm-4 col-form-label text-danger">poniesione koszta</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control-plaintext" value="<?php echo $data->monthCosts ?>" readonly="true">
                </div>
            </div>

            <div class="form-group row">
                <label  class="col-sm-4 col-form-label text-primary">aktualny stan budżetu</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control-plaintext" value="<?php echo $data->actualBudget ?>" readonly="true">
                </div>
            </div>

            <div class="d-flex flex-column align-items-center justify-content-center">
                <h3 class="mb-5">dodaj nowy koszt</h3>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-primary">Opis kosztu</span>
                    </div>
                    <textarea class="form-control" id ="cost-description" aria-label="With textarea"><?php
                        echo (!empty($data->editCost) ? $data->editCost['description']
                                : '' )
                        ?></textarea>
                </div>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-primary" id="basic-addon3">Wartość</span>
                    </div>
                    <input type="text" class="form-control" id="cost-value" aria-describedby="basic-addon3" value="<?php
                    echo (!empty($data->editCost) ? $data->editCost['cost'] : '' )
                    ?>">
                    <input type="hidden" class="form-control" id="cost_id" value="<?php
                    echo (!empty($data->editCost) ? $data->editCost['id'] : '' )
                    ?>">
                    <input type="hidden" class="form-control" id="id" value="<?php echo $data->month ?>">
                    <input type="hidden" class="form-control" id="date" value="<?php echo $data->date ?>">
                </div>

            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-primary save-month-btn mr-3">zaktualizuj</button>
                <button type="button" class="btn btn-success back-btn">wróć</button>
            </div>
        </form>
    </div>
    <div>
        <?php if (!empty($data->costModel)): ?>
            <table class="table table-dark mt-5">
                <thead>
                    <tr>
                        <th scope="col">Pozycja</th>
                        <th scope="col">Opis kosztu</th>
                        <th scope="col">Wartość(w zł)</th>
                        <th scope="col">******************</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($data->costModel as $costKey => $costValue) {
                        $count ++;
                        ?>
                        <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $costValue['description'] ?></td>
                            <td><?php echo $costValue['cost'] ?></td>
                            <td>
                                <div class="d-flex flex-row">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-btn mr-3" data-cost-id="<?php echo $costValue['id'] ?>">usuń</button>
                                    <button type="button" class="btn btn-outline-warning btn-sm edit-btn" data-cost-id="<?php echo $costValue['id'] ?>">edytuj</button>
                                </div>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php else: ?>
            <h3> brak kosztów w tym miesiącu</h3>
        <?php endif; ?>
    </div>
</div>