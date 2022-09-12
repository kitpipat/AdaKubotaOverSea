<style>
    .xCNIconContentAPI {
        width: 15px;
        height: 15px;
        background-color: #e84393;
        display: inline-block;
        margin-right: 10px;
        margin-top: 0px;
    }

    .xCNIconContentDOC {
        width: 15px;
        height: 15px;
        background-color: #ffca28;
        display: inline-block;
        margin-right: 10px;
        margin-top: 0px;
    }

    .xCNIconContentPOS {
        width: 15px;
        height: 15px;
        background-color: #42a5f5;
        display: inline-block;
        margin-right: 10px;
        margin-top: 0px;
    }

    .xCNIconContentSL {
        width: 15px;
        height: 15px;
        background-color: #ff9030;
        display: inline-block;
        margin-right: 10px;
        margin-top: 0px;
    }

    .xCNIconContentWEB {
        width: 15px;
        height: 15px;
        background-color: #99cc33;
        display: inline-block;
        margin-right: 10px;
        margin-top: 0px;
    }

    .xCNIconContentVD {
        width: 15px;
        height: 15px;
        background-color: #dbc559;
        display: inline-block;
        margin-right: 10px;
        margin-top: 0px;
    }

    .xCNIconContentALL {
        width: 15px;
        height: 15px;
        background-color: #ff5733;
        display: inline-block;
        margin-right: 10px;
        margin-top: 0px;
    }

    .xCNIconContentETC {
        width: 15px;
        height: 15px;
        background-color: #92918c;
        display: inline-block;
        margin-right: 10px;
        margin-top: 0px;
    }

    /* .xCNTableScrollY{
        overflow-y      : auto; 
    } */

    .xCNCheckboxBlockDefault:before {
        background: #ededed !important;
    }

    .xCNInputBlock {
        background: #ededed !important;
        pointer-events: none;
    }

    #ospDetailFooter {
        font-weight: bold;
    }
</style>
<?php
$nDecimalCurrentcySave = FCNxHGetOptionDecimalCurrencySave();
$nDecimalCurrentcyShow = FCNxHGetOptionDecimalCurrencyShow();
?>

<!-- TABLE สำหรับ checkbox -->
<input type="text" class='xCNHide' value="<?php echo $nDecimalCurrentcyShow ?>" id="oetDecimal">

<div class="row">
    <div class="col-md-12">
    <div style='text-align: right;'>
    <?php 
    if(!empty($dJobDate)){
     echo language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyuLastSummit');   
     echo substr($dJobDate,0,-4);
    }
    ?>
    <!-- <?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyuLastSummit') ?>
    <?= substr($dJobDate,0,-4); ?> -->
    </div>
        <!-- <div class="table-responsive xCNTableScrollY xCNTableHeightCheckbox">  ของ เดิม -->
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%" id="otbTableForCheckbox">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold" style=" width:160px;"><?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyuAgency') ?></th>
                        <th class="xCNTextBold" style=" width:160px;"><?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyCode') ?></th>
                        <th class="xCNTextBold" style=""><?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyName') ?></th>
                        <th class="xCNTextBold" style="display:none;"><?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyRate') ?></th>
                        <th class="xCNTextBold" style="display:none; width:180px;">
                            <?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyRateLast') ?>
                            <?php
                            if(!empty($ApiTime)){
                                echo '<br>('.substr($ApiTime,0,-4).')';
                            }
                            ?>
                            
                        </th>
                        <th class="xCNTextBold" style="width:200px;">
                            <?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingCalDailyCurrencyuSERateLast') ?>
                            <?php
                            if(!empty($ApiTime)){
                                echo '<br>('.substr($ApiTime,0,-4).')';
                            }
                            ?>
                        </th>
                        <th class="xCNTextBold" style="width:160px;">
                            <!-- <label class="fancy-checkbox" style = 'color: #232C3D !important;'> -->
                                <input type="checkbox" class="ocmCENCheckUseLast" id="ocmCENCheckUseLast">
                                <span class="ospListItem">
                                </span>
                                <?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyuSERateLast') ?>

                            <!-- </label> -->

                        </th>
                        <th class="xCNTextBold" style="width:160px;"><?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyConfirm') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($aListRate['rtCode'] == 1) : ?>
                        <?php foreach ($aListRate['raItems'] as $key => $aValue) {
                            // print_r($aValue['FTRteCode']); 
                        ?>
                            <tr class="text-center xCNTextDetail2">
                                <td style="text-align:left;"><?php echo ($aValue['FTAgnName'] == '') ? '-' : $aValue['FTAgnName']; ?></td>
                                <td style="text-align:left;"><?php echo $aValue['FTRteCode'] ?></td>
                                <td style="text-align:left;"><?php echo ($aValue['FTRteName'] == '') ? '-' : $aValue['FTRteName']; ?></td>

                                <?php 
                                    if( $aValue['FCRteRate'] == $aValue['FCRteLastRate']){
                                        $tColor = 'color : green !important;';
                                    }else{
                                        $tColor = 'color : red !important;';
                                    }
                                ?>
                                
                                <td style="display:none; text-align:right; <?php echo $tColor ?>" ><?php echo number_format($aValue['FCRteRate'],$nDecimalCurrentcyShow) ?></td>
                                <td style="display:none; text-align:right; <?php echo $tColor ?>"><?php echo number_format($aValue['FCRteLastRate'],$nDecimalCurrentcyShow) ?></td>
                                <?php if($aValue['FCRteLastRate'] > 0) {?>
                                    <td style="text-align:right;<?php echo $tColor ?>" id='oetCalCurrency'><?php echo number_format((1/$aValue['FCRteLastRate']),$nDecimalCurrentcyShow) ?></td>
                                <?php }else{ ?>
                                    <td style="text-align:right;<?php echo $tColor ?>" id='oetCalCurrency'><?php echo number_format(($aValue['FCRteRate']),$nDecimalCurrentcyShow) ?></td>
                                <?php }?>


                                <td>
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbListItem_<?= $key ?>" class='ocbListItem' data-seq='<?= $key ?>' data-rterate='<?= $aValue['FCRteRate'] ?>' data-rtelastrate='<?= $aValue['FCRteLastRate'] ?>' onclick="JSxEventClickCheckboxCurrentcy(this);"><span></span>
                                    </label>
                                </td>


                                <td>
                                    <input type="text" style="text-align:right;<?php echo $tColor ?>" autocomplete="off" class="oetCurrentCurentcy xCNInputNumericWithDecimal" data-seq='<?= $key ?>' data-agncode='<?= $aValue['FTAgnCode'] ?>' data-rtecode='<?= $aValue['FTRteCode'] ?>' data-oldval='<?php echo number_format(1/$aValue['FCRteRate'],$nDecimalCurrentcyShow) ?>' id='oetUseCurrency<?= $key ?>' value='<?= ($aValue['FCRteRate'] > 0) ? number_format(1/$aValue['FCRteRate'],$nDecimalCurrentcyShow) : number_format('0',$nDecimalCurrentcyShow);?>'>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='8'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($FTAgnCode != '' && $dJobDate != '') { ?>
    
<?php } ?>

<div class="row" style="margin-top:10px;" id="odvContentFooterText">
    <div class="col-md-12">
        <span id="ospDetailFooter"><?= language('settingconfig/settingconfig/settingconfig', 'tDetail') ?> : </span><span id="ospDetailFooterText"></span>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<script>
    $('#odvContentFooterText').hide();
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date()
    });

    // Browse ปฎิทิน
    function JSxClickPopUpcalendar(ptID, elemID) {
        $('#oetDate' + ptID + elemID).datepicker('show');
    }

    // Browse คลัง(กำหนดเอง)
    var nLangEdits = <?= $this->session->userdata("tLangEdit") ?>;
    var oBrowseMakeWah = {
        Title: ['company/warehouse/warehouse', 'tWAHTitle'],
        Table: {
            Master: 'TCNMWaHouse',
            PK: 'FTWahCode'
        },
        Join: {
            Table: ['TCNMWaHouse_L'],
            On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
        },
        GrideView: {
            ColumnPathLang: 'company/warehouse/warehouse',
            ColumnKeyLang: ['tWahCode', 'tWahName'],
            DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            ColumnsSize: ['15%', '75%'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TCNMWaHouse.FTWahCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetMakeBrowseID", "TCNMWaHouse.FTWahCode"],
            Text: ["oetMakeBrowseName", "TCNMWaHouse_L.FTWahCode"],
        }
    }

    var oBrowseConfigMake = function(poParameters) {
        var tInputReturnCode = poParameters.tReturnInputCode;
        var tInputReturnName = poParameters.tReturnInputName;
        var tConfigName = poParameters.tConfigName;
        var nLangEdits = <?= $this->session->userdata("tLangEdit") ?>;
        var tWhereCondition = "";

        switch (tConfigName) {
            case 'tPS_Warehouse':
                var oOptionReturn = {
                    Title: ['company/warehouse/warehouse', 'tWAHTitle'],
                    Table: {
                        Master: 'TCNMWaHouse',
                        PK: 'FTWahCode'
                    },
                    Join: {
                        Table: ['TCNMWaHouse_L'],
                        On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
                    },
                    GrideView: {
                        ColumnPathLang: 'company/warehouse/warehouse',
                        ColumnKeyLang: ['tWahCode', 'tWahName'],
                        DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                        ColumnsSize: ['15%', '75%'],
                        DataColumnsFormat: ['', ''],
                        WidthModal: 50,
                        Perpage: 10,
                        OrderBy: ['TCNMWaHouse.FTWahCode'],
                        SourceOrder: "ASC"
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMWaHouse.FTWahCode"],
                        Text: [tInputReturnName, "TCNMWaHouse_L.FTWahName"],
                    }
                }
                break;
            case 'tPS_Channel':
                var tAgnCode = $('#oetAgnCode').val();
                if (typeof(tAgnCode) != 'undefined' || tAgnCode !== undefined) {
                    tWhereCondition += " AND (TCNMChannelSpc.FTAgnCode = '" + tAgnCode + "' OR TCNMChannelSpc.FTChnCode IS NULL) "
                }
                var oOptionReturn = {
                    Title: ['company/warehouse/warehouse', 'tWAHTitle'],
                    Table: {
                        Master: 'TCNMChannel',
                        PK: 'FTChnCode'
                    },
                    Join: {
                        Table: ['TCNMChannel_L', 'TCNMChannelSpc'],
                        On: [
                            'TCNMChannel_L.FTChnCode = TCNMChannel.FTChnCode AND TCNMChannel_L.FNLngID = ' + nLangEdits,
                            'TCNMChannel.FTChnCode = TCNMChannelSpc.FTChnCode'
                        ]
                    },
                    Where: {
                        Condition: [tWhereCondition]
                    },
                    GrideView: {
                        ColumnPathLang: 'company/warehouse/warehouse',
                        ColumnKeyLang: ['tWahCode', 'tWahName'],
                        DataColumns: ['TCNMChannel.FTChnCode', 'TCNMChannel_L.FTChnName'],
                        ColumnsSize: ['15%', '75%'],
                        DataColumnsFormat: ['', ''],
                        WidthModal: 50,
                        Perpage: 10,
                        OrderBy: ['TCNMChannel.FDCreateOn DESC']
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMChannel.FTChnCode"],
                        Text: [tInputReturnName, "TCNMChannel_L.FTChnName"],
                    }
                }
                break;
        }
        return oOptionReturn;
    }

    function JSxClickMakeBrowse(elemID, ptBrowseName) {
        window.oBrowseOption = oBrowseConfigMake({
            'tReturnInputCode': 'oetMakeBrowseID' + elemID,
            'tReturnInputName': 'oetMakeBrowseName' + elemID,
            'tConfigName': ptBrowseName
        });
        JCNxBrowseData('oBrowseOption');
    }

    function JSxClickRefBrowse(elemID, ptBrowseName) {
        window.oBrowseOption = oBrowseConfigMake({
            'tReturnInputCode': 'oetRefBrowseID' + elemID,
            'tReturnInputName': 'oetRefBrowseName' + elemID,
            'tConfigName': ptBrowseName
        });
        JCNxBrowseData('oBrowseOption');
    }

    // Input Text , int , double ถูก change ต้องเก็บค่าไว้ใน array
    var aPackDataInput = [];
    $('.xCNInputValue').change(function(elem) {
        var tSyscode = $(this).attr('data-syscode');
        var tSysapp = $(this).attr('data-sysapp');
        var tSyskey = $(this).attr('data-syskey');
        var tSysseq = $(this).attr('data-sysseq');
        var tOldpws = $(this).attr('data-oldpws');
        var tKind = $(this).attr('data-kind'); // แก้ไขที่ค่ากำหนดเอง (MAKE) , แก้ไขที่ค่าอ้างอิง (REF)
        var tInputType = $(this).attr('data-inputtype');
        var tInputValue = $(this).val();
        var nLenArray = aPackDataInput.length;
        if (nLenArray >= 1) {
            for ($i = 0; $i < aPackDataInput.length; $i++) {
                if (tSyscode == aPackDataInput[$i]['tSyscode'] &&
                    tSysapp == aPackDataInput[$i]['tSysapp'] &&
                    tSyskey == aPackDataInput[$i]['tSyskey'] &&
                    tSysseq == aPackDataInput[$i]['tSysseq'] &&
                    tKind == aPackDataInput[$i]['tKind']) {
                    aPackDataInput.splice($i, 1);
                }
            }
        }

        // เก็บค่าไว้ใน array
        var aSubValue = {
            'tSyscode': tSyscode,
            'tSysapp': tSysapp,
            'tSyskey': tSyskey,
            'tSysseq': tSysseq,
            'tOldpws': tOldpws,
            'nValue': tInputValue,
            'tKind': tKind,
            'tType': tInputType
        };
        aPackDataInput.push(aSubValue);
    });

    // Option ถูก change ต้องเก็บค่าไว้ใน array
    $('.xCNOptionValue').change(function(elem) {
        var tSyscode = $(this).attr('data-syscode');
        var tSysapp = $(this).attr('data-sysapp');
        var tSyskey = $(this).attr('data-syskey');
        var tSysseq = $(this).attr('data-sysseq');
        var tKind = $(this).attr('data-kind'); // แก้ไขที่ค่ากำหนดเอง (MAKE) , แก้ไขที่ค่าอ้างอิง (REF)
        var tInputType = $(this).attr('data-inputtype');
        var nOptionValue = $('option:selected', this).val();
        var nLenArray = aPackDataInput.length;
        if (nLenArray >= 1) {
            for ($i = 0; $i < aPackDataInput.length; $i++) {
                if (tSyscode == aPackDataInput[$i]['tSyscode'] &&
                    tSysapp == aPackDataInput[$i]['tSysapp'] &&
                    tSyskey == aPackDataInput[$i]['tSyskey'] &&
                    tSysseq == aPackDataInput[$i]['tSysseq'] &&
                    tKind == aPackDataInput[$i]['tKind']) {
                    aPackDataInput.splice($i, 1);
                }
            }
        }

        // เก็บค่าไว้ใน array
        var aSubValue = {
            'tSyscode': tSyscode,
            'tSysapp': tSysapp,
            'tSyskey': tSyskey,
            'tSysseq': tSysseq,
            'nValue': nOptionValue,
            'tKind': tKind,
            'tType': tInputType
        };
        aPackDataInput.push(aSubValue);
    });

    // Input Date ถูก change ต้องเก็บค่าไว้ใน array
    $('.xCNInputDateValue').change(function(elem) {
        var tSyscode = $(this).attr('data-syscode');
        var tSysapp = $(this).attr('data-sysapp');
        var tSyskey = $(this).attr('data-syskey');
        var tSysseq = $(this).attr('data-sysseq');
        var tKind = $(this).attr('data-kind'); // แก้ไขที่ค่ากำหนดเอง (MAKE) , แก้ไขที่ค่าอ้างอิง (REF)
        var tInputType = $(this).attr('data-inputtype');
        var dDate = $(this).val();
        var nLenArray = aPackDataInput.length;
        if (nLenArray >= 1) {
            for ($i = 0; $i < aPackDataInput.length; $i++) {
                if (tSyscode == aPackDataInput[$i]['tSyscode'] &&
                    tSysapp == aPackDataInput[$i]['tSysapp'] &&
                    tSyskey == aPackDataInput[$i]['tSyskey'] &&
                    tSysseq == aPackDataInput[$i]['tSysseq'] &&
                    tKind == aPackDataInput[$i]['tKind']) {
                    aPackDataInput.splice($i, 1);
                }
            }
        }

        // เก็บค่าไว้ใน array
        var aSubValue = {
            'tSyscode': tSyscode,
            'tSysapp': tSysapp,
            'tSyskey': tSyskey,
            'tSysseq': tSysseq,
            'nValue': dDate,
            'tKind': tKind,
            'tType': tInputType
        };
        aPackDataInput.push(aSubValue);
    });

    // Input Browse ถูก change ต้องเก็บค่าไว้ใน array
    $('.xCNBrowseValue').change(function(elem) {
        var tSyscode = $(this).attr('data-syscode');
        var tSysapp = $(this).attr('data-sysapp');
        var tSyskey = $(this).attr('data-syskey');
        var tSysseq = $(this).attr('data-sysseq');
        var tKind = $(this).attr('data-kind'); // แก้ไขที่ค่ากำหนดเอง (MAKE) , แก้ไขที่ค่าอ้างอิง (REF)
        var tInputType = $(this).attr('data-inputtype');
        var tValue = $(this).val();
        var nLenArray = aPackDataInput.length;
        if (nLenArray >= 1) {
            for ($i = 0; $i < aPackDataInput.length; $i++) {
                if (tSyscode == aPackDataInput[$i]['tSyscode'] &&
                    tSysapp == aPackDataInput[$i]['tSysapp'] &&
                    tSyskey == aPackDataInput[$i]['tSyskey'] &&
                    tSysseq == aPackDataInput[$i]['tSysseq'] &&
                    tKind == aPackDataInput[$i]['tKind']) {
                    aPackDataInput.splice($i, 1);
                }
            }
        }

        // เก็บค่าไว้ใน array
        var aSubValue = {
            'tSyscode': tSyscode,
            'tSysapp': tSysapp,
            'tSyskey': tSyskey,
            'tSysseq': tSysseq,
            'nValue': tValue,
            'tKind': tKind,
            'tType': tInputType
        };
        aPackDataInput.push(aSubValue);
    });

    // เอารายละเอียดมาโชว์
    function JSxAppendSpanDetail(elem, ptTypeTable) {
        if (ptTypeTable == 'checkbox') {
            var tType = $(elem).find("td:eq(0)").text();
            var tDetail = $(elem).find("td:eq(1)").text();
            var tDescription = $(elem).find("td:eq(2)").text();
            if (tDescription == '' || tDescription == null || tDescription == '-') {
                tDescriptionText = '';
            } else {
                tDescriptionText = ' (' + tDescription + ')';
            }
            var tResultText = tDetail + tDescriptionText;
        } else if (ptTypeTable == 'input') {
            var tType = $(elem).find("td:eq(0)").text();
            var tDetail = $(elem).find("td:eq(1)").text();
            var tDescription = $(elem).find("td:eq(2)").text();
            var tValueMake = $(elem).find("td:eq(5)").children().val();
            var tValueRef = $(elem).find("td:eq(6)").children().val();
            if (tDescription == '' || tDescription == null || tDescription == '-') {
                tDescriptionText = '';
            } else {
                tDescriptionText = ' (' + tDescription + ')';
            }

            if (tValueMake == '' || tValueMake == null || tValueMake == '-') {
                tValueMakeText = '';
            } else {
                tValueMakeText = ' ' + '<?= language('settingconfig/settingconfig/settingconfig', 'tDetailMake') ?>' + ' : ' + tValueMake;
            }

            if (tValueRef == '' || tValueRef == null || tValueRef == '-') {
                tValueRefText = '';
            } else {
                tValueRefText = ' ' + '<?= language('settingconfig/settingconfig/settingconfig', 'tDetailRef') ?>' + ' : ' + tValueRef;
            }

            var tResultText = tDetail + tDescriptionText + tValueMakeText + tValueRefText;
        }

        $('#odvContentFooterText').show();
        $('#ospDetailFooterText').text(tResultText);
    }

    $(document).on('click', '.ocmCENCheckUseLast', function(e) {
        var nStaClick = $(e.target).is(':checked');
        JCNxClickCheckUseCurrentBox(nStaClick);
    });

    function JCNxClickCheckUseCurrentBox(pnStaClick) {
        $('.ocbListItem').each(function() {
            if (pnStaClick) { // กรณีติ๊กถูก
                if (!$(this).is(':checked')) { // ตรวจสอบ checkbox ในหน้าจอ จะติ๊กเฉพาะที่ยังไม่ถูกติ๊ก (ปล.checkbox ที่ถูกติ๊กก่อนหน้าที่จะกด checkall จะไม่ถูกติ๊กซ้ำ)
                    $(this).trigger("click");
                }
            } else { // กรณียกเลิกติ๊กถูก
                if ($(this).is(':checked')) { // ตรวจสอบ checkbox ในหน้าจอ จะติ๊กเฉพาะที่ถูกติ๊กไว้ก่อนหน้าเท่านั้น
                    $(this).trigger("click");
                }
            }
        });
    }

    // $('.oetCurrentCurentcy').change(function() {
    // var ncurrentRate = parseFloat($(this).val());
    // var ncallastrate = parseFloat($(this).parent().parent().find("td#oetCalCurrency").text());
    // var nresult      = parseFloat(ncurrentRate);
    // var nDecimal     = $("#oetDecimal").val();
    // $(this).parent().parent().find("td#oetCalCurrency").text(nresult.toFixed(nDecimal));
    // });
</script>