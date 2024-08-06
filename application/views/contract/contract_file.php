<div class="row">
    <div class="col-md-4">
            <?
                $file = 'assets/documents/' . $contract_details['document'];
                if(is_file(DOCUMENT_ROOT . $file) and !is_dir(DOCUMENT_ROOT . $file)) {
                    ?>
                    <a href="<? print WEB_ROOT;?>assets/documents/<? echo $contract_details['document']; ?>" class="text-black fs-6" download>
                        <span class="mdi mdi-file-download-outline"></span>&nbsp;<? echo $contract_details['document']; ?>
                    </a>
                    <?
                }
                else {
                    ?>
                    <div class="alert alert-danger mb-0" role="alert">
                        <span class="mdi mdi-paperclip"></span>&nbsp;No Document found.
                    </div>
                    <?
                }
            ?>
    </div>
    <div class="col-md-4">
        <form class="mb-0" id="contract_document" method="POST" enctype="multipart/form-data">
            <input type="file" name="document" id="contract_file" onchange="updateDocument('contract_document')" value="<? echo $contract_details['document']; ?>" class="d-none" />
            <input type="hidden" name="id" value="<? echo $contract_details['id']; ?>">
            <button type="button" class="btn btn-outline-success btn-sm" onclick="$('#contract_file').click();"><i class="mdi mdi-file-upload-outline" aria-hidden="true"></i>&nbsp;Change</button>
            <div class="text-danger"><small>.pdf, .doc, .docx files are allowed.</small></div>
        </form>
    </div>
    <div class="col-sm-4">
        <? if(isset($msg)) {?>
                <div class="alert alert-success"><? echo $msg;?></div>
          <?} elseif (isset($error_msg)) {?>
                <div class="alert alert-warning"><? echo $error_msg; ?></div><? }?>
    </div>
</div>