//------------------------------------------------------------------------------ Import File ------------------------------------------------------------------------------//

//หน้าจอ pop-up
function JSxImportPopUp(poPackdata){

    //ล้างค่า สรุปว่าสามารถนำเข้าได้กี่อัน
    $('#ospTextSummaryImport').text('');

    var tNameModule     = poPackdata.tNameModule.toLowerCase();
    var tTypeModule     = poPackdata.tTypeModule.toLowerCase();
    var tAfterRoute     = poPackdata.tAfterRoute;
    var tFlagClearTmp   = poPackdata.tFlagClearTmp;
    //tFlagClearTmp = null : ไม่ระบุ
    //tFlagClearTmp = 1 : ล้างค่าทั้งหมด
    //tFlagClearTmp = 2 : ต่อเนื่อง

    //เซตค่า สำหรับ import 
    $('#ohdImportNameModule').val(tNameModule);
    $('#ohdImportAfterRoute').val(tAfterRoute);
    $('#ohdImportTypeModule').val(tTypeModule);
    $('#ohdImportClearTempOrInsCon').val(tFlagClearTmp);

    //สั้งให้ pop-up โชว์
    $('#odvModalImportFile').modal('show');
    $('#obtIMPConfirm').hide();

    //ขนาดความกว้างของ pop-up
    if(tTypeModule == 'master'){
        //ถ้าเป็น Type : master
        $('#odvModalImportFile .modal-dialog').css({
            'width' : '80%', 
            'top'   : '5%'
        });
    }else{
        //ถ้าเป็น Type : document
        $('#odvModalImportFile .modal-dialog').css({
            'width' : '800px', 
            'top'   : '20%'
        });
    }

    //ดาวน์โหลดแม่แบบ
    switch (tNameModule){
        case 'branch':
            var tPathTemplate = $('#ohdBaseUrlUseInJS').val() + 'application/modules/common/assets/template/Branch_Template.xlsx';
        break;
        case 'adjprice':
            var tPathTemplate = $('#ohdBaseUrlUseInJS').val() + 'application/modules/common/assets/template/AdjustPrice_Template.xlsx';
        break;
        case 'user':
            var tPathTemplate = $('#ohdBaseUrlUseInJS').val() + 'application/modules/common/assets/template/User_Template.xlsx';
        break;
        case 'product':
            var tPathTemplate = $('#ohdBaseUrlUseInJS').val() + 'application/modules/common/assets/template/Product_Template.xlsx';
        break;
        case 'pos':
            var tPathTemplate = $('#ohdBaseUrlUseInJS').val() + 'application/modules/common/assets/template/Pos_Template.xlsx';
        break;
    }
    $('#odvModalImportFile #oahDowloadTemplate').attr("href",tPathTemplate);

    // Clear ค่า
    var bIsMasterType = $('#ohdImportTypeModule').val() == "master";
    if(bIsMasterType){
        $("#odvModalImportFile .modal-body").css("min-height", "70vh");
        $('#odvContentRenderHTMLImport').html('<div class="xCNImportBefore"><label>กรุณานำเข้าไฟล์</label></div>');
    }else{
        $("#odvModalImportFile .modal-body").removeAttr("style");
        $('#odvContentRenderHTMLImport').html('<div style="text-align: center; margin-top: 50px;"><label>กรุณานำเข้าไฟล์</label></div>');
    }
    $('#oetFileNameImport').val('');
    $('#oefFileImportExcel').val('');
}

//Import File
function JSxCheckFileImportFile(poElement, poEvent) {
    try {
        var oFile = $(poElement)[0].files[0];
        if(oFile == undefined){
            $("#oetFileNameImport").val("");
        }else{
            $("#oetFileNameImport").val(oFile.name);
        }
        
    } catch (err) {
        console.log("JSxPromotionStep1SetImportFile Error: ", err);
    }
}

//กดปุ่มยืนยัน
function JSxImportFileExcel(){
    $('#ospTextSummaryImport').text('');

    var tNameFile = $("#oetFileNameImport").val();
    if(tNameFile == '' || tNameFile == null){
        //ไม่พบไฟล์
    }else{
        var bIsMasterType = $('#ohdImportTypeModule').val() == "master";
        if(bIsMasterType){
            JCNxOpenLoading();
            $('#odvContentRenderHTMLImport').html('<div class="xCNImportBefore"><label>กำลังนำเข้าไฟล์...</label></div>');
        }else{
            $('#odvContentRenderHTMLImport').html('<div style="text-align: center; margin-top: 50px;"><label>กำลังนำเข้าไฟล์...</label></div>');
        } 
        setTimeout(function(){
            JSxWirteImportFile();
        }, 50);
    }
}

function JSxWirteImportFile(evt) {
    var f = $('#oefFileImportExcel')[0].files[0];
    if (f) {
        var r = new FileReader();
        r.onload = e => {
            var contents 	= processExcel(e.target.result);
            var aJSON 		= JSON.parse(contents);
            var tNameModule = $('#ohdImportNameModule').val().toLowerCase();
            switch (tNameModule){
                case 'branch':
                    //ตรวจสอบชื่อชิทว่าถูกต้องไหม
                    if(typeof(aJSON['Branch']) == 'undefined'){
                        alert('รูปแบบเอกสารไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
                        JSxFileFailFormat();
                        return;
                    }

                    var aJSONData           = aJSON["Branch"];
                    var nCount              = aJSONData.length;
                    var aNewPackData        = [];
                    var aError              = [];

                    //ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
                    for(var k=0; k<nCount; k++){
                        if(aJSONData[k].length > 0){
                            aNewPackData.push(aJSONData[k]);
                        }
                    }
                    var nCount              = aNewPackData.length;
                    var aJSONData           = aNewPackData;

                    //ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
                    for(var j=1; j<nCount; j++){

                        //Template_Filed_สาขา
                        if(typeof(aJSONData[j][0]) != 'undefined' || null){
                            if(aJSONData[j][0] == null){
                                aJSONData[j][0] = 'N/A';
                                aError.push('7','[0]'+'$&รหัสสาขาไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][0].toString().length > 5){
                                    var tValueOld   = aJSONData[j][0];
                                    aJSONData[j][0] = aJSONData[j][0].toString().substring(0, 5);
                                    aError.push('4','[0]'+'$&รหัสสาขายาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][0] = 'N/A';
                            aError.push('7','[0]'+'$&รหัสสาขาไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_ชื่อสาขา
                        if(typeof(aJSONData[j][1]) != 'undefined' || null){
                            if(aJSONData[j][1] == null){
                                aJSONData[j][1] = 'N/A';
                                aError.push('7','[1]'+'$&ชื่อสาขาไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][1].length > 100){
                                    var tValueOld   = aJSONData[j][1];
                                    aJSONData[j][1] = aJSONData[j][1].substring(0, 100);
                                    aError.push('4','[1]'+'$&ชื่อสาขาเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][1] = 'N/A';
                            aError.push('7','[1]'+'$&ชื่อสาขาไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_รหัส agency
                        if(typeof(aJSONData[j][2]) != 'undefined' || null){
                            if(aJSONData[j][2] == null){
                                aJSONData[j][2] = 'N/A';
                                aError.push('7','[2]'+'$&รหัสตัวแทนขายไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][2].length > 10){
                                    var tValueOld   = aJSONData[j][2];
                                    aJSONData[j][2] = aJSONData[j][2].substring(0, 10);
                                    aError.push('4','[2]'+'$&รหัสตัวแทนขายยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][2] = 'N/A';
                            aError.push('7','[2]'+'$&รหัสตัวแทนขายไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_รหัส price group
                        if(typeof(aJSONData[j][3]) != 'undefined' || null){
                            if(aJSONData[j][3] == null){
                                aJSONData[j][3] = '';
                            }else{
                                if(aJSONData[j][3].length > 5){
                                    var tValueOld   = aJSONData[j][3];
                                    aJSONData[j][3] = aJSONData[j][3].substring(0, 5);
                                    aError.push('4','[3]'+'$&รหัสกลุ่มราคายาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][3] = '';
                        }   

                        if(aError.length > 0){
                            aJSONData[j].push(aError[0],aError[1]);
                            aError = [];
                        }else{
                            aJSONData[j].push('1','');
                        }
                        ///////////////////////////////////////////// DATATYPE
                    }
                break;
                case 'adjprice':
                    //ตรวจสอบชื่อชิทว่าถูกต้องไหม
                    if(typeof(aJSON['Adjust Price']) == 'undefined'){
                        alert('รูปแบบเอกสารไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
                        return;
                    }

                    var aJSONData           = aJSON["Adjust Price"];
                    var nCount              = aJSONData.length;
                    var aNewPackData        = [];
                    var aError              = [];

                    //ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
                    for(var k=0; k<nCount; k++){
                        if(aJSONData[k].length > 0){
                            aNewPackData.push(aJSONData[k]);
                        }
                    }
                    var nCount              = aNewPackData.length;
                    var aJSONData           = aNewPackData;

                    //ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
                    for(var j=1; j<nCount; j++){
                        var tValueOld = '';

                        //Template_Filed_ราคา
                        if(typeof(aJSONData[j][2]) != 'undefined' || null){
                            if(aJSONData[j][2] == null){
                                aJSONData[j][2] = '0';
                            }else{
                                var Letters = /^[ก-๛A-Za-z]+$/;
                                var nValue = aJSONData[j][2].toString();
                                var nValue = nValue.replace(" ", "");
                                if(nValue.match(Letters)){
                                    //เอาตัวที่ผิดออก
                                    var tValueOld  = aJSONData[j][2];
                                    aJSONData[j].pop();
                                    aJSONData[j].push(0);
                                    aError.push('3','[2]'+'$&รูปแบบราคาผิด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][2] = '0';
                        }

                        //Template_Filed_รหัสสินค้า
                        if(typeof(aJSONData[j][0]) != 'undefined' || null){
                            if(aJSONData[j][0] == null){
                                aJSONData[j][0] = 'N/A';
                                aError.push('7','[0]'+'$&รหัสสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][0].length > 20){
                                    var tValueOld   = aJSONData[j][0];
                                    aJSONData[j][0] = aJSONData[j][0].substring(0, 20);
                                    aError.push('4','[0]'+'$&รหัสสินค้ายาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][0] = 'N/A';
                            aError.push('4','[0]'+'$&รหัสสินค้ายาวเกินกำหนด$&'+tValueOld);
                        }

                        //Template_Filed_หน่วยสินค้า
                        if(typeof(aJSONData[j][1]) != 'undefined' || null){
                            if(aJSONData[j][1] == null){
                                aJSONData[j][1] = 'N/A';
                                aError.push('7','[1]'+'$&รหัสหน่วยสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][1].length > 5){
                                    var tValueOld   = aJSONData[j][1];
                                    aJSONData[j][1] = aJSONData[j][1].substring(0, 5);
                                    aError.push('4','[1]'+'$&รหัสหน่วยสินค้ายาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][1] = '00000';
                        }

                        //ถ้าผ่านทุกอัน
                        if(aError.length > 0){
                            aJSONData[j].push(aError[0],aError[1]);
                            aError = [];
                        }else{
                            aJSONData[j].push('1','');
                        }
                        ///////////////////////////////////////////// DATATYPE
                    }
                break;
                case 'user':
                    //ตรวจสอบชื่อชิทว่าถูกต้องไหม
                    if(typeof(aJSON['User']) == 'undefined'){
                        alert('รูปแบบเอกสารไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
                        JSxFileFailFormat();
                        return;
                    }

                    var aJSONData           = aJSON["User"];
                    var nCount              = aJSONData.length;
                    var aNewPackData        = [];
                    var aError              = [];

                    //ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
                    for(var k=0; k<nCount; k++){
                        if(aJSONData[k].length > 0){
                            aNewPackData.push(aJSONData[k]);
                        }
                    }
                    var nCount              = aNewPackData.length;
                    var aJSONData           = aNewPackData;

                    //ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
                    for(var j=1; j<nCount; j++){
                        var tValueOld = '';

                        //Template_Filed_รหัสผู้ใช้
                        if(typeof(aJSONData[j][0]) != 'undefined' || null){
                            if(aJSONData[j][0] == null){
                                aJSONData[j][0] = 'N/A';
                                aError.push('7','[0]'+'$&รหัสผู้ใช้ไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][0].toString().length > 20){
                                    var tValueOld   = aJSONData[j][0];
                                    aJSONData[j][0] = aJSONData[j][0].toString().substring(0, 20);
                                    aError.push('4','[0]'+'$&รหัสผู้ใช้กินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][0] = 'N/A';
                            aError.push('7','[0]'+'$&รหัสผู้ใช้ไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_ชื่อผู้ใช้
                        if(typeof(aJSONData[j][1]) != 'undefined' || null){
                            if(aJSONData[j][1] == null){
                                aJSONData[j][1] = 'N/A';
                                aError.push('7','[1]'+'$&ชื่อผู้ใช้ไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][1].length > 100){
                                    var tValueOld   = aJSONData[j][1];
                                    aJSONData[j][1] = aJSONData[j][1].substring(0, 100);
                                    aError.push('4','[1]'+'$&ชื่อผู้ใช้เกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][1] = 'N/A';
                            aError.push('7','[1]'+'$&ชื่อผู้ใช้ไม่ได้ระบุข้อมูล$&'+'N/A');
                        }
                       
                        //Template_Filed_รหัสสาขา
                        if(typeof(aJSONData[j][2]) != 'undefined' || null){
                            if(aJSONData[j][2] == null){
                                aJSONData[j][2] = '';
                            }else{
                                if(aJSONData[j][2].toString().length > 5){
                                    var tValueOld   = aJSONData[j][2];
                                    aJSONData[j][2] = aJSONData[j][2].toString().substring(0, 5);
                                    aError.push('4','[2]'+'$&รหัสสาขายาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][2] = '';
                        }
                 
                        //Template_Filed_กลุ่มสิทธิ
                        if(typeof(aJSONData[j][3]) != 'undefined' || null){
                            if(aJSONData[j][3] == null){
                                aJSONData[j][3] = '';
                            }else{
                                if(aJSONData[j][3].toString().length > 5){
                                    var tValueOld   = aJSONData[j][3];
                                    aJSONData[j][3] = aJSONData[j][3].toString().substring(0, 5);
                                    aError.push('4','[3]'+'$&รหัสกลุ่มสิทธิยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][3] = '';
                        }
                      
                        //Template_Filed_ตัวแทนขาย
                        if(typeof(aJSONData[j][4]) != 'undefined' || null){
                            if(aJSONData[j][4] == null){
                                aJSONData[j][4] = '';
                            }else{
                                if(aJSONData[j][4].length > 10){
                                    var tValueOld   = aJSONData[j][4];
                                    aJSONData[j][4] = aJSONData[j][4].substring(0, 10);
                                    aError.push('4','[4]'+'$&รหัสตัวแทนขายยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][4] = '';
                        }
                      
                        //Template_Filed_กลุ่มธุรกิจ
                        if(typeof(aJSONData[j][5]) != 'undefined' || null){
                            if(aJSONData[j][5] == null){
                                aJSONData[j][5] = '';
                            }else{
                                if(aJSONData[j][5].length > 10){
                                    var tValueOld   = aJSONData[j][5];
                                    aJSONData[j][5] = aJSONData[j][5].substring(0, 10);
                                    aError.push('4','[5]'+'$&รหัสธุรกิจยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][5] = '';
                        }

                        //Template_Filed_ร้านค้า
                        if(typeof(aJSONData[j][6]) != 'undefined' || null){
                            if(aJSONData[j][6] == null){
                                aJSONData[j][6] = '';
                            }else{
                                if(aJSONData[j][6].length > 5){
                                    var tValueOld   = aJSONData[j][6];
                                    aJSONData[j][6] = aJSONData[j][6].substring(0, 5);
                                    aError.push('4','[6]'+'$&รหัสรหัสร้านค้ายาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][6] = '';
                        }

                        //Template_Filed_แผนก
                        if(typeof(aJSONData[j][7]) != 'undefined' || null){
                            if(aJSONData[j][7] == null){
                                aJSONData[j][7] = '';
                            }else{
                                if(aJSONData[j][7].length > 5){
                                    var tValueOld   = aJSONData[j][7];
                                    aJSONData[j][7] = aJSONData[j][7].substring(0, 5);
                                    aError.push('4','[7]'+'$&รหัสแผนกยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][7] = '';
                        }

                        //Template_Filed_เบอร์
                        if(typeof(aJSONData[j][8]) != 'undefined' || null){
                            if(aJSONData[j][8] == null){
                                aJSONData[j][8] = '';
                            }else{
                                if(aJSONData[j][8].length > 50){
                                    var tValueOld   = aJSONData[j][8];
                                    aJSONData[j][8] = aJSONData[j][8].substring(0, 50);
                                    aError.push('4','[8]'+'$&เบอร์โทรศัพท์ยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][8] = '';
                        }

                        //Template_Filed_อีเมล์
                        if(typeof(aJSONData[j][9]) != 'undefined' || null){
                            if(aJSONData[j][9] == null){
                                aJSONData[j][9] = '';
                            }else{
                                if(aJSONData[j][9].length > 100){
                                    var tValueOld   = aJSONData[j][9];
                                    aJSONData[j][9] = aJSONData[j][9].substring(0, 100);
                                    aError.push('4','[9]'+'$&อีเมลล์ยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][9] = '';
                        }

                        //ถ้าผ่านทุกอัน
                        if(aError.length > 0){
                            aJSONData[j].push(aError[0],aError[1]);
                            aError = [];
                        }else{
                            aJSONData[j].push('1','');
                        }
                        ///////////////////////////////////////////// DATATYPE
                    }
                break;
                case 'pos':
                    //ตรวจสอบชื่อชิทว่าถูกต้องไหม
                    if(typeof(aJSON['Pos']) == 'undefined'){
                        alert('รูปแบบเอกสารไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
                        JSxFileFailFormat();
                        return;
                    }

                    var aJSONData           = aJSON["Pos"];
                    var nCount              = aJSONData.length;
                    var aNewPackData        = [];
                    var aError              = [];
                    var aPosType            = [1,2,3,4,5,6];

                    //ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
                    for(var k=0; k<nCount; k++){
                        if(aJSONData[k].length > 0){
                            aNewPackData.push(aJSONData[k]);
                        }
                    }
                    var nCount              = aNewPackData.length;
                    var aJSONData           = aNewPackData;

                    //ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
                    for(var j=1; j<nCount; j++){
                        var tValueOld = '';

                        //Template_Filed_สาขา
                        if(typeof(aJSONData[j][0]) != 'undefined' || null){
                            if(aJSONData[j][0] == null){
                                aJSONData[j][0] = 'N/A';
                                aError.push('7','[0]'+'$&รหัสสาขาไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][0].toString().length > 5){
                                    var tValueOld   = aJSONData[j][0];
                                    aJSONData[j][0] = aJSONData[j][0].toString().substring(0, 5);
                                    aError.push('4','[0]'+'$&รหัสสาขายาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][0] = 'N/A';
                            aError.push('7','[0]'+'$&รหัสสาขาไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_จุดขาย
                        if(typeof(aJSONData[j][1]) != 'undefined' || null){
                            if(aJSONData[j][1] == null){
                                aJSONData[j][1] = 'N/A';
                                aError.push('7','[1]'+'$&รหัสจุดขายไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][1].toString().length > 5){
                                    var tValueOld   = aJSONData[j][1];
                                    aJSONData[j][1] = aJSONData[j][1].toString().substring(0, 5);
                                    aError.push('4','[1]'+'$&รหัสจุดขายยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][1] = 'N/A';
                            aError.push('7','[1]'+'$&รหัสจุดขายไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_ชื่อจุดขาย
                        if(typeof(aJSONData[j][2]) != 'undefined' || null){
                            if(aJSONData[j][2] == null){
                                aJSONData[j][2] = 'N/A';
                                aError.push('7','[2]'+'$&ชื่อจุดขายไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData[j][2].length > 100){
                                    var tValueOld   = aJSONData[j][2];
                                    aJSONData[j][2] = aJSONData[j][2].substring(0, 100);
                                    aError.push('4','[2]'+'$&ชื่อจุดขายเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][2] = 'N/A';
                            aError.push('7','[2]'+'$&ชื่อจุดขายไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_ประเภทเครื่องจุดขาย
                        if(typeof(aJSONData[j][3]) != 'undefined' || null){
                            if(aJSONData[j][3] == null){
                                aJSONData[j][3] = '1';
                            }else{
                                var Letters = /^[ก-๛A-Za-z]+$/;
                                var nValue = aJSONData[j][3].toString();
                                var nValue = nValue.replace(" ", "");
                                if(nValue.match(Letters)){
                                    //เอาตัวที่ผิดออก
                                    var tValueOld  = aJSONData[j][3];
                                    aJSONData[j].pop();
                                    aJSONData[j].push(1);
                                    aError.push('3','[3]'+'$&รูปแบบประเภทผิด$&'+tValueOld);
                                }
                                
                                if(aJSONData[j][3].length > 1){
                                    var tValueOld   = aJSONData[j][3];
                                    aJSONData[j][3] = aJSONData[j][3].substring(0, 1);
                                    aError.push('4','[3]'+'$&ประเภทจุดขายไม่ถูกต้อง$&'+tValueOld);
                                }

                                if(aPosType.includes(aJSONData[j][3]) != true){
                                    var tValueOld   = aJSONData[j][3];
                                    aJSONData[j][3] = 1;
                                    aError.push('4','[3]'+'$&ประเภทจุดขายไม่ถูกต้อง$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][3] = '1';
                        }

                         //Template_Filed_รหัสลงทะเบียน
                         if(typeof(aJSONData[j][4]) != 'undefined' || null){
                            if(aJSONData[j][4] == null){
                                aJSONData[j][4] = '';
                            }else{
                                if(aJSONData[j][4].length > 20){
                                    var tValueOld   = aJSONData[j][4];
                                    aJSONData[j][4] = aJSONData[j][4].substring(0, 20);
                                    aError.push('4','[4]'+'$&หมายเลขจุดขายเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData[j][4] = '';
                        }

                        //ถ้าผ่านทุกอัน
                        if(aError.length > 0){
                            aJSONData[j].push(aError[0],aError[1]);
                            aError = [];
                        }else{
                            aJSONData[j].push('1','');
                        }
                        ///////////////////////////////////////////// DATATYPE
                    }
                break;
                case 'product':
                    //ตรวจสอบชื่อชิทว่าถูกต้องไหม
                    if(typeof(aJSON['Product']) == 'undefined'){
                        alert('รูปแบบเอกสารไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
                        JSxFileFailFormat();
                        return;
                    }

                    var aJSONData               = ['[1] Tab : product , [2] Tab : unit , [3] Tab : brand , [4] Tab : touch group'];
                    //###################################################  Sheet Product
                    var aJSONData_PDT           = aJSON["Product"];
                    var nCount_PDT              = aJSONData_PDT.length;
                    var aNewPackData_PDT        = [];
                    var aError                  = [];

                    //ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
                    for(var k=0; k<nCount_PDT; k++){
                        if(aJSONData_PDT[k].length > 0){
                            aNewPackData_PDT.push(aJSONData_PDT[k]);
                        }
                    }
                    var nCount              = aNewPackData_PDT.length;
                    var aJSONData_PDT       = aNewPackData_PDT;

                    //ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
                    for(var j=1; j<nCount; j++){
                        var tValueOld = '';

                        //Template_Filed_รหัสสินค้า
                        if(typeof(aJSONData_PDT[j][0]) != 'undefined' || null){
                            if(aJSONData_PDT[j][0] == null){
                                aJSONData_PDT[j][0] = 'N/A';
                                aError.push('7','[0]'+'$&รหัสสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData_PDT[j][0].toString().length > 20){
                                    var tValueOld   = aJSONData_PDT[j][0];
                                    aJSONData_PDT[j][0] = aJSONData_PDT[j][0].toString().substring(0, 20);
                                    aError.push('4','[0]'+'$&รหัสสินค้ากินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_PDT[j][0] = 'N/A';
                            aError.push('7','[0]'+'$&รหัสสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_ชื่อสินค้า
                        if(typeof(aJSONData_PDT[j][1]) != 'undefined' || null){
                            if(aJSONData_PDT[j][1] == null){
                                aJSONData_PDT[j][1] = 'N/A';
                                aError.push('7','[1]'+'$&ชื่อสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData_PDT[j][1].length > 100){
                                    var tValueOld   = aJSONData_PDT[j][1];
                                    aJSONData_PDT[j][1] = aJSONData_PDT[j][1].substring(0, 100);
                                    aError.push('4','[1]'+'$&ชื่อสินค้าเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_PDT[j][1] = 'N/A';
                            aError.push('7','[1]'+'$&ชื่อสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                        }
                    
                        //Template_Filed_ชื่อเพิ่มเติม
                        if(typeof(aJSONData_PDT[j][2]) != 'undefined' || null){
                            if(aJSONData_PDT[j][2] == null){
                                aJSONData_PDT[j][2] = '';
                            }else{
                                if(aJSONData_PDT[j][2].toString().length > 30){
                                    var tValueOld   = aJSONData_PDT[j][2];
                                    aJSONData_PDT[j][2] = aJSONData_PDT[j][2].toString().substring(0, 30);
                                    aError.push('4','[2]'+'$&ชื่อเพิ่มเติมยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_PDT[j][2] = '';
                        }
                
                        //Template_Filed_หน่วยสินค้า
                        if(typeof(aJSONData_PDT[j][3]) != 'undefined' || null){
                            if(aJSONData_PDT[j][3] == null){
                                aJSONData_PDT[j][3] = 'N/A';
                                aError.push('7','[3]'+'$&รหัสหน่วยสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData_PDT[j][3].length > 5){
                                    var tValueOld   = aJSONData_PDT[j][3];
                                    aJSONData_PDT[j][3] = aJSONData_PDT[j][3].substring(0, 5);
                                    aError.push('4','[3]'+'$&รหัสหน่วยสินค้าเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_PDT[j][3] = 'N/A';
                            aError.push('7','[3]'+'$&รหัสหน่วยสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_เฟกเตอร์
                        if(typeof(aJSONData_PDT[j][4]) != 'undefined' || null){
                            if(aJSONData_PDT[j][4] == null){
                                aJSONData_PDT[j][4] = 0;
                            }else{
                                var Letters = /^[ก-๛A-Za-z]+$/;
                                var nValue = aJSONData_PDT[j][4];
                                if(typeof nValue == 'string'){
                                    aJSONData_PDT[j][4] = 0;
                                    aError.push('3','[4]'+'$&รูปแบบหน่วยผิด$&'+tValueOld);
                                }else{
                                    var nValue = aJSONData_PDT[j][4].toString();;
                                    var nValue = nValue.replace(" ", "");
                                    if(nValue.match(Letters)){
                                        //เอาตัวที่ผิดออก
                                        var tValueOld  = aJSONData_PDT[j][4];
                                        aJSONData_PDT[j][4] = 0;
                                        aError.push('3','[4]'+'$&รูปแบบหน่วยผิด$&'+tValueOld);
                                    }
                                }
                            }
                        }else{
                            aJSONData_PDT[j][4] = 0;
                        }

                        //Template_Filed_บาร์โค๊ด
                        if(typeof(aJSONData_PDT[j][5]) != 'undefined' || null){
                            if(aJSONData_PDT[j][5] == null){
                                aJSONData_PDT[j][5] = 'N/A';
                                aError.push('7','[5]'+'$&บาร์โค๊ดไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData_PDT[j][5].length > 20){
                                    var tValueOld   = aJSONData_PDT[j][5];
                                    aJSONData_PDT[j][5] = aJSONData_PDT[j][5].substring(0, 20);
                                    aError.push('4','[5]'+'$&บาร์โค๊ดเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_PDT[j][5] = 'N/A';
                            aError.push('7','[5]'+'$&บาร์โค๊ดไม่ได้ระบุข้อมูล$&'+'N/A');
                        }
                    
                        //Template_Filed_แบรนด์
                        if(typeof(aJSONData_PDT[j][6]) != 'undefined' || null){
                            if(aJSONData_PDT[j][6] == null){
                                aJSONData_PDT[j][6] = '';
                            }else{
                                if(aJSONData_PDT[j][6].length > 5){
                                    var tValueOld   = aJSONData_PDT[j][6];
                                    aJSONData_PDT[j][6] = aJSONData_PDT[j][6].substring(0, 5);
                                    aError.push('4','[6]'+'$&แบรนด์ยาวเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_PDT[j][6] = '';
                        }

                        //Template_Filed_สินค้าทัช
                        if(typeof(aJSONData_PDT[j][7]) != 'undefined' || null){
                            if(aJSONData_PDT[j][7] == null){
                                aJSONData_PDT[j][7] = '';
                            }else{
                                if(aJSONData_PDT[j][7].length > 5){
                                    var tValueOld   = aJSONData_PDT[j][7];
                                    aJSONData_PDT[j][7] = aJSONData_PDT[j][7].substring(0, 5);
                                    aError.push('4','[7]'+'$&กลุ่มสินค้าทัชเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_PDT[j][7] = '';
                        }

                        //ถ้าผ่านทุกอัน
                        if(aError.length > 0){
                            aJSONData_PDT[j].push(aError[0],aError[1]);
                            aError = [];
                        }else{
                            aJSONData_PDT[j].push('1','');
                        }
                    }       
                    aJSONData_PDT.shift();
                    aJSONData.push(aJSONData_PDT);



                    //###################################################  Sheet UNIT
                    var aJSONData_UNIT              = aJSON["Unit"];
                    var nCount_UNIT                 = aJSONData_UNIT.length;
                    var aNewPackData_UNIT           = [];
                    var aError                      = [];

                    //ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
                    for(var k=0; k<nCount_UNIT; k++){
                        if(aJSONData_UNIT[k].length > 0){
                            aNewPackData_UNIT.push(aJSONData_UNIT[k]);
                        }
                    }
                    var nCount              = aNewPackData_UNIT.length;
                    var aJSONData_UNIT      = aNewPackData_UNIT;

                    //ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
                    for(var j=1; j<nCount; j++){
                        var tValueOld = '';

                        //Template_Filed_รหัสหน่วยสินค้า
                        if(typeof(aJSONData_UNIT[j][0]) != 'undefined' || null){
                            if(aJSONData_UNIT[j][0] == null){
                                aJSONData_UNIT[j][0] = 'N/A';
                                aError.push('7','[0]'+'$&รหัสหน่วยสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData_UNIT[j][0].toString().length > 5){
                                    var tValueOld   = aJSONData_UNIT[j][0];
                                    aJSONData_UNIT[j][0] = aJSONData_UNIT[j][0].toString().substring(0, 5);
                                    aError.push('4','[0]'+'$&รหัสหน่วยสินค้ากินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_UNIT[j][0] = 'N/A';
                            aError.push('7','[0]'+'$&รหัสหน่วยสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_ชื่อหน่วยสินค้า
                        if(typeof(aJSONData_UNIT[j][1]) != 'undefined' || null){
                            if(aJSONData_UNIT[j][1] == null){
                                aJSONData_UNIT[j][1] = 'N/A';
                                aError.push('7','[1]'+'$&ชื่อหน่วยสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData_UNIT[j][1].length > 50){
                                    var tValueOld   = aJSONData_UNIT[j][1];
                                    aJSONData_UNIT[j][1] = aJSONData_UNIT[j][1].substring(0, 50);
                                    aError.push('4','[1]'+'$&ชื่อหน่วยสินค้าเกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_UNIT[j][1] = 'N/A';
                            aError.push('7','[1]'+'$&ชื่อหน่วยสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //ถ้าผ่านทุกอัน
                        if(aError.length > 0){
                            aJSONData_UNIT[j].push(aError[0],aError[1]);
                            aError = [];
                        }else{
                            aJSONData_UNIT[j].push('1','');
                        }
                    }   
                    aJSONData_UNIT.shift();
                    aJSONData.push(aJSONData_UNIT);

                    //###################################################  Sheet Brand
                    var aJSONData_BRAND             = aJSON["Brand"];
                    var nCount_BRAND                = aJSONData_BRAND.length;
                    var aNewPackData_BRAND          = [];
                    var aError                      = [];

                    //ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
                    for(var k=0; k<nCount_BRAND; k++){
                        if(aJSONData_BRAND[k].length > 0){
                            aNewPackData_BRAND.push(aJSONData_BRAND[k]);
                        }
                    }
                    var nCount               = aNewPackData_BRAND.length;
                    var aJSONData_BRAND      = aNewPackData_BRAND;

                    //ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
                    for(var j=1; j<nCount; j++){
                        var tValueOld = '';

                        //Template_Filed_รหัสแบรนด์
                        if(typeof(aJSONData_BRAND[j][0]) != 'undefined' || null){
                            if(aJSONData_BRAND[j][0] == null){
                                aJSONData_BRAND[j][0] = 'N/A';
                                aError.push('7','[0]'+'$&รหัสแบรนด์ไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData_BRAND[j][0].toString().length > 5){
                                    var tValueOld   = aJSONData_BRAND[j][0];
                                    aJSONData_BRAND[j][0] = aJSONData_BRAND[j][0].toString().substring(0, 5);
                                    aError.push('4','[0]'+'$&รหัสแบรนด์กินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_BRAND[j][0] = 'N/A';
                            aError.push('7','[0]'+'$&รหัสแบรนด์ไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //Template_Filed_ชื่อแบรนด์
                        if(typeof(aJSONData_BRAND[j][1]) != 'undefined' || null){
                            if(aJSONData_BRAND[j][1] == null){
                                aJSONData_BRAND[j][1] = 'N/A';
                                aError.push('7','[1]'+'$&ชื่อแบรนด์ไม่ได้ระบุข้อมูล$&'+'N/A');
                            }else{
                                if(aJSONData_BRAND[j][1].length > 50){
                                    var tValueOld   = aJSONData_BRAND[j][1];
                                    aJSONData_BRAND[j][1] = aJSONData_BRAND[j][1].substring(0, 50);
                                    aError.push('4','[1]'+'$&ชื่อแบรนด์เกินกำหนด$&'+tValueOld);
                                }
                            }
                        }else{
                            aJSONData_BRAND[j][1] = 'N/A';
                            aError.push('7','[1]'+'$&ชื่อแบรนด์ไม่ได้ระบุข้อมูล$&'+'N/A');
                        }

                        //ถ้าผ่านทุกอัน
                        if(aError.length > 0){
                            aJSONData_BRAND[j].push(aError[0],aError[1]);
                            aError = [];
                        }else{
                            aJSONData_BRAND[j].push('1','');
                        }
                    }   
                    aJSONData_BRAND.shift();
                    aJSONData.push(aJSONData_BRAND);

                     //###################################################  Sheet Touch Group
                     var aJSONData_TGroup             = aJSON["Touch Group"];
                     var nCount_TGroup                = aJSONData_TGroup.length;
                     var aNewPackData_TGroup          = [];
                     var aError                       = [];
 
                     //ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
                     for(var k=0; k<nCount_TGroup; k++){
                         if(aJSONData_TGroup[k].length > 0){
                             aNewPackData_TGroup.push(aJSONData_TGroup[k]);
                         }
                     }
                     var nCount                = aNewPackData_TGroup.length;
                     var aJSONData_TGroup      = aNewPackData_TGroup;
 
                     //ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
                     for(var j=1; j<nCount; j++){
                         var tValueOld = '';
 
                         //Template_Filed_รหัสกลุ่ม
                         if(typeof(aJSONData_TGroup[j][0]) != 'undefined' || null){
                             if(aJSONData_TGroup[j][0] == null){
                                 aJSONData_TGroup[j][0] = 'N/A';
                                 aError.push('7','[0]'+'$&รหัสกลุ่มไม่ได้ระบุข้อมูล$&'+'N/A');
                             }else{
                                 if(aJSONData_TGroup[j][0].toString().length > 5){
                                     var tValueOld   = aJSONData_TGroup[j][0];
                                     aJSONData_TGroup[j][0] = aJSONData_TGroup[j][0].toString().substring(0, 5);
                                     aError.push('4','[0]'+'$&รหัสกลุ่มกินกำหนด$&'+tValueOld);
                                 }
                             }
                         }else{
                             aJSONData_TGroup[j][0] = 'N/A';
                             aError.push('7','[0]'+'$&รหัสกลุ่มไม่ได้ระบุข้อมูล$&'+'N/A');
                         }
 
                         //Template_Filed_ชื่อกลุ่ม
                         if(typeof(aJSONData_TGroup[j][1]) != 'undefined' || null){
                             if(aJSONData_TGroup[j][1] == null){
                                 aJSONData_TGroup[j][1] = 'N/A';
                                 aError.push('7','[1]'+'$&ชื่อกลุ่มไม่ได้ระบุข้อมูล$&'+'N/A');
                             }else{
                                 if(aJSONData_TGroup[j][1].length > 50){
                                     var tValueOld   = aJSONData_TGroup[j][1];
                                     aJSONData_TGroup[j][1] = aJSONData_TGroup[j][1].substring(0, 50);
                                     aError.push('4','[1]'+'$&ชื่อกลุ่มเกินกำหนด$&'+tValueOld);
                                 }
                             }
                         }else{
                             aJSONData_TGroup[j][1] = 'N/A';
                             aError.push('7','[1]'+'$&ชื่อกลุ่มไม่ได้ระบุข้อมูล$&'+'N/A');
                         }
 
                         //ถ้าผ่านทุกอัน
                         if(aError.length > 0){
                             aJSONData_TGroup[j].push(aError[0],aError[1]);
                             aError = [];
                         }else{
                             aJSONData_TGroup[j].push('1','');
                         }
                     }   
                     aJSONData_TGroup.shift();
                     aJSONData.push(aJSONData_TGroup);

                break;
            }

            // console.log(aJSONData);

            // ถ้า = 1 จะมี pop-up แจ้งเตือนว่า ข้อมูลทั้งหมด
            // ถ้าเป็นเอกสาร ต้องเเจ้งเตือนว่า ข้อมูลทั้งหมดใน Tmp จะถูกเคลียร์ 
            var tTypeModule     = $('#ohdImportTypeModule').val();
            var tFlagClearTmp   = $('#ohdImportClearTempOrInsCon').val();
            if(tTypeModule == 'document' && tFlagClearTmp == 1){
                $('#odvModalImportFile').modal('hide');
                $('#odvModalDialogClearData').modal('show');

                $('#obtConfirmDeleteBeforeInsert').off();
                $('#obtConfirmDeleteBeforeInsert').on("click", function() {
                    JSxProcessImportExcel(aJSONData,tNameModule,tTypeModule,tFlagClearTmp);
                });
            }else{
                JSxProcessImportExcel(aJSONData,tNameModule,tTypeModule,tFlagClearTmp);
            }

        }
        r.readAsBinaryString(f);
    } else {
        console.log("Failed to load file");
    }
}

function processExcel(data) {
    var workbook = XLSX.read(data, {
        type: 'binary'
    });

    var firstSheet = workbook.SheetNames[0];
    var data = to_json(workbook);
    return data
};

function to_json(workbook) {
    var result = {};
    workbook.SheetNames.forEach(function(sheetName) {
        var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
            header: 1
        });
        if (roa.length) result[sheetName] = roa;
    });
    return JSON.stringify(result, 2, 2);
};

//ฟังก์ชั่นสำหรับ import excel -> controller -> modal
function JSxProcessImportExcel(aJSONData,tNameModule,tTypeModule,tFlagClearTmp){
    $.ajax({
        type		: "POST",
        url			: "ImportFileExcel",
        data		: { 'aPackdata' : aJSONData , 'tNameModule' : tNameModule , 'tTypeModule' :tTypeModule , 'tFlagClearTmp' : tFlagClearTmp },
        async       : false,
        success	: function (aResult) {
            // console.log(aResult);
            if($('#ohdImportTypeModule').val().toString() == "master"){
                //ถ้าเป็นหน้าจอมาสเตอร์ จะโหลด HTML มา
                var tRouteMaster = $('#ohdImportAfterRoute').val();
                JSxRenderHTMLForImport(tNameModule,tRouteMaster);
            }else{
                //ถ้าเป็นเอกสาร จะรับมาเป็น nextFunc
                $('#odvModalImportFile').modal('hide');
                setTimeout(function () {
                    var tNextFunc = $('#ohdImportAfterRoute').val();
                    return window[tNextFunc]();
                }, 500);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('ERROR');
            JCNxCloseLoading();
        }
    });
}

//ไฟล์ผิด รุปแบบผิดพลาด
function JSxFileFailFormat(){
    JCNxCloseLoading();
    $('#odvContentRenderHTMLImport').html('<div class="xCNImportBefore"><label>กรุณานำเข้าไฟล์</label></div>');
}

//---------------------------------------------------------------------------- END Import File ---------------------------------------------------------------------------//

// $('#odvModalImportFile').modal('show');
// JSxRenderHTMLForImport('','productPageImportDataTable');
// $('#odvModalImportFile .modal-dialog').css({
//     'width' : '80%', 
//     'top'   : '5%'
// });
function JSxRenderHTMLForImport(ptNameModule,ptRouteMaster){
    $.ajax({
        type		: "POST",
        url			: ptRouteMaster,
        data		: {},
        async       : false,
        success	: function (tHTML){
            $('#odvContentRenderHTMLImport').html(tHTML);   // นำ DataTable มาวางทับ
            $('#obtIMPConfirm').show();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('JSxRenderHTMLForImport ERROR');
            JCNxCloseLoading();
        }
    });
}