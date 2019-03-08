<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-list-in" id="btnGroup">
        <li class="aui-list-header">导入密码本</li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">用户名</div>
                <div class="aui-list-item-input">
                    <input type="text" placeholder="用户名加密为文件名" v-model="usrname">
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">密码</div>
                <div class="aui-list-item-input">
                    <input type="password" placeholder="密码请和手机端密码保持一致" v-model="pwd">
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">密码本区域</div>
                <hr>
                <div class="aui-list-item-input">
                    <textarea placeholder="请粘贴在此处" rows="10" v-model="pbook"></textarea>
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner aui-list-item-center aui-list-item-btn">
                <div class="aui-btn aui-btn-info aui-margin-r-5" v-on:click="btnSubmit">提交</div>
                <div class="aui-btn aui-btn-danger aui-margin-l-5" v-on:click="btnCancel">取消</div>
            </div>
        </li>
    </ul>
</div>
<script>
var vm = new Vue({
    el: "#btnGroup",
    data: {
        usrname: "",
        pwd: "",
        pbook: ""
    },
    methods: {
        btnSubmit: function () {
            //Step1:检查是否有重名
            var usr = this.usrname;
            var pwd = this.pwd;
            var filename = (XXTEA.encryptToBase64(usr, pwd));
            var dialog = new auiDialog({})
            var amsg="";
            var toast = new auiToast({
            });
            $.post("../isExist.php", {
                filename: filename
            }, function (result) {
                amsg += result;
                if (result.indexOf("不") != -1) { //文件不存在就提示
                    // $("#state22").html("文件不存在，取回失败，请检查用户名和密码");
                    amsg += "文件不存在，取回失败，请检查用户名和密码";
                    toast.fail({
                    title:amsg,
                    duration:2000
                    });
                }
                else{//文件已存在，是否进行覆盖
                    dialog.alert({
                        title:"警告",
                        msg:'文件已存在，请问是否覆盖',
                        buttons:['取消','确定']
                    },function(ret){
                        switch(ret.buttonIndex){
                            case 1:{
                                break;
                            }
                            case 2:{
                                
                            }
                        }
                        
                    })
                }
            });
        },
        btnCancel: function () {
            $("#recover").show(); //隐藏取回的按钮
            $("#Mimport").hide();
            $("#content").hide();
            $("#content2").show();
        }
    }
})
</script>