  <div class="aui-card-list">
        <div class="aui-card-list-header">
            <div> <i class="aui-iconfont aui-icon-menu"></i><span class="aui-text-danger">&nbsp;密码</span></div>
            <i class="aui-iconfont aui-icon-more"></i>
        </div>
        <div id="pwdList" class="aui-card-list-content">
            <ul class="aui-list aui-media-list">
                <li class="aui-list-item aui-list-item-middle" v-for="item,index in items" @click="showContent(index)">
                    <div class="aui-media-list-item-inner">
                        
                        <div class="aui-list-item-inner aui-list-item-arrow">
                            <div class="aui-list-item-text">
                                <div class="aui-list-item-title aui-font-size-14">
                                    {{ item.title }}
                                </div>
                            </div>
                            <div class="aui-list-item-text">
                                    
                            </div>
                            
                        </div>
                    </div>
                </li>
              
            </ul>
        </div>

    </div>
    <script>
        vm_lists=new Vue({
            el:"#pwdList",
            data:{
                items:"",
                rawitems:""
            },
            methods:{
                showContent:function(id){
                    
                    dialog.alert({
                        title:"查看&编辑",
                        msg:' <textarea placeholder="" rows="5">'+this.items[id].content+'</textarea>',
                        buttons:['取消','确定'],
                        //input:true
                    },function(ret){
                            
                    });
                    
                }
            }
        })
    </script>