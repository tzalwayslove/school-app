/**
 * Created by Administrator on 2017/11/30.
 */
reply = Vue.component('reply', function (success, error) {
    axios.get("/public/tpl/reply.html").then(function (res) {
        success({
            template: res.data,
            props: ['comment', 'niming', 'sex'],
            data(){
                return {
                    content : '',
                    niming_prop: 1 
                }
            },
            methods:{
                back: function(){
                    router.push({
                        path: '/tiezi',
                    })
                },
                reply: function(){
                    $this = this;
                    sendData  = {
                        content : this.content,
                        comment: this.$route.params.id,
                        niming : this.niming
                    };
                    axios.post('/wx/reply', sendData).then(function(res){
                        res = res.data;
                        if(res.result.code == 1){
                            data.success = true;
                            $this.back();
                        }else{
                            alert(res.result.message);
                        }

                    });
                }
            },
            mounted: function(){
                console.log(this.$route.params.id);
                console.log(this.$route.params.niming);
                this.niming_prop = this.$route.params.niming;
            }
        });
    });
});