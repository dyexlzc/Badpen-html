<!DOCTYPE HTML>
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>私密笔记网页客户端 —— 采用Lay ui和Vue构建</title>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="dist/xxtea.min.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="mine.css" type="text/css" media="all" />
        <!-- ZUI 标准版压缩后的 CSS 文件 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/zui/1.8.1/css/zui.min.css">
        <!-- ZUI Javascript 依赖 jQuery -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/zui/1.8.1/lib/jquery/jquery.js"></script>
        <!-- ZUI 标准版压缩后的 JavaScript 文件 -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/zui/1.8.1/js/zui.min.js"></script>
        <style>
</style>
    </head>
    
    <body>
        <a href="https://www.coolapk.com/apk/217528"><img src="software.png" class="img-rounded" alt="圆角图片" /></a>
        
        <hr>
        <div class="container-fluid">
            <div class="row">
                <div class="text-left col-md-2">
                    <div id="Divbtn" class="text-center">
                        <!-- 对话框触发按钮 -->
                        <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#custom-pop">导入密码本</button>
                        <hr>
                        <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#takepwd">取回密码本</button>
                    </div>
                </div>
                <div class="col-xs-8 content_border">
                    <div class="row "  id="items">
                        <div class="col-xs-2">
                            <ul class="nav nav-tabs nav-stacked">
                                
                                    <li v-for="item in items">
                                        <a href="###" data-toggle="tab" v-bind:data-target="'#'+item.id" class="active">
                                            {{ item.title }}
                                        </a>
                                    </li>
                                    
                               
                               <!--
                                <li>
                                    <a href="###" data-target="#tab3Content1" data-toggle="tab">标签1</a>
                                </li>
                                <li>
                                    <a href="###" data-target="#tab3Content2" data-toggle="tab">标签2</a>
                                </li>
                                <li>
                                    <a href="###" data-target="#tab3Content3" data-toggle="tab">标签3</a>
                                </li>
                                -->
                            </ul>
                        </div>
                        <div class="col-xs-9">
                            <div class="tab-content col-xs-9">
                                
                                    <div v-for="item in items" class="tab-pane fade" v-bind:id="item.id">
                                        
                                        <p>{{ item.content }}</p>
                                        
                                        
                                    </div>
                                
                                <!--
                                <div class="tab-pane fade" id="tab3Content1">
                                    <p>我是标签1。</p>
                                </div>
                                <div class="tab-pane fade" id="tab3Content2">
                                    <p>标签2的内容。</p>
                                </div>
                                <div class="tab-pane fade" id="tab3Content3">
                                    <p>这是标签3的内容。</p>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2"></div>
            </div>
        </div>
        <!-- 对话框HTML -->
        <div class="modal fade" id="custom-pop">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
                        </button>
                         <h4 class="modal-title">导入密码本</h4>

                    </div>
                    <div class="modal-body">
                        <div class="modal-content">
                            <textarea class="form-control" rows="10" placeholder="可以输入多行文本" v-model="content"></textarea>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="input-control has-icon-left">
                                  <input id="inputAccountExample1" type="text" class="form-control" placeholder="用户名" v-model="str">
                                  <label for="inputAccountExample1" class="input-control-icon-left"><i class="icon icon-user "></i></label>
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="input-control has-icon-right">
                                  <input id="inputPasswordExample1" type="password" class="form-control" placeholder="密码，此处密码要和手机版私密笔记中设定的密码一致才能成功解密" v-model="pwd">
                                  <label for="inputPasswordExample1" class="input-control-icon-right"><i class="icon icon-key"></i></label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="state" style="padding:10px;">
                        <div id="state1"></div>  <!--显示用密码将用户名加密后的密文作为文件名的状态-->
                        <div id="state2"></div>  <!--显示文件名是否存在-->
                        <div id="state3"></div>  <!--显示写入状态-->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" v-on:click="clean">关闭</button>
                        <button class="btn btn-success " type="button" v-on:click="btnSubmitAndCheck">提交/覆盖</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 对话框2HTML -->
        <div class="modal fade" id="takepwd">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
                        </button>
                         <h4 class="modal-title">取回</h4>

                    </div>
                    <div class="modal-body">
                        <div class="modal-content">
                            <div class="row">
                            <div class="col-xs-5">
                                <div class="input-control has-icon-left">
                                  <input id="inputAccountExample1" type="text" class="form-control" placeholder="用户名" v-model="str">
                                  <label for="inputAccountExample1" class="input-control-icon-left"><i class="icon icon-user "></i></label>
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="input-control has-icon-right">
                                  <input id="inputPasswordExample1" type="password" class="form-control" placeholder="密码，此处密码要和手机版私密笔记中设定的密码一致才能成功解密" v-model="pwd">
                                  <label for="inputPasswordExample1" class="input-control-icon-right"><i class="icon icon-key"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                        

                    </div>
                    <div id="state" style="padding:10px;">
                        <div id="state11"></div>  <!--显示是由有这个文件-->
                        <div id="state22"></div>  <!--显示文件名是否存在-->
                        <div id="state33"></div>  <!--显示写入状态-->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" >关闭</button>
                        <button class="btn btn-success " type="button" v-on:click="btnTake">取回</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script>
        /*var str="69ntM5GJ6veQrcR86jrzew==";
            alert(XXTEA.decryptFromBase64(str,"198111"));
            */
        var win = new $.zui.ModalTrigger({
            custom: $("#custom-pop").html(),
            title: "导入密码本"
        });
        var vm1 = new Vue({
            el: "#Divbtn",
            methods: {
                btnImport: function () {
                    win.show();
                }
            }
        })

         var vm2 = new Vue({
            el: "#custom-pop",
            data: {
                content:"",
                str: "",
                pwd: ""
            },
            methods: {
                clean:function(){
                    $("#state1").html("");
                    $("#state2").html("");
                    $("#state3").html("");
                },
                btnSubmitAndCheck: function () {
                    //全程用AJAX和后台通信，所有发送的数据都可以在F12的network中查看到发送的数据
                    //Step1:用xxtea和密码加密用户名作为文件名
                    var filename=(XXTEA.encryptToBase64(this.str, this.pwd));
                    //Step2:JQ检查在pbook文件夹下是否有这个文件
                    $("#state1").text("加密密文为:"+XXTEA.encryptToBase64(this.str, this.pwd));
                    $.post("isExist.php",{filename:filename},function(result){
                        $("#state2").html(result);
                    });
                    //Step3:直接传送密文，手机上的密码本【明文反而会解密出错】
                    $.post("setPbook.php",{filename:filename,content:this.content},function(result){
                        $("#state33").html(result);
                    });
                }
            }
        })
        
        var vm_lists=new Vue({  //绑定列表
            el:"#items",
            data:{
                items:""
            }
        })
        var vm3=new Vue({
            el:"#takepwd",
            data: {
                str: "",
                pwd: ""
            },
            methods:{
                 btnTake: function () {
                     //Step1:打开用密码加密用户名组成的文件名，看是否有文件存在
                     var filename=(XXTEA.encryptToBase64(this.str, this.pwd));
                     $.post("isExist.php",{filename:filename},function(result){
                        $("#state11").html(result);
                        if(result.indexOf("不")!=-1){ //文件不存在就提示
                            $("#state22").html("文件不存在，取回失败，请检查用户名和密码");
                        }
                        else{
                            //存在就取回密文，用密码解密
                            $("#state22").html("文件存在，正在取回...");
                            $.post("gotPbook.php",{filename:filename},function(result){
                                $("#state33").html("取回成功 ");
                                var obj = JSON.parse(result).data; //解析JSON字符串
                               //遍历json数组时，这么写p为索引，0,1
                                //console.log(vm3);
                                for(var i in obj){
                                  obj[i]["id"]=i;
                                  obj[i]["title"]=XXTEA.decryptFromBase64(obj[i]["title"],vm3.pwd);
                                  obj[i]["content"]=XXTEA.decryptFromBase64(obj[i]["content"],vm3.pwd);
                                  //console.log(obj[i]);
                                }
                                vm_lists.$data.items=eval(JSON.stringify(obj));
                                //console.log(JSON.stringify(obj.data));
                            });
                        }
                    });
                 }
            }
        })
        </script>
    </body>

</html>