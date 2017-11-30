/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('fabu', function (success, error) {
    axios.get("/public/tpl/fatie.html").then(function (res) {
        success({
            template: res.data,
            data(){
                return {
                    title:'',
                    content:''
                }
            },
            methods:{
                send: function(){
                    axios.post('/wx/articel', {
                        title: this.title,
                        content: this.content
                    }).then(function(res){
                        if(res.data.result.code == 1){
                            alert('发布成功');
                        }else{
                            alert(res.data.result.message || '发布失败');
                        }
                    });
                }
            }
        });
    });
});