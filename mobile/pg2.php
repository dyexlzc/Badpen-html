<div class="aui-card-list">
    <div class="aui-card-list-header">
        <div><i class="aui-iconfont aui-icon-gear aui-text-danger"></i><span class="aui-text-danger"> 相关设置</span>
        </div> <i class="aui-iconfont aui-icon-more"></i>
    </div>
    <div class="aui-content aui-margin-b-15" id="setting">
        <ul class="aui-list aui-list-in">
            <li class="aui-list-item aui-list-item-middle" v-on:click="Mimport">
                <div class="aui-list-item-inner aui-list-item-arrow">
                    <div class="aui-list-item-title" >导入密码本</div>
            </li>
            <li class="aui-list-item"  v-on:click="Mexport">
                <div class="aui-list-item-inner aui-list-item-arrow">
                    <div class="aui-list-item-title">
                        <a download="PwdBook.txt" href="../pbook/<?echo $_POST["file"].".txt";?>"  id="dlink"></a>
                        导出密码本</div>
                </div>
            </li>
            <li class="aui-list-item">
                <div class="aui-list-item-inner aui-list-item-arrow">
                    <div class="aui-list-item-title">更改密码</div>
                </div>
            </li>
            <li class="aui-list-item">
                <div class="aui-list-item-inner aui-list-item-arrow">
                    <div class="aui-list-item-title" v-on:click="pay">给作者打气</div>
                </div>
            </li>
        </ul>
        </div>
    </div>
    <script>
        var vm=new Vue({
            el:"#setting",
            methods:{
                Mexport:function(){  //导出的逻辑代码
                    console.log("clicked");
                    $("#dlink")[0].click();
                },
                Mimport:function(){  //导入的逻辑代码
                    $.post("Mimport.php",{},function(result){
                       $("#Mimport").html(result);
                       $("#recover").hide(); //隐藏取回的按钮
                       $("#Mimport").show();
                       $("#content").hide();
                       $("#content2").hide();
                    });
                },
                pay:function(){
                    dialog.alert({
                    title:"给作者打气~！",
                    msg:'<img src="../pay.png"  alt="赞助我~" />',
                    buttons:['残忍拒绝！','emmm']
                    },function(ret){
                        console.log(ret)
                    })
                }
            }
        })
    </script>