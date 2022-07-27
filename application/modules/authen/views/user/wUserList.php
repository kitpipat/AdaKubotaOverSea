<div class="panel panel-headline">
    <div class="panel-heading">
        <div id="ostSearchUser">
            <div class="row">
                <div class="col-xs-4 col-md-4">
                    <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                        <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tSearchNew') ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
                            <span class="input-group-btn">
                                <button id="oimSearchUser" class="btn xCNBtnGenCode" type="button">
                                    <img class="xCNIconAddOn" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if($aAlwEventUser['tAutStaFull'] == 1 || $aAlwEventUser['tAutStaDelete'] == 1 ) : ?>
                    <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">

                        <?php if($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1)){ ?>
                            <button type="button" id="odvEventImportFileUSR" class="btn xCNBTNImportFile"><?= language('common/main/main','tImport')?></button>
                        <?php } ?>

                        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                <?php echo language('common/main/main', 'tCMNOption') ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li id="oliBtnDeleteAll" class="disabled">
                                    <a data-toggle="modal" data-target="#odvModalDelUser"><?php echo language('common/main/main', 'tDelAll') ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="ostDataUser"></section>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<script>
    $('#oimSearchUser').click(function(){
            JCNxOpenLoading();
            JSvUserDataTable();
    });

    $('#oetSearchAll').keypress(function(event){
        if(event.keyCode == 13){
            JCNxOpenLoading();
            JSvUserDataTable();
        }
    });

    //supawat 13/07/2020
	//กดนำเข้า จะวิ่งไป Modal popup ที่ center
	$('#odvEventImportFileUSR').click(function() {
		var tNameModule = 'User';
		var tTypeModule = 'master';
		var tAfterRoute = 'userPageImportDataTable';

		var aPackdata = {
			'tNameModule' : tNameModule,
			'tTypeModule' : tTypeModule,
			'tAfterRoute' : tAfterRoute
		};
		JSxImportPopUp(aPackdata);
	});
</script>