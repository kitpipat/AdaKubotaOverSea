<style>
    #odvInforSettingconfig , #odvInforAutonumber{
        padding-bottom  : 0px;
        padding-top: 0px;
    }

    #odvSettingConfig{
        margin-bottom : 0px !important;
    }
</style>

<div id="odvSettingConfig" class="panel panel-headline">
	<div class="panel-body" style="padding-top:20px !important;">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="tab-content">
					<div id="odvInforSettingconfig" class="tab-pane in active" role="tabpanel" aria-expanded="true"></div>
					<div id="odvInforAutonumber"  class="tab-pane" role="tabpanel" aria-expanded="true"></div>
                    <div id="odvSCFApiCentent"  class="tab-pane" role="tabpanel" aria-expanded="true"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    $("document").ready(function () {
        //Load view : config
        JSvSettingDairyCurrencyLoadViewSearch();
    });
</script>