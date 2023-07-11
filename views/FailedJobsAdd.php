<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$FailedJobsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var ffailed_jobsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    ffailed_jobsadd = currentForm = new ew.Form("ffailed_jobsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "failed_jobs")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.failed_jobs)
        ew.vars.tables.failed_jobs = currentTable;
    ffailed_jobsadd.addFields([
        ["uuid", [fields.uuid.visible && fields.uuid.required ? ew.Validators.required(fields.uuid.caption) : null], fields.uuid.isInvalid],
        ["connection", [fields.connection.visible && fields.connection.required ? ew.Validators.required(fields.connection.caption) : null], fields.connection.isInvalid],
        ["queue", [fields.queue.visible && fields.queue.required ? ew.Validators.required(fields.queue.caption) : null], fields.queue.isInvalid],
        ["payload", [fields.payload.visible && fields.payload.required ? ew.Validators.required(fields.payload.caption) : null], fields.payload.isInvalid],
        ["exception", [fields.exception.visible && fields.exception.required ? ew.Validators.required(fields.exception.caption) : null], fields.exception.isInvalid],
        ["failed_at", [fields.failed_at.visible && fields.failed_at.required ? ew.Validators.required(fields.failed_at.caption) : null, ew.Validators.datetime(0)], fields.failed_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ffailed_jobsadd,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    ffailed_jobsadd.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    ffailed_jobsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffailed_jobsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ffailed_jobsadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffailed_jobsadd" id="ffailed_jobsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="failed_jobs">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->uuid->Visible) { // uuid ?>
    <div id="r_uuid" class="form-group row">
        <label id="elh_failed_jobs_uuid" for="x_uuid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uuid->caption() ?><?= $Page->uuid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->uuid->cellAttributes() ?>>
<span id="el_failed_jobs_uuid">
<input type="<?= $Page->uuid->getInputTextType() ?>" data-table="failed_jobs" data-field="x_uuid" name="x_uuid" id="x_uuid" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->uuid->getPlaceHolder()) ?>" value="<?= $Page->uuid->EditValue ?>"<?= $Page->uuid->editAttributes() ?> aria-describedby="x_uuid_help">
<?= $Page->uuid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uuid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->connection->Visible) { // connection ?>
    <div id="r_connection" class="form-group row">
        <label id="elh_failed_jobs_connection" for="x_connection" class="<?= $Page->LeftColumnClass ?>"><?= $Page->connection->caption() ?><?= $Page->connection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->connection->cellAttributes() ?>>
<span id="el_failed_jobs_connection">
<textarea data-table="failed_jobs" data-field="x_connection" name="x_connection" id="x_connection" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->connection->getPlaceHolder()) ?>"<?= $Page->connection->editAttributes() ?> aria-describedby="x_connection_help"><?= $Page->connection->EditValue ?></textarea>
<?= $Page->connection->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->connection->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->queue->Visible) { // queue ?>
    <div id="r_queue" class="form-group row">
        <label id="elh_failed_jobs_queue" for="x_queue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->queue->caption() ?><?= $Page->queue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->queue->cellAttributes() ?>>
<span id="el_failed_jobs_queue">
<textarea data-table="failed_jobs" data-field="x_queue" name="x_queue" id="x_queue" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->queue->getPlaceHolder()) ?>"<?= $Page->queue->editAttributes() ?> aria-describedby="x_queue_help"><?= $Page->queue->EditValue ?></textarea>
<?= $Page->queue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->queue->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->payload->Visible) { // payload ?>
    <div id="r_payload" class="form-group row">
        <label id="elh_failed_jobs_payload" for="x_payload" class="<?= $Page->LeftColumnClass ?>"><?= $Page->payload->caption() ?><?= $Page->payload->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->payload->cellAttributes() ?>>
<span id="el_failed_jobs_payload">
<textarea data-table="failed_jobs" data-field="x_payload" name="x_payload" id="x_payload" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->payload->getPlaceHolder()) ?>"<?= $Page->payload->editAttributes() ?> aria-describedby="x_payload_help"><?= $Page->payload->EditValue ?></textarea>
<?= $Page->payload->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->payload->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->exception->Visible) { // exception ?>
    <div id="r_exception" class="form-group row">
        <label id="elh_failed_jobs_exception" for="x_exception" class="<?= $Page->LeftColumnClass ?>"><?= $Page->exception->caption() ?><?= $Page->exception->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->exception->cellAttributes() ?>>
<span id="el_failed_jobs_exception">
<textarea data-table="failed_jobs" data-field="x_exception" name="x_exception" id="x_exception" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->exception->getPlaceHolder()) ?>"<?= $Page->exception->editAttributes() ?> aria-describedby="x_exception_help"><?= $Page->exception->EditValue ?></textarea>
<?= $Page->exception->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->exception->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->failed_at->Visible) { // failed_at ?>
    <div id="r_failed_at" class="form-group row">
        <label id="elh_failed_jobs_failed_at" for="x_failed_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->failed_at->caption() ?><?= $Page->failed_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->failed_at->cellAttributes() ?>>
<span id="el_failed_jobs_failed_at">
<input type="<?= $Page->failed_at->getInputTextType() ?>" data-table="failed_jobs" data-field="x_failed_at" name="x_failed_at" id="x_failed_at" placeholder="<?= HtmlEncode($Page->failed_at->getPlaceHolder()) ?>" value="<?= $Page->failed_at->EditValue ?>"<?= $Page->failed_at->editAttributes() ?> aria-describedby="x_failed_at_help">
<?= $Page->failed_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->failed_at->getErrorMessage() ?></div>
<?php if (!$Page->failed_at->ReadOnly && !$Page->failed_at->Disabled && !isset($Page->failed_at->EditAttrs["readonly"]) && !isset($Page->failed_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffailed_jobsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("ffailed_jobsadd", "x_failed_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("failed_jobs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
