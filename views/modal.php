<div class="modal fade" id="modal<?= $data->getId(); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Signaler un commentaire</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="modal-form" action="index.php?action=chapter&id=<?= $getId ?>&report=<?= $data->getId(); ?>" method="post">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Raison :</label>
                        <textarea class="form-control" name="message_report" id="message-text" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="submit_report">Signaler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>