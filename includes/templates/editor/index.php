<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Meta Editor :: <?= $user->user_login ?></title>
    <link rel="stylesheet" href="<?= ME_ANJAN_SUME_URL?>/assets/lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ME_ANJAN_SUME_URL?>/assets/css/meta-editor.css">
    <link rel="stylesheet" href="<?= ME_ANJAN_SUME_URL?>/assets/lib/bootstrap/css/bootstrap-theme.min.css">
    <script>
        var ajaxUrlUpdateMeta = '<?= admin_url('admin-ajax.php?action=me_anjan_sume_update_user_meta')?>';
        var ajaxUrlDeleteMeta = '<?= admin_url('admin-ajax.php?action=me_anjan_sume_delete_user_meta')?>';
        var ajaxUrlAddMeta = '<?= admin_url('admin-ajax.php?action=me_anjan_sume_add_user_meta')?>';
    </script>
</head>
<body>

    <div id="top-bar-fixed">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <span class="user-login pull-left">
                        Meta data:
                        <strong><?= $user->user_login?></strong>
                    </span>

                     <a id="link-go-back" class="btn btn-sm btn-info pull-right" href="<?= $returnUrl?>" title="Shift + B">
                         <span class="glyphicon glyphicon-chevron-left"></span> <span class="u">B</span>ack
                     </a>

                    <a id="link-add-meta" class="btn btn-sm btn-success pull-right" href="#" style="margin-right: 10px;" data-toggle="modal" data-target="#new-meta-modal" title="Shift + A">
                        <span class="glyphicon glyphicon-plus"></span> <span class="u">A</span>dd
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php
            $metaList = sume_user_meta::get_user_meta_data(array(
                'user_id' => $user->ID
            ));
        ?>

        <div class="row">
            <div class="col-xs-12">

                <?php if (is_array($metaList) && !empty($metaList)): ?>
                <ul class="list-group" id="sume-meta-list">
                    <?php foreach ( $metaList as $md ): ?>
                        <li class="list-group-item" id="meta-block-<?= $md['umeta_id']?>">
                            <label for="meta-value-<?= $md['umeta_id']?>" class="meta-key-label"><?= $md['meta_key']?></label>

                            <textarea id="meta-value-<?= $md['umeta_id']?>" class="form-control typeable" rows="2" data-id="<?= $md['umeta_id']?>" data-key="<?= htmlentities($md['meta_key'])?>"><?= $md['meta_value']?></textarea>

                            <input type="button" id="btn-update-<?= $md['umeta_id']?>" class="btn btn-sm btn-success btn-update-meta" value="Update" data-id="<?= $md['umeta_id']?>" />

                            <input type="button" id="btn-delete-<?= $md['umeta_id']?>" class="btn btn-sm btn-danger btn-delete-meta" value="Delete" data-id="<?= $md['umeta_id']?>" data-key="<?= htmlentities($md['meta_key'])?>" />

                            <span class="ajax-msg txt-info" style="display: none;">Please wait ...</span>
                        </li>


                    <?php endforeach; ?>
                </ul>

                <?php else: ?>
                    <p class="text-danger">No meta data available!</p>
                <?php endif; ?>

            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="new-meta-modal" tabindex="-1" role="dialog" aria-labelledby="new-meta-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="new-meta-form" method="post" class="form-horizontal">
                    <input type="hidden" name="user_id" value="<?= $user->ID?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add new meta</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="new-meta-key" class="col-xs-12">Key</label>
                            <div class="col-xs-12">
                                <input type="text" name="meta_key" id="new-meta-key" value="" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new-meta-value" class="col-xs-12">Value</label>
                            <div class="col-xs-12">
                                <textarea type="text" name="meta_value" id="new-meta-value" class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">

                        <span class="ajax-msg" style="display:none;"></span>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Meta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php wp_print_scripts('jquery')?>
    <script src="<?= ME_ANJAN_SUME_URL?>/assets/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= ME_ANJAN_SUME_URL?>/assets/js/meta-editor.js"></script>
</body>
</html>