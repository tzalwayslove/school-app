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
                    content:'',
                    niming:false
                }
            },
            methods:{
                send: function(){
                    $this = this;
                    axios.post('/wx/articel', {
                        title: '',
                        niming:$this.niming,
                        content: this.content.trim()
                    }).then(function(res){
                        if(res.data.result.code == 1){
                            alert('发布成功');
                        }else{
                            alert(res.data.result.message || '发布失败');
                        }
                    });
                },
                back: function(){
                    window.history.go(-1);
                }
            }
        });
    });
});